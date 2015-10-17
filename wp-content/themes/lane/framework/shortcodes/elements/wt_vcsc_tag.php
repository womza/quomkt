<?php

// File Security Check
if (!defined('ABSPATH')) die('-1');

/*
Register WhoaThemes shortcode.
*/

class WPBakeryShortCode_WT_tag extends WPBakeryShortCode {
	
	private $wt_sc;
	
	public function __construct($settings) {
        parent::__construct($settings);
		$this->wt_sc = new WT_VCSC_SHORTCODE;
	}
			
	protected function content($atts, $content = null) {
		
		extract( shortcode_atts( array(
			'type'          => 'div',
			'el_id'         => '',
			'el_class'      => '',
			'el_style'      => '',
    		'css_animation' => '',
    		'anim_type'     => '',
    		'anim_delay'    => '',			
			'css'           => ''		
		), $atts ) );
		
		$sc_class = 'wt_tag_sc';
				
		$id = mt_rand(9999, 99999);
		if (trim($el_id) != false) {
			$el_id = esc_attr( trim($el_id) );
		} else {
			$el_id = $sc_class . '-' . $id;
		}		
		
		$el_style = esc_attr($el_style);
				
		$el_class = esc_attr( $this->getExtraClass($el_class) );		
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $sc_class.$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);		
		$css_class .= $this->wt_sc->getWTCSSAnimationClass($css_animation,$anim_type);
		$anim_data = $this->wt_sc->getWTCSSAnimationData($css_animation,$anim_delay);
		
		$el_style = $this->wt_sc->getWTElementStyle($el_style);
		
		$content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
		
		$output = '<'.$type.' id="'.$el_id.'" class="'.$css_class.'"'.$el_style.$anim_data.'>';
	        $output .= "\n\t\t\t".$content;
        $output .= '</'.$type.'>';
		
        return $output;
    }
	
}

/*
Register WhoaThemes shortcode within Visual Composer interface.
*/

if (function_exists('wpb_map')) {

	$add_wt_sc_func             = new WT_VCSC_SHORTCODE;
	$add_wt_css_animation       = $add_wt_sc_func->getWTAnimations();
	$add_wt_css_animation_type  = $add_wt_sc_func->getWTAnimationsType();
	$add_wt_css_animation_delay = $add_wt_sc_func->getWTAnimationsDelay();
	
	wpb_map( array(
		'name'          => esc_html__('WT Tag', 'wt_vcsc'),
		'base'          => 'wt_tag',
		'icon'          => 'wt_vc_ico_tag',
		'class'         => 'wt_vc_sc_tag',
		'category'      => esc_html__('by WhoaThemes', 'wt_vcsc'),
		'description'   => esc_html__('Place HTML tags ( div, section, span, i )', 'wt_vcsc'),
		'params'        => array(
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Type', 'wt_vcsc'),
				'param_name'    => 'type',
				'value'         => array(esc_html__('Div', 'wt_vcsc') => 'div', esc_html__('Section', 'wt_vcsc') => 'section', esc_html__('Span', 'wt_vcsc') => 'span', esc_html__('I', 'wt_vcsc') => 'i' ),
				'description'   => esc_html__('Select the html tag you need. This shortcode is very useful because you can create block elements withought html coding. You can give them an id, a class attribute or set an inline style.', 'wt_vcsc')
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Extra Unique ID name', 'wt_vcsc'),
				'param_name'    => 'el_id',
				'description'   => esc_html__('If you wish to style particular content element differently, then use this field to add a UNIQUE ID name and then refer to it in your css file.', 'wt_vcsc')
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Extra class name', 'wt_vcsc'),
				'param_name'    => 'el_class',
				'description'   => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wt_vcsc')
			),
			array(
				'type'          => 'textarea',
				'heading'       => esc_html__('Extra style', 'wt_vcsc'),
				'param_name'    => 'el_style',
				'description'   => esc_html__('If you wish to use inline styles, then use this field. The style attribute can contain any CSS property.', 'wt_vcsc').' <br>'. esc_html__('Example: color:sienna;margin-left:20px;', 'wt_vcsc')
			),
			array(
				'type'          => 'textarea_html',
				'holder'        => 'div',
				'class'         => '',
				'heading'       => esc_html__('Content', 'wt_vcsc'),
				'param_name'    => 'content',
				'value'         => esc_html__('I am test text block. Click edit button to change this text.', 'wt_vcsc'),
				'description'   => esc_html__('Enter your content.', 'wt_vcsc')
			),
			
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