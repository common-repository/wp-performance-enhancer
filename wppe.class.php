<?php
/**
 * Wordpress Performance Enhancer
 * 
 * @version 1.0
 * @author Robert Lord, Codepeak AB <robert@codepeak.se>
 */

class wppe {
	
	/**
	 * Hook to run when the admin menu is processed
	 */
	function addMenu() {
		add_action( 'admin_menu', array('wppe','menu_init') );
	}
	
	/**
	 * Actually add the menu when called
	 */
	function menu_init() {
		add_menu_page( __('Wordpress Performance Enhancer', 'wp-performance-enhancer'), __('Maintenance', 'wp-performance-enhancer'), 'activate_plugins', 'wppe-settings', array('wppe','admin_page_settings') );
	}
	
	/**
	 * Our administration page
	 */
	function admin_page_settings() {
		
		include( WPPE_BASE . 'tpl/admin.tpl.php' );
		
	}
	
	/**
	 * Return an array with all tables in the database
	 */
	function database_list_tables() {
		
		global $wpdb;
		$results = $wpdb->get_results("SHOW TABLES FROM `" . DB_NAME . "`");		
		$list = array();
		foreach ( $results as $key => $data ) $list[] = current( $data );
		return $list;

	}
	
	/**
	 * Database, calculate how much the data is overhead 
	 */
	function database_calculate_overhead() {

		$overhead = 0;
		
		global $wpdb;
		$results = $wpdb->get_results("SHOW TABLE STATUS");
		foreach ( $results as $data ) $overhead = $overhead + $data->Data_free;
		
		// Convert into kb
		$overhead = round( ($overhead/1024) ,2);
		
		return $overhead;
	
	}
	
	/**
	 * Optimize the database
	 */
	function optimize_db() {
		
		global $wpdb;
		
		// Get all tables
		$tables = self::database_list_tables();
		$list2 = array();
		foreach ( $tables as $tbl ) $list2[] = '`' . $tbl . '`';
		
		// Join them in a SQL array
		$sql = 'OPTIMIZE TABLE ' . implode(', ', $list2);
		
		// Perform SQL query
		$wpdb->query( $sql );

	}
	
	/**
	 * Find all orphans in postmeta-table
	 */
	function findOrphanPostmeta($delete=FALSE) {
		
		global $wpdb;
		
		$deleteIDs = array();
		$postsID = array();
		$missingCount = 0;
		
		// Get a list of all posts
		$posts = $wpdb->get_results("SELECT `ID` FROM `" . $wpdb->posts . "`");
		foreach ( $posts as $post ) $postsID[] = $post->ID;
		
		// Loop through all the postmeta
		$postmeta = $wpdb->get_results("SELECT COUNT(*) as `count`, `post_id` FROM `" . $wpdb->postmeta . "` GROUP BY `post_id`");
		
		foreach ( $postmeta as $pm ) {

			$missing = FALSE;
			if ( !in_array($pm->post_id, $postsID) ) {
				$missing = TRUE;
				$missingCount =+ $pm->count;
			}

			if ( $missing == TRUE && $delete == TRUE ) {
				// Add for deletelist
				$deleteIDs[] = $pm->post_id;
			}
			
		}
		
		// Delete the entries
		foreach ( $deleteIDs as $id ) {
			$wpdb->query("DELETE FROM `" . $wpdb->postmeta . "` WHERE `post_id` = '" . $id . "'");
		}
	
		
		return $missingCount;
		
	}
	
}

$wppe = new wppe();