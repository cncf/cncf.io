<?php 

function pmxi_delete_term($term, $tt_id, $taxonomy, $deleted_term, $object_ids) {
	if (is_numeric($term)){
		$post = new PMXI_Post_Record();
        $post->getBy(array(
            'post_id' => $term,
            'product_key' => 'taxonomy_term',
        ));
        $post->isEmpty() or $post->delete();
        // Delete entries from the hash table when posts are deleted.
        $hashRecord = new PMXI_Hash_Record();
        $hashRecord->getBy(['post_id' => $term, 'post_type' => 'taxonomy'])->isEmpty() or $hashRecord->delete();
	}
}