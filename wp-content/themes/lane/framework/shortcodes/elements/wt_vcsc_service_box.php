<?php

// File Security Check
if (!defined('ABSPATH')) die('-1');

/*
Register WhoaThemes shortcode.
*/

class WPBakeryShortCode_WT_service_box extends WPBakeryShortCode {
	
	private $wt_sc;
	
	public function __construct($settings) {
        parent::__construct($settings);
		$this->wt_sc = new WT_VCSC_SHORTCODE;
	}
				
	protected function content($atts, $content = null) {
		
		extract( shortcode_atts( array(
			'image' 	       		=> '',
			'img_size'         		=> 'thumbnail',
    		'style'            		=> '',
    		'border_color'     		=> '',
			'icon' 	           		=> '',
			'icon_type'		   		=> 'wt_icon_type_1',
			'icon_style'	  		=> 'wt_icon_circle',
			'default_icon'     		=> '',
			'border_style'    		=> '',
			'icon_background'  		=> '',
			'icon_color'       		=> '',
			'icon_size'       		=> 30,			
    		'alignment'        		=> 'left',
			'title_content_new_row' => '',
			'content_new_row'       => '',
			'empty_space'      		=> '',
			'title' 	       		=> '',
						
			'el_id'            => '',
			'el_class'         => '',
    		'css_animation'    => '',
    		'anim_type'        => '',
    		'anim_delay'       => '',			
			'css'              => ''		
		), $atts ) );
		
		$sc_class = 'wt_service_box_sc';	
					
		$id = mt_rand(9999, 99999);
		if (trim($el_id) != false) {
			$el_id = esc_attr( trim($el_id) );
		} else {
			$el_id = $sc_class . '-' . $id;
		}		
		
		$style        = ($style!='') ? $style : '';		
		$el_style     = '';	
		$inline_style = '';
		$img_output   = '';
		
		// Service Image Output
		if ( $border_color != '' ) {
			if ($style == 'vc_box_border' || $style == 'vc_box_border_circle' ) {
				$el_style = 'background-color:' . esc_attr( $border_color ) . ';';
			}
			if ($style == 'vc_box_outline' || $style == 'vc_box_outline_circle' ) {
				$el_style = 'border-color:' . esc_attr( $border_color ) . ';';
			}
		}
		
		$img_id = preg_replace('/[^\d]/', '', $image);
		
		if ( $border_color != '' && ($style == 'vc_box_border' || $style == 'vc_box_border_circle' || $style == 'vc_box_outline' || $style == 'vc_box_outline_circle') ) {
			$img = wt_wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => $style, 'style' => $el_style ));
		} else {
			$img = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => $style ));
		}
				
		$img_output = ($style=='vc_box_shadow_3d') ? '<span class="vc_box_shadow_3d_wrap">' . $img['thumbnail'] . '</span>' : $img['thumbnail'];			
				
		// Service Icon Output
		if ( $default_icon == 'yes' ) {
			$icon_default = ' wt_icon_default';
		} else {
			$icon_default = '';
		}
			
		if ( $icon_background != '' ) {
			$icon_background = 'background: ' . $icon_background . ';';
		}
			
		if ( $icon_color != '' ) {
			if ( $icon_type != 'wt_icon_type_3' ) {
				$icon_color = 'color: ' . $icon_color . ';';
			} else {
				$icon_color = 'color: ' . $icon_color . ';' . 'border-color: ' . $icon_color . ';'; 
			}
		}
		
		if ( $icon_background != '' || $icon_color != '' ) {
			$inline_style = ' style="'. $icon_color . $icon_background .'"';
		}
		
		if ( $icon_type != 'wt_icon_type_3' ) {
			$border_style = ''; // Add border style only for type_3 icons
		} else {
			$border_style = ' wt_icon_border_' . $border_style;
		}
		
		$icon  = esc_html( $icon );
		$title = esc_html( $title );
		
		if ( $icon_type != 'wt_icon_type_2' && $icon_type != 'wt_icon_type_3' ) {
			$icon_style = ''; // Add icon style (rounded, squared and circle) ony for type2 and type3 icons
		} else {
			$icon_style = ' ' . $icon_style;
		}
		
		if ($icon_type == 'wt_icon_type_1') {
			$title_type = ' wt_title_type_1';
		} elseif ($icon_type == 'wt_icon_type_2') {
			$title_type = ' wt_title_type_2';
		} else {
			$title_type = ' wt_title_type_3';
		}
		
		$icon_type  = ' ' . $icon_type;
		
		$title_size = ' wt_title_' . $icon_size;
		$icon_size  = ' wt_icon_' . $icon_size;
		
		if ( $icon != '' ) {
			$icon_out = '<i class="'.$icon.'"></i>';
		} else {
			$icon_out = ''; 
		}
		
		if ( $empty_space == 'yes' ) {
			$empty_space = ' wt_overflow_hidden';
		} else {
			$empty_space = '';
		}
		
		if ( $alignment != 'center' && $title_content_new_row == 'yes' ) {
			$new_content_rows = ' wt_title_content_new_row';
		} elseif ( $alignment != 'center' && $content_new_row == 'yes' ) {
			$new_content_rows = ' wt_content_new_row';
		} else {
			$new_content_rows = '';			
		}
		
		if ( $title != '' ) {
			$title_out = '<h4>'.$title.'</h4>';
		} else {
			$title_out = ''; 
		}
		
		if ( $img_output != '' ) {
			$service_with_img = ' wt_service_with_img'; 
		} else {
			$service_with_img = ''; 
		}
				
		$el_class = esc_attr( $this->getExtraClass($el_class) );
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $sc_class.$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);
		$css_class .= ' wt_align_' . $alignment . $new_content_rows . $service_with_img;		
		$css_class .= $this->wt_sc->getWTCSSAnimationClass($css_animation,$anim_type);
		$anim_data = $this->wt_sc->getWTCSSAnimationData($css_animation,$anim_delay);		
		
		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content		
			
		$output = '<div id="'.$el_id.'" class="'.$css_class.'"'.$anim_data.'>';
			if ( $new_content_rows != '' ) { // if title, or content, or both of them are on new rows
			
				if ( $icon_out != '' ) {
					$output .= "\n\t" . '<div class="wt_icon'.$icon_type.$icon_style.$border_style.$icon_size.$icon_default.'"'.$inline_style.'>'; 
						$output .= $icon_out;
					$output .= "\n\t" . '</div>';
				}
				
				if ( $img_output != '' ) {
					$output .= "\n\t" . '<div class="wt_service_img">'; 
						$output .= $img_output;
					$output .= "\n\t" . '</div>';
				}
				
				// if title and content are on new rows
				if ( trim($new_content_rows) == 'wt_title_content_new_row' ) {
					$output .= '<div class="wt_clearboth"></div>';
				}				
				
				// set title line height
				if ( trim($new_content_rows) == 'wt_content_new_row' ) {
					$title_height = $title_size;
				} else {
					$title_height = '';
					$title_type   = '';
				}
				
				$output .= '<div class="wt_service_details'.$empty_space.$title_type.$title_height.'">'; 
					$output .= "\n\t" . $title_out;
				$output .= '</div>';
				
				// always new row for content
				$output .= '<div class="wt_clearboth"></div>';
				
				$output .= '<div class="wt_service_details wt_new_content_row'.$empty_space.'">';
					$output .= "\n\t" . $content;
				$output .= '</div>';
				
			} else {
				
				if ( $icon_out != '' ) {
					$output .= "\n\t" . '<div class="wt_icon'.$icon_type.$icon_style.$border_style.$icon_size.$icon_default.'"'.$inline_style.'>'; 
						$output .= $icon_out;
					$output .= "\n\t" . '</div>';
				}
				
				if ( $img_output != '' ) {
					$output .= "\n\t" . '<div class="wt_service_img">'; 
						$output .= $img_output;
					$output .= "\n\t" . '</div>';
				}
				
				$output .= '<div class="wt_service_details'.$empty_space.'">'; 
					$output .= "\n\t" . $title_out;
					$output .= "\n\t" . $content;
				$output .= '</div>';
				
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
		'name'          => esc_html__('WT Service Box', 'wt_vcsc'),
		'base'          => 'wt_service_box',
		'icon'          => 'wt_vc_ico_service_box',
		'class'         => 'wt_vc_sc_service_box',
		'category'      => esc_html__('by WhoaThemes', 'wt_vcsc'),
		'description'   => esc_html__('Build a service box', 'wt_vcsc'),
		'params'        => array(
			array(
				'type'		  => 'wt_separator',
				'heading'	  => esc_html__( '', 'wt_vcsc' ),
				"param_name"  => 'separator',
				'value'	      => 'Service Image & Styles'
			),
			array(
				'type'          => 'attach_image',
				'heading'       => esc_html__('Image', 'wt_vcsc'),
				'param_name'    => 'image',
				'value'         => '',
				'description'   => esc_html__('Select image from media library.', 'wt_vcsc')
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Image size', 'wt_vcsc'),
				'param_name'    => 'img_size',
				'description'   => esc_html__('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'wt_vcsc')
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Image style', 'wt_vcsc'),
				'param_name'    => 'style',
				'value'         => WT_VCSC_getShared('single image styles')
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Border color', 'wt_vcsc'),
				'param_name'    => 'border_color',
				'dependency'    => Array('element' => 'style', 'value' => array('vc_box_border', 'vc_box_border_circle', 'vc_box_outline', 'vc_box_outline_circle')),
				'description'   => esc_html__( 'Select border color for your image.', 'wt_vcsc' )
			),			
			array(
				'type'		  => 'wt_separator',
				'heading'	  => esc_html__( '', 'wt_vcsc' ),
				"param_name"  => 'separator_2',
				'value'	      => 'Service Icon & Styles'
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Icon', 'wt_vcsc'),
				'param_name'    => 'icon',
				'description'   => '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Font Awesome</a>, <a href="http://entypo.com/" target="_blank">Entypo</a> or <a href="http://glyphicons.com/" target="_blank">Glyphicons</a> accepted. (use "fa-", "entypo-" or "glyphicon-" prefix - for example "<strong>fa-adjust, entypo-flag or glyphicon-leaf</strong>"'
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Icon type', 'wt_vcsc'),
				'param_name'    => 'icon_type',
				'value'         => array( 
					__('Simple', 'wt_vcsc')             		 => 'wt_icon_type_1',
					__('Background', 'wt_vcsc')         		 => 'wt_icon_type_2', 
					__('Background hover & border', 'wt_vcsc')   => 'wt_icon_type_3',
				),
				'description'   => esc_html__('Select service icon type.', 'wt_vcsc')
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Icon style', 'wt_vcsc'),
				'param_name'    => 'icon_style',
				'value'         => array(
					__('Square', 'wt_vcsc')          => 'wt_icon_square', 
					__('Rounded', 'wt_vcsc')         => 'wt_icon_rounded',
					__('Circle', 'wt_vcsc')          => 'wt_icon_circle',
					__('Diamond', 'wt_vcsc')   	     => 'wt_icon_diamond',
					__('Diamond Rounded', 'wt_vcsc') => 'wt_icon_diamond wt_icon_rounded',
				),
				'std'           => 'wt_icon_circle',
				'dependency' 	=> array(
					'element' 	=> 'icon_type',
					'value' 	=> array('wt_icon_type_2', 'wt_icon_type_3')
				),
				'description'   => esc_html__('Select service icon style.', 'wt_vcsc')
			),
			array(
				'type'			=> 'checkbox',
				'heading'		=> esc_html__('Default Icon?','wt_vcsc'),
				'param_name'	=> 'default_icon',
				'value'			=> Array( esc_html__('Yes please.', 'wt_vcsc') => 'yes'),
				'description'   => esc_html__( 'Check this option to add a default background / border color.', 'wt_vcsc' )
			),
			array(
				'type'			=> 'dropdown',
				'class'			=> '',
				'heading'		=> esc_html__('Border Style','wt_vcsc'),
				'param_name'	=> 'border_style',
				'value'			=> array(
					__('Solid', 'wt_vcsc')	=> 'solid',
					__('Dotted', 'wt_vcsc')	=> 'dotted',
					__('Dashed', 'wt_vcsc')	=> 'dashed',
				),
				'dependency' 	=> array(
					'element' 	=> 'icon_type',
					'value' 	=> array('wt_icon_type_3')
				),
				'description'   => esc_html__('Select border style.', 'wt_vcsc')
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Icon background', 'wt_vcsc'),
				'param_name'    => 'icon_background',
				'dependency' 	=> array(
					'element' 	=> 'icon_type',
					'value' 	=> array('wt_icon_type_2', 'wt_icon_type_3')
				),
				'description'   => esc_html__( 'Select icon background.', 'wt_vcsc' )
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Icon color', 'wt_vcsc'),
				'param_name'    => 'icon_color',
				'description'   => esc_html__( 'Select icon color.', 'wt_vcsc' )
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Icon size', 'wt_vcsc'),
				'param_name'    => 'icon_size',
				'value'         => array( 
					'20' => '20',
					'24' => '24',
					'25' => '25',
					'26' => '26',
					'30' => '30', 
					'32' => '32',  
					'34' => '34', 
					'35' => '35',
					'36' => '36',
					'38' => '38',
					'40' => '40',
					'42' => '42',
					'44' => '44',
					'45' => '45',
					'50' => '50',
					'60' => '60',
				),
				'std'           => '30',
				'description'   => esc_html__('Select icon size.', 'wt_vcsc')
			),				
			array(
				'type'		  => 'wt_separator',
				'heading'	  => esc_html__( '', 'wt_vcsc' ),
				"param_name"  => 'separator_3',
				'value'	      => 'Service Title & Content'
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Alignment', 'wt_vcsc'),
				'param_name'    => 'alignment',
				'value'         => array( esc_html__('Align left', 'wt_vcsc') => 'left', esc_html__('Align right', 'wt_vcsc') => 'right', esc_html__('Align center', 'wt_vcsc') => 'center'),
				'std'           => 'left',
				'description'   => esc_html__('Select service box alignment.', 'wt_vcsc')
			),
				array(
					'type'			=> 'checkbox',
					'heading'		=> esc_html__('New row for title & content?','wt_vcsc'),
					'param_name'	=> 'title_content_new_row',
					'value'			=> Array( esc_html__('Yes please.', 'wt_vcsc') => 'yes'),
					'param_holder_class' => 'wt_dependency',
					'dependency' 	=> array(
						'element' 	=> 'alignment',
						'value' 	=> array('left', 'right')
					),
					'description'   => esc_html__( 'Check this option if you want a new row for service title & content.', 'wt_vcsc' )
				),	
				array(
					'type'			=> 'checkbox',
					'heading'		=> esc_html__('New row for content?','wt_vcsc'),
					'param_name'	=> 'content_new_row',
					'value'			=> Array( esc_html__('Yes please.', 'wt_vcsc') => 'yes'),
					'param_holder_class' => 'wt_dependency',
					'dependency' 	=> array(
						'element' 	=> 'alignment',
						'value' 	=> array('left', 'right')
					),
					'description'   => esc_html__( 'Check this option if you want a new row only for service content.', 'wt_vcsc' )
				),		
				array(
					'type'			=> 'checkbox',
					'heading'		=> esc_html__('Empty space below icon?','wt_vcsc'),
					'param_name'	=> 'empty_space',
					'value'			=> Array( esc_html__('Yes please.', 'wt_vcsc') => 'yes'),
					'param_holder_class' => 'wt_dependency',
					'dependency' 	=> array(
						'element' 	=> 'alignment',
						'value' 	=> array('left', 'right')
					),
					'description'   => esc_html__( 'Check this option if you don\'t want to fill the space below icon with text.', 'wt_vcsc' )
				),	
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Service title', 'wt_vcsc'),
				'param_name'    => 'title',
				"admin_label"   => true,
				'description'   => esc_html__('Add title for your service box.', 'wt_vcsc')
			),
			array(
				'type'          => 'textarea_html',
				'heading'       => esc_html__('Service text', 'wt_vcsc'),
				'param_name'    => 'content',
				'value' 		=>  '<p>' . esc_html__( 'I am text block. Click edit button to change this text.', 'wt_vcsc' ). '</p>',
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