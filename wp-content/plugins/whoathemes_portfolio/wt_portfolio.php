<?php
/*
Plugin Name: Whoathemes Portfolio
Plugin URI: http://whoathemes.com
Description: Portfolio wordpress plugin template
Version: 1.0
Author: Whoathemes
Author URI: http://whoathemes.com
*/

if(!class_exists('Whoathemes_Portfolio')) {
	class Whoathemes_Portfolio	{
		/**
		 * Construct the plugin object
		 */
		public function __construct() {
        	
			require_once(sprintf("%s/types/portfolio.php", dirname(__FILE__)));
		} // END public function __construct
	    
		/**
		 * Activate the plugin
		 */
		public static function activate() {
			// Do nothing
		} // END public static function activate
	
		/**
		 * Deactivate the plugin
		 */		
		public static function deactivate() {
			// Do nothing
		} // END public static function deactivate
	} // END class Whoathemes_Portfolio
} // END if(!class_exists('Whoathemes_Portfolio'))

if(class_exists('Whoathemes_Portfolio')) {
	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('Whoathemes_Portfolio', 'activate'));
	register_deactivation_hook(__FILE__, array('Whoathemes_Portfolio', 'deactivate'));

	// instantiate the plugin class
	$whoathemes_portfolio = new Whoathemes_Portfolio();
	
    // Add a link to the settings page onto the plugin page
   /* if(isset($whoathemes_portfolio)) {
        // Add the settings link to the plugins page
        function whoathemes_portfolio_link($links) { 
            return $links; 
        }

        $plugin = plugin_basename(__FILE__); 
        add_filter("plugin_action_links_$plugin", 'whoathemes_portfolio_link');
    }*/
}
/*-----------------------------------------------------------------------------------*/
/* Manage portfolio's columns */
/*-----------------------------------------------------------------------------------*/
function edit_wt_portfolio_columns($columns) {
	$columns['portfolio_categories'] = esc_html__('Categories', 'wt_admin' );
	$columns['description'] = esc_html__('Description', 'wt_admin' );
	$columns['thumbnail'] = esc_html__('Thumbnail', 'wt_admin' );
	
	return $columns;
}
add_filter('manage_edit-wt_portfolio_columns', 'edit_wt_portfolio_columns');

function manage_wt_portfolio_columns($column) {
	global $post;
	
	if ($post->post_type == "wt_portfolio") {
		switch($column){
			case "description":
				the_excerpt();
				break;
			case "portfolio_categories":
				$terms = get_the_terms($post->ID, 'wt_portfolio_category');
				
				if (! empty($terms)) {
					foreach($terms as $t)
						$output[] = "<a href='edit.php?post_type=wt_portfolio&wt_portfolio_category=$t->slug'> " . esc_html(sanitize_term_field('name', $t->name, $t->term_id, 'wt_portfolio_category', 'display')) . "</a>";
					$output = implode(', ', $output);
				} else {
					$t = get_taxonomy('wt_portfolio_category');
					$output = "No $t->label";
				}
				
				echo balanceTags( $output );
				break;
			
			case 'thumbnail':
				echo the_post_thumbnail('thumbnail');
				break;
		}
	}
}
add_action('manage_posts_custom_column', 'manage_wt_portfolio_columns', 10, 2);