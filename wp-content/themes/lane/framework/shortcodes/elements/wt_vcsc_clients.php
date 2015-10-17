<?php

// File Security Check
if (!defined('ABSPATH')) die('-1');

/*
Register WhoaThemes shortcode.
*/

class WPBakeryShortCode_WT_clients extends WPBakeryShortCode {
	
	private $wt_sc;
	
	public function __construct($settings) {
        parent::__construct($settings);
		$this->wt_sc = new WT_VCSC_SHORTCODE;
	}
	
	public function singleParamHtmlHolder( $param, $value ) {
		$output = '';
		// Compatibility fixes
		$old_names = array( 'yellow_message', 'blue_message', 'green_message', 'button_green', 'button_grey', 'button_yellow', 'button_blue', 'button_red', 'button_orange' );
		$new_names = array( 'alert-block', 'alert-info', 'alert-success', 'btn-success', 'btn', 'btn-info', 'btn-primary', 'btn-danger', 'btn-warning' );
		$value = str_ireplace( $old_names, $new_names, $value );
		//$value = esc_html__($value, "js_composer");
		//
		$param_name = isset( $param['param_name'] ) ? $param['param_name'] : '';
		$type = isset( $param['type'] ) ? $param['type'] : '';
		$class = isset( $param['class'] ) ? $param['class'] : '';

		if ( isset( $param['holder'] ) == true && $param['holder'] !== 'hidden' ) {
			$output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">' . $value . '</' . $param['holder'] . '>';
		}
		if ( $param_name == 'images' ) {
			$images_ids = empty( $value ) ? array() : explode( ',', trim( $value ) );
			$output .= '<ul class="attachment-thumbnails' . ( empty( $images_ids ) ? ' image-exists' : '' ) . '" data-name="' . $param_name . '">';
			foreach ( $images_ids as $image ) {
				$img = wpb_getImageBySize( array( 'attach_id' => (int)$image, 'thumb_size' => 'thumbnail' ) );
				$output .= ( $img ? '<li>' . $img['thumbnail'] . '</li>' : '<li><img width="150" height="150" test="' . $image . '" src="' . vc_asset_url( 'vc/blank.gif' ) . '" class="attachment-thumbnail" alt="" title="" /></li>' );
			}
			$output .= '</ul>';
			$output .= '<a href="#" class="column_edit_trigger' . ( ! empty( $images_ids ) ? ' image-exists' : '' ) . '">' . esc_html__( 'Add images', 'js_composer' ) . '</a>';

		}
		return $output;
	}
				
	protected function content($atts, $content = null) {
		
		extract( shortcode_atts( array(
			'images'                => '',
			'img_size'              => 'thumbnail',
			'type'                  => 'simple',
			'columns'               => 6,
			'opacity'               => 20,
    		'hover_effect'          => false,
    		'hover_border'          => false,
    		'black_white'           => false,
    		'tooltip'               => false,
			'tooltip_placement'     => 'top',
    		'custom_links'          => false,
			'custom_links_textarea' => '',
			'custom_links_target'   => '_self',
			
			// Type - carousel dependencies
    		'owl_speed'             => 600,	
    		'owl_pagspeed'          => 1000,	
    		'owl_autoplay'          => 'false',	
    		'owl_stoponhover'       => false,	
    		'owl_navigation'        => false,	
    		'owl_pagination'        => false,	
    		'owl_items'             => 6,	
    		'owl_itemsdesktop'      => 4,	
    		'owl_itemssmalldesktop' => 4,	
    		'owl_itemstablet'       => 3,		
    		'owl_itemsmobile'       => 2,		
    		'owl_itemsmobilesmall'  => 1,			
						
			'el_id'           => '',
			'el_class'        => '',
    		'css_animation'   => '',
    		'anim_type'       => '',
    		'anim_delay'      => '',			
			'css'             => ''		
		), $atts ) );
				
		$gal_images = '';
		$link_start = '';
		$link_end   = '';	
		
		$opacity               = (int)$opacity;
		
		$owl_speed             = (int)$owl_speed;
		$owl_pagspeed          = (int)$owl_pagspeed;		
		$owl_autoplay          = esc_attr($owl_autoplay);
		$owl_stoponhover       = esc_attr($owl_stoponhover);
		$owl_navigation        = esc_attr($owl_navigation);
		$owl_pagination        = esc_attr($owl_pagination);		
		$owl_items             = (int)$owl_items;		
		$owl_itemsdesktop      = (int)$owl_itemsdesktop;
		$owl_itemssmalldesktop = (int)$owl_itemssmalldesktop;
		$owl_itemstablet       = (int)$owl_itemstablet;
		$owl_itemsmobile       = (int)$owl_itemsmobile;
		$owl_itemsmobilesmall  = (int)$owl_itemsmobilesmall;
		
		if ( $images == '' ) $images = '-1,-2,-3'; // adding placeholder images if no image was set
		
		if ( $owl_stoponhover == false ) { $owl_stoponhover = 'false'; }
		if ( $owl_navigation  == false ) { $owl_navigation  = 'false'; }
		if ( $owl_pagination  == false ) { $owl_pagination  = 'false'; }

		if ( $custom_links == true ) {
			$custom_links_textarea = explode( ',', $custom_links_textarea );
		}
		
		$images = explode( ',', $images );
		$i = - 1;
		$count = 0;		
		
		$sc_class = 'wt_clients_sc';	
					
		$id = mt_rand(9999, 99999);
		if (trim($el_id) != false) {
			$el_id = esc_attr( trim($el_id) );
		} else {
			$el_id = $sc_class . '-' . $id;
		}		
				
		$img_size = esc_html($img_size);		
				
		if ($type == 'simple') {
			$carousel = '';
		} else {
			wp_print_scripts('owlCarousel');
			$carousel = ' wt_owl_carousel ';
		}	
			
		$sc_class .= ' wt_align_center'.$carousel;				
		$el_class = esc_attr( $this->getExtraClass($el_class) );
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $sc_class.$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);	
		$css_class .= $this->wt_sc->getWTCSSAnimationClass($css_animation,$anim_type);
		$anim_data = $this->wt_sc->getWTCSSAnimationData($css_animation,$anim_delay);
		
		switch( $columns ) {
			case 3  : $col_out = ' col-xs-4 col-sm-4 col-md-4 col-lg-4'; break;
			case 4  : $col_out = ' col-xs-4 col-sm-4 col-md-3 col-lg-3'; break;
			case 6  : 
			default : $col_out = ' col-xs-4 col-sm-4 col-md-2 col-lg-2'; break;
		}
		
		$el_opacity = 'opacity: ' . $opacity/100 . ';';
		$el_filter = 'filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=' . $opacity . ');';
		$opacity_style = ' style="'. $el_opacity . $el_filter .'"';
		
		if ( $hover_border == true ) {
			$hover_border = ' wt_client_border';
		} else {
			$hover_border = '';
		}
		
		if ( $hover_effect == true ) {
			$hover_effect = ' wt_client_scale_effect';
		} else {
			$hover_effect = '';
		}
		
		if ( $black_white == true ) {
			$black_white = ' wt_grayscale';
		} else {
			$black_white = '';
		}
		
		if ( $tooltip == true ) {
			$tooltip_out = '  data-toggle="tooltip" data-placement="'.$tooltip_placement.'"';
		} else {
			$tooltip_out = '';
		}
		
		if ($type == 'simple') {
			wp_enqueue_script( 'waypoints' ); // VC file
			$carousel_data = '';
		} else {
			$carousel_data = '  data-owl-speed="'.$owl_speed.'" data-owl-pagSpeed="'.$owl_pagspeed.'" data-owl-autoPlay="'.$owl_autoplay.'" data-owl-stopOnHover="'.$owl_stoponhover.'" data-owl-navigation="'.$owl_navigation.'" data-owl-pagination="'.$owl_pagination.'" data-owl-items="'.$owl_items.'" data-owl-itemsDesktop="'.$owl_itemsdesktop .'" data-owl-itemsSmallDesktop="'.$owl_itemssmalldesktop.'" data-owl-itemsTablet="'.$owl_itemstablet.'" data-owl-itemsMobile="'.$owl_itemsmobile.'" data-owl-itemsMobileSmall="'.$owl_itemsmobilesmall.'"';
		}
					
		$output = '<div id="'.$el_id.'" class="'.$css_class.'"'.$anim_data.$carousel_data.'>';
				
		foreach ( $images as $attach_id ) {				
			$i ++;
			$count ++;
			$delay = $count * 100;	
			
			if ( $attach_id > 0 ) {
				$img = wpb_getImageBySize( array( 'attach_id' => $attach_id, 'thumb_size' => $img_size ) );
			} else {
				$img = array();
				$img['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
			}
			$img_output = $img['thumbnail'];
			
			// if image caption not set then take it's title
			$attachment_meta = WT_WpGetAttachment($attach_id);
			if (!empty($attachment_meta['caption'])) {
				$img_title = $attachment_meta['caption'];
			} else {
				$img_title = $attachment_meta['title'];
			}
			
			// output for client image
			if ( $custom_links == true && isset( $custom_links_textarea[$i] ) && $custom_links_textarea[$i] != '' ) {
				$output_image = '<a href="'.$custom_links_textarea[$i].'"' . ' title="'.$img_title.'"' . ' target="'.$custom_links_target.'"'.$tooltip_out.'>' . $img_output . '</a>';					
			} elseif ($tooltip == true) {
				$output_image = '<a href="#"'.$tooltip_out.' title="'.$img_title.'">' . $img_output . '</a>';
			} else {
				$output_image = $img_output;
			}
			
			// display simple images or with custom links 
			if ($type == 'simple') {
				$output .= '<div class="wt_client'.$hover_effect.$hover_border.$black_white.$col_out.' wt_animate wt_animate_if_visible" data-animation="fadeInUp" data-animation-delay="'.$delay.'"'.$opacity_style.'>';
					$output .= "\n\t" . $output_image;
				$output .= '</div>';
			} else {
				$output .= "\n\t" . '<div class="wt_client item'.$hover_effect.$hover_border.$black_white.'"'.$opacity_style.'>';
					$output .= "\n\t\t" . $output_image;
				$output .= "\n\t" . '</div>';
			}
			
			if ( $count == $columns ) $count = 0; // reset column number
		}
		
		$output .= '</div>';
		
        return $output;
								
    }
	
}
	
/*
Register WhoaThemes shortcode within Visual Composer interface.
*/

if (function_exists('wpb_map')) {

	$add_wt_sc_func             = new WT_VCSC_SHORTCODE;
	$add_wt_extra_id            = $add_wt_sc_func->getWTExtraId();
	$add_wt_extra_class         = $add_wt_sc_func->getWTExtraClass();
	$add_wt_css_animation       = $add_wt_sc_func->getWTAnimations();
	$add_wt_css_animation_type  = $add_wt_sc_func->getWTAnimationsType();
	$add_wt_css_animation_delay = $add_wt_sc_func->getWTAnimationsDelay();
	
	wpb_map( array(
		'name'          => esc_html__('WT Clients', 'wt_vcsc'),
		'base'          => 'wt_clients',
		'icon'          => 'wt_vc_ico_clients',
		'class'         => 'wt_vc_sc_clients',
		'category'      => esc_html__('by WhoaThemes', 'wt_vcsc'),
		'description'   => esc_html__('List of clients or caousel with images', 'wt_vcsc'),
		'params'        => array(
			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Images', 'wt_vcsc' ),
				'param_name' => 'images',
				'value' => '',
				'description' => esc_html__( 'Select images from media library.', 'wt_vcsc' )
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Image Size', 'wt_vcsc'),
				'param_name'    => 'img_size',
				'description'   => esc_html__('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'wt_vcsc')
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Type', 'wt_vcsc'),
				'param_name'  => 'type',
				'value'       => array( 
					__('Simple', 'wt_vcsc')   => 'simple',
					__('Carousel', 'wt_vcsc') => 'carousel',
				),
				'description' => esc_html__('Select how should clients list should be displayed - simple or with animated carousel images.', 'wt_vcsc')
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Columns', 'wt_vcsc'),
				'param_name'    => 'columns',
				'value' 		=> array(
					__( 'Three', 'wt_vcsc' ) => 3,
					__( 'Four', 'wt_vcsc' )	 => 4,
					__( 'Six', 'wt_vcsc' )	 => 6,
				),
				'std'	        => '6',
				'dependency'	=> Array(
					'element'	=> 'type',
					'value'		=> 'simple'
				),
				'description'   => esc_html__('Select number of columns.', 'wt_vcsc')
			),
			array(
				'type'               => 'wt_range',
				'heading'            => esc_html__('Set opacity', 'wt_vcsc'),
				'param_name'         => 'opacity',
				'value'              => 20,
				'min'                => 10,
				'max'                => 100,
				'step'               => 5,
				'description'        => esc_html__('Define image opacity.', 'wt_vcsc')
			),	
			array(
				'type'          => 'checkbox',
				'heading'       => esc_html__('Set hover scale effect?', 'wt_vcsc'),
				'param_name'    => 'hover_effect',
				'value'         => Array( esc_html__('Yes, please', 'wt_vcsc') => 'yes'),
				'description'   => esc_html__('If selected, the images will have a scale effect on mouse hover.', 'wt_vcsc')
			),
			array(
				'type'          => 'checkbox',
				'heading'       => esc_html__('Set hover border?', 'wt_vcsc'),
				'param_name'    => 'hover_border',
				'value'         => Array( esc_html__('Yes, please', 'wt_vcsc') => 'yes'),
				'description'   => esc_html__('If selected, the images will have a border on mouse hover.', 'wt_vcsc')
			),
			array(
				'type'          => 'checkbox',
				'heading'       => esc_html__('Set black & white filter?', 'wt_vcsc'),
				'param_name'    => 'black_white',
				'value'         => Array( esc_html__('Yes, please', 'wt_vcsc') => 'yes'),
				'description'   => esc_html__('If selected, the images will be displayed with black & white filter.', 'wt_vcsc')
			),
			array(
				'type'          => 'checkbox',
				'heading'       => esc_html__('Show tooltip on hover?', 'wt_vcsc'),
				'param_name'    => 'tooltip',
				'value'         => Array( esc_html__('Yes, please', 'wt_vcsc') => 'yes'),
				'description'   => esc_html__('If selected, tooltip ( ', 'wt_vcsc') .' <strong>' . esc_html__('image wordpress captions', 'wt_vcsc') .'</strong>'. esc_html__(' ) will be displayed on mouse hover.', 'wt_vcsc')
			),	
			array(
				'type'               => 'dropdown',
				'heading'            => esc_html__('Tooltip placement', 'wt_vcsc'),
				'param_name'         => 'tooltip_placement',
				'param_holder_class' => 'border_box wt_dependency',
				'value' 		     => array(
					__( 'Top', 'wt_vcsc' )    => 'top',
					__( 'Bottom', 'wt_vcsc' ) => 'bottom',
					__( 'Left', 'wt_vcsc' )   => 'left',
					__( 'Right', 'wt_vcsc' )  => 'right',
				),
				'dependency'	     => array(
					'element'	=> 'tooltip',
					'not_empty' => true
				),
				'description'        => esc_html__('Select tooltip placement ( position ).', 'wt_vcsc')
			),		
			array(
				'type'          => 'checkbox',
				'heading'       => esc_html__('Place custom links?', 'wt_vcsc'),
				'param_name'    => 'custom_links',
				'value'         => Array( esc_html__('Yes, please', 'wt_vcsc') => 'yes'),
				'description'   => esc_html__('If selected, you can place custom links on images.', 'wt_vcsc')
			),	
			array(
				'type'               => 'exploded_textarea',
				'heading'            => esc_html__( 'Custom links', 'wt_vcsc' ),
				'param_name'         => 'custom_links_textarea',
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'custom_links', 'not_empty' => true ),
				'description'        => esc_html__( 'Enter links for each client here. Divide links with linebreaks (Enter).', 'wt_vcsc' )
			),
			array(
				'type'               => 'dropdown',
				'heading'            => esc_html__( 'Custom link target', 'wt_vcsc' ),
				'param_name'         => 'custom_links_target',
				'value'              => array(
					__( 'Same window', 'wt_vcsc' ) => '_self',
					__( 'New window', 'wt_vcsc' )  => "_blank"
				),
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'custom_links', 'not_empty' => true ),
				'description'        => esc_html__( 'Select where to open custom links.', 'wt_vcsc' )
			),
			// Carousel Settings
			array(
				'type'		  => 'wt_separator',
				'heading'	  => esc_html__( '', 'wt_vcsc' ),
				"param_name"  => 'separator',
				'value'	      => 'Carousel Settings',
				'dependency'  => array( 'element' => 'type', 'value' => 'carousel' ),
				'description' => esc_html__( 'Below you can edit default carousel settings.', 'wt_vcsc' )
			),
			array(
				'type'               => 'wt_range',
				'heading'            => esc_html__('Speed', 'wt_vcsc'),
				'param_name'         => 'owl_speed',
				'value'              => 600,
				'min'                => 0,
				'max'                => 5000,
				'step'               => 100,
				'unit'               => 'ms',
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'type', 'value' => 'carousel' ),
				'description'        => esc_html__('Define slide speed in milliseconds. Example: \'600\', \'1000\'. Default speed - \'600\'.', 'wt_vcsc')
			),	
			array(
				'type'               => 'wt_range',
				'heading'            => esc_html__('Pagination speed', 'wt_vcsc'),
				'param_name'         => 'owl_pagspeed',
				'value'              => 1000,
				'min'                => 0,
				'max'                => 5000,
				'step'               => 100,
				'unit'               => 'ms',
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'type', 'value' => 'carousel' ),
				'description'        => esc_html__('Define pagination speed in milliseconds. Example: \'600\', \'1000\'. Default speed - \'1000\'.', 'wt_vcsc')
			),		
			array(
				'type'               => 'textfield',
				'heading'            => esc_html__('AutoPlay', 'wt_vcsc'),
				'param_name'         => 'owl_autoplay',
				'value'              => 'false',
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'type', 'value' => 'carousel' ),
				'description'        => esc_html__('Change to any integer for example \'5000\' to play every 5 seconds. If you set \'true\', default speed will be 5 seconds.', 'wt_vcsc')
			),			
			array(
				'type'               => 'checkbox',
				'heading'            => esc_html__('Stop on hover?', 'wt_vcsc'),
				'param_name'         => 'owl_stoponhover',
				'value'              => Array( esc_html__('Yes, please', 'wt_vcsc') => 'true'),
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'type', 'value' => 'carousel' ),
				'description'        => esc_html__('If selected, will stop autoplay on mouse hover.', 'wt_vcsc')
			),
			array(
				'type'               => 'checkbox',
				'heading'            => esc_html__('Navigation?', 'wt_vcsc'),
				'param_name'         => 'owl_navigation',
				'value'              => Array( esc_html__('Yes, please', 'wt_vcsc') => 'true'),
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'type', 'value' => 'carousel' ),
				'description'        => esc_html__('If selected, it will show navigation.', 'wt_vcsc')
			),	
			array(
				'type'               => 'checkbox',
				'heading'            => esc_html__('Pagination?', 'wt_vcsc'),
				'param_name'         => 'owl_pagination',
				'value'              => Array( esc_html__('Yes, please', 'wt_vcsc') => 'true'),
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'type', 'value' => 'carousel' ),
				'description'        => esc_html__('If selected, it will show pagination.', 'wt_vcsc')
			),			
			array(
				'type'               => 'wt_range',
				'heading'            => esc_html__( 'Items visible', 'wt_vcsc' ),
				'param_name'         => 'owl_items',
				'value'              => 6,
				'min'                => 1,
				'max'                => 10,
				'step'               => 1,
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'type', 'value' => 'carousel' ),
				'description'        => esc_html__( 'Define maximum amount of items displayed at a time with the widest browser width.', 'wt_vcsc' )
			),		
			array(
				'type'               => 'wt_range',
				'heading'            => esc_html__( 'Items visible on Desktop', 'wt_vcsc' ),
				'param_name'         => 'owl_itemsdesktop',
				'value'              => 4,
				'min'                => 1,
				'max'                => 10,
				'step'               => 1,
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'type', 'value' => 'carousel' ),
				'description'        => esc_html__( 'Define maximum amount of items to be visible on desktops.', 'wt_vcsc' )
			),	
			array(
				'type'               => 'wt_range',
				'heading'            => esc_html__( 'Items visible on Small Desktop', 'wt_vcsc' ),
				'param_name'         => 'owl_itemssmalldesktop',
				'value'              => 4,
				'min'                => 1,
				'max'                => 10,
				'step'               => 1,
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'type', 'value' => 'carousel' ),
				'description'        => esc_html__( 'Define maximum amount of items to be visible on small desktops.', 'wt_vcsc' )
			),	
			array(
				'type'               => 'wt_range',
				'heading'            => esc_html__( 'Items visible on Tablet', 'wt_vcsc' ),
				'param_name'         => 'owl_itemstablet',
				'value'              => 3,
				'min'                => 1,
				'max'                => 10,
				'step'               => 1,
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'type', 'value' => 'carousel' ),
				'description'        => esc_html__( 'Define maximum amount of items to be visible on tablets.', 'wt_vcsc' )
			),	
			array(
				'type'               => 'wt_range',
				'heading'            => esc_html__( 'Items visible on Mobile', 'wt_vcsc' ),
				'param_name'         => 'owl_itemsmobile',
				'value'              => 2,
				'min'                => 1,
				'max'                => 10,
				'step'               => 1,
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'type', 'value' => 'carousel' ),
				'description'        => esc_html__( 'Define maximum amount of items to be visible on mobiles.', 'wt_vcsc' )
			),	
			array(
				'type'               => 'wt_range',
				'heading'            => esc_html__( 'Items visible on Small Mobile', 'wt_vcsc' ),
				'param_name'         => 'owl_itemsmobilesmall',
				'value'              => 1,
				'min'                => 1,
				'max'                => 10,
				'step'               => 1,
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'type', 'value' => 'carousel' ),
				'description'        => esc_html__( 'Define maximum amount of items to be visible on small mobiles.', 'wt_vcsc' )
			),				
			
			$add_wt_extra_id,
			$add_wt_extra_class,
			$add_wt_css_animation,
			$add_wt_css_animation_type,
			$add_wt_css_animation_delay,
			
			array(
				'type'          => 'css_editor',
				'heading'       => esc_html__('Css', 'wt_vcsc'),
				'param_name'    => 'css',
				'group'         => esc_html__('Design options', 'wt_vcsc')
			),
			
			// Load Custom CSS/JS File
			array(
				'type'               => 'wt_loadfile',
				'heading'            => esc_html__( '', 'wt_vcsc' ),
				'param_name'         => 'el_file',
				'value'              => '',
				'file_path'          => 'wt-visual-composer-extend-element.min.js',
				'param_holder_class' => 'wt_loadfile_field',
				'description'        => esc_html__( '', 'wt_vcsc' )
			),
		)
	));	
	
}