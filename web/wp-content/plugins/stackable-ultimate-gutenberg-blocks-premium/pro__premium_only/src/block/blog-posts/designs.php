<?php

if ( ! function_exists( 'stackable_blog_posts_design_portfolio' ) ) {
	function stackable_blog_posts_design_portfolio( $post_markup, $design, $props ) {
		$attributes = $props['attributes'];
		$post_id = $props['post_id'];

		if ( $design === 'portfolio' || $design === 'portfolio2' ) {

			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full', false );
			$styles = array();
			if ( ! empty( $image ) ) {
				$styles[] = "background-image: url(" . esc_attr( $image[0] ) . ")";
			}
			if ( ! empty( $attributes['borderRadius'] ) || $attributes['borderRadius'] !== 0 ) {
				$styles[] = 'border-radius: ' . $attributes['borderRadius'] . 'px';
			}

			$classes = array( 'ugb-blog-posts__item' );
			if ( ! empty( $attributes['shadow'] ) || $attributes['shadow'] !== 0 ) {
				$classes[] = 'ugb--shadow-' . $attributes['shadow'];
			}


			$markup = "<article class='" . implode( ' ', $classes ) . "' style='" . implode( ';', $styles ) . "'>";
            // $markup .= $props['featured_image'];
            $markup .= "<div class='ugb-blog-posts__side'>";
            $markup .= $props['category'];
            $markup .= $props['title'];
            $markup .= $props['excerpt'];
			$markup .= $props['read_more'];
            if ( $attributes['displayDate'] || $attributes['displayAuthor'] || $attributes['displayComments'] ) {
                $markup .= '<aside class="entry-meta ugb-blog-posts__meta">';
                $markup .= $props['author'];
                if ( ! empty( $attributes['displayAuthor'] ) && ( ! empty( $attributes['displayDate'] ) || ! empty( $attributes['displayComments'] ) ) ) {
                    $markup .= '<span class="ugb-blog-posts__sep">&middot;</span>';
                }
                $markup .= $props['date'];
                if ( ! empty( $attributes['displayDate'] ) && ! empty( $attributes['displayComments'] ) ) {
                    $markup .= '<span class="ugb-blog-posts__sep">&middot;</span>';
                }
                $markup .= $props['comments'];
                $markup .= '</aside>';
            }
            $markup .= "</div>";
			$markup .= "</article>";
			return $markup;
		}

		if ( $design === 'vertical-card' || $design === 'horizontal-card' ) {

			$styles = array();
			if ( ! empty( $attributes['borderRadius'] ) || $attributes['borderRadius'] !== 0 ) {
				$styles[] = 'border-radius: ' . $attributes['borderRadius'] . 'px';
			}

			$classes = array( 'ugb-blog-posts__item' );
			if ( ! empty( $attributes['shadow'] ) || $attributes['shadow'] !== 0 ) {
				$classes[] = 'ugb--shadow-' . $attributes['shadow'];
			}

			$markup = "<article class='" . implode( ' ', $classes ) . "' style='" . implode( ';', $styles ) . "'>";
            $markup .= $props['featured_image'];
            $markup .= "<div class='ugb-blog-posts__side'>";
            $markup .= $props['category'];
            $markup .= $props['title'];
            $markup .= $props['excerpt'];
			$markup .= $props['read_more'];
            if ( $attributes['displayDate'] || $attributes['displayAuthor'] || $attributes['displayComments'] ) {
                $markup .= '<aside class="entry-meta ugb-blog-posts__meta">';
                $markup .= $props['author'];
                if ( ! empty( $attributes['displayAuthor'] ) && ( ! empty( $attributes['displayDate'] ) || ! empty( $attributes['displayComments'] ) ) ) {
                    $markup .= '<span class="ugb-blog-posts__sep">&middot;</span>';
                }
                $markup .= $props['date'];
                if ( ! empty( $attributes['displayDate'] ) && ! empty( $attributes['displayComments'] ) ) {
                    $markup .= '<span class="ugb-blog-posts__sep">&middot;</span>';
                }
                $markup .= $props['comments'];
                $markup .= '</aside>';
            }
            $markup .= "</div>";
			$markup .= "</article>";
			return $markup;
		}

		if ( $design === 'vertical-card2' ) {

			$styles = array();
			if ( ! empty( $attributes['borderRadius'] ) || $attributes['borderRadius'] !== 0 ) {
				$styles[] = 'border-radius: ' . $attributes['borderRadius'] . 'px';
			}

			$classes = array( 'ugb-blog-posts__item' );
			if ( ! empty( $attributes['shadow'] ) || $attributes['shadow'] !== 0 ) {
				$classes[] = 'ugb--shadow-' . $attributes['shadow'];
			}

			$markup = "<article class='" . implode( ' ', $classes ) . "' style='" . implode( ';', $styles ) . "'>";
            $markup .= "<div class='ugb-blog-posts__side'>";
            $markup .= $props['category'];
            $markup .= $props['title'];
            $markup .= $props['excerpt'];
			$markup .= $props['read_more'];
            $markup .= "</div>";
            $markup .= $props['featured_image'];
            if ( $attributes['displayDate'] || $attributes['displayAuthor'] || $attributes['displayComments'] ) {
                $markup .= '<aside class="entry-meta ugb-blog-posts__meta">';
                $markup .= $props['author'];
                if ( ! empty( $attributes['displayAuthor'] ) && ( ! empty( $attributes['displayDate'] ) || ! empty( $attributes['displayComments'] ) ) ) {
                    $markup .= '<span class="ugb-blog-posts__sep">&middot;</span>';
                }
                $markup .= $props['date'];
                if ( ! empty( $attributes['displayDate'] ) && ! empty( $attributes['displayComments'] ) ) {
                    $markup .= '<span class="ugb-blog-posts__sep">&middot;</span>';
                }
                $markup .= $props['comments'];
                $markup .= '</aside>';
            }
			$markup .= "</article>";
			return $markup;
		}

		if ( $design === 'image-card' ) {

			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full', false );
			$header_styles = array();
			if ( ! empty( $image ) ) {
				$header_styles[] = "background-image: url(" . esc_attr( $image[0] ) . ")";
			}

			$styles = array();
			if ( ! empty( $attributes['borderRadius'] ) || $attributes['borderRadius'] !== 0 ) {
				$styles[] = 'border-radius: ' . $attributes['borderRadius'] . 'px';
			}

			$classes = array( 'ugb-blog-posts__item' );
			if ( ! empty( $attributes['shadow'] ) || $attributes['shadow'] !== 0 ) {
				$classes[] = 'ugb--shadow-' . $attributes['shadow'];
			}

			$markup = "<article class='" . implode( ' ', $classes ) . "' style='" . implode( ';', $styles ) . "'>";
			$markup .= "<div class='ugb-blog-posts__header' style='" . implode( ';', $header_styles ) . "'>";
			if ( $attributes['displayDate'] || $attributes['displayAuthor'] || $attributes['displayComments'] ) {
                $markup .= '<aside class="entry-meta ugb-blog-posts__meta">';
                $markup .= $props['author'];
                if ( ! empty( $attributes['displayAuthor'] ) && ( ! empty( $attributes['displayDate'] ) || ! empty( $attributes['displayComments'] ) ) ) {
                    $markup .= '<span class="ugb-blog-posts__sep">&middot;</span>';
                }
                $markup .= $props['date'];
                if ( ! empty( $attributes['displayDate'] ) && ! empty( $attributes['displayComments'] ) ) {
                    $markup .= '<span class="ugb-blog-posts__sep">&middot;</span>';
                }
                $markup .= $props['comments'];
                $markup .= '</aside>';
            }
			$markup .= $props['title'];
            $markup .= "</div>";
            $markup .= "<div class='ugb-blog-posts__side'>";
            $markup .= $props['excerpt'];
			$markup .= $props['read_more'];
            $markup .= $props['category'];
            $markup .= "</div>";
			$markup .= "</article>";
			return $markup;
		}

		return $post_markup;
	}
	add_filter( 'stackable/designs_blog-posts_save', 'stackable_blog_posts_design_portfolio', 10, 3 );
}

if ( ! function_exists( 'stackable_blog_posts_custom_css' ) ) {
	function stackable_blog_posts_custom_css( $output, $design, $props ) {
		$attributes = $props['attributes'];
		if ( ! empty( $attributes['customCSSCompiled'] ) ) {
			$output .= '<style>' . $attributes['customCSSCompiled'] . '</style>';
		}
		return $output;
	}
	add_filter( 'stackable/blog-posts_save_output_before', 'stackable_blog_posts_custom_css', 10, 3 );
}

if ( ! function_exists( 'stackable_blog_posts_main_classes' ) ) {
	function stackable_blog_posts_main_classes( $classes, $design, $props ) {
		$attributes = $props['attributes'];
		if ( ! empty( $attributes['customCSSUniqueID'] ) ) {
			$classes[] = $attributes['customCSSUniqueID'];
		}
		return $classes;
	}
	add_filter( 'stackable/blog-posts_main-classes', 'stackable_blog_posts_main_classes', 10, 3 );
}
