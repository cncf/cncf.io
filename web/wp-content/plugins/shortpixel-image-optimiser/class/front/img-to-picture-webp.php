<?php
namespace ShortPixel;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

/**
 * Class ShortPixelImgToPictureWebp - convert an <img> tag to a <picture> tag and add the webp versions of the images
 * thanks to the Responsify WP plugin for some of the code
 */
class ShortPixelImgToPictureWebp
{

    public function convert($content)
    {
        // Don't do anything with the RSS feed.
        if (is_feed() || is_admin()) {
            Log::addInfo('SPDBG convert is_feed or is_admin');
            return $content; // . (isset($_GET['SHORTPIXEL_DEBUG']) ? '<!--  -->' : '');
        }

        $new_content = $this->testPictures($content);

        if ($new_content !== false)
        {
          $content = $new_content;
        }
        else
        {
          Log::addDebug('Test Pictures returned empty.');
        }

				if (! class_exists('DOMDocument'))
        {
          Log::addWarn('Webp Active, but DomDocument class not found ( missing xmldom library )');
          return false;
        }

			//	preg_match_all
        $content = preg_replace_callback('/<img[^>]*>/i', array($this, 'convertImage'), $content);
        //$content = preg_replace_callback('/background.*[^:](url\(.*\)[,;])/im', array('self', 'convertInlineStyle'), $content);

        // [BS] No callback because we need preg_match_all
        $content = $this->testInlineStyle($content);

        return $content;

    }

    /** If lazy loading is happening, get source (src) from those values
    * Otherwise pass back image data in a regular way.
    */
    private function lazyGet($img, $type)
    {

      $value = false;
      $prefix = false;

       if (isset($img['data-lazy-' . $type]) && strlen($img['data-lazy-' . $type]) > 0)
       {
           $value = $img['data-lazy-' . $type];
           $prefix = 'data-lazy-';
       }
       elseif( isset($img['data-' . $type]) && strlen($img['data-' . $type]) > 0)
       {
          $value = $img['data-' . $type];
          $prefix = 'data-';
       }
       elseif(isset($img[$type]) && strlen($img[$type]) > 0)
       {
          $value = $img[$type];
          $prefix = '';
       }

      return array(
        'value' => $value,
        'prefix' => $prefix,
       );
    }

    /* Find image tags within picture definitions and make sure they are converted only by block, */
    private function testPictures($content)
    {
      // [BS] Escape when DOM Module not installed
      //if (! class_exists('DOMDocument'))
      //  return false;
    //$pattern =''
    //$pattern ='/(?<=(<picture>))(.*)(?=(<\/picture>))/mi';
    $pattern = '/<picture.*?>.*?(<img.*?>).*?<\/picture>/is';
    $count = preg_match_all($pattern, $content, $matches);

    if ($matches === false)
      return false;

    if ( is_array($matches) && count($matches) > 0)
    {
      foreach($matches[1] as $match)
      {
           $imgtag = $match;

           if (strpos($imgtag, 'class=') !== false) // test for class, if there, insert ours in there.
           {
            $pos = strpos($imgtag, 'class=');
            $pos = $pos + 7;

            $newimg = substr($imgtag, 0, $pos) . 'sp-no-webp ' . substr($imgtag, $pos);

           }
           else {
              $pos = 4;
              $newimg = substr($imgtag, 0, $pos) . ' class="sp-no-webp" ' . substr($imgtag, $pos);
           }

           $content = str_replace($imgtag, $newimg, $content);

      }
    }

    return $content;
    }

    /* This might be a future solution for regex callbacks.
    public static function processImageNode($node, $type)
    {
      $srcsets = $node->getElementsByTagName('srcset');
      $srcs = $node->getElementsByTagName('src');
      $imgs = $node->getElementsByTagName('img');
    } */

    /** Callback function with received an <img> tag match
    * @param $match Image declaration block
    * @return String Replacement image declaration block
    */
    protected function convertImage($match)
    {
        $fs = \wpSPIO()->filesystem();

				$raw_image = $match[0];
				// Raw Image HTML
				$image = new FrontImage($raw_image);

				if (false === $image->isParseable())
				{
					 return $raw_image;
				}

        $srcsetWebP = array();
        $srcsetAvif = array();
				// Count real instances of either of them, without fillers.
				$webpCount = $avifCount = 0;

        $imagePaths = array();

				$definitions = $image->getImageData();
				$imageBase = $image->getImageBase();

        foreach ($definitions as $definition) {

								// Split the URL from the size definition ( eg 800w )
                $parts = preg_split('/\s+/', trim($definition));
                $image_url = $parts[0];

								// The space if not set is required, otherwise it will not work.
                $image_condition = isset($parts[1]) ? ' ' . $parts[1] : ' ';

                // A source that starts with data:, will not need processing.
                if (strpos($image_url, 'data:') === 0)
								{
                  continue;
								}

                $fsFile = $fs->getFile($image_url);
                $extension = $fsFile->getExtension(); // trigger setFileinfo, which will resolve URL -> Path
                $mime = $fsFile->getMime();

								// Can happen when file is virtual, or other cases. Just assume this type.
								if ($mime === false)
								{
									 $mime = 'image/' .  $extension;
								}

                $fileWebp = $fs->getFile($imageBase . $fsFile->getFileBase() . '.webp');
                $fileWebpCompat = $fs->getFile($imageBase . $fsFile->getFileName() . '.webp');

								// The URL of the image without the filename
                $image_url_base = str_replace($fsFile->getFileName(), '', $image_url);

								$files = array($fileWebp, $fileWebpCompat);

                $fileAvif = $fs->getFile($imageBase . $fsFile->getFileBase() . '.avif');

								$lastwebp = false;

                foreach($files as $index => $thisfile)
                {
                  if (! $thisfile->exists())
                  {
										// FILTER: boolean, object, string, filedir
                    $thisfile = $fileWebp_exists = apply_filters('shortpixel/front/webp_notfound', false, $thisfile, $image_url, $imageBase);
                  }

                  if ($thisfile !== false)
                  {
                      // base url + found filename + optional condition ( in case of sourceset, as in 1400w or similar)
                      Log::addDebug('Adding new URL', $image_url_base . $thisfile->getFileName() . $image_condition);
											$webpCount++;

                       $lastwebp = $image_url_base . $thisfile->getFileName() . $image_condition;
											 $srcsetWebP[] = $lastwebp;
                       break;
                  }
									elseif ($index+1 !== count($files)) // Don't write the else on the first file, because then the srcset will be written twice ( if file exists on the first fails)
									{
										continue;
									}
									else {
										Log::addTemp('Adding Def - ' . $definition);
											$lastwebp = $definition;
											$srcsetWebP[] = $lastwebp;
									}
                }

								if (false === $fileAvif->exists())
								{
									$fileAvif = apply_filters('shortpixel/front/webp_notfound', false, $fileAvif, $image_url, $imageBase);
								}

								//@todo This will not work with offloaded avifs.
                if ($fileAvif !== false)
                {
                  // $fileurl_base = str_replace($fsFile->getFileName(), '', $fileurl);
									 $srcsetAvif[] = $image_url_base . $fileAvif->getFileName() . $image_condition;

  								 $avifCount++;
                }
								else { //fallback to jpg
									if (false !== $lastwebp) // fallback to webp if there is a variant in this run. or jpg if none
									{
										 $srcsetAvif[] = $lastwebp;
									}
									else {
										$srcsetAvif[] = $definition;
									}
								}
        }

        if ($webpCount == 0 && $avifCount == 0) {
            return $raw_image; //. (isset($_GET['SHORTPIXEL_DEBUG']) ? '<!-- SPDBG no srcsetWebP found (' . $srcsetWebP . ') -->' : '');
        }

				$args = array(
					'webp' => $srcsetWebP,
					'avif' => $srcsetAvif,
				);

Log::addTemp('Replacementss', $args);
				$output = $image->parseReplacement($args);

				return $output;

    }

    /** Check and remove elements that should not be in the picture tag. Especially items within attributes. */
/*
    private function filterForPicture($img)
    {

      if (isset($img['style']))
      {
         $bordercount = substr_count($img['style'], 'border');
         for ($i = 0; $i <= $bordercount; $i++)
         {
           $offset = strpos($img['style'], 'border');
           $end = strpos($img['style'], ';', $offset);

           $nstyle = substr($img['style'], 0, $offset);

           // if end is false, ; terminator does not exist, assume full string is border.
           if ($end !== false)
              $nstyle .= substr($img['style'], ($end+1) ); // do not include ;

              $img['style'] = $nstyle;
         }
      }

      return $img;
    } */

    public function testInlineStyle($content)
    {
      //preg_match_all('/background.*[^:](url\(.*\))[;]/isU', $content, $matches);
      preg_match_all('/url\(.*\)/isU', $content, $matches);

      if (count($matches) == 0)
        return $content;

      $content = $this->convertInlineStyle($matches, $content);
      return $content;
    }

    /** Function to convert inline CSS backgrounds to webp
    * @param $match Regex match for inline style
    * @return String Replaced (or not) content for webp.
    * @author Bas Schuiling
    */
    public function convertInlineStyle($matches, $content)
    {
      // ** matches[0] = url('xx') matches[1] the img URL.
//      preg_match_all('/url\(\'(.*)\'\)/imU', $match, $matches);

  //    if (count($matches)  == 0)
  //      return $match; // something wrong, escape.

      //$content = $match;
      $allowed_exts = array('jpg', 'jpeg', 'gif', 'png');
      $converted = array();

      for($i = 0; $i < count($matches[0]); $i++)
      {
        $item = $matches[0][$i];

        preg_match('/url\(\'(.*)\'\)/imU', $item, $match);
        if (! isset($match[1]))
          continue;

        $url = $match[1];
        //$parsed_url = parse_url($url);
        $filename = basename($url);

        $fileonly = pathinfo($url, PATHINFO_FILENAME);
        $ext = pathinfo($url, PATHINFO_EXTENSION);

        if (! in_array($ext, $allowed_exts))
          continue;

        $imageBaseURL = str_replace($filename, '', $url);

        $imageBase = static::getImageBase($url);

        if (! $imageBase) // returns false if URL is external, do nothing with that.
          continue;

        $checkedFile = false;
        if (file_exists($imageBase . $fileonly . '.' . $ext . '.webp'))
        {
          $checkedFile = $imageBaseURL . $fileonly . '.' . $ext . '.webp';
        }
        elseif (file_exists($imageBase . $fileonly . '.webp'))
        {
          $checkedFile = $imageBaseURL . $fileonly . '.webp';
        }
        else
        {
          Log::addDebug('convertInlineStyle, no webp existing', $checkedFile);
        }

        if ($checkedFile)
        {
            // if webp, then add another URL() def after the targeted one.  (str_replace old full URL def, with new one on main match?
            $target_urldef = $matches[0][$i];
            if (! isset($converted[$target_urldef])) // if the same image is on multiple elements, this replace might go double. prevent.
            {
              $converted[] = $target_urldef;
              $new_urldef = "url('" . $checkedFile . "'), " . $target_urldef;
              $content = str_replace($target_urldef, $new_urldef, $content);
            }
        }

      }

      return $content;
    }

    /**
     * Makes a string with all attributes.
     *
     * @param $attribute_array
     * @return string
     */
		 /*
    public function create_attributes($attribute_array)
    {
        $attributes = '';
        foreach ($attribute_array as $attribute => $value) {
            $attributes .= $attribute . '="' . $value . '" ';
        }

        // Removes the extra space after the last attribute
        return substr($attributes, 0, -1);
    } */
} // Convert

class FrontImage
{
		protected $raw;
		protected $image_loaded = false;
		protected $is_parsable = false;
		protected $imageBase; // directory path of this image.

		protected $id; // HTML ID of image
		protected $alt;
		protected $src;  // original src of image
		protected $srcset; // orginal srcset of image
		protected $class;
		protected $width;
		protected $height;
		protected $style;
		protected $sizes;


		// Array of all other attributes.
		protected $attributes;

		// Parsed items of src /srcset / sizes
		protected $dataTags = array();

		public function __construct($raw_html)
		{
				$this->raw = $raw_html;
				$this->loadImageDom();
		}


		public function loadImageDom()
    {
        if (function_exists("mb_convert_encoding")) {
            $this->raw = mb_encode_numericentity($this->raw, [0x80, 0x10FFFF, 0, ~0], 'UTF-8');
        }

        $dom = new \DOMDocument();
        @$dom->loadHTML($this->raw);
        $image = $dom->getElementsByTagName('img')->item(0);
        $attributes = array();


        /* This can happen with mismatches, or extremely malformed HTML.
        In customer case, a javascript that did  for (i<imgDefer) --- </script> */
        if (! is_object($image))
				{
					$this->is_parsable = false;
          return false;
				}

        foreach ($image->attributes as $attr) {
						// Skip is no value
					 if (strlen($attr->nodeValue) == 0)
					 	continue;

					 if (property_exists($this, $attr->nodeName))
					 {
						  $this->{$attr->nodeName} = $attr->nodeValue;
					 }

					 $this->attributes[$attr->nodeName] = $attr->nodeValue;
        }

			Log::addTemp('Attributes', $this->attributes);
			Log::addTemp('Srcset', explode(',', $this->srcset));


				if (! is_null($this->src))
				{
					$fs = \wpSPIO()->filesystem();
		      $fileObj = $fs->getFile($this->src);
		      $fileDir = $fileObj->getFileDir();
		      $this->imageBase = $fileObj->getFileDir();
				}

				$this->image_loaded = true;
    }

		public function hasBackground()
		{
				if (! is_null($this->style) && strpos($this->style, 'background') !== false)
				{
					 return true;
				}
				return false;
		}

		public function hasPreventClasses()
		{
			// no class, no prevent.
			if (is_null($this->class))
			{
				 return false;
			}

			$preventArray = apply_filters('shortpixel/front/preventclasses', array('sp-no-webp', 'rev-sildebg') );

			foreach($preventArray as $classname)
			{
				if (false !== strpos($this->class, $classname) )
				{
					 return true;
				}
			}

			return false;

		}

		public function hasSource()
		{
			  if (is_null($this->src) && is_null($this->srcset))
				{
					 return false;
				}
				return true;
		}

		public function isParseable()
		{
			 if (
				 false === $this->hasPreventClasses() &&
				 false === $this->hasBackground()  &&
				 true === $this->hasSource() &&
				 true === $this->image_loaded
				 )
			{
					return true;
			}

			return false;
		}

		public function getImageData()
		{
			 if (! is_null($this->srcset))
			 {
 			 	 	$data = $this->getLazyData('srcset');
					$data = explode(',', $data); // srcset is multiple images, split.
			 }
			 else {
				 	$data = $this->getLazyData('src');
					$data = array($data);  // single item, wrap in array
			 }

			 $this->getLazyData('sizes'); // sets the sizes.

			 return $data;
		}

		public function getImageBase()
		{
			 return $this->imageBase->getPath();
		}

		public function parseReplacement($args)
		{
				if (is_null($this->class))
				{
					 $this->class = '';
				}

				$this->class .= ' sp-no-webp';

				$output = "<picture>";

				if ($args['avif'] && count($args['avif']) > 0)
				{
						$output .= $this->buildSource($args['avif'], 'avif');
				}

				if ($args['webp'] && count($args['webp']) > 0)
				{
						$output .= $this->buildSource($args['webp'], 'webp');
				}

				$output .= $this->buildImage();

				$output .= "</picture>";

				return $output;
		}


		protected function buildSource($sources, $fileFormat)
		{

				$prefix = (isset($this->dataTags['srcset'])) ? $this->dataTags['srcset'] : $this->dataTags['src'];
				$srcset = implode(',', $sources);

				$sizeOutput = '';
				if (! is_null($this->sizes))
				{
						$sizeOutput = $this->dataTags['sizes'] . 'sizes="' . $this->sizes . '"';
				}

			  $output = '<source ' . $prefix . 'srcset="' . $srcset . '"' . $sizeOutput . ' type="image/' . $fileFormat . '">';

				return $output;
		}

		protected function buildImage()
		{
			$src = $this->src;
			$output = '<img src="' . $src . '" ';

			// Get this from set attributes on class.
			$attrs = array('id', 'alt', 'height', 'width', 'srcset', 'sizes', 'class');
			foreach($attrs as $attr)
			{
				if (! is_null($this->{$attr}))
					$output .= $attr . '="' . $this->{$attr} . '" ';
			}

			// Left over attributes that should be harmless, ie extra image data or other custom tags.
			$leftAttrs = $this->getImageAttributes();
			foreach($leftAttrs as $name => $value)
			{
	 				$output .= $name . '="' . $value . '" ';
			}

			$output .= ' > '; // ending image.

			return $output;

	//		.'<img ' . $srcPrefix . 'src="' . $src . '" ' . $this->create_attributes($img) . $idAttr . $altAttr . $heightAttr . $widthAttr
	//				. (strlen($srcset) ? ' srcset="' . $srcset . '"': '') . (strlen($sizes) ? ' sizes="' . $sizes . '"': '') . '>'

		}

		protected function getImageAttributes()
		{

			$dontuse = array(
					'src', 'data-src', 'data-lazy-src', 'srcset', 'sizes'

			);
			$dontuse = array_merge($dontuse, array('id', 'alt', 'height', 'width', 'srcset', 'sizes', 'class'));

			$attributes = $this->attributes;

			$leftAttrs = array();
			foreach($attributes as $name => $value)
			{
				 if (! in_array($name, $dontuse ))
				 {
					  $leftAttrs[$name] = $value;
				 }
			}

			return $leftAttrs;
		}

		protected function getLazyData($type)
		{
				$attributes = $this->attributes;

				$value = $prefix = false;

				if (isset($attributes['data-lazy-' . $type]) && strlen($attributes['data-lazy-' . $type]) > 0)
				{
						$value = $attributes['data-lazy-' . $type];
						$prefix = 'data-lazy-';
				}
				elseif( isset($attributes['data-' . $type]) && strlen($attributes['data-' . $type]) > 0)
				{
					 $value = $img['data-' . $type];
					 $prefix = 'data-';
				}
				elseif(isset($attributes[$type]) && strlen($attributes[$type]) > 0)
				{
					 $value = $attributes[$type];
					 $prefix = '';
				}

				$this->dataTags[$type] = $prefix;

				return $value;
		}
}
