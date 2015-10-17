<?php

// File Security Check
if (!defined('ABSPATH')) die('-1');

/*
Register WhoaThemes shortcode.
*/

class WPBakeryShortCode_WT_team_slider extends WPBakeryShortCode {
	
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
			'images'                  => '',
			'img_size'                => 'thumbnail',
    		'black_white'             => false,
    		'custom_links'            => false,
			'team_member_link'        => '',
			'team_member_link_target' => '_self',
			'team_member_name'        => false,
			'team_member_job'         => false,
			'team_member_socials'     => false,
			
    		'owl_speed'             => 600,	
    		'owl_pagspeed'          => 1000,	
    		'owl_autoplay'          => false,	
    		'owl_stoponhover'       => false,	
    		'owl_navigation'        => false,	
    		'owl_pagination'        => false,
    		'owl_singleitem'        => false,		
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
					
		$owl_speed             = (int)$owl_speed;
		$owl_pagspeed          = (int)$owl_pagspeed;		
		$owl_autoplay          = esc_attr($owl_autoplay);
		$owl_stoponhover       = esc_attr($owl_stoponhover);
		$owl_navigation        = esc_attr($owl_navigation);
		$owl_pagination        = esc_attr($owl_pagination);
		$owl_singleitem        = esc_attr($owl_singleitem);			
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
		
		// build team - content array
		$content          = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
		$team_content_arr = preg_split("/\r\n|\n|\r/", $content);
		
		// build team - name array		
		$team_name_arr = explode( ',', $team_member_name );
			
		// build team - job array		
		$team_job_arr = explode( ',', $team_member_job );
		
		// build team - socials array	
		$team_socials_arr  = preg_split("/\r\n|\n|\r/", rawurldecode(base64_decode(strip_tags($team_member_socials))));
		
		// build team - custom links array
		if ( $custom_links == true ) {
			$team_member_link = explode( ',', $team_member_link );
		}	
				
		$images = explode( ',', $images );
		$i = - 1;
		$count = 0;
		$singleItem = '';
		
		$sc_class = 'wt_team_slider_sc';	
					
		$id = mt_rand(9999, 99999);
		if (trim($el_id) != false) {
			$el_id = esc_attr( trim($el_id) );
		} else {
			$el_id = $sc_class . '-' . $id;
		}		
				
		$img_size = esc_html($img_size);		
						
		wp_print_scripts('owlCarousel');
		$carousel = ' wt_owl_carousel wt_align_center row';
		
		if ( $owl_singleitem == true ) {
			/*
			"singleItem: true" is a shortcut for:
				items             : 1, 
				itemsDesktop      : false,
				itemsDesktopSmall : false,
				itemsTablet       : false,
				itemsMobile       : false
			*/
			$singleItem = ' single_item_slider';			
			$owl_items = 1; 
			$owl_itemsdesktop = $owl_itemssmalldesktop = $owl_itemstablet = $owl_itemsmobile = $owl_itemsmobilesmall = 1;
		}
			
		$sc_class .= $carousel.$singleItem;				
		$el_class = esc_attr( $this->getExtraClass($el_class) );
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $sc_class.$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);	
		$css_class .= $this->wt_sc->getWTCSSAnimationClass($css_animation,$anim_type);
		$anim_data = $this->wt_sc->getWTCSSAnimationData($css_animation,$anim_delay);
					
		if ( $black_white == true ) {
			$black_white = ' wt_grayscale';
		} else {
			$black_white = '';
		}
									
		$carousel_data = '  data-owl-speed="'.$owl_speed.'" data-owl-pagSpeed="'.$owl_pagspeed.'" data-owl-autoPlay="'.$owl_autoplay.'" data-owl-stopOnHover="'.$owl_stoponhover.'" data-owl-navigation="'.$owl_navigation.'" data-owl-pagination="'.$owl_pagination.'" data-owl-transitionStyle="fade" data-owl-items="'.$owl_items.'" data-owl-itemsDesktop="'.$owl_itemsdesktop .'" data-owl-itemsSmallDesktop="'.$owl_itemssmalldesktop.'" data-owl-itemsTablet="'.$owl_itemstablet.'" data-owl-itemsMobile="'.$owl_itemsmobile.'" data-owl-itemsMobileSmall="'.$owl_itemsmobilesmall.'"';
					
		$output = '<div id="'.$el_id.'" class="'.$css_class.'"'.$anim_data.$carousel_data.'>';
				
		foreach ( $images as $attach_id ) {				
			$i ++;
			$count ++;
			$delay = $count * 100;	
			$output_team_content = '';
			$output_team_name    = '';
			$output_team_job     = '';
			$output_team_socials = '';
			
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
			
			// output for team item image
			if ( $custom_links == true && isset( $team_member_link[$i] ) && $team_member_link[$i] != '' ) {
				$output_image = '<a href="'.$team_member_link[$i].'"' . ' title="'.$img_title.'"' . ' target="'.$team_member_link_target.'">' . $img_output . '</a>';					
			} else {
				$output_image = $img_output;
			}
						
			// output for team item content			
			if ( isset($team_content_arr[$i]) ) {
				$output_team_content = $team_content_arr[$i];
			}
			
			// output for team item name			
			if ( isset($team_name_arr[$i]) ) {
				$output_team_name = $team_name_arr[$i];
			}
			
			// output for team item job			
			if ( isset($team_job_arr[$i]) ) {
				$output_team_job = $team_job_arr[$i];
			}
			
			// output for team item socials			
			if ( isset($team_socials_arr[$i]) ) {
				$output_team_socials = $team_socials_arr[$i];
			}
									
			// display team slider items 
			$output .= "\n\t" . '<div class="wt_team_slider_item">';
			
			if ( $owl_singleitem == true ) {
				if ( $i % 2 == 0 ) { // check if slider item is odd or even
					$output .= "\n\t\t" . '<div class="col-sm-7">';
					$output .= "\n\t\t" . '<div class="wt_team_info">';
						$output .= "\n\t\t\t" . '<div class="wt_team_content h2">' . $output_team_content . '</div>';
						$output .= "\n\t\t\t" . '<h4 class="wt_team_title">' . $output_team_name . '</h4>';
						$output .= "\n\t\t\t" . '<p class="wt_team_job">' . $output_team_job . '</p>';
						$output .= "\n\t\t\t" . '<div class="wt_team_social">' . $output_team_socials . '</div>';
					$output .= "\n\t\t" . '</div>';
					$output .= "\n\t\t" . '</div>';										
					$output .= "\n\t\t" . '<div class="col-sm-5'.$black_white.'">';
						$output .= "\n\t\t\t" . $output_image;
					$output .= "\n\t\t" . '</div>';
				} else {
					$output .= "\n\t\t" . '<div class="col-sm-5'.$black_white.'">';
						$output .= "\n\t\t\t" . $output_image;
					$output .= "\n\t\t" . '</div>';					
					$output .= "\n\t\t" . '<div class="col-sm-7">';
					$output .= "\n\t\t" . '<div class="wt_team_info">';
						$output .= "\n\t\t\t" . '<div class="wt_team_content h2">' . $output_team_content . '</div>';
						$output .= "\n\t\t\t" . '<h4 class="wt_team_title wt_align_left">' . $output_team_name . '</h4>';
						$output .= "\n\t\t\t" . '<p class="wt_team_job wt_align_left">' . $output_team_job . '</p>';
						$output .= "\n\t\t\t" . '<div class="wt_team_social">' . $output_team_socials . '</div>';
					$output .= "\n\t\t" . '</div>';
					$output .= "\n\t\t" . '</div>';
				}
			} else {
				$output .= "\n\t\t" . '<div class="wt_team_image'.$black_white.'">' .$output_image . '</div>';
				$output .= "\n\t\t" . '<div class="wt_team_info">';
					$output .= "\n\t\t" . '<h4 class="wt_team_title">' . $output_team_name . '</h4>';
					$output .= "\n\t\t" . '<p class="wt_team_job">' . $output_team_job . '</p>';
					$output .= "\n\t\t" . '<div class="wt_team_content">' . $output_team_content . '</div>';
					$output .= "\n\t\t" . '<div class="wt_team_social">' . $output_team_socials . '</div>';
				$output .= "\n\t\t" . '</div>';
			}
			
			$output .= "\n\t" . '</div>';			
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
		'name'          => esc_html__('WT Team Slider', 'wt_vcsc'),
		'base'          => 'wt_team_slider',
		'icon'          => 'wt_vc_ico_team_slider',
		'class'         => 'wt_vc_sc_team_slider',
		'category'      => esc_html__('by WhoaThemes', 'wt_vcsc'),
		'description'   => esc_html__('Team members slider', 'wt_vcsc'),
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
				'type'          => 'checkbox',
				'heading'       => esc_html__('Set black & white filter?', 'wt_vcsc'),
				'param_name'    => 'black_white',
				'value'         => Array( esc_html__('Yes, please', 'wt_vcsc') => 'yes'),
				'description'   => esc_html__('If selected, the images will be displayed with black & white filter.', 'wt_vcsc')
			),
			array(
				'type'          => 'textarea_html',
				'heading'       => esc_html__( 'Text for each team member', 'wt_vcsc' ),
				'param_name'    => 'content',
                'holder'        => 'div',
                'value'         => __("Team Member text block 1. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo. \n\n Text block 2, lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde, earum, impedit, veniam quam eaque deserunt tempore praesentium possimus rerum non neque cumque? \n\n Text block 3 lorem ipsum dolor sit amet, consectetur adipisicing elit.", 'wt_vcsc'),
				'description'   => esc_html__( 'Enter content for each team member here. Divide each with linebreaks (Enter).', 'wt_vcsc' )
			),
			array(
				'type'          => 'exploded_textarea',
				'heading'       => esc_html__( 'Name for each team member', 'wt_vcsc' ),
				'param_name'    => 'team_member_name',
                'value'         => esc_html__( "John Doe,Jane Doe,Justin Doe", 'wt_vcsc'),
				'description'   => esc_html__( 'Enter name for each team member here. Divide each with linebreaks (Enter).', 'wt_vcsc' )
			),
			array(
				'type'          => 'exploded_textarea',
				'heading'       => esc_html__( 'Job title for each team member', 'wt_vcsc' ),
				'param_name'    => 'team_member_job',
                'value'         => esc_html__( "Founder,Co-Founder,Developer", 'wt_vcsc'),
				'description'   => esc_html__( 'Enter job title for each team member here. Divide each with linebreaks (Enter).', 'wt_vcsc' )
			),
			array(
				'type'          => 'textarea_raw_html',
				'heading'       => esc_html__( 'Socials for each team member', 'wt_vcsc' ),
				'param_name'    => 'team_member_socials',
                'value'         => base64_encode("<a href=\"#\" class=\"facebook\"><i class=\"fa-facebook\" title=\"Facebook\"></i></a> <a href=\"#\" class=\"twitter\"><i class=\"fa-twitter\" title=\"Twitter\"></i></a> <a href=\"#\" class=\"google plus\"><i class=\"entypo-gplus\" title=\"Google Plus\"></i></a> <a href=\"#\" class=\"behance\"><i class=\"entypo-behance\" title=\"Behance\"></i></a> \n<a href=\"#\" class=\"facebook\"><i class=\"fa-facebook\" title=\"Facebook\"></i></a> <a href=\"#\" class=\"twitter\"><i class=\"fa-twitter\" title=\"Twitter\"></i></a> <a href=\"#\" class=\"google plus\"><i class=\"entypo-gplus\" title=\"Google Plus\"></i></a> <a href=\"#\" class=\"behance\"><i class=\"entypo-behance\" title=\"Behance\"></i></a> \n<a href=\"#\" class=\"facebook\"><i class=\"fa-facebook\" title=\"Facebook\"></i></a> <a href=\"#\" class=\"twitter\"><i class=\"fa-twitter\" title=\"Twitter\"></i></a> <a href=\"#\" class=\"google plus\"><i class=\"entypo-gplus\" title=\"Google Plus\"></i></a> <a href=\"#\" class=\"behance\"><i class=\"entypo-behance\" title=\"Behance\"></i></a>"),
				'description'   => esc_html__( 'Enter html code for each team member socials here. Divide each with linebreaks (Enter).', 'wt_vcsc' )
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
				'heading'            => esc_html__( 'Link for each team member', 'wt_vcsc' ),
				'param_name'         => 'team_member_link',
				'param_holder_class' => 'border_box wt_dependency',
				'dependency'         => array( 'element' => 'custom_links', 'not_empty' => true ),
				'description'        => esc_html__( 'Enter links for each team member here. Divide each with linebreaks (Enter).', 'wt_vcsc' )
			),
			array(
				'type'               => 'dropdown',
				'heading'            => esc_html__( 'Link target', 'wt_vcsc' ),
				'param_name'         => 'team_member_link_target',
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
				'value'	      => 'Team Slider Settings',
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
				'description'        => esc_html__('Define pagination speed in milliseconds. Example: \'600\', \'1000\'. Default speed - \'1000\'.', 'wt_vcsc')
			),		
			array(
				'type'               => 'textfield',
				'heading'            => esc_html__('AutoPlay', 'wt_vcsc'),
				'param_name'         => 'owl_autoplay',
				'value'              => 'false',
				'description'        => esc_html__('Change to any integer for example \'5000\' to play every 5 seconds. If you set \'true\', default speed will be 5 seconds.', 'wt_vcsc')
			),			
			array(
				'type'               => 'checkbox',
				'heading'            => esc_html__('Stop on hover?', 'wt_vcsc'),
				'param_name'         => 'owl_stoponhover',
				'value'              => Array( esc_html__('Yes, please', 'wt_vcsc') => 'true'),
				'description'        => esc_html__('If selected, will stop autoplay on mouse hover.', 'wt_vcsc')
			),
			array(
				'type'               => 'checkbox',
				'heading'            => esc_html__('Navigation?', 'wt_vcsc'),
				'param_name'         => 'owl_navigation',
				'value'              => Array( esc_html__('Yes, please', 'wt_vcsc') => 'true'),
				'description'        => esc_html__('If selected, it will show navigation.', 'wt_vcsc')
			),	
			array(
				'type'               => 'checkbox',
				'heading'            => esc_html__('Pagination?', 'wt_vcsc'),
				'param_name'         => 'owl_pagination',
				'value'              => Array( esc_html__('Yes, please', 'wt_vcsc') => 'true'),
				'description'        => esc_html__('If selected, it will show pagination.', 'wt_vcsc')
			),
			array(
				'type'               => 'checkbox',
				'heading'            => esc_html__('Single item?', 'wt_vcsc'),
				'param_name'         => 'owl_singleitem',
				'value'              => Array( esc_html__('Yes, please', 'wt_vcsc') => 'true'),
				'description'        => esc_html__('If selected, it will display only one item.', 'wt_vcsc')
			),				
			array(
				'type'               => 'wt_range',
				'heading'            => esc_html__( 'Items visible', 'wt_vcsc' ),
				'param_name'         => 'owl_items',
				'value'              => 4,
				'min'                => 1,
				'max'                => 10,
				'step'               => 1,
				'dependency'         => array( 'element' => 'owl_singleitem', 'is_empty' => true ),
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
				'dependency'         => array( 'element' => 'owl_singleitem', 'is_empty' => true ),
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
				'dependency'         => array( 'element' => 'owl_singleitem', 'is_empty' => true ),
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
				'dependency'         => array( 'element' => 'owl_singleitem', 'is_empty' => true ),
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
				'dependency'         => array( 'element' => 'owl_singleitem', 'is_empty' => true ),
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
				'dependency'         => array( 'element' => 'owl_singleitem', 'is_empty' => true ),
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