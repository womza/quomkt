<?php

// File Security Check
if (!defined('ABSPATH')) die('-1');

/*
Register WhoaThemes shortcode.
*/

class WPBakeryShortCode_WT_timeline extends WPBakeryShortCode {
	
	private $wt_sc;
	
	public function __construct($settings) {
        parent::__construct($settings);
		$this->wt_sc = new WT_VCSC_SHORTCODE;
	}
				
	protected function content($atts, $content = null) {
		
		extract( shortcode_atts( array(
			'date' 	       	   => '',
			'alignment'        => 'left',
			'title' 	       => '',
			//'timeline_text' 		=> '',
			'el_id'            		=> '',
			'el_class'         		=> '',
    		'date_css_animation'    => '',
    		'date_anim_delay'       => '',
    		'date_anim_type'        => '',
    		'content_css_animation' => '',
    		'content_anim_delay'    => '',
    		'content_anim_type'     => '',		
				
			'css'              		=> ''		
		), $atts ) );
		
		$sc_class = 'wt_timeline_sc';		
		
		$date      = esc_html( $date );	
		$alignment = esc_html( $alignment );
		$title     = esc_html( $title );
				
		$id = mt_rand(9999, 99999);
		if (trim($el_id) != false) {
			$el_id = ' id="' . esc_attr( trim($el_id) ) . '"';
		} else {
			// $el_id = $sc_class . '-' . $id;
			$el_id = '';
		}		
						
		$el_class  = esc_attr( $this->getExtraClass($el_class) );		
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $sc_class.$el_class, $this->settings['base']);		
			
		$date_css_class    = $this->wt_sc->getWTCSSAnimationClass($date_css_animation,$date_anim_type);
		$content_css_class = $this->wt_sc->getWTCSSAnimationClass($content_css_animation,$content_anim_type);
		
		$date_anim_data    = $this->wt_sc->getWTCSSAnimationData($date_css_animation,$date_anim_delay);
		$content_anim_data = $this->wt_sc->getWTCSSAnimationData($content_css_animation,$content_anim_delay);		
		
		$date_out            = '';
		$timeline_item_start = '';
		$timeline_item_end   = '';
		$title_out           = '';
		$content_out         = '';
						
		if ($date) {
			$date_out .= '<div class="wt_timeline_year text-center'.$date_css_class.'"'.$date_anim_data.'>';
				$date_out .= '<span>' . $date . '</span>';
			$date_out .= '</div>';
		}
		
		if ($alignment == 'left') {
			$alignment = ' pull-left';
		} else {
			$alignment = ' pull-right';
		}
		
		if ($content || $title) {
			$timeline_item_start .= '<div class="wt_timeline_item">';
				$timeline_item_start .= '<div class="col-xs-12 col-md-5'. $alignment .' wt_timeline_item_content'.$content_css_class.'"'.$content_anim_data.'>';
				$timeline_item_end   .= '</div>'; 
			$timeline_item_end   .= '</div>'; 
		}		
		
		if ($title) {
			$title_out .= '<div class="wt_timeline_item_title clearfix">';
				$title_out .= '<h4>' . $title . '</h4>';
			$title_out .= '</div>';
		}		
		
		if ($content) {
			$content_out .= '<div class="wt_timeline_item_text">';
				$content_out .= $content;
			$content_out .= '</div>';
		} 	
			
		$output = '<div'.$el_id.' class="'.$css_class.'">';
			$output .= $date_out;
			$output .= $timeline_item_start;
				$output .= $title_out;
				$output .= $content_out;		
			$output .= $timeline_item_end;
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
		'name'          => esc_html__('WT Timeline', 'wt_vcsc'),
		'base'          => 'wt_timeline',
		'icon'          => 'wt_vc_ico_timeline',
		'class'         => 'wt_vc_sc_timeline',
		'category'      => esc_html__('by WhoaThemes', 'wt_vcsc'),
		'description'   => esc_html__('Build a custom timeline', 'wt_vcsc'),
		'params'        => array(
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Date / Step', 'wt_vcsc'),
				'param_name'    => 'date',
				'description'   => esc_html__('Enter the date / step for the timeline element.', 'wt_vcsc')
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Alignment', 'wt_vcsc'),
				'param_name'    => 'alignment',
				'value'         => array(  
					esc_html__('Left', 'wt_vcsc')   => 'left',
					esc_html__('Right', 'wt_vcsc')  => 'right'
				),
				'description'   => esc_html__('Define timeline alignment: left / right.', 'wt_vcsc')
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Title', 'wt_vcsc'),
				'param_name'    => 'title',
				'description'   => esc_html__('Enter the title for the timeline element.', 'wt_vcsc')
			),
			array(
				'type'          => 'textarea_html',
				'heading'       => esc_html__('Text', 'wt_vcsc'),
				'param_name'    => 'content',
				'value' 		=>  '<p>' . esc_html__( 'I am text block. Click edit button to change this text.', 'wt_vcsc' ). '</p>',
				'description'   => esc_html__('Add text for the timeline.', 'wt_vcsc')
			),
			
			$add_wt_extra_id,
			$add_wt_extra_class,			
			
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Date / Step CSS WT Animation", "wt_vcsc"),
				"param_name" => "date_css_animation",
				"value" => array( esc_html__("No", "wt_vcsc") => '', esc_html__("Hinge", "wt_vcsc") => "hinge", esc_html__("Flash", "wt_vcsc") => "flash", esc_html__("Shake", "wt_vcsc") => "shake", esc_html__("Bounce", "wt_vcsc") => "bounce", esc_html__("Tada", "wt_vcsc") => "tada", esc_html__("Swing", "wt_vcsc") => "swing", esc_html__("Wobble", "wt_vcsc") => "wobble", esc_html__("Pulse", "wt_vcsc") => "pulse", esc_html__("Flip", "wt_vcsc") => "flip", esc_html__("FlipInX", "wt_vcsc") => "flipInX", esc_html__("FlipOutX", "wt_vcsc") => "flipOutX", esc_html__("FlipInY", "wt_vcsc") => "flipInY", esc_html__("FlipOutY", "wt_vcsc") => "flipOutY", esc_html__("FadeIn", "wt_vcsc") => "fadeIn", esc_html__("FadeInUp", "wt_vcsc") => "fadeInUp", esc_html__("FadeInDown", "wt_vcsc") => "fadeInDown", esc_html__("FadeInLeft", "wt_vcsc") => "fadeInLeft", esc_html__("FadeInRight", "wt_vcsc") => "fadeInRight", esc_html__("FadeInUpBig", "wt_vcsc") => "fadeInUpBig", esc_html__("FadeInDownBig", "wt_vcsc") => "fadeInDownBig", esc_html__("FadeInLeftBig", "wt_vcsc") => "fadeInLeftBig", esc_html__("FadeInRightBig", "wt_vcsc") => "fadeInRightBig", esc_html__("FadeOut", "wt_vcsc") => "fadeOut", esc_html__("FadeOutUp", "wt_vcsc") => "fadeOutUp", esc_html__("FadeOutDown", "wt_vcsc") => "fadeOutDown", esc_html__("FadeOutLeft", "wt_vcsc") => "fadeOutLeft", esc_html__("FadeOutRight", "wt_vcsc") => "fadeOutRight", esc_html__("fadeOutUpBig", "wt_vcsc") => "fadeOutUpBig", esc_html__("FadeOutDownBig", "wt_vcsc") => "fadeOutDownBig", esc_html__("FadeOutLeftBig", "wt_vcsc") => "fadeOutLeftBig", esc_html__("FadeOutRightBig", "wt_vcsc") => "fadeOutRightBig", esc_html__("BounceIn", "wt_vcsc") => "bounceIn", esc_html__("BounceInUp", "wt_vcsc") => "bounceInUp", esc_html__("BounceInDown", "wt_vcsc") => "bounceInDown", esc_html__("BounceInLeft", "wt_vcsc") => "bounceInLeft", esc_html__("BounceInRight", "wt_vcsc") => "bounceInRight", esc_html__("BounceOut", "wt_vcsc") => "bounceOut", esc_html__("BounceOutUp", "wt_vcsc") => "bounceOutUp", esc_html__("BounceOutDown", "wt_vcsc") => "bounceOutDown", esc_html__("BounceOutLeft", "wt_vcsc") => "bounceOutLeft", esc_html__("BounceOutRight", "wt_vcsc") => "bounceOutRight", esc_html__("RotateIn", "wt_vcsc") => "rotateIn", esc_html__("RotateInUpLeft", "wt_vcsc") => "rotateInUpLeft", esc_html__("RotateInDownLeft", "wt_vcsc") => "rotateInDownLeft", esc_html__("RotateInUpRight", "wt_vcsc") => "rotateInUpRight", esc_html__("RotateInDownRight", "wt_vcsc") => "rotateInDownRight", esc_html__("RotateOut", "wt_vcsc") => "rotateOut", esc_html__("RotateOutUpLeft", "wt_vcsc") => "rotateOutUpLeft", esc_html__("RotateOutDownLeft", "wt_vcsc") => "rotateOutDownLeft", esc_html__("RotateOutUpRight", "wt_vcsc") => "rotateOutUpRight", esc_html__("RotateOutDownRight", "wt_vcsc") => "rotateOutDownRight", esc_html__("RollIn", "wt_vcsc") => "rollIn", esc_html__("RollOut", "wt_vcsc") => "rollOut", esc_html__("LightSpeedIn", "wt_vcsc") => "lightSpeedIn", esc_html__("LightSpeedOut", "wt_vcsc") => "lightSpeedOut" ),
				"description" => esc_html__("Select type of animation (for timeline date / step) if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "wt_vcsc"),
				'group' => esc_html__('Extra settings', 'wt_vcsc')
			),	
			array(
				"type" => "textfield",
				"heading" => esc_html__("Date / Step WT Animation Delay", "wt_vcsc"),
				"param_name" => "date_anim_delay",
				"description" => esc_html__("Here you can set a specific delay for the timeline date / step animation (miliseconds). Example: '100', '500', '1000'.", "wt_vcsc"),
				'group' => esc_html__('Extra settings', 'wt_vcsc')
			),
			array(
				"type"        => "dropdown",
				"heading"     => esc_html__("Date / Step WT Animation Visible Type", "wt_vcsc"),
				"param_name"  => "date_anim_type",
				"value"       => array( esc_html__("Animate when element is visible", "wt_vcsc") => 'wt_animate_if_visible', esc_html__("Animate if element is almost visible", "wt_vcsc") => "wt_animate_if_almost_visible" ),
				"description" => esc_html__("Select when the type of animation should start for timeline date / step element.", "wt_vcsc"),
				'group'       => esc_html__('Extra settings', 'wt_vcsc')
			),	
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Content CSS WT Animation", "wt_vcsc"),
				"param_name" => "content_css_animation",
				"value" => array( esc_html__("No", "wt_vcsc") => '', esc_html__("Hinge", "wt_vcsc") => "hinge", esc_html__("Flash", "wt_vcsc") => "flash", esc_html__("Shake", "wt_vcsc") => "shake", esc_html__("Bounce", "wt_vcsc") => "bounce", esc_html__("Tada", "wt_vcsc") => "tada", esc_html__("Swing", "wt_vcsc") => "swing", esc_html__("Wobble", "wt_vcsc") => "wobble", esc_html__("Pulse", "wt_vcsc") => "pulse", esc_html__("Flip", "wt_vcsc") => "flip", esc_html__("FlipInX", "wt_vcsc") => "flipInX", esc_html__("FlipOutX", "wt_vcsc") => "flipOutX", esc_html__("FlipInY", "wt_vcsc") => "flipInY", esc_html__("FlipOutY", "wt_vcsc") => "flipOutY", esc_html__("FadeIn", "wt_vcsc") => "fadeIn", esc_html__("FadeInUp", "wt_vcsc") => "fadeInUp", esc_html__("FadeInDown", "wt_vcsc") => "fadeInDown", esc_html__("FadeInLeft", "wt_vcsc") => "fadeInLeft", esc_html__("FadeInRight", "wt_vcsc") => "fadeInRight", esc_html__("FadeInUpBig", "wt_vcsc") => "fadeInUpBig", esc_html__("FadeInDownBig", "wt_vcsc") => "fadeInDownBig", esc_html__("FadeInLeftBig", "wt_vcsc") => "fadeInLeftBig", esc_html__("FadeInRightBig", "wt_vcsc") => "fadeInRightBig", esc_html__("FadeOut", "wt_vcsc") => "fadeOut", esc_html__("FadeOutUp", "wt_vcsc") => "fadeOutUp", esc_html__("FadeOutDown", "wt_vcsc") => "fadeOutDown", esc_html__("FadeOutLeft", "wt_vcsc") => "fadeOutLeft", esc_html__("FadeOutRight", "wt_vcsc") => "fadeOutRight", esc_html__("fadeOutUpBig", "wt_vcsc") => "fadeOutUpBig", esc_html__("FadeOutDownBig", "wt_vcsc") => "fadeOutDownBig", esc_html__("FadeOutLeftBig", "wt_vcsc") => "fadeOutLeftBig", esc_html__("FadeOutRightBig", "wt_vcsc") => "fadeOutRightBig", esc_html__("BounceIn", "wt_vcsc") => "bounceIn", esc_html__("BounceInUp", "wt_vcsc") => "bounceInUp", esc_html__("BounceInDown", "wt_vcsc") => "bounceInDown", esc_html__("BounceInLeft", "wt_vcsc") => "bounceInLeft", esc_html__("BounceInRight", "wt_vcsc") => "bounceInRight", esc_html__("BounceOut", "wt_vcsc") => "bounceOut", esc_html__("BounceOutUp", "wt_vcsc") => "bounceOutUp", esc_html__("BounceOutDown", "wt_vcsc") => "bounceOutDown", esc_html__("BounceOutLeft", "wt_vcsc") => "bounceOutLeft", esc_html__("BounceOutRight", "wt_vcsc") => "bounceOutRight", esc_html__("RotateIn", "wt_vcsc") => "rotateIn", esc_html__("RotateInUpLeft", "wt_vcsc") => "rotateInUpLeft", esc_html__("RotateInDownLeft", "wt_vcsc") => "rotateInDownLeft", esc_html__("RotateInUpRight", "wt_vcsc") => "rotateInUpRight", esc_html__("RotateInDownRight", "wt_vcsc") => "rotateInDownRight", esc_html__("RotateOut", "wt_vcsc") => "rotateOut", esc_html__("RotateOutUpLeft", "wt_vcsc") => "rotateOutUpLeft", esc_html__("RotateOutDownLeft", "wt_vcsc") => "rotateOutDownLeft", esc_html__("RotateOutUpRight", "wt_vcsc") => "rotateOutUpRight", esc_html__("RotateOutDownRight", "wt_vcsc") => "rotateOutDownRight", esc_html__("RollIn", "wt_vcsc") => "rollIn", esc_html__("RollOut", "wt_vcsc") => "rollOut", esc_html__("LightSpeedIn", "wt_vcsc") => "lightSpeedIn", esc_html__("LightSpeedOut", "wt_vcsc") => "lightSpeedOut" ),
				"description" => esc_html__("Select type of animation (for timeline content / text) if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "wt_vcsc"),
				'group' => esc_html__('Extra settings', 'wt_vcsc')
			),	
			array(
				"type" => "textfield",
				"heading" => esc_html__("Content WT Animation Delay", "wt_vcsc"),
				"param_name" => "content_anim_delay",
				"description" => esc_html__("Here you can set a specific delay for the timeline content / text animation (miliseconds). Example: '100', '500', '1000'.", "wt_vcsc"),
				'group' => esc_html__('Extra settings', 'wt_vcsc')
			),
			array(
				"type"        => "dropdown",
				"heading"     => esc_html__("Content WT Animation Visible Type", "wt_vcsc"),
				"param_name"  => "content_anim_type",
				"value"       => array( esc_html__("Animate when element is visible", "wt_vcsc") => 'wt_animate_if_visible', esc_html__("Animate if element is almost visible", "wt_vcsc") => "wt_animate_if_almost_visible" ),
				"std"         => "wt_animate_if_almost_visible",
				"description" => esc_html__("Select when the type of animation should start for timeline content element.", "wt_vcsc"),
				'group'       => esc_html__('Extra settings', 'wt_vcsc')
			),	
						
			array(
				'type'          => 'css_editor',
				'heading'       => esc_html__('Css', 'wt_vcsc'),
				'param_name'    => 'css',
				'group'         => esc_html__('Design options', 'wt_vcsc')
			)
		)
	));	
	
}