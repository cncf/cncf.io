<?php
namespace ShortPixel\Model\Converter;

use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\Helper\UtilHelper as UtilHelper;

class ApiConverter extends MediaLibraryConverter
{

	const CONVERTABLE_EXTENSIONS = array( 'heic');

	protected $requestAPIthumbnails = true;


		public function isConvertable()
		{
			 $fs = \wpSPIO()->filesystem();
			 $extension = $this->imageModel->getExtension();

			 // If extension is in list of allowed Api Converts.
			 if (in_array($extension, static::CONVERTABLE_EXTENSIONS) && $extension !== 'png')
			 {
				  return true;
			 }

			 // If file has not been converted in terms of file, but has a placeholder - process ongoing, so continue;
			 if (false === $this->imageModel->getMeta()->convertMeta()->isConverted() && true === $this->imageModel->getMeta()->convertMeta()->hasPlaceHolder())
			 {
				 return true;
			 }

			 // File has been converted, not converting again.
			 if (true === $this->imageModel->getMeta()->convertMeta()->isConverted())
			 {
				  return false;
			 }
		}

		// Create placeholder here.
		public function convert($args = array())
		{
			$defaults = array(
				 'runReplacer' => true, // The replacer doesn't need running when the file is just uploaded and doing in handle upload hook.
			);

				$args = wp_parse_args($args, $defaults);

				$this->setupReplacer();

				$fs = \wpSPIO()->filesystem();

				$placeholderFile = $fs->getFile(\wpSPIO()->plugin_path('res/img/fileformat-heic-placeholder.jpg'));


				// @todo Check replacementpath here. Rename main file - and backup - if numeration is needed.
				// @todo Also placeholder probably needs to be done each time to block current job in progress.
				$replacementPath = $this->getReplacementPath();
				if (false === $replacementPath)
				{
					Log::addWarn('ApiConverter replacement path failed');
					$this->imageModel->getMeta()->convertMeta()->setError(self::ERROR_PATHFAIL);

					return false; // @todo Add ResponseController something here.
				}

				$replaceFile = $fs->getFile($replacementPath);
				// If filebase (filename without extension) is not the same, this indicates that a double is there and it's enumerated. Move backup accordingly.

				$destinationFile = $fs->getFile($replacementPath);
				$copyok = $placeholderFile->copy($destinationFile);

				if ($copyok)
				{
					$this->imageModel->getMeta()->convertMeta()->setFileFormat('heic');
					$this->imageModel->getMeta()->convertMeta()->setPlaceHolder(true);
					$this->imageModel->getMeta()->convertMeta()->setReplacementImageBase($destinationFile->getFileBase());
					$this->imageModel->saveMeta();


					// @todo Wip . Moved from handleConverted.
					// Backup basically. Do this first.
					$conversion_args = array('replacementPath' => $replacementPath);
					$prepared = $this->imageModel->conversionPrepare($conversion_args);
					if (false === $prepared)
					{
						 return false;
					}

					$this->setTarget($destinationFile);
				//	$params = array('success' => true, 'generate_metadata' => false);
				//	$this->updateMetaData($params);

					$fs->flushImage($this->imageModel);

					if (true === $args['runReplacer'])
					{
						$result = $this->replacer->replace();
					}

				}
				else {
					Log::addError('Failed to copy placeholder');
					return false;
				}

				return true;
		}

		// Restore from original file. Search and replace everything else to death.
		public function restore()
		{
			/*$params = array('restore' => true);
			$fs = \wpSPIO()->filesystem();

			$this->setupReplacer();

			$newExtension =  $this->imageModel->getMeta()->convertMeta()->getFileFormat();

			$oldFileName = $this->imageModel->getFileName(); // Old File Name, Still .jpg
			$newFileName =  $this->imageModel->getFileBase() . '.' . $newExtension;

			if ($this->imageModel->isScaled())
			{
				 $oldFileName = $this->imageModel->getOriginalFile()->getFileName();
				 $newFileName = $this->imageModel->getOriginalFile()->getFileBase() . '.' . $newExtension;
			}

			$fsNewFile = $fs->getFile($this->imageModel->getFileDir() . $newFileName);

			$this->newFile = $fsNewFile;
			$this->setTarget($fsNewFile);

			$this->updateMetaData($params);
	//		$result = $this->replacer->replace();

			$fs->flushImageCache(); */
		}

		public function getCheckSum()
		{
			 return 1; // done or not.
		}

		public function handleConverted($optimizeData)
		{
			$this->setupReplacer();
			$fs = \wpSPIO()->filesystem();


/*			$replacementPath = $this->getReplacementPath();
			if (false === $replacementPath)
			{
				Log::addWarn('ApiConverter replacement path failed');
				$this->imageModel->getMeta()->convertMeta()->setError(self::ERROR_PATHFAIL);

				return false; // @todo Add ResponseController something here.
			}

			$replacementFile = $fs->getFile($replacementPath);
*/
			$replacementBase = $this->imageModel->getMeta()->convertMeta()->getReplacementImageBase();
			if (false === $replacementBase)
			{
				$replacementPath = $this->getReplacementPath();
				$replacementFile = $fs->getFile($replacementPath);
			}
			else {
				$replacementPath = $replacementBase . '.jpg';
				$replacementFile = $fs->getFile($this->imageModel->getFileDir() . $replacementPath);
			}

			// If -sigh- file has a placeholder, then do something with that.
			if (true === $this->imageModel->getMeta()->convertMeta()->hasPlaceHolder())
			{
				 $this->imageModel->getMeta()->convertMeta()->setPlaceHolder(false);
				// $this->imageModel->getMeta()->convertMeta()->setReplacementImageBase(false);

		//		 $attach_id = $this->imageModel->get('id');

				// ReplacementFile as source should not point to the placeholder file
				 $this->source_url = $fs->pathToUrl($replacementFile);
				 $this->replacer->setSource($this->source_url);

				 $replacementFile->delete();
			}



			if (isset($optimizeData['files']) && isset($optimizeData['data']))
			{
				 $files = $optimizeData['files'];
				 $data = $optimizeData['data'];
			}
			else {
				Log::addError('Something went wrong with handleOptimized', $optimizeData);
				return false;
			}

			$mainImageKey = $this->imageModel->get('mainImageKey');
			$mainFile = (isset($files) && isset($files[$mainImageKey])) ? $files[$mainImageKey] : false;

			if (false === $mainFile)
			{
				 Log::addError('MainFile not set during success Api Conversion');
				 return false;
			}

			if (! isset($mainFile['image']) || ! isset($mainFile['image']['file']))
			{
				 Log::addError('Optimizer didn\'t return file', $mainFile);
				 return false;
			}

			$tempFile = $fs->getFile($mainFile['image']['file']);

			$res = $tempFile->copy($replacementFile);

			if (true === $res)
			{
				 $this->newFile = $replacementFile;
				 $tempFile->delete();

				 $params = array('success' => true);
				 $this->updateMetaData($params);

				 $result = true;

				// if (true === $args['runReplacer'])
			//	 {
					 $result = $this->replacer->replace();
			//	 }

				 // Conversion done, but backup results.
				 $this->imageModel->conversionSuccess(array('omit_backup' => false));
				 return true;
			}
			else {
				return false;
			}

		}








}
