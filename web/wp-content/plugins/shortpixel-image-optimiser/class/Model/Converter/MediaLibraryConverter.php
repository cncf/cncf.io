<?php
namespace ShortPixel\Model\Converter;
use ShortPixel\Replacer\Replacer as Replacer;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

abstract class MediaLibraryConverter extends Converter
{
	protected $source_url;


	public function getUpdatedMeta()
	{
		 $id = $this->imageModel->get('id');
		 $meta = wp_get_attachment_metadata($id); // reset the metadata because we are on the hook.
		 return $meta;
	}

	protected function setupReplacer()
	{
		$this->replacer = new Replacer();
		$fs = \wpSPIO()->filesystem();

		$url = $fs->pathToUrl($this->imageModel);

		if ($this->imageModel->isScaled()) // @todo Test these assumptions
		{
			$url = $fs->pathToUrl($this->imageModel->getOriginalFile());
		}

		$this->source_url = $url;
		$this->replacer->setSource($url);

		$this->replacer->setSourceMeta($this->imageModel->getWPMetaData());

	}

	protected function setTarget($newFile)
	{
		$fs = \wpSPIO()->filesystem();
		$this->newFile = $newFile; // set target newFile.

		$url = $fs->pathToUrl($this->imageModel);
		$newUrl = str_replace($this->imageModel->getFileName(), $newFile->getFileName(), $url);

		$this->replacer->setTarget($newUrl);
	}

	protected function updateMetaData($params)
	{
			$defaults = array(
				 'success' => false,
				 'restore' => false,
				 'generate_metadata' => true,
			);

			$params = wp_parse_args($params, $defaults);

			$newFile = $this->newFile;
			$fullPath = $newFile->getFullPath();

			if (! is_object($newFile))
			{
				 Log::addError('Update metadata failed. NewFile not properly set', $newFile);
				 return false;
			}

			$attach_id = $this->imageModel->get('id');

			$WPMLduplicates = $this->imageModel->getWPMLDuplicates();

			$attachment = get_post($attach_id);

			$guid = $attachment->guid;

			// This action prevents images from being regenerated on the thumbnail hook.
				do_action('shortpixel-thumbnails-before-regenerate', $attach_id );
				do_action('shortpixel/converter/prevent-offload', $attach_id);

			// Update attached_file
			$bool = update_attached_file($attach_id, $newFile->getFullPath() );
			if (false === $bool)
				return false;


			// Update post mime on attachment
			if (isset($params['success']) && true === $params['success'])
			{
				$newExt = $this->imageModel->getMeta()->convertMeta()->getFileFormat();
				$newGuid = str_replace($guid, $newExt, 'jpg'); // This probable doesn't work bcause doesn't update Guid with this function.
				$post_ar = array('ID' => $attach_id, 'post_mime_type' => 'image/jpeg', 'guid' => $newGuid);
			}
			elseif ( isset($params['restore']) && true === $params['restore'] )
			{
				$oldExt = $this->imageModel->getMeta()->convertMeta()->getFileFormat();
				$newGuid = str_replace($guid, 'jpg', $oldExt);
				$post_ar = array('ID' => $attach_id, 'post_mime_type' => 'image/png', 'guid' => $newGuid);
			}

			$result = wp_update_post($post_ar);

			if ($result === 0 || is_wp_error($result))
			{
				Log::addError('Issue updating WP Post converter - ' . $attach_id);
				return false;
			}

			$metadata = wp_get_attachment_metadata($attach_id);

			if (true === $params['generate_metadata'])
			{
				$attachment = get_post( $attach_id );

				$new_metadata = wp_generate_attachment_metadata($attach_id, $newFile->getFullPath());

			}
			else {
				$new_metadata = array();
			}

			// Metadata might not be array when add_attachment is calling this hook via AdminController ( PNG2JPG)
			if (is_array($metadata))
			{
				// Original Image in the new situation can not be there. Don't preserve it.
				if (isset($metadata['original_image']) && ! isset($new_metadata['original_image']) )
				{
						unset($metadata['original_image']);
				}

				$new_metadata = array_merge($metadata, $new_metadata); // merge to preserve other custom metadata

			}

			if (isset($params['success']) && true === $params['success'])
			{
				do_action('shortpixel/converter/prevent-offload-off', $attach_id);
			}

			if (is_array($new_metadata) && count($new_metadata) > 0)
			{
				$bool = wp_update_attachment_metadata($attach_id, $new_metadata);
			}

			// Restore -sigh- fires off a later signal, because on the succesHandler in MediaLIbraryModel it may copy back backups.
			if (isset($params['restore']) && true === $params['restore'])
			{
				do_action('shortpixel/converter/prevent-offload-off', $attach_id);
			}

			if (is_array($WPMLduplicates) && count($WPMLduplicates) > 0)
			{
				 foreach ($WPMLduplicates as $duplicate_id)
				 {
						update_attached_file($duplicate_id, $newFile->getFullPath() );
						wp_update_attachment_metadata($duplicate_id, $new_metadata);

						$post_ar["ID"]  = $duplicate_id;
						wp_update_post($post_ar);
				 }
			}

			$this->replacer->setTargetMeta($new_metadata);

	}


} // class
