<?php
/**
 * Used for the theme's initialization.
 */
class wt_themeFiles {

	function wt_init($options) {
		
		/* Define theme's constants. */
		$this->wt_constants($options);
		
		/* Add theme support. */
		add_action('after_setup_theme', array(&$this, 'wt_supports'));
		
		/* Load theme's functions. */
		$this->wt_functions();
		
		/* Load theme's plugin. */
		$this->wt_plugins();
		
		/* Load WhoaThemes shortcodes within Visual Composer Plugin. */
		$this->wt_visual_composer_extensions();
		
		/* Initialize the theme's widgets. */
		add_action('widgets_init',array(&$this, 'wt_widgets'));
		
		/* Load admin files. */
        $this->wt_admin();
		
		//Long posts should require a higher limit, see http://core.trac.wordpress.org/ticket/8553
		//@ini_set('pcre.backtrack_limit', 500000);
	}
	
	/**
	 * Defines the constant paths for use within the theme.
	 */
	function wt_constants($options) {
		define('THEME_NAME', $options['theme_name']);
		define('THEME_SLUG', $options['theme_slug']);
		
		define('THEME_DIR', get_template_directory());
		define('THEME_URI', get_template_directory_uri());
		
		define('THEME_FRAMEWORK', THEME_DIR . '/framework');
		
		define('THEME_PLUGINS', THEME_FRAMEWORK . '/plugins');
		define('THEME_FUNCTIONS', THEME_FRAMEWORK . '/functions');
		define('THEME_WIDGETS', THEME_FRAMEWORK . '/widgets');
		define('THEME_SHORTCODES', THEME_FRAMEWORK . '/shortcodes');
		define('THEME_VC_EXTEND_ELEMENTS', THEME_SHORTCODES . '/elements/');
		define('THEME_VC_EXTEND_PLUGINS', THEME_SHORTCODES . '/plugins/');
		define('THEME_VC_EXTEND_INCLUDES', THEME_SHORTCODES . '/includes/');
		define('THEME_FILES', THEME_FRAMEWORK . '/includes');
		
		define('THEME_FONTFACE_URI', THEME_URI . '/font-faces');
		define('THEME_FONTFACE_DIR', THEME_DIR . '/font-faces');
		
		define('THEME_INCLUDES', THEME_URI . '/includes');
		define('THEME_CACHE_DIR', THEME_DIR . '/cache');
		define('THEME_CACHE_URI', THEME_URI . '/cache');
		define('THEME_IMAGES', THEME_URI . '/img');
		define('THEME_CSS', THEME_URI . '/css');
		define('THEME_JS', THEME_URI . '/js');
		define('THEME_VC_ASSETS', THEME_URI . '/framework/shortcodes/assets/');
		define('THEME_VC_CSS', THEME_URI . '/framework/shortcodes/assets/lib/css');
		define('THEME_VC_JS', THEME_URI . '/framework/shortcodes/assets/lib/js');
		define('THEME_VC_IMG', THEME_URI . '/framework/shortcodes/assets/lib/img');
		
		define('THEME_ADMIN', THEME_FRAMEWORK . '/admin');
		define('THEME_ADMIN_TYPES', THEME_ADMIN . '/types');
		define('THEME_ADMIN_AJAX', THEME_ADMIN . '/ajax');
		define('THEME_ADMIN_ASSETS_URI', THEME_URI . '/framework/admin/assets');
		define('THEME_ADMIN_FUNCTIONS', THEME_ADMIN . '/functions');
		define('THEME_ADMIN_OPTIONS', THEME_ADMIN . '/options');
		define('THEME_ADMIN_METABOXES', THEME_ADMIN . '/metaboxes');
	}
	
	/**
	 * Add theme support.
	 */
	function wt_supports() {
		if (function_exists('add_theme_support')) {
			
			//add_theme_support('custom-header');
			//add_theme_support('custom-background');
			
			//This enables post-thumbnail support for a theme.
			add_theme_support('post-thumbnails', array('post', 'page', 'wt_portfolio', 'product'));
			//add_theme_support('post-thumbnails', array('page', 'product'));
			
			//This enables the naviagation menu ability. 
			add_theme_support('menus');

			register_nav_menus(array(
				'primary-menu' => esc_html__(THEME_NAME . ' Navigation', 'wt_admin' ), 
			));
			
			//This enables post and comment RSS feed links to head. This should be used in place of the deprecated automatic_feed_links.
			add_theme_support('automatic-feed-links');
			
			// reference to: http://codex.wordpress.org/Function_Reference/add_editor_style
			add_theme_support('editor-style');
			add_theme_support( 'woocommerce' );

		}
	}
		
	/**
	 * Loads the core theme functions.
	 */
	function wt_functions() {
		require_once (THEME_FUNCTIONS . '/theme-functions.php');
		
		/* Load theme's options. */
		$this->wt_options();

		require_once (THEME_FUNCTIONS . '/custom_scripts.php');
		
		require_once (THEME_FILES . '/theme-features.php');
		require_once (THEME_FILES . '/sidebar.php');
		if(wt_get_option('general', 'woocommerce')){
			require_once (THEME_FUNCTIONS . '/woocommerce.php');
			require_once (THEME_FUNCTIONS . '/woocommerce_config.php');
		}
	}
	
	/**
	 * Loads the theme options.
	 */
	function wt_options() {
		global $theme_options;
		$theme_options = array();
		$option_files = array(
			'general',
			'blog',
			'portfolio',
			'background',
			'color',
			'fonts',
			'sidebar',
			'footer',
		);
		foreach($option_files as $file){
			$page = include (THEME_ADMIN_OPTIONS . "/" . $file.'.php');
			$theme_options[$page['name']] = array();
			foreach($page['options'] as $option) {
				if (isset($option['default']) && isset($option['id'])) {
					$theme_options[$page['name']][$option['id']] = $option['default'];
				}
			}
			$theme_options[$page['name']] = array_merge((array) $theme_options[$page['name']], (array) get_option(THEME_SLUG . '_' . $page['name']));
		}
	}
	
	/**
	 * Load plugins integrated in a theme.
	 */
	function wt_plugins() {
		require_once (THEME_PLUGINS . '/breadcrumbs-plus/breadcrumbs-plus.php');
		require_once (THEME_PLUGINS . '/class-tgm-plugin-activation.php');
		//require_once (THEME_PLUGINS . '/wt_megamenu/wt_megamenu.php');
	}
	
	/**
	 * Register theme's extra widgets.
	 */
	function wt_widgets() {
		/* Load each widget file. */
		require_once (THEME_WIDGETS . '/subnav.php');
		require_once (THEME_WIDGETS . '/flickr.php');
		require_once (THEME_WIDGETS . '/social.php');
		require_once (THEME_WIDGETS . '/social_font_awesome.php');
		require_once (THEME_WIDGETS . '/recent.php');
		require_once (THEME_WIDGETS . '/popular.php');
		require_once (THEME_WIDGETS . '/related.php');
		require_once (THEME_WIDGETS . '/most-read.php');
		require_once (THEME_WIDGETS . '/recent-portfolio.php');
		require_once (THEME_WIDGETS . '/popular-portfolio.php');
		require_once (THEME_WIDGETS . '/contactform.php');
		require_once (THEME_WIDGETS . '/contactinfo.php');
		require_once (THEME_WIDGETS . '/customlinks.php');
		require_once (THEME_WIDGETS . '/advertisement-125.php');
		require_once (THEME_WIDGETS . '/search.php');
		
		/* Register each widget. */
		register_widget('Wt_Widget_SubNav');
		register_widget('Wt_Widget_Flickr');
		register_widget('Wt_Widget_Social');
		register_widget('Wt_Widget_Social_Font_Awesome');
		register_widget('Wt_Widget_Recent_Posts');
		register_widget('Wt_Widget_Popular_Posts');
		register_widget('Wt_Widget_Related_Posts');
		register_widget('Wt_Widget_Most_Read_Posts');
		register_widget('Wt_Widget_Recent_Portfolio_Posts');
		register_widget('Wt_Widget_Popular_Portfolio_Posts');
		register_widget('Wt_Widget_Contact_Form');
		register_widget('Wt_Widget_Contact_Info');
		register_widget('Wt_Widget_Custom_Links');
		register_widget('Wt_Widget_Advertisement_125');
		//register_widget('Wt_Widget_Search');
	}
			
	/**
	 * Extend Visual Composer with WhoaThemes Shortcodes
	 */
	function wt_visual_composer_extensions() {
		
		if (class_exists('WPBakeryVisualComposerAbstract')) {
					
			require_once (THEME_SHORTCODES . '/wt-visual-composer-extensions.php');
				
		}
		
	}
	
	/**
	 * Load admin files.
	 */
	function wt_admin() {
		if (is_admin()) {
			require_once (THEME_ADMIN . '/admin-panel.php');
			$admin = new wt_admin();
			$admin->wt_init();
		}
	}
}
?>