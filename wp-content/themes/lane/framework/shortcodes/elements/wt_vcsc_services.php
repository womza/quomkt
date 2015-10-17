<?php

// File Security Check
if (!defined('ABSPATH')) die('-1');

/*
Register WhoaThemes shortcode.
*/

class WPBakeryShortCode_WT_services extends WPBakeryShortCode {
	
	private $wt_sc;
	
	public function __construct($settings) {
        parent::__construct($settings);
		$this->wt_sc = new WT_VCSC_SHORTCODE;
	}
				
	protected function content($atts, $content = null) {
		
		extract( shortcode_atts( array(
			'icon' 	           => '',
			'icon_color'       => '',
			'icon_size'        => 80,
    		'align'            => 'right',
			'title' 	       => '',
			'text' 	           => '',
						
			'el_id'            => '',
			'el_class'         => '',
    		'css_animation'    => '',
    		'anim_type'        => '',
    		'anim_delay'       => '',			
			'css'              => ''		
		), $atts ) );
		
		$sc_class = 'wt_services_sc';	
					
		$id = mt_rand(9999, 99999);
		if (trim($el_id) != false) {
			$el_id = esc_attr( trim($el_id) );
		} else {
			$el_id = $sc_class . '-' . $id;
		}		
		
		$icon_style = '';
						
		// Service Icon Output			
		if ( $icon_color != '' ) {
			$icon_color = 'color: ' . $icon_color . ';';
		}
		
		if ( $icon_color != '' ) {
			$icon_style = ' style="'. $icon_color .'"';
		}
		
		$icon  = esc_html( $icon );
		$title = esc_html( $title );
		//$text  = esc_textarea( $text );	
		
		if ( $icon != '' ) {
			$icon_out    = '<i class="'.$icon.'"></i>';
			$icon_bg_out = '<i class="wt_services_bg_icon '.$icon.'"></i>';
		} else {
			$icon_out    = ''; 
			$icon_bg_out = ''; 
		}	
			
		if ( $title != '' ) {
			$title_out = '<h3>'.$title.'</h3>';
		} else {
			$title_out = ''; 
		}
			
		if ( $text != '' ) {
			$text_out = '<h5>'.$text.'</h5>';
		} else {
			$text_out = ''; 
		}
				
		$el_class = esc_attr( $this->getExtraClass($el_class) );
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $sc_class.$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);
		$css_class .= ' col-lg-6 col-md-6 col-sm-6 col-xs-12 wt_align_' .$align. ' wt_icon_' .$icon_size;		
		$css_class .= $this->wt_sc->getWTCSSAnimationClass($css_animation,$anim_type);
		$anim_data = $this->wt_sc->getWTCSSAnimationData($css_animation,$anim_delay);		
			
		$output = '<div id="'.$el_id.'" class="'.$css_class.'"'.$anim_data.'>';
			if ( $icon_out != '' ) {
				$output .= "\n\t" . $icon_bg_out;
				$output .= "\n\t" . '<div class="wt_icon wt_icon_'.$icon_size.'"'.$icon_style.'>'; 
					$output .= "\n\t\t" . $icon_out;
				$output .= "\n\t" . '</div>';
			}
						
			$output .= "\n\t" . '<div class="wt_service_details">'; 
				$output .= "\n\t\t" . $title_out;
				$output .= "\n\t\t" . $text_out;
			$output .= "\n\t" . '</div>';
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
		'name'          => esc_html__('WT Services', 'wt_vcsc'),
		'base'          => 'wt_services',
		'icon'          => 'wt_vc_ico_services',
		'class'         => 'wt_vc_sc_services',
		'category'      => esc_html__('by WhoaThemes', 'wt_vcsc'),
		'description'   => esc_html__('Build an alternative services block', 'wt_vcsc'),
		'params'        => array(			
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Icon', 'wt_vcsc'),
				'param_name'    => 'icon',
				'description'   => '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Font Awesome</a>, <a href="http://entypo.com/" target="_blank">Entypo</a> or <a href="http://glyphicons.com/" target="_blank">Glyphicons</a> accepted. (use "fa-", "entypo-" or "glyphicon-" prefix - for example "<strong>fa-adjust, entypo-flag or glyphicon-leaf</strong>"'
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Icon color', 'wt_vcsc'),
				'param_name'    => 'icon_color',
				'description'   => esc_html__( 'Select icon color.', 'wt_vcsc' )
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Alignment', 'wt_vcsc'),
				'param_name'    => 'align',
				'value'         => array( esc_html__('Align left', 'wt_vcsc') => 'left', esc_html__('Align right', 'wt_vcsc') => 'right', esc_html__('Align center', 'wt_vcsc') => 'center'),
				'std'           => 'right',
				'description'   => esc_html__('Select services alignment.', 'wt_vcsc')
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Icon size', 'wt_vcsc'),
				'param_name'    => 'icon_size',
				'value'         => array( 
					'30' => '30', 
					'40' => '40',
					'50' => '50',
					'60' => '60',
					'70' => '70',
					'80' => '80',
				),
				'std'           => '80',
				'description'   => esc_html__('Select icon size.', 'wt_vcsc')
			),			
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Service title', 'wt_vcsc'),
				'admin_label'   => true,
				'param_name'    => 'title',
				'description'   => esc_html__('Add title for your service box.', 'wt_vcsc')
			),
			array(
				'type'          => 'textarea',
				'heading'       => esc_html__('Service text', 'wt_vcsc'),
				'param_name'    => 'text',
				'description'   => esc_html__('Add text for your service box.', 'wt_vcsc')
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
			)
		)
	));	
	
}