<?php

/**
 * Find duplicates according to settings
 */
function pmxi_findDuplicates($articleData, $custom_duplicate_name = '', $custom_duplicate_value = '', $duplicate_indicator = 'title', $indicator_value = '') {
    global $wpdb;

    if ('custom field' == $duplicate_indicator) {

        $duplicate_ids = array();

        if (!empty($articleData['post_type'])) {

            switch ($articleData['post_type']) {

                case 'taxonomies':
                    $args = array(
                        'hide_empty' => FALSE,
                        // also retrieve terms which are not used yet
                        'meta_query' => array(
                            array(
                                'key' => $custom_duplicate_name,
                                'value' => $custom_duplicate_value,
                                'compare' => '='
                            )
                        )
                    );

                    $terms = get_terms($articleData['taxonomy'], $args);

                    if (!empty($terms) && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            $duplicate_ids[] = $term->term_id;
                        }
                    }

                    break;

                case 'comments':
                    $args = array(
                        'hide_empty' => FALSE,
                        // also retrieve terms which are not used yet
                        'meta_query' => array(
                            array(
                                'key' => $custom_duplicate_name,
                                'value' => $custom_duplicate_value,
                                'compare' => '='
                            )
                        )
                    );

                    $comments = get_comments($args);

                    if (!empty($comments) && !is_wp_error($comments)) {
                        foreach ($comments as $comment) {
                            $duplicate_ids[] = $comment->comment_ID;
                        }
                    }

                    break;

                default:

                    $post_types = (class_exists('PMWI_Plugin') and $articleData['post_type'] == 'product') ? array(
                        'product',
                        'product_variation'
                    ) : array($articleData['post_type']);

                    $id = $wpdb->get_var(
                        $wpdb->prepare(
                            "
                            SELECT posts.ID
                            FROM {$wpdb->posts} as posts
                            INNER JOIN {$wpdb->postmeta} AS lookup ON posts.ID = lookup.post_id
                            WHERE
                            posts.post_type IN ( '" . implode("','", $post_types) . "' )                            
                            AND lookup.meta_key = %s
                            AND lookup.meta_value = %s
                            LIMIT 1
                            ",
                            trim($custom_duplicate_name),
                            trim($custom_duplicate_value)
                        )
                    );

                    if ($id) {
                        $duplicate_ids[] = $id;
                    }

                    break;
            }

        }
        else {

            $args = array(
                'meta_query' => array(
                    0 => array(
                        'key' => $custom_duplicate_name,
                        'value' => $custom_duplicate_value,
                        'compare' => '='
                    )
                )
            );
            $user_query = new WP_User_Query($args);

            if (!empty($user_query->results)) {
                foreach ($user_query->results as $user) {
                    $duplicate_ids[] = $user->ID;
                }
            }
            else {
                $query = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS " . $wpdb->users . ".ID FROM " . $wpdb->users . " INNER JOIN " . $wpdb->usermeta . " ON (" . $wpdb->users . ".ID = " . $wpdb->usermeta . ".user_id) WHERE 1=1 AND ( (" . $wpdb->usermeta . ".meta_key = '%s' AND " . $wpdb->usermeta . ".meta_value = '%s') ) GROUP BY " . $wpdb->users . ".ID ORDER BY " . $wpdb->users . ".ID ASC LIMIT 0, 20", $custom_duplicate_name, $custom_duplicate_value));

                if (!empty($query)) {
                    foreach ($query as $p) {
                        $duplicate_ids[] = $p->ID;
                    }
                }
            }
        }

        return $duplicate_ids;

    }
    elseif ('parent' == $duplicate_indicator) {

        $field = 'post_title'; // post_title or post_content
        return $wpdb->get_col($wpdb->prepare("
			SELECT ID FROM " . $wpdb->posts . "
			WHERE
				post_type = %s
				AND ID != %s
				AND post_parent = %s
				AND REPLACE(REPLACE(REPLACE($field, ' ', ''), '\\t', ''), '\\n', '') = %s
			",
            $articleData['post_type'],
            isset($articleData['ID']) ? $articleData['ID'] : 0,
            (!empty($articleData['post_parent'])) ? $articleData['post_parent'] : 0,
            preg_replace('%[ \\t\\n]%', '', $articleData[$field])
        ));
    }
    else {

        if (!empty($articleData['post_type'])) {
            switch ($articleData['post_type']) {
                case 'taxonomies':
                    $field = $duplicate_indicator == 'title' ? 'name' : 'slug';
                    if (empty($indicator_value)) {
                        $indicator_value = $duplicate_indicator == 'title' ? $articleData['post_title'] : $articleData['slug'];
                    }
                    return $wpdb->get_col($wpdb->prepare("
            SELECT t.term_id FROM " . $wpdb->terms . " t
            INNER JOIN " . $wpdb->term_taxonomy . " tt ON (t.term_id = tt.term_id)
            WHERE
                t.term_id != %s
                AND tt.taxonomy LIKE %s
                    AND (REPLACE(REPLACE(REPLACE(t." . $field . ", ' ', ''), '\\t', ''), '\\n', '') = %s
                        OR REPLACE(REPLACE(REPLACE(t." . $field . ", ' ', ''), '\\t', ''), '\\n', '') = %s
                            OR REPLACE(REPLACE(REPLACE(t." . $field . ", ' ', ''), '\\t', ''), '\\n', '') = %s) 
            ",
                        isset($articleData['ID']) ? $articleData['ID'] : 0,
                        isset($articleData['taxonomy']) ? $articleData['taxonomy'] : '%',
                        preg_replace('%[ \\t\\n]%', '', esc_attr($indicator_value)),
                        preg_replace('%[ \\t\\n]%', '', htmlentities($indicator_value)),
                        preg_replace('%[ \\t\\n]%', '', $indicator_value)
                    ));
                    break;
                case 'comments':
                    $field = 'comment_' . $duplicate_indicator; // post_title or post_content
                    return $wpdb->get_col($wpdb->prepare("
            SELECT comment_ID FROM " . $wpdb->comments . "
            WHERE                
                AND comment_ID != %s
                AND REPLACE(REPLACE(REPLACE($field, ' ', ''), '\\t', ''), '\\n', '') = %s
            ",
                        isset($articleData['ID']) ? $articleData['ID'] : 0,
                        preg_replace('%[ \\t\\n]%', '', $articleData[$field])
                    ));
                    break;
                default:
                    $field = 'post_' . $duplicate_indicator; // post_title or post_content
                    return $wpdb->get_col($wpdb->prepare("
            SELECT ID FROM " . $wpdb->posts . "
            WHERE
                post_type = %s
                AND ID != %s
                AND REPLACE(REPLACE(REPLACE($field, ' ', ''), '\\t', ''), '\\n', '') = %s
            ",
                        $articleData['post_type'],
                        isset($articleData['ID']) ? $articleData['ID'] : 0,
                        preg_replace('%[ \\t\\n]%', '', $articleData[$field])
                    ));
                    break;
            }
        }
        else {
            if ($duplicate_indicator == 'title') {
                $field = 'user_login';
                $u = get_user_by('login', $articleData[$field]);
                return (!empty($u)) ? array($u->ID) : FALSE;
            }
            else {
                $field = 'user_email';
                $u = get_user_by('email', $articleData[$field]);
                return (!empty($u)) ? array($u->ID) : FALSE;
            }
        }
    }
}