<?php
/**
 * @package   GFP_Dynamic_Population
 * @copyright 2014-2019 gravity+
 * @license   GPL-2.0+
 * @since     1.0.0
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */

/**
 * Class GFP_Dynamic_Population_Custom_Data
 *
 * Handles custom data used in form fields
 *
 * @since 1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Dynamic_Population_Custom_Data {

	private static $_tables = array();

	private static $_table_columns = array();


	/**
	 * Get all of the tables in the WP database
	 *
	 * @since    1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @internal important to *not* make the assumption that these tables will have the $wpdb->prefix
	 *
	 * @return array
	 */
	public static function get_tables() {

		global $wpdb;

		$tables = array();

		if ( ! empty( self::$_tables ) ) {

			$tables = self::$_tables;

		} else {

			$query = 'SHOW TABLES';

			$results = $wpdb->get_results( $query, ARRAY_N );

			if ( ! empty( $results ) ) {

				foreach ( $results as $index => $result ) {

					$tables[ ] = $result[ 0 ];

				}

				self::$_tables = $tables;
			}
		}

		return $tables;
	}

	/**
	 * Get columns in table
	 *
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $table
	 *
	 * @return array
	 */
	public static function get_table_columns( $table ) {

		global $wpdb;

		$columns = array();

		if ( ! empty( self::$_table_columns[ $table ] ) ) {

			$columns = self::$_table_columns[ $table ];

		} else {

			$table = esc_sql( $table );
			$query = "SHOW COLUMNS from {$table}";

			$results = $wpdb->get_results( $query, ARRAY_A );

			if ( ! empty( $results ) ) {

				foreach ( $results as $result ) {

					$columns[ ] = $result[ 'Field' ];

				}

				self::$_table_columns[ $table ] = $columns;

			}

		}

		return $columns;
	}

	public static function get_custom_query( $query ) {
	}

	/**
	 * Get values
	 *
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param string $table table name
	 * @param string $column       label column, if separate value column is used. Otherwise, the label & value column
	 * @param array  $where_rule   Any where rules
	 * @param string $sort_order   ASC or DESC
	 * @param string $value_column A separate value column
	 *
	 * @return array
	 */
	public static function get_column_values( $table, $column, $where_rule = array(), $sort_order, $value_column = '' ) {

		global $wpdb;

		$column_values = array();

		$table  = esc_sql( $table );
		$columns = $column = esc_sql( $column );

		if ( ! empty( $value_column ) ) {

			$value_column = esc_sql( $value_column );

			if ( $value_column !== $column ) {

				$columns .= ',' . esc_sql( $value_column );

			}

		}

		if ( ! empty( $where_rule ) ) {

			$where     = '';
			$num_rules = 0;

			foreach ( $where_rule as $rule ) {

				if ( 0 < $num_rules ) {

					$where .= ' AND ';

				}

				$rule[ 'column' ] = esc_sql( $rule[ 'column' ] );

				if ( empty( $rule['operator'] ) ) {

					$value = "='{$rule['value']}'";

				}
				else {

					switch( $rule['operator'] ) {

						case 'is':

							$value = "='{$rule['value']}'";

							break;

						case 'contains':

							$value = "LIKE '%{$rule['value']}%'";

							break;

						case 'starts_with':

							$value = "LIKE '{$rule['value']}%'";

							break;

						case 'ends_with':

							$value = "LIKE '%{$rule['value']}'";

							break;
					}

				}

				$where .= "{$rule['column']} {$value}";

				$num_rules ++;

			}

		}

		if ( empty( $sort_order ) || ! in_array( $sort_order, array( 'ASC', 'DESC' ) ) ) {

			$sort_order = 'ASC';

		}

		if ( empty( $where ) ) {

			$query = "SELECT {$columns} FROM {$table} GROUP BY {$column} {$sort_order}";

		} else {

			$query = "SELECT {$columns} FROM {$table} WHERE {$where} GROUP BY {$column} {$sort_order}";

		}

		$results = $wpdb->get_results( $query, ARRAY_N );

		if ( ! empty( $results ) ) {

			$column_values = $results;

		}

		return $column_values;
	}

	/**
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public static function flush_current_data() {

		self::$_tables        = array();
		self::$_table_columns = array();

	}

}