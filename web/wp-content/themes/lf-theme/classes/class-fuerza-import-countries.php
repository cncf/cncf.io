<?php
// phpcs:ignoreFile
if ( ! class_exists( 'Fuerza_Import_Countries' ) ) {

	/**
	 * Class definition.
	 */
	class Fuerza_Import_Countries {

		public function __construct() {
			add_action( 'admin_init', array( $this, 'handle_request' ) );
		}

		public function handle_request() {
			if ( ! isset( $_GET['fz-countries'] ) ) {
				return;
			}

			$type = $_GET['fz-countries'];

			if ( ! in_array( $type, array( 'update', 'import' ) ) ) {
				return;
			}

			set_time_limit(0);

			$countries = $this->get_countries_list();

			if ( $type == 'update' ) {
				$this->update_terms( $countries );
			}

			if ( $type == 'import' ) {
				$this->import_terms( $countries );
			}
		}

		private function update_terms( $countries ) {
			$terms = get_terms(
				array(
					'taxonomy'   => 'lf-country',
					'hide_empty' => false
				)
			);

			if ( empty( $terms ) ) {
				return;
			}

			$count   = 0;
			$missing = [];

			foreach ( $terms as $term ) {
				$item = $this->find_item_by_name( $term->name, $countries );

				if ( empty( $item ) ) {
					array_push( $missing, $term->name );
					continue;
				}

				wp_update_term(
					$term->term_id,
					'lf-country',
					array(
						'name' => $item['name'],
						'slug' => strtolower( $item['code'] ),
					)
				);

				$count++;
			}

			$message = "<p>Updated terms: {$count}</p>";

			if ( ! empty( $missing ) ) {
				$message .= '<p>Missing terms: ' . implode( ', ', $missing ) . '</p>';
			}

			wp_die( $message, 'LF Events', array( 'back_link' => true ) );
		}

		private function import_terms( $countries ) {
			$count = 0;

			foreach ( $countries as $item ) {
				$is_continent = $this->is_continent( $item[7] );
				$name         = $is_continent ? $item[1] : $item[7];
				$slug         = strtolower( $is_continent ? $item[1] : $item[4] );

				if ( term_exists( $slug, 'lf-country' ) ) {
					continue;
				}

				$args = array( 'slug' => $slug );

				if ( ! $is_continent ) {
					$continent_name = $item[1];
					$term_exists    = term_exists( $continent_name, 'lf-country' );

					if ( ! $term_exists ) {
						$continent_term = wp_insert_term( $continent_name, 'lf-country', array( 'slug' => $continent_name ) );
					} else {
						$continent_term = $term_exists;
					}

					if ( ! is_wp_error( $continent_term ) ) {
						$args['parent'] = $continent_term['term_id'];
					}
				}

				$response = wp_insert_term( $name, 'lf-country', $args );

				if ( ! is_wp_error( $response ) ) {
					$count++;
				}
			}

			$message = "<p>Created terms: {$count}</p>";

			wp_die( $message, 'LF Events', array( 'back_link' => true ) );
		}

		private function find_item_by_name( $name, $countries ) {
			$keys = array_keys(
				array_filter(
						$countries,
						function ( $value ) use ( $name ) {
								$position = $this->is_continent( $name ) ? 1 : 7;
								return ( strpos( $value[ $position ], $name ) !== false );
						}
				)
			);

			if ( empty( $keys ) ) {
				return false;
			}

			$data         = $countries[ $keys[0] ];
			$is_continent = $this->is_continent( $name );

			return array(
				'name'         => $is_continent ? $data[1] : $data[7],
				'code'         => $is_continent ? $data[3] : $data[4],
				'is_continent' => $is_continent,
			);
		}

		private function is_continent( $name ) {
			$continents = array( 'Asia', 'Asia Pacific', 'Europe', 'Africa', 'North America', 'South America', 'Antarctica', 'Oceania' );

			return in_array( trim( $name ), $continents );
		}

		private function get_countries_list() {
			$file = get_stylesheet_directory() . '/countries-data/list.csv';

			if ( ! file_exists( $file ) ) {
				return false;
			}

			$data   = [];
			$handle = fopen( $file, 'r' );

			for ( $i = 0; $row = fgetcsv( $handle ); ++$i ) {
					$data[] = $row;
			}

			fclose( $handle );

			unset( $data[0] ); // Headers

			return $data;
		}
	}

	$instance = new Fuerza_Import_Countries();

}
