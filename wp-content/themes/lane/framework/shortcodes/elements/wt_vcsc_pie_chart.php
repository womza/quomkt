<?php

// File Security Check
if (!defined('ABSPATH')) die('-1');

/*
Register WhoaThemes shortcode.
*/

class WPBakeryShortCode_WT_pie_chart extends WPBakeryShortCode {
	
	private $wt_sc;
	
	public function __construct($settings) {
        parent::__construct($settings);
		$this->wt_sc = new WT_VCSC_SHORTCODE;
	}
			
	protected function content($atts, $content = null) {
		
		extract( shortcode_atts( array(
			'title'              => '',
			'value'              => 50,
			//'size'               => 1,
			'units'              => '%',
			'track_color'        => '#202020',  
			'bar_color'          => '#ffc400',
			'line_width'         => 5,
			'animate'            => 2000,
			'line_cap'           => 'butt',
			'start_in_viewport'  => true,
			
			'el_id'              => '',
			'el_class'           => '',
    		'css_animation'      => '',
    		'anim_type'          => 'wt_animate_if_visible',
    		'anim_delay'         => ''
		), $atts ) );		
		
		wp_enqueue_script('wt-extend-easypiechart');
		
		$sc_class = 'wt_pie_chart_sc';
		
		$value        = (int)$value;	
		//$size         = (int)$size;	
		$units        = esc_html( $units );
		$track_color  = esc_attr( $track_color );
		$bar_color    = esc_attr( $bar_color );	
		$line_width   = (int)$line_width;	
		$animate      = (int)$animate;	
		$line_cap     = esc_attr( $line_cap );
				
		$id = mt_rand(9999, 99999);
		if (trim($el_id) != false) {
			$el_id = ' id="' . esc_attr( trim($el_id) ) . '"';
		} else {
			// $el_id = $sc_class . '-' . $id;
			$el_id = '';
		}		
						
		$el_class  = esc_attr( $this->getExtraClass($el_class) );		
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $sc_class.$el_class, $this->settings['base']);
		
		if ($start_in_viewport) {
			// Add "wt_animate_if_visible" because counters should start when they appear in viewport
			wp_enqueue_script( 'waypoints' );
			//$start_in_viewport = ' wt_animate_if_visible';
			$css_class .= $this->wt_sc->getWTCSSAnimationClass($css_animation,false);
			$start_in_viewport = ' ' . $anim_type;
		} else {
			$css_class .= $this->wt_sc->getWTCSSAnimationClass($css_animation,$anim_type);
			$start_in_viewport = '';
		}		
		
		$anim_data = $this->wt_sc->getWTCSSAnimationData($css_animation,$anim_delay);		
						
		if($title) {
			$title_out = '<h4>' . esc_html( $title ) . '</h4>';
		} else {
			$title_out = ''; }		
			
		$output = '<div'.$el_id.' class="'.$css_class.$start_in_viewport.'"'.$anim_data.'>';
		$output .= '<div class="wt_pie_percentage" data-percent="'.$value.'" data-track_color="'.$track_color.'" data-bar_color="'.$bar_color.'" data-line_width="'.$line_width.'" data-animate="'.$animate.'" data-line_cap="'.$line_cap.'">';
		$output .= '<span class="wt_pie_percent"></span>';
		$output .= '<span class="wt_pie_unit">' . $units . '</span>';
		$output .= '</div>';
		$output .= $title_out;
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
		'name'          => esc_html__('WT Pie Chart', 'wt_vcsc'),
		'base'          => 'wt_pie_chart',
		'icon'          => 'wt_vc_ico_pie_chart',
		'class'         => 'wt_vc_sc_pie_chart',
		'category'      => esc_html__('by WhoaThemes', 'wt_vcsc'),
		'description'   => esc_html__('Animated pie chart', 'wt_vcsc'),
		'params'        => array(
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Pie chart title', 'wt_vcsc'),
				'param_name'    => 'title',
				'description'   => esc_html__('Enter text which will be used as widget title. Leave blank if no title is needed.', 'wt_vcsc'),
				'admin_label'   => true
			),
			array(
				'type'          => 'wt_range',
				'heading'       => esc_html__( 'Pie value', 'wt_vcsc' ),
				'param_name'    => 'value',
				'value'         => '50',
				'min'           => '0',
				'max'           => '100',
				'step'          => '1',
				'description'   => esc_html__( 'Input graph value here. Choose range between 0 and 100.', 'wt_vcsc' ),
				'admin_label'   => true
			),
			/*
			array(
				'type'          => 'wt_range',
				'heading'       => esc_html__( 'Pie size', 'wt_vcsc' ),
				'param_name'    => 'size',
				'value'         => '130',
				'min'           => '50',
				'max'           => '500',
				'step'          => '1',
				'description'   => esc_html__( 'Size of the pie chart in px. It will always be a square.', 'wt_vcsc' )
			),
			*/
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__( 'Units', 'wt_vcsc' ),
				'param_name'    => 'units',
				'value'         => '%',
				'description'   => esc_html__( 'Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.', 'wt_vcsc' )
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__( 'Track color', 'wt_vcsc' ),
				'param_name'    => 'track_color',
				'value'         => '#202020',
				'description'   => esc_html__( 'The color of the track.', 'wt_vcsc' )
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__( 'Bar color', 'wt_vcsc' ),
				'param_name'    => 'bar_color',
				'value'         => '#ffc400',
				'description'   => esc_html__( 'Select pie chart color.', 'wt_vcsc' )
			),
			array(
				'type'          => 'wt_range',
				'heading'       => esc_html__( 'Line width', 'wt_vcsc' ),
				'param_name'    => 'line_width',
				'value'         => '5',
				'min'           => '0',
				'max'           => '15',
				'step'          => '1',
				'unit'          => 'px',
				'description'   => esc_html__( 'Width of the chart line in px.', 'wt_vcsc' )
			),
			array(
				'type'          => 'wt_range',
				'heading'       => esc_html__( 'Animate time', 'wt_vcsc' ),
				'param_name'    => 'animate',
				'value'         => '2000',
				'min'           => '0',
				'max'           => '10000',
				'step'          => '100',
				'unit'          => 'ms',
				'description'   => esc_html__( 'Time in milliseconds for an animation of the bar growing.', 'wt_vcsc' )
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Line cap', 'wt_vcsc'),
				'param_name'    => 'line_cap',
				'value'         => array(  
					esc_html__('Butt', 'wt_vcsc')   => 'butt',
					esc_html__('Round', 'wt_vcsc')  => 'round', 
					esc_html__('Square', 'wt_vcsc') => 'square'
				),
				'std'           => 'butt',
				'description'   => esc_html__('Defines how the ending of the bar line looks like. Possible values are: butt, round and square.', 'wt_vcsc')
			),
			
			array(
				'type'                  => 'wt_loadfile',
				'heading'               => esc_html__( '', 'wt_vcsc' ),
				'param_name'            => 'el_file',
				'value'                 => '',
				'file_type'             => 'js',
				'file_path'             => 'wt-visual-composer-extend-element.min.js',
				'param_holder_class'    => 'wt_loadfile_field',
				'description'           => esc_html__( '', 'wt_vcsc' )
			),
			
			$add_wt_extra_id,
			$add_wt_extra_class,
			$add_wt_css_animation,
			$add_wt_css_animation_type,
			$add_wt_css_animation_delay
						
		)
	));
	
}