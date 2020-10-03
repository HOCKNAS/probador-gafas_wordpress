<?php

// Activa el plugin
class Try_on_sck_Activator {
	public static function activate() {
		global $wpdb;
		$create_table_query = "
				CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}sck_options` (
				  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				  `name` text NOT NULL,
				  `value` text NOT NULL,
				  PRIMARY KEY (id)
				)AUTO_INCREMENT=100  ENGINE=MyISAM  DEFAULT CHARSET=utf8;
		";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $create_table_query );
		$tableName =$wpdb->prefix.'sck_options';
		$bootstrap_enable=$wpdb->get_results ( "
		SELECT value 
		FROM  ".$wpdb->prefix."sck_options where name='include_bootstrap'" );
		
		if(count($bootstrap_enable) == 0){
		
		$result = $wpdb->insert($tableName, array(
			"id" => '100',
			"name" => 'include_bootstrap',
			"value" => 'yes'
		 ), array( '%d', '%s', '%s' ) );
		}
	}

}
