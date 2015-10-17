<?php
class wt_sidebar {
	var $wt_sidebar_names = array();
	var $wt_sidebar_desc = array();
	var $wt_footer_sidebar_count = 0;
	var $wt_footer_sidebar_names = array();
	var $wt_footer_top_sidebar_names = array();
	var $wt_sub_footer_sidebar_names = array();
	
	function wt_sidebar(){
		$this->wt_sidebar_names = array(
			'page'         => esc_html__('Page Area','wt_admin'),
			'blog'         => esc_html__('Blog Area','wt_admin'),
		);
		$this->wt_sidebar_desc = array(
			'page_desc'         => esc_html__('Main Sidebar that appears in left / right sidebar template.','wt_admin'),
			'blog_desc'         => esc_html__('Appears in blog page template & single blog posts.','wt_admin'),
		);
		$this->wt_footer_sidebar_names = array(
			__('Footer 1 Area','wt_admin'),
			__('Footer 2 Area','wt_admin'),
			__('Footer 3 Area','wt_admin'),
			__('Footer 4 Area','wt_admin'),
			__('Footer 5 Area','wt_admin'),
			__('Footer 6 Area','wt_admin'),
		);
	}

	function wt_register_sidebar(){
		
		foreach ($this->wt_sidebar_names as $slug => $name){
			$desc = $this->wt_sidebar_desc[$slug.'_desc'];
			
			register_sidebar(array(
				'id'			=> 'sidebar-'.$slug,
				'name'          => $name,
				'description'   => $desc,
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widgettitle"><span>',
				'after_title'   => '</span></h3>',
			));
		}
		
		register_sidebar(array(
			'id'            => "sidebar-footer-top-area",
			'name'          =>  esc_html__('Footer Top Area','wt_admin'),
			'description'   =>  esc_html__('Appears in the Footer Top Area of the site.','wt_admin'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '',
			'after_title'   => '',
		));
		
		//register footer sidebars
		foreach ($this->wt_footer_sidebar_names as $slug => $name){
			register_sidebar(array(
				'name'          => $name,
				'id'			=> 'sidebar-'.$slug,
				'description'   =>  esc_html__('Appears in the Footer Area of the site.','wt_admin'),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widgettitle"><span>',
				'after_title'   => '</span></h4>',
			));
		}
		
		//register sub footer sidebars
		register_sidebar(array(
			'id'            => "sidebar-footer-bottom-area",
			'name'          =>  esc_html__('Footer Bottom Area','wt_admin'),
			'description'   =>  esc_html__('Appears in the Footer Bottom Area of the site.','wt_admin'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '',
			'after_title'   => '',
		));
		
		//register header sidebars
		register_sidebar(array(
			'id'            => "sidebar-header-area",
			'name'          =>  esc_html__('Header Area','wt_admin'),
			'description'   =>  esc_html__('Appears in the Header Area of the site.','wt_admin'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		));
		
		//register portfolio sidebars
		if(class_exists('Whoathemes_Portfolio')){
			register_sidebar(array(
				'id'            => "sidebar-portfolio-area",
				'name'          =>  esc_html__('Portfolio Area','wt_admin'),
				'description'   =>  esc_html__('Appears in single portfolio posts.','wt_admin'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgettitle">',
				'after_title'   => '</h3>',
			));
		}
		
		//register woocommerce sidebars
		if(wt_get_option('general', 'woocommerce')){
			register_sidebar(array(
				'id'            => "sidebar-product-area",
				'name'          =>  esc_html__('Products Area','wt_admin'),
				'description'   =>  esc_html__('Appears in your shop.','wt_admin'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgettitle">',
				'after_title'   => '</h3>',
			));
		}
		
		//register custom sidebars
		$wt_custom_sidebars = wt_get_option('sidebar','sidebars');
		if(!empty($wt_custom_sidebars)){
			$wt_custom_sidebar_names = explode(',',$wt_custom_sidebars);
			foreach ($wt_custom_sidebar_names as $name){
				$slug = strtolower(preg_replace('/[^a-zA-Z0-9-]/', '-', $name));
				register_sidebar(array(			
					'name'          => $name,	
					'id' 			=> 'sidebar-custom-'.$slug,
					'description'   =>  $name. ' custom sidebar',
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h3 class="widgettitle">',
					'after_title'   => '</h3>',
				));
			}
		}
	}
	
	function wt_get_sidebar($post_id){
		if(is_page()){
			$wt_sidebar = $this->wt_sidebar_names['page'];
		}
		if(is_home() || is_front_page() || $post_id == wt_get_option('homepage','one_page_home') ){
			$home_page_id = wt_get_option('homepage','one_page_home');
			$post_id = get_object_id($home_page_id,'page');
				$wt_sidebar = $this->wt_sidebar_names['page'];
		}
		if(is_page_template( 'template_blog.php' )){
			$wt_sidebar = $this->wt_sidebar_names['blog'];
		}
		if(is_singular('post')){
			$wt_sidebar = $this->wt_sidebar_names['blog'];
		}elseif(is_singular('wt_portfolio')){
			$wt_sidebar = dynamic_sidebar( esc_html__('Portfolio Area','wt_admin'));
		}
		if(is_search() || is_archive()){
			$wt_sidebar = $this->wt_sidebar_names['blog'];
		}
		if (wt_get_option('general', 'woocommerce')) {
			if(is_woocommerce() || is_cart() || is_checkout() || is_account_page()){
				$wt_sidebar = dynamic_sidebar( esc_html__('Products Area','wt_admin'));
			}
		}
		if(!empty($post_id) && !is_archive()){
			$wt_custom = get_post_meta($post_id, '_sidebar', true);
			if(!empty($wt_custom)){
				$wt_sidebar = $wt_custom;
			}
		}
		if(isset($wt_sidebar)){
			dynamic_sidebar($wt_sidebar);
		}
	}
	function wt_get_footer_sidebar(){
		dynamic_sidebar($this->wt_footer_sidebar_names[$this->wt_footer_sidebar_count]);
		$this->wt_footer_sidebar_count++;
	}
}
global $_wt_sidebar;
$_wt_sidebar = new wt_sidebar;

add_action('widgets_init', array($_wt_sidebar,'wt_register_sidebar'));

function wt_sidebar_generator($function){
	global $_wt_sidebar;
	$args = array_slice( func_get_args(), 1 );
	return call_user_func_array(array( &$_wt_sidebar, $function ), $args );
}