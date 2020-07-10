<?php 

function pmxi_delete_post($post_id) {
    if (!empty($post_id) && is_numeric($post_id)){
        $post    = new PMXI_Post_Record();
        $is_post = ! $post->getBy( 'post_id', $post_id )->isEmpty();
        if ( $is_post ) {
            $post->delete();
        } else {
            $image = new PMXI_Image_Record();
            $image->getBy( 'attachment_id', $post_id )->isEmpty() or $image->delete();
        }
        // Delete entries from the hash table when posts are deleted.
        $hashRecord = new PMXI_Hash_Record();
        $hashRecord->getBy(['post_id' => $post_id, 'post_type' => 'post'])->isEmpty() or $hashRecord->delete();
    }
}