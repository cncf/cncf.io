<?php


/**
 * Returns the message for no terms found for a givne taxonomy.
 *
 * @since 3.1
 * @param string $taxonomy The taxonomy name
 * @return string The message
 */
function wprss_ftp_no_terms_msg( $taxonomy ) {
	return sprintf(
				__("<span class='ftp-tax-no-terms'>The <strong>%s</strong> taxonomy has no available terms.</span>", WPRSS_TEXT_DOMAIN),
				$taxonomy
			);
}


add_action( 'wp_ajax_wprss_taxonomies', 'wprss_ftp_ajax_taxonomy_for_post_type' );
/**
 * AJAX handler that outputs the taxonomy sections for a given post.
 * Requires the Post ID and it's selected Post Type.
 *
 * @since 3.1
 */
function wprss_ftp_ajax_taxonomy_for_post_type() {
	// Get POST data
	$post_id = isset( $_POST['post_id'] )? $_POST['post_id'] : NULL;
	$post_type = $_POST['post_type'];

	// Get the saved meta data
	$meta = WPRSS_FTP_Meta::get_instance()->get( $post_id, 'taxonomies' );
	// Check if post has old taxonomies options
	if ( $meta === '' ) {
		$meta = WPRSS_FTP_Meta::convert_post_taxonomy_meta( $post_id );
	}

	echo wprss_ftp_taxonomy_sections( $post_type, $meta );
	die();
}

add_action( 'wp_ajax_wprss_terms', 'wprss_ftp_ajax_terms_for_taxonomy' );
/**
 * AJAX Handler that outputs the terms option for a given post.
 * Required the Post ID, the corressponding selected taxonomy and its entry ID.
 *
 * @since 3.1
 */
function wprss_ftp_ajax_terms_for_taxonomy() {
	// Get POST data
	$post_id = isset( $_POST['post_id'] )? $_POST['post_id'] : NULL;
	$post_type = isset( $_POST['post_type'] )? $_POST['post_type'] : NULL;
	$selected = isset( $_POST['selected'] )? $_POST['selected'] : NULL;
	$taxonomy = $_POST['taxonomy'];
	$entry_id = $_POST['entry_id'];

	// Get the saved meta data
	$meta_taxonomies = WPRSS_FTP_Meta::get_instance()->get( $post_id, 'taxonomies' );
	// Check if post has old taxonomies options
	if ( $meta_taxonomies === '' ) {
		$meta_taxonomies = WPRSS_FTP_Meta::convert_post_taxonomy_meta( $post_id );
	}

	// Get the saved terms
	if ( isset( $meta_taxonomies[ $entry_id ]['terms'] ) ) {
		$meta_terms = $meta_taxonomies[$entry_id]['terms'];
		if ( !is_array($meta_terms) ) $meta_terms = array( $meta_terms );
	} else $meta_terms = array();

	// Combine with the recieved POST selected values, if present
	if ( $selected !== NULL && is_array($selected) ) {
		$meta_terms = array_merge( $meta_terms, $selected );
	}
	// Get all the terms for the taxonomy in POST
	$terms = WPRSS_FTP_Utils::get_taxonomy_terms( $taxonomy );

	if ( count($terms) === 0 ) {
		$taxonomies = WPRSS_FTP_Utils::get_post_type_taxonomies( $post_type );
		echo wprss_ftp_no_terms_msg( $taxonomies[$taxonomy] );
		die();
	}

	// Generate the dropdown (option elements only)
	$options = WPRSS_FTP_Utils::array_to_select(
		$terms,
		array(
			'selected'		=>	$meta_terms,
			'multiple'		=>	TRUE,
			'options_only'	=>	TRUE
		)
	);

	// Echp the options and stop
	echo $options;
	die();
}


add_action( 'wp_ajax_new_taxonomy_section', 'wprss_ftp_new_taxonomy_section' );
/**
 * AJAX Handler that outputs a new taxonomy section.
 * Requires the entry ID where the section will be placed, and a selected Post Type.
 *
 * @since 3.1
 */
function wprss_ftp_new_taxonomy_section() {
	echo wprss_ftp_taxonomy_section( $_POST['id'], $_POST['post_type'] );
	die();
}


/**
 * Generates the taxonomy sections for a given post type, and uses the given and
 * optional $meta options to set the values as selected in the fields.
 *
 * @since 3.1
 * @param string $post_type The post type used to determine the taxonomies
 * @param array $meta The array of meta options used to prepare the selected values
 * @return string The HTML output of the taxonomy sections
 */
function wprss_ftp_taxonomy_sections( $post_type, $meta = NULL ) {
	if ( $meta === NULL ) {
		$meta = array();
	}

	$output = '';

	for( $i = 0; $i < count($meta); $i++ ) {
		$entry = $meta[$i];
		$output .= wprss_ftp_taxonomy_section( $i, $post_type, $entry );
	}

	return $output;
}


/**
 * Generates a single taxonomy section for a given post type at the given entry index,
 * and uses the given and optional $meta options to set the values as selected in the fields.
 *
 * @since 3.1
 * @param int $id The entry ID - the index/position of the section
 * @param string $post_type The post type used to determine the taxonomies
 * @param array $meta The array of meta options used to prepare the selected values
 * @return string The HTML output of the taxonomy sections
 */
function wprss_ftp_taxonomy_section( $id, $post_type, $meta = NULL ) {
	if ( $post_type == '' ) {
		$post_type = 'post';
	}

	if ( empty($meta) || !is_array($meta) ) {
		$meta = array(
			'taxonomy'	=>	'',
			'terms'		=>	'',
			'auto'		=>	'false',
            'method'    => WPRSS_FTP_Meta::get_instance()->getDefaultTaxonomyCompareMethod(),
		);
	}
	ob_start(); ?>

	<tr data-id="<?php echo $id; ?>" class="wprss-tr-hr ftp-taxonomy-section">
		<th>
			<?php
				$post_type_taxonomies = WPRSS_FTP_Utils::get_post_type_taxonomies( $post_type );
				if ( count($post_type_taxonomies) > 0 ) {
					echo WPRSS_FTP_Utils::array_to_select(
						$post_type_taxonomies,
						array(
							'id'		=>	'ftp-taxonomy-'.$id,
							'class'		=>	'ftp-taxonomy',
							'name'		=>	WPRSS_FTP_Meta::META_PREFIX . "post_taxonomy[$id]",
							'selected'	=>	$meta['taxonomy']
						)
					);
					/* The taxonomy 'selected' above might be saved in meta, but not in the list.
					 * Therefore, we need to check the REAL selected taxonomy, which could be either
					 * the taxonomy saved in meta also the one selected in the dropdown, or the first
					 * taxonomy in the dropdown if the saved taxonomy is not the dropdown.
					 */
					$selected_tax = $meta['taxonomy'];
					// If the saved taxonomy (also the one to be 'selected') is not present
					if ( !array_key_exists( $meta['taxonomy'], $post_type_taxonomies ) ) {
						// Use the first taxonomy in the list
						reset( $post_type_taxonomies );
						$selected_tax = key( $post_type_taxonomies );
					}

					// The edit taxonomy link - the 'href' attribute and the <span> child element will be populated via JS ?>
					<a class="ftp-edit-tax" href="#" target="_blank" data-base-url="<?php echo admin_url('edit-tags.php?taxonomy='); ?>">
						<i class="fa fa-pencil"></i> Edit <span></span>
					</a>
					<?php
				}
			?>
		</th>

		<td>
			<?php
				if ( count($post_type_taxonomies) === 0 ) :
					$all_post_types = WPRSS_FTP_Meta::get_post_types();
					printf(
						__("<p id='ftp-no-taxonomies'>The Post Type <strong>%s</strong>  has no taxonomies available!</p>", WPRSS_TEXT_DOMAIN),
						$all_post_types[$post_type]
					);
				else :
            ?>
            <div class="ftp-tax-terms-wrapper wpra-metabox-row">
                <div class="ftp-terms-wrapper">
                <?php
                        $tax_terms = WPRSS_FTP_Utils::get_taxonomy_terms( $selected_tax );
                        if ( count($tax_terms) == 0 ) {
                            echo wprss_ftp_no_terms_msg( $post_type_taxonomies[$selected_tax] );
                        } else {
                            echo WPRSS_FTP_Utils::array_to_select(
                                $tax_terms,
                                array(
                                    'id'			=>	'ftp-terms-'.$id,
                                    'class'			=>	'ftp-terms',
                                    'name'			=>	WPRSS_FTP_Meta::META_PREFIX . "post_terms[$id]",
                                    'selected'		=>	$meta['terms'],
                                    'multiple'		=>	TRUE
                                )
                            );
                        }
                ?>
                </div>
                <div class="ftp-tax-row-buttons">
                    <button title="<?php esc_attr_e("Refresh the terms, if they've changed", WPRSS_TEXT_DOMAIN); ?>" type="button" class="ftp-tax-section-refresh button-secondary" data-id="<?php echo $id; ?>">
                        <fa class="fa fa-fw fa-refresh"></fa>
                        <span><?php _e('Refresh terms', WPRSS_TEXT_DOMAIN); ?></span>
                    </button>

                    <button title="<?php esc_attr_e("Remove this entry", WPRSS_TEXT_DOMAIN); ?>" type="button" class="ftp-tax-section-remove button-secondary" data-id="<?php echo $id; ?>">
                        <fa class="fa fa-fw fa-times"></fa>
                        <span><?php _e('Remove row', WPRSS_TEXT_DOMAIN); ?></span>
                    </button>
                </div>
            </div>

					<div class="ftp-auto-terms-wrapper wpra-metabox-row">
						<?php
							echo WPRSS_FTP_Utils::boolean_to_checkbox(
								$meta['auto'],
								array(
									'id'		=>	'ftp-auto-terms-'.$id,
									'class'		=>	'ftp-auto-terms',
									'name'		=>	WPRSS_FTP_Meta::META_PREFIX . "auto_terms[$id]",
									'value'		=>	'true',
								)
							);
						?>
						<label for="ftp-auto-terms-<?php echo $id; ?>"><?php echo sprintf(__('Auto create terms from the feed items for this taxonomy. <a href="%1$s" target="_blank">Learn more here.</a>', WPRSS_TEXT_DOMAIN), 'http://docs.wprssaggregator.com/taxonomies/#taxonomy-options' ) ?></label>
					</div>
					<div class="ftp-taxonomy-conditions-wrapper wpra-metabox-row">
						<?php
							$select = WPRSS_FTP_Utils::array_to_select(
								array(
									'title'		=> __('Feed Title', WPRSS_TEXT_DOMAIN),
									'content'	=> __('Feed Content', WPRSS_TEXT_DOMAIN)
								),
								array(
									'id'		=> 'ftp-tax-filter-subject-'.$id,
									'class'		=> 'ftp-tax-filter-subject',
									'name'		=> WPRSS_FTP_Meta::META_PREFIX . "filter_subject[$id]",
									'selected'	=> isset( $meta['filter_subject'] ) ? $meta['filter_subject'] : null,
									'multiple'	=> TRUE
								)
							);

                            $metaInstance = WPRSS_FTP_Meta::get_instance();
                            $methodSelect = WPRSS_FTP_Utils::array_to_select(
                                $metaInstance->getTaxonomyCompareMethods(),
								array(
									'id'		=> 'ftp-tax-compare-method-'.$id,
									'class'		=> 'ftp-tax-compare-method',
									'name'		=> WPRSS_FTP_Meta::META_PREFIX . "post_taxonomy_compare_method[$id]",
									'selected'	=> isset( $meta['post_taxonomy_compare_method'] ) ? $meta['post_taxonomy_compare_method'] : $metaInstance->getDefaultTaxonomyCompareMethod(),
								)
							);
							_e(
								sprintf(
									'Only apply the preceding terms if the %1$s contains %2$s of the following keywords: ',
									$select,
                                    $methodSelect
								),
								WPRSS_TEXT_DOMAIN
							);
						?>

							<input
								type="text"
								id="ftp-tax-filter-keywords-<?php echo $id ?>"
								name="<?php echo WPRSS_FTP_Meta::META_PREFIX . "filter_keywords[$id]" ?>"
								value="<?php echo isset( $meta['filter_keywords'] ) ? $meta['filter_keywords'] : '' ?>"
								placeholder="<?php _e('Enter comma separated words or phrases', WPRSS_TEXT_DOMAIN) ?>"
								style="width:100%"
							/>
                    </div>
			<?php endif; ?>
		</td>
	</tr>

	<?php return ob_get_clean();
}


/**
 * Returns the term, creating it if it does not exist, by slug.
 *
 * @since 3.1
 * @uses wp_insert_term
 * @uses term_exists
 * @param string $slug The term slug
 * @param string $taxonomy The taxonomy of the term to get or create
 * @param string $return (Optional) The field to return: 'OBJECT', 'SLUG' or 'ID. Default: 'SLUG'
 * @param array $args (Optional) The args to pass to `wp_insert_term` if the term is to be created.
 * @return string|object Depends on the $returns parameter. Returns FALSE if term was not found and
 * 							could not be created.
 */
function wprss_ftp_create_or_get_term( $slug, $taxonomy, $return = 'SLUG', $args = array() ) {
	// Check if term exists
	$exists = term_exists( $slug, $taxonomy );
	// If not, create it
	if ( $exists === 0 || $exists === NULL ) {
		$exists = wp_insert_term( $slug, $taxonomy, $args );
	}
	// Get the ID
	$term_id = $exists['term_id'];
	// Get the full term object
	$term_obj = get_term_by( 'id', $term_id, $taxonomy );
	// If not found, return FALSE
	if ( $term_obj == FALSE ) return FALSE;

	// Check the return parameter, and return the appropriate data
	$return = strtoupper( $return );
	switch( $return ) {
		default:
		case 'OBJECT': return $term_obj;
		case 'ID': return $term_obj->term_id;
		case 'SLUG': return $term_obj->slug;
	}

	// Just in case
	return FALSE;
}


/**
 * Inserts the terms into a given post, based on their saved meta/
 *
 * This function replaces the old taxonomy code in the converter class, utilizing the new meta data
 * format used for the taxonomies. The terms for each taxonomy, along with any auto created feed terms
 * are inserted into the post.
 *
 * @since 3.1
 * @param int $post_id The ID of the post.
 * @param int $feed_id The ID of the feed source that imported the post.
 * @param object $sp_item The SimplePie_Item from which the post was converted.
 * @return bool TRUE if the terms where inserted successfully, FALSE if the post was not found.
 */
function wprss_ftp_add_taxonomies_to_post( $post_id, $feed_id, $sp_item ) {
	// If the post does not exist, stop immediately
	if ( get_post( $post_id ) === null ) return NULL;

	// Get the taxonomies meta
	$meta = WPRSS_FTP_Meta::get_instance()->get( $feed_id, 'taxonomies' );
	// If the source has the old meta saved, convert it into the new meta
	if ( $meta === '' ) {
		$meta = WPRSS_FTP_Meta::convert_post_taxonomy_meta( $feed_id );
	}

	// Get the settings instance
	$settings = WPRSS_FTP_Settings::get_instance();
	// Get the post type saved in the settings
	$settings_post_type = $settings->get( 'post_type' );
	// If it matches, add the settings taxonomies to the meta taxonomies
	if ( $settings_post_type === get_post_type( $post_id ) ) {
		// Get the taxonomies settings, and convert from old format if needed
		$settings_taxonomies = $settings->get( 'taxonomies' );
		if ( $settings_taxonomies === '' ) {
			$settings_taxonomies = WPRSS_FTP_Settings::convert_post_taxonomy_settings();
		}
		// Add to meta taxonomies
		$meta = array_merge( (array) $settings_taxonomies, (array) $meta );
	}

	$tax_iterated = array();

	// For each entry
	foreach( $meta as $entry ) {
		// Check if this taxonomy term should be applied.
		if ( wprss_ftp_should_apply_taxonomy( $entry, $sp_item ) === FALSE ) {
			continue;
		}

		// Get the data
		$taxonomy = $entry['taxonomy'];
		$terms = $entry['terms'];
		$terms = is_array( $terms ) ? $terms : array();
		$auto = WPRSS_FTP_Utils::multiboolean( $entry['auto'] );
		$feed_terms = array();

		// Repeat the taxonomy slug in an array with the same length as the terms array
		$taxonomies_array = count( $terms ) > 0 ? array_fill( 0, count($terms), $taxonomy ) : array();
		// Run the term slugs through the 'wprss_ftp_create_or_get_term'
		$terms_to_set = array_map( 'wprss_ftp_create_or_get_term', $terms, $taxonomies_array);
		// Filter the terms to remove NULL entries (NULL can be returned by 'wprss_ftp_create_or_get_term')
		$terms_to_set = array_filter( $terms_to_set );

		// If auto creation is enabled
		if ( $auto === TRUE ) {
			// If auto create is enabled, get the terms from the feed
			$feed_terms = $sp_item->get_categories();
			$feed_terms = is_array( $feed_terms )? $feed_terms : array();
			// Map the terms through our preparation function, and filter them for custom user manipulation
			$feed_terms = array_map( 'wprss_ftp_prepare_auto_created_term', $feed_terms );
			$feed_terms = apply_filters( 'wprss_auto_create_terms', $feed_terms, $taxonomy, $feed_id );
			// Repeat the taxonomy slug in an array with the same length as the terms array
			$num_terms = count( $feed_terms );
			$taxonomies_array = $num_terms > 0? array_fill( 0, $num_terms, $taxonomy ) : array();
			// Run them through the `wprss_ftp_process_auto_created_terms` function for processing
			$feed_terms = array_map( 'wprss_ftp_process_auto_created_terms', $feed_terms, $taxonomies_array );
			// Filter the terms to remove NULL entries (NULL can be returned by 'wprss_ftp_create_or_get_term')
			$feed_terms = array_filter( $feed_terms );
			// Add them to the terms to set
			$terms_to_set = array_merge( (array) $terms_to_set, (array) $feed_terms );
		}

		// Add the taxonomy to the tax_iterated array if it's not already in the array
		if ( ! in_array( $taxonomy, $tax_iterated ) ) {
			$tax_iterated[] = $taxonomy;
			// Set no terms, and override existing - to remove any default terms, like 'Uncategorized'
			wp_set_object_terms( $post_id, array(), $taxonomy, FALSE );
		}
		// Insert the terms
		wp_set_object_terms( $post_id, $terms_to_set, $taxonomy, TRUE );
		// clear the cache
		delete_option($taxonomy."_children");
	}

	return TRUE;
}

/**
 * Checks for any conditions that must be met for taxonomy terms to be applied.
 *
 * @since 3.5
 * @param object $entry The taxonomy entry to check whether we should apply.
 * @param object $item The SimplePie RSS item
 * @return boolean TRUE if the taxonomy term should be applied, else FALSE.
 */
function wprss_ftp_should_apply_taxonomy( $entry, $item ) {
	$subjects = isset($entry['filter_subject'])
        ? $entry['filter_subject']
        : [];

	$keywords = isset($entry['filter_keywords'])
        ? $entry['filter_keywords']
        : '';
	$keywords = explode( ',', $keywords );


    $method = isset($entry['post_taxonomy_compare_method'])
        ? $entry['post_taxonomy_compare_method']
        : WPRSS_FTP_Meta::get_instance()->getDefaultTaxonomyCompareMethod();

	if ( empty( $keywords ) || empty( $subjects ) ) return true;

    if ($method === 'all') {
        foreach ( $keywords as $keyword ) {
            $keyword = trim( $keyword );

            foreach ( $subjects as $subject ) {
                if ( $subject === 'title' && stripos( $item->get_title(), $keyword ) === FALSE ) {
                    return FALSE;
                }

                if ( $subject === 'content' && stripos( $item->get_content(), $keyword ) === FALSE ) {
                    return FALSE;
                }
            }
        }

        return TRUE;
    }
    elseif ($method === 'any') {
        foreach ($keywords as $keyword) {
            $keyword = trim($keyword);

            foreach ($subjects as $subject) {
                if ($subject === 'title' && stripos($item->get_title(), $keyword) !== false) {
                    return true;
                }

                if ($subject === 'content' && stripos($item->get_content(), $keyword) !== false) {
                    return true;
                }
            }
        }

        return false;
    }
    else {
        return apply_filters('wprss_ftp_should_apply_taxonomy_method_other', false, $entry, $item);
    }

    return false;
}

/**
 * Prepares the given term for user filtering via the `wprss_auto_create_terms` filter.
 *
 * The function (called via array_map by `wprss_ftp_add_taxonomies_to_post`) takes the term and generates an
 * assoc. array with 'name' and 'args' entries. This makes the user filter easier to use, manipulating the
 * assoc arrays generated rather than WP's term objects.
 *
 * @since 3.1
 * @param object $term The term to be prepared
 * @return array An assoc array, with the term label in the 'name' index and an empty array in the  'args' index.
 */
function wprss_ftp_prepare_auto_created_term( $term ) {
	return array(
		'name'	=>	$term->get_label(),
		'args'	=>	array(),
	);
}


/**
 * Process auto created terms, after they have been prepared by `wprss_ftp_prepare_auto_created_term`,
 * and filtered through the user filter `wprss_auto_create_terms`.
 *
 * After the auto created terms have been prepared and processed through the user filter, this function (called via array_map
 * by `wprss_ftp_add_taxonomies_to_post`) checks if the term exists and creates it if not. It's parent argument is also
 * checked and is also created if not found.
 *
 * @since 3.1
 * @param string $term The term assoc array to be processed, in the format given by `wprss_ftp_prepare_auto_created_term`
 * @param string $taxonomy The slug of the taxonomy of the term to be processed
 * @return string The slug of the processed term.
 */
function wprss_ftp_process_auto_created_terms( $term, $taxonomy ) {
	// Get the data
	$term_slug = $term['name'];
	$args = isset( $term['args'] )? $term['args'] : array();

	// If the parent field exists
	// Change the its value into an ID. If the term does not exist, it is created
	if ( !empty( $args['parent'] ) ) {
		// Get it - it's the slug
		$parent_slug = $args['parent'];
		// Get the parent term, or create it, returning the ID into the parent field
		$args['parent'] = wprss_ftp_create_or_get_term( $parent_slug, $taxonomy, 'ID' );
	}

	// Get or create the term
	$term_slug = wprss_ftp_create_or_get_term( $term_slug, $taxonomy, 'SLUG', $args );

	// Return it
	return $term_slug;
}
