<?php
	if (function_exists('vc_add_param')) {
		
		// Column WT_VC Extensions
		vc_add_param("vc_column", array(
			'type'              			=> 'wt_separator',
			'heading'           			=> esc_html__( '', 'wt_vcsc' ),
			'param_name'        			=> 'separator',
			'value'             			=> 'Background Extended Settings',
			'description'       			=> esc_html__( '', 'wt_vcsc' ),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));	
		vc_add_param("vc_column", array(
			'type'                          => 'textfield',
			'heading'                       => esc_html__('Extra Unique ID name', 'wt_vcsc'),
			'param_name'                    => 'el_id',
			'description'                   => esc_html__('If you wish to style particular content element differently, then use this field to add a UNIQUE ID name and then refer to it in your css file.', 'wt_vcsc')
		));
		vc_add_param( "vc_column", array(
			'type'							=> 'dropdown',
			'heading'						=> esc_html__('Column Style','wt_vcsc'),
			'param_name'					=> 'style',
			'value'							=> array(
				__('None', 'wt_vcsc')  => '',
				__('Bordered', 'wt_vcsc') => 'bordered',
				__('Boxed', 'wt_vcsc')    => 'boxed',
			),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc')
		));		
		vc_add_param( "vc_column", array(
			'type'							=> 'checkbox',
			'class'							=> '',
			'heading'						=> esc_html__('Drop Shadow?','wt_vcsc'),
			'param_name'					=> 'shadow',
			'value'							=> Array( esc_html__('Yes please.', 'wt_vcsc') => 'yes'),
			'description'           		=> esc_html__( 'Check this option to add a default shadow to this column.', 'wt_vcsc' ),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc')
		));
		vc_add_param("vc_column", array(
			'type' 							=> 'dropdown',
			'heading' 						=> esc_html__( 'Typography Style', 'wt_vcsc'),
			'param_name' 					=> 'typography',
			'value' 						=> array(
				__( 'Dark Text', 'wt_vcsc')		=> 'dark',
				__( 'White Text', 'wt_vcsc')	=> 'light'
			),
			'description' 					=> esc_html__('Select typography style.', 'wt_vcsc'),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
		vc_add_param("vc_column", array(
			'type'                          => 'colorpicker',
			'heading'                       => esc_html__('Background Color', 'wt_vcsc'),
			'param_name'                    => 'bck_color',
			'description'                   => esc_html__( 'Select background color for this column.', 'wt_vcsc' ),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc')
		));	
		vc_add_param("vc_column", array(
			'type' 							=> 'dropdown',
			'heading' 						=> esc_html__( 'Background Type', 'wt_vcsc'),
			'param_name' 					=> 'bg_type',
			'value' 						=> array(
				__( 'None', 'wt_vcsc')					=> '',
				__( 'Simple Image', 'wt_vcsc')			=> 'image',
				__( 'Fixed Image', 'wt_vcsc')			=> 'fixed',
				__( 'Parallax Image', 'wt_vcsc')		=> 'parallax'
			),
			'admin_label' 					=> true,
			'description' 					=> esc_html__('Select background type for this column.', 'wt_vcsc'),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
		vc_add_param("vc_column", array(
			'type'							=> 'attach_image',
			'heading'						=> esc_html__( 'Background Image', 'wt_vcsc' ),
			'param_name'					=> 'bck_image',
			'value'							=> '',
			'description'					=> esc_html__( 'Select the background image for your column.', 'wt_vcsc' ),
			'dependency' 					=> array(
				'element' 	=> 'bg_type',
				'value' 	=> array('image', 'fixed', 'parallax')
			),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
		vc_add_param("vc_column", array(
			'type'                  		=> 'dropdown',
			'heading'               		=> esc_html__( 'Background Image Size', 'wt_vcsc' ),
			'param_name'            		=> 'bg_size',
			'value'                 		=> array(
				__( 'Full Size Image', 'wt_vcsc' )			=> 'full',
				__( 'Large Size Image', 'wt_vcsc' )			=> 'large',
				__( 'Medium Size Image', 'wt_vcsc' )		=> 'medium',
				__( 'Thumbnail Size Image', 'wt_vcsc' )		=> 'thumbnail',
			),
			'description'           		=> esc_html__( 'Select which image size based on WordPress settings should be used.', 'wt_vcsc' ),
			'dependency' 					=> array(
				'element' 	=> 'bg_type',
				'value' 	=> array('image', 'fixed', 'parallax')
			),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
		vc_add_param("vc_column", array(
			'type' 							=> 'dropdown',
			'heading' 						=> esc_html__( 'Background Position', 'wt_vcsc' ),
			'param_name' 					=> 'bg_position',
			'value' 						=> array(
				__( 'Top', 'wt_vcsc' )			=> 'top',
				__( 'Middle', 'wt_vcsc' ) 		=> 'center',
				__( 'Bottom', 'wt_vcsc' ) 		=> 'bottom'
			),
			//'description' 					=> esc_html__(''),
			'dependency' 					=> array(
				'element' 	=> 'bg_type',
				'value' 	=> array('image', 'fixed', 'parallax')
			),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc' ),
		));
		vc_add_param("vc_column", array(
			'type' 							=> 'dropdown',
			'heading' 						=> esc_html__( 'Background Size', 'wt_vcsc' ),
			'param_name' 					=> 'bg_size_standard',
			'value' 						=> array(
				__( 'Cover', 'wt_vcsc' ) 		=> 'cover',
				__( 'Contain', 'wt_vcsc' ) 		=> 'contain',
				__( 'Initial', 'wt_vcsc' ) 		=> 'initial',
				__( 'Auto', 'wt_vcsc' ) 		=> 'auto',
			),
			'dependency' 					=> array(
				'element' 	=> 'bg_type',
				'value' 	=> array('image', 'fixed', 'parallax')
			),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
		vc_add_param("vc_column", array(
			'type' 							=> 'dropdown',
			'heading' 						=> esc_html__( 'Background Repeat', 'wt_vcsc' ),
			'param_name' 					=> 'bg_repeat',
			'value' 						=> array(
				__( 'No Repeat', 'wt_vcsc' )	=> 'no-repeat',
				__( 'Repeat X + Y', 'wt_vcsc' )	=> 'repeat',
				__( 'Repeat X', 'wt_vcsc' )		=> 'repeat-x',
				__( 'Repeat Y', 'wt_vcsc' )		=> 'repeat-y'
			),
			'dependency' 					=> array(
				'element' 	=> 'bg_type',
				'value' 	=> array('image', 'fixed', 'parallax')
			),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
		vc_add_param("vc_column", array(
			'type'							=> 'colorpicker',
			'class'							=> '',
			'heading'						=> esc_html__('Border Color','wt_vcsc'),
			'param_name'					=> 'border_color',
			'value' 						=> '',
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc')
		));
		
		vc_add_param("vc_column", array(
			'type'							=> 'dropdown',
			'class'							=> '',
			'heading'						=> esc_html__('Border Style','wt_vcsc'),
			'param_name'					=> 'border_style',
			'value'							=> array(
				__('Solid', 'wt_vcsc')	=> 'solid',
				__('Dotted', 'wt_vcsc')	=> 'dotted',
				__('Dashed', 'wt_vcsc')	=> 'dashed',
			),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc')
		));
		
		vc_add_param("vc_column", array(
			'type'							=> 'textfield',
			'class'							=> '',
			'heading'						=> esc_html__('Border Width','wt_vcsc'),
			'param_name'					=> 'border_width',
			'value'							=> '0px 0px 0px 0px',
			'description'					=> esc_html__('Your border width in pixels. Example: <strong>1px 1px 1px 1px</strong> (top, right, bottom, left).', 'wt_vcsc'),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc')
		));	
		
		// Paddings & Margins
		vc_add_param("vc_column", array(
			'type'              			=> 'wt_separator',
			'heading'           			=> esc_html__( '', 'wt_vcsc' ),
			'param_name'        			=> 'separator_2',
			'value'             			=> 'Paddings and Margins',
			'description'       			=> esc_html__( '', 'wt_vcsc' ),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
		vc_add_param("vc_column", array(
			'type'                  		=> 'wt_range',
			'heading'               		=> esc_html__( 'Padding: Top', 'wt_vcsc' ),
			'param_name'            		=> 'padding_top',
			'value'                 		=> '0',
			'min'                   		=> '0',
			'max'                   		=> '250',
			'step'                  		=> '1',
			'unit'                  		=> 'px',
			'description'           		=> esc_html__( '', 'wt_vcsc' ),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
		vc_add_param("vc_column", array(
			'type'                  		=> 'wt_range',
			'heading'               		=> esc_html__( 'Padding: Bottom', 'wt_vcsc' ),
			'param_name'            		=> 'padding_bottom',
			'value'                 		=> '0',
			'min'                   		=> '0',
			'max'                   		=> '250',
			'step'                  		=> '1',
			'unit'                  		=> 'px',
			'description'           		=> esc_html__( '', 'wt_vcsc' ),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
		vc_add_param("vc_column", array(
			'type'                  		=> 'wt_range',
			'heading'               		=> esc_html__( 'Padding: Left', 'wt_vcsc' ),
			'param_name'            		=> 'padding_left',
			'value'                 		=> '0',
			'min'                   		=> '0',
			'max'                   		=> '250',
			'step'                  		=> '1',
			'unit'                  		=> 'px',
			'description'           		=> esc_html__( '', 'wt_vcsc' ),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
		vc_add_param("vc_column", array(
			'type'                  		=> 'wt_range',
			'heading'               		=> esc_html__( 'Padding: Right', 'wt_vcsc' ),
			'param_name'            		=> 'padding_right',
			'value'                 		=> '0',
			'min'                   		=> '0',
			'max'                   		=> '250',
			'step'                  		=> '1',
			'unit'                  		=> 'px',
			'description'           		=> esc_html__( '', 'wt_vcsc' ),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
		vc_add_param("vc_column", array(
			'type'                  		=> 'wt_range',
			'heading'               		=> esc_html__( 'Margin: Top', 'wt_vcsc' ),
			'param_name'            		=> 'margin_top',
			'value'                 		=> '0',
			'min'                   		=> '-250',
			'max'                   		=> '250',
			'step'                  		=> '1',
			'unit'                  		=> 'px',
			'description'           		=> esc_html__( '', 'wt_vcsc' ),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
		vc_add_param("vc_column", array(
			'type'                  		=> 'wt_range',
			'heading'               		=> esc_html__( 'Margin: Bottom', 'wt_vcsc' ),
			'param_name'            		=> 'margin_bottom',
			'value'                 		=> '0',
			'min'                   		=> '-250',
			'max'                   		=> '250',
			'step'                  		=> '1',
			'unit'                  		=> 'px',
			'description'           		=> esc_html__( '', 'wt_vcsc' ),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
		
		// Animations	
		vc_add_param("vc_column", array(
			'type'              			=> 'wt_separator',
			'heading'           			=> esc_html__( '', 'wt_vcsc' ),
			'param_name'        			=> 'separator_3',
			'value'             			=> 'Animations',
			'description'       			=> esc_html__( '', 'wt_vcsc' ),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));	
		vc_add_param("vc_column", array(
			"type"                          => "dropdown",
			"heading"                       => esc_html__("CSS WT Animation", "wt_vcsc"),
			"param_name"                    => "css_animation",
			"value" => array( esc_html__("No", "wt_vcsc") => '', esc_html__("Hinge", "wt_vcsc") => "hinge", esc_html__("Flash", "wt_vcsc") => "flash", esc_html__("Shake", "wt_vcsc") => "shake", esc_html__("Bounce", "wt_vcsc") => "bounce", esc_html__("Tada", "wt_vcsc") => "tada", esc_html__("Swing", "wt_vcsc") => "swing", esc_html__("Wobble", "wt_vcsc") => "wobble", esc_html__("Pulse", "wt_vcsc") => "pulse", esc_html__("Flip", "wt_vcsc") => "flip", esc_html__("FlipInX", "wt_vcsc") => "flipInX", esc_html__("FlipOutX", "wt_vcsc") => "flipOutX", esc_html__("FlipInY", "wt_vcsc") => "flipInY", esc_html__("FlipOutY", "wt_vcsc") => "flipOutY", esc_html__("FadeIn", "wt_vcsc") => "fadeIn", esc_html__("FadeInUp", "wt_vcsc") => "fadeInUp", esc_html__("FadeInDown", "wt_vcsc") => "fadeInDown", esc_html__("FadeInLeft", "wt_vcsc") => "fadeInLeft", esc_html__("FadeInRight", "wt_vcsc") => "fadeInRight", esc_html__("FadeInUpBig", "wt_vcsc") => "fadeInUpBig", esc_html__("FadeInDownBig", "wt_vcsc") => "fadeInDownBig", esc_html__("FadeInLeftBig", "wt_vcsc") => "fadeInLeftBig", esc_html__("FadeInRightBig", "wt_vcsc") => "fadeInRightBig", esc_html__("FadeOut", "wt_vcsc") => "fadeOut", esc_html__("FadeOutUp", "wt_vcsc") => "fadeOutUp", esc_html__("FadeOutDown", "wt_vcsc") => "fadeOutDown", esc_html__("FadeOutLeft", "wt_vcsc") => "fadeOutLeft", esc_html__("FadeOutRight", "wt_vcsc") => "fadeOutRight", esc_html__("fadeOutUpBig", "wt_vcsc") => "fadeOutUpBig", esc_html__("FadeOutDownBig", "wt_vcsc") => "fadeOutDownBig", esc_html__("FadeOutLeftBig", "wt_vcsc") => "fadeOutLeftBig", esc_html__("FadeOutRightBig", "wt_vcsc") => "fadeOutRightBig", esc_html__("BounceIn", "wt_vcsc") => "bounceIn", esc_html__("BounceInUp", "wt_vcsc") => "bounceInUp", esc_html__("BounceInDown", "wt_vcsc") => "bounceInDown", esc_html__("BounceInLeft", "wt_vcsc") => "bounceInLeft", esc_html__("BounceInRight", "wt_vcsc") => "bounceInRight", esc_html__("BounceOut", "wt_vcsc") => "bounceOut", esc_html__("BounceOutUp", "wt_vcsc") => "bounceOutUp", esc_html__("BounceOutDown", "wt_vcsc") => "bounceOutDown", esc_html__("BounceOutLeft", "wt_vcsc") => "bounceOutLeft", esc_html__("BounceOutRight", "wt_vcsc") => "bounceOutRight", esc_html__("RotateIn", "wt_vcsc") => "rotateIn", esc_html__("RotateInUpLeft", "wt_vcsc") => "rotateInUpLeft", esc_html__("RotateInDownLeft", "wt_vcsc") => "rotateInDownLeft", esc_html__("RotateInUpRight", "wt_vcsc") => "rotateInUpRight", esc_html__("RotateInDownRight", "wt_vcsc") => "rotateInDownRight", esc_html__("RotateOut", "wt_vcsc") => "rotateOut", esc_html__("RotateOutUpLeft", "wt_vcsc") => "rotateOutUpLeft", esc_html__("RotateOutDownLeft", "wt_vcsc") => "rotateOutDownLeft", esc_html__("RotateOutUpRight", "wt_vcsc") => "rotateOutUpRight", esc_html__("RotateOutDownRight", "wt_vcsc") => "rotateOutDownRight", esc_html__("RollIn", "wt_vcsc") => "rollIn", esc_html__("RollOut", "wt_vcsc") => "rollOut", esc_html__("LightSpeedIn", "wt_vcsc") => "lightSpeedIn", esc_html__("LightSpeedOut", "wt_vcsc") => "lightSpeedOut" ),
			'description' => esc_html__('Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'wt_vcsc'),
			'group' 	                    => esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
		vc_add_param("vc_column", array(
			"type"                          => "dropdown",
			"heading"                       => esc_html__("WT Animation Visible Type", "wt_vcsc"),
			"param_name"                    => "anim_type",
			"value"                         => array( esc_html__("Animate when element is visible", "wt_vcsc") => 'wt_animate_if_visible', esc_html__("Animate if element is almost visible", "wt_vcsc") => "wt_animate_if_almost_visible" ),
			"description"                   => esc_html__("Select when the type of animation should start for this element.", "wt_vcsc"),
			'group'                         => esc_html__('WT_VC Extensions', 'wt_vcsc')
		));		
		vc_add_param("vc_column", array(
			"type"                          => "textfield",
			"heading"                       => esc_html__("WT Animation Delay", "wt_vcsc"),
			"param_name"                    => "anim_delay",
			"description"                   => esc_html__("Here you can set a specific delay for the animation (miliseconds). Example: '100', '500', '1000'.", "wt_vcsc"),
			'group'                         => esc_html__('WT_VC Extensions', 'wt_vcsc')
		));	
		
		vc_add_param("vc_column", array(
			'type'                  		=> 'wt_loadfile',
			'heading'               		=> esc_html__( '', 'wt_vcsc' ),
			'param_name'            		=> 'el_file',
			'value'                 		=> '',
			'file_type'             		=> 'js',
			'file_path'             		=> 'wt-visual-composer-extend-element.min.js',
			'param_holder_class'            => 'wt_loadfile_field',
			'description'           		=> esc_html__( '', 'wt_vcsc' ),
			'group' 						=> esc_html__( 'WT_VC Extensions', 'wt_vcsc'),
		));
	}
?>