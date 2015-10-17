<?php

// File Security Check
if (!defined('ABSPATH')) die('-1');

/*
Register WhoaThemes shortcode.
*/

class WPBakeryShortCode_WT_Custom_heading extends WPBakeryShortCode {
	
	private $wt_sc;
	
	public function __construct($settings) {
        parent::__construct($settings);
		$this->wt_sc = new WT_VCSC_SHORTCODE;
	}
				
	protected function content($atts, $content = null) {
		
		extract( shortcode_atts( array(
			'tag'             => 'h2',
			'style'           => 'wt_cheading_3',
			'align'           => 'left',
			'color'           => '',
			'background'      => '',
									
			'el_id'           => '',
			'el_class'        => '',
    		'css_animation'   => '',
    		'anim_type'       => '',
    		'anim_delay'      => '',			
			'css'             => ''		
		), $atts ) );
								
		$color          = esc_attr($color);
		$background     = esc_attr($background);
				
		$sc_class = 'wt_cheading_sc';	
					
		$id = mt_rand(9999, 99999);
		if (trim($el_id) != false) {
			$el_id = esc_attr( trim($el_id) );
		} else {
			$el_id = $sc_class . '-' . $id;
		}								
					
		$el_class = esc_attr( $this->getExtraClass($el_class) );
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $sc_class.$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);	
		$css_class .= $this->wt_sc->getWTCSSAnimationClass($css_animation,$anim_type);
		$anim_data = $this->wt_sc->getWTCSSAnimationData($css_animation,$anim_delay);
		
		$el_style = '';
		
		if ( $color != '' ) {
			$color = 'color: ' . $color . ';';
		}
		if ( $background != '' ) {
			$background = 'background: ' . $background . ';';
		}
	
		if ( $background != '' || $color != '' ) {
			$el_style = ' style="'. $color . $background .'"';
		}
		
		$alignment = !empty($align) ? 'wt_align_'.$align : '';
		
		$content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
		
		$output = '<div id="'.$el_id.'" class="'.$css_class.' '.$style.' '.$alignment.'"'.$anim_data.'>';
		
		switch($style) {
			case "wt_cheading_1":
			case "wt_cheading_4":
				$output .= '<'.$tag.$el_style.'>'.$content.'</'.$tag.'>';
				break;
			case "wt_cheading_2":
				if ($align == 'left' || $align == 'center') { // center is not working with this anyway
					$output .= '<'.$tag.$el_style.'>'.$content.'</'.$tag.'>';
					$output .= '<div class="wt_cheading_sep_wrap"><div class="wt_cheading_sep"></div></div>';
				} else { // right
					$output .= '<div class="wt_cheading_sep_wrap"><div class="wt_cheading_sep"></div></div>';
					$output .= '<'.$tag.$el_style.'>'.$content.'</'.$tag.'>';
				}
				break;
			case "wt_cheading_3":
			default:
				$output .= '<'.$tag.$el_style.'><span>'.$content.'</span></'.$tag.'>';
				break;
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
		'name'          => esc_html__('WT Custom Heading', 'wt_vcsc'),
		'base'          => 'wt_custom_heading',
		'icon'          => 'wt_vc_ico_custom_heading',
		'class'         => 'wt_vc_sc_custom_heading',
		'category'      => esc_html__('by WhoaThemes', 'wt_vcsc'),
		'description'   => esc_html__('Add custom heading text', 'wt_vcsc'),
		'params'        => array(
			array(
				'type'        => 'textarea',
				'heading'     => esc_html__( 'Text', 'wt_vcsc' ),
				'param_name'  => 'content',
				'admin_label' => true,
				'value'       => esc_html__( 'This is a custom heading element', 'wt_vcsc' ),
				'description' => esc_html__( 'Enter your custom heading content.', 'wt_vcsc' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Element tag', 'wt_vcsc'),
				'param_name'  => 'tag',
				'value'       => array(
					__('H1', 'wt_vcsc')   => 'h1', 
					__('H2', 'wt_vcsc')   => 'h2',
					__('H3', 'wt_vcsc')   => 'h3',
					__('H4', 'wt_vcsc')   => 'h4',
					__('H5', 'wt_vcsc')   => 'h5',
					__('H6', 'wt_vcsc')   => 'h6'
				),
				'std'	      => 'h2',
				'description' => esc_html__('Select the element tag.', 'wt_vcsc')
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Heading style', 'wt_vcsc'),
				'param_name'  => 'style',
				'value'       => array(
					__('Style #1', 'wt_vcsc')   => 'wt_cheading_1',
					__('Style #2', 'wt_vcsc')   => 'wt_cheading_2', 
					__('Style #3', 'wt_vcsc')   => 'wt_cheading_3', 
					__('Style #4', 'wt_vcsc')   => 'wt_cheading_4'
				),
				'std'	      => 'wt_cheading_3',
				'description' => esc_html__('Select the element tag.', 'wt_vcsc')
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Text align', 'wt_vcsc'),
				'param_name'    => 'align',
				'value'         => array( esc_html__('Align left', 'wt_vcsc') => 'left', esc_html__('Align right', 'wt_vcsc') => 'right', esc_html__('Align center', 'wt_vcsc') => 'center'),
				'std'           => 'left',
				'description'   => esc_html__('Select text alignment.', 'wt_vcsc').' <strong>' .esc_html__('Style #2 is not working on center.', 'wt_vcsc') .'</strong>'
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Text color', 'wt_vcsc'),
				'param_name'    => 'color',
				'description'   => esc_html__( 'Select text color.', 'wt_vcsc' )
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Custom heading background', 'wt_vcsc'),
				'param_name'    => 'background',
				'description'   => esc_html__( 'Select custom heading background.', 'wt_vcsc' )
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