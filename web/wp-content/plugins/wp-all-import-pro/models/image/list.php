<?php

/**
 * Class PMXI_Image_List
 */
class PMXI_Image_List extends PMXI_Model_List {

    /**
     * PMXI_Image_List constructor.
     */
    public function __construct() {
		parent::__construct();
		$this->setTable(PMXI_Plugin::getInstance()->getTablePrefix() . 'images');
	}

    /**
     * @param $url
     * @return array|bool|null|\WP_Post
     */
    public function getExistingImageByUrl($url) {
        $args = array(
            'image_url' => trim($url),
        );
        return $this->getExistingImage($args);
    }

    /**
     * @param $image
     * @return array|bool|null|\WP_Post
     */
    public function getExistingImageByFilename($image) {
        $args = array(
            'image_filename' => trim($image),
        );
        return $this->getExistingImage($args, false);
    }

    /**
     * @param $args
     * @return array|bool|null|\WP_Post
     */

    public function getExistingImage($args, $allow_filter = true){
        $attch = false;
        foreach($this->getBy($args)->convertRecords() as $imageRecord) {
            if ( ! $imageRecord->isEmpty() ) {
                // only allow the filter if not matching by Filename
                $attid = ($allow_filter) ? apply_filters('wp_all_import_get_existing_image', $imageRecord->attachment_id) : $imageRecord->attachment_id;

                $attch = get_post($attid);
                if ($attch) {
                    break;
                }
                else{
                    $imageRecord->delete();
                }
            }
        }

        return $attch;
    }
}