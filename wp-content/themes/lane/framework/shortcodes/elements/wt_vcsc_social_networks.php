<?php

// File Security Check
if (!defined('ABSPATH')) die('-1');

/*
Register WhoaThemes shortcode.
*/

class WPBakeryShortCode_WT_social_networks extends WPBakeryShortCode {
	
	private $wt_sc;
	
	public function __construct($settings) {
        parent::__construct($settings);
		$this->wt_sc = new WT_VCSC_SHORTCODE;
	}
				
	protected function content($atts, $content = null) {
		
		extract( shortcode_atts( array(
			'icon_type' 	    => 'wt_icon_type_1',
			'icon_style' 	    => 'simple',
			'icon_background'   => '',
			'icon_color'        => '',
    		'icon_align'        => 'left',
			'icon_margin' 	    => '5',
			'icon_size'         => 32,
			'tooltip'	        => false,
			'tooltip_placement' => '',		
			'social_networks'   => '',
			
			'website_link'     => '',
			'email_link'       => '',
			'facebook_link'    => '',
			'twitter_link'     => '',
			'pinterest_link'   => '',
			'linkedin_link'    => '',
			'google_link'      => '',
			'dribbble_link'    => '',
			'youtube_link'     => '',
			'vimeo_link'       => '',
			'rss_link'         => '',
			'github_link'      => '',
			'delicious_link'   => '',
			'flickr_link'      => '',
			//'forrst_link'      => '',
			'lastfm_link'      => '',
			'tumblr_link'      => '',
			'deviantart_link'  => '',
			'skype_link'       => '',
			'instagram_link'   => '',
			'stumbleupon_link' => '',
			'behance_link'     => '',
			'soundcloud_link'  => '',
			
			'el_id'            => '',
			'el_class'         => '',
    		'css_animation'    => '',
    		'anim_type'        => '',
    		'anim_delay'       => '',			
			'css'              => ''		
		), $atts ) );
		
		$sc_class = 'wt_social_networks_sc';	
					
		$id = mt_rand(9999, 99999);
		if (trim($el_id) != false) {
			$el_id = esc_attr( trim($el_id) );
		} else {
			$el_id = $sc_class . '-' . $id;
		}		
		
		$icon_margin = (int)$icon_margin;	
				
		if ( $icon_margin != '' || $icon_margin == 0 ) {
			$icon_margin = ' style="margin: ' . $icon_margin . 'px;"';
		} else {
			$icon_margin = ''; 
		}
		
		$el_style = '';	
		
		if ( $icon_color != '' ) {
			$icon_color = 'color: ' . $icon_color . ';';
		}
						
		if ((empty($icon_background)) || ($icon_style == 'simple')) {
			$icon_background = '';
		} else {
			$icon_background = 'background: ' . $icon_background . ';';
		}
			
		if ( $icon_background != '' || $icon_color != '' ) {
			$el_style = ' style="'. $icon_color . $icon_background .'"';
		}
				
		$el_class = esc_attr( $this->getExtraClass($el_class) );
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $sc_class.$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);
		$css_class .= ' wt_align_'.$icon_align;		
		$css_class .= $this->wt_sc->getWTCSSAnimationClass($css_animation,$anim_type);
		$anim_data = $this->wt_sc->getWTCSSAnimationData($css_animation,$anim_delay);
								
		if($social_networks != ''){
			 
			$soc_output = '';	
			$icon_name  = '';
			$social_networks = array_map( 'trim', explode( ',', $social_networks ) );	
					
			if(is_array($social_networks) && !empty($social_networks)){
				$soc_output .= "\n\t\t\t" . '<ul class="wt_icon_'.$icon_size.' ' . $icon_type . ' ' . $icon_style . '">'; 
				
					foreach ( $social_networks as $index=>$icon ) {
						$icon_link = $icon.'_link';
						$icon_name = $icon;
						
						switch( $icon ) {
							case 'website'     : $icon_output = '<i class="entypo-link"></i>';      break;
							case 'email'       : $icon_output = '<i class="fa-envelope"></i>';      break;
							case 'facebook'    : $icon_output = '<i class="fa-'.$icon.'"></i>';     break;
							case 'twitter'     : $icon_output = '<i class="fa-'.$icon.'"></i>';     break;
							case 'pinterest'   : $icon_output = '<i class="fa-'.$icon.'"></i>';     break;
							case 'linkedin'    : $icon_output = '<i class="fa-'.$icon.'"></i>';     break;
							case 'google'      : $icon_output = '<i class="entypo-gplus"></i>';     break;
							case 'dribbble'    : $icon_output = '<i class="entypo-'.$icon.'"></i>'; break;
							case 'youtube'     : $icon_output = '<i class="fa-'.$icon.'"></i>';     break;
							case 'vimeo'       : $icon_output = '<i class="entypo-'.$icon.'"></i>'; break;
							case 'rss'         : $icon_output = '<i class="fa-'.$icon.'"></i>';     break;
							case 'github'      : $icon_output = '<i class="entypo-'.$icon.'"></i>'; break;
							case 'delicious'   : $icon_output = '<i class="fa-'.$icon.'"></i>';     break;
							case 'flickr'      : $icon_output = '<i class="entypo-'.$icon.'"></i>'; break;
							//case 'forrst'      : $icon_output = '<i class="fa-'.$icon.'"></i>'; break;
							case 'lastfm'      : $icon_output = '<i class="entypo-'.$icon.'"></i>'; break;
							case 'tumblr'      : $icon_output = '<i class="entypo-'.$icon.'"></i>'; break;
							case 'deviantart'  : $icon_output = '<i class="fa-'.$icon.'"></i>';     break;
							case 'skype'       : $icon_output = '<i class="entypo-'.$icon.'"></i>'; break;
							case 'instagram'   : $icon_output = '<i class="entypo-'.$icon.'"></i>'; break;
							case 'stumbleupon' : $icon_output = '<i class="entypo-'.$icon.'"></i>'; break;
							case 'behance'     : $icon_output = '<i class="entypo-'.$icon.'"></i>'; break;
							case 'soundcloud'  : $icon_output = '<i class="entypo-'.$icon.'"></i>'; break;
						}
						
						if ($tooltip == false) {
							$tooltip = '';
						} else {
							$tooltip_placement == '' ? $tooltip_placement = 'top' : '';
							$tooltip = ' data-toggle="tooltip" data-placement="'.$tooltip_placement.'"';
						}
						
						$soc_output .= "\n\t\t\t\t" . '<li' . $icon_margin . '>';
							if ($$icon_link == false) { // if there is not set the social link, put '#' as a placeholder
									$soc_output .= "\n\t\t\t\t\t" . '<a'.$el_style.' href="#" class="'.$icon_name.'" title="'.$icon.'" rel="nofollow" target="_blank"'.$tooltip.'>'.$icon_output.'</a>'; 
							} else {
									$soc_output .= "\n\t\t\t\t\t" . '<a'.$el_style.' href="'.esc_url( $$icon_link ).'" class="'.$icon_name.'" title="'.$icon.'" rel="nofollow" target="_blank"'.$tooltip.'>'.$icon_output.'</a>'; 
							}
						$soc_output .= "\n\t\t\t\t" . '</li>';												
					}
				
				$soc_output .= "\n\t\t\t" . '</ul>'; 
			}
		}
		
		$output = '<div id="'.$el_id.'" class="'.$css_class.'"'.$anim_data.'>';
	        $output .= "\n\t" . $soc_output;
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
		'name'          => esc_html__('WT Social Networks', 'wt_vcsc'),
		'base'          => 'wt_social_networks',
		'icon'          => 'wt_vc_ico_social_networks',
		'class'         => 'wt_vc_sc_social_networks',
		'category'      => esc_html__('by WhoaThemes', 'wt_vcsc'),
		'description'   => esc_html__('Place social networks links', 'wt_vcsc'),
		'params'        => array(
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Icon type', 'wt_vcsc'),
				'param_name'    => 'icon_type',
				'value' => array( 
					esc_html__('Type #1', 'wt_vcsc')   => 'wt_icon_type_1',
					esc_html__('Type #2', 'wt_vcsc')   => 'wt_icon_type_2', 
					esc_html__('Type #3', 'wt_vcsc')   => 'wt_icon_type_3',
					esc_html__('Type #4', 'wt_vcsc')   => 'wt_icon_type_4',
				),
				'description'   => esc_html__('Select social networks type.', 'wt_vcsc')
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Icon style', 'wt_vcsc'),
				'param_name'    => 'icon_style',
				'value' => array( 
					esc_html__('Simple', 'wt_vcsc')    => 'wt_simple',
					esc_html__('Square', 'wt_vcsc')    => 'wt_square', 
					esc_html__('Rounded', 'wt_vcsc')   => 'wt_rounded',
					esc_html__('Circle', 'wt_vcsc')    => 'wt_circle',
				),
				'description'   => esc_html__('Select social networks style.', 'wt_vcsc')
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Icon background', 'wt_vcsc'),
				'param_name'    => 'icon_background',
				'description'   => esc_html__( 'Select social networks background.', 'wt_vcsc' )
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Icon color', 'wt_vcsc'),
				'param_name'    => 'icon_color',
				'description'   => esc_html__( 'Select social networks text color.', 'wt_vcsc' )
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Icons alignment', 'wt_vcsc'),
				'param_name'    => 'icon_align',
				'value'         => array( esc_html__('Align left', 'wt_vcsc') => 'left', esc_html__('Align right', 'wt_vcsc') => 'right', esc_html__('Align center', 'wt_vcsc') => 'center'),
				'std'           => 'center',
				'description'   => esc_html__('Select icons alignment.', 'wt_vcsc')
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Icon margin', 'wt_vcsc'),
				'param_name'    => 'icon_margin',
				'value'         => '5',
				'description'   => esc_html__('Select icons margin. (in pixels)', 'wt_vcsc')
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Icon size', 'wt_vcsc'),
				'param_name'    => 'icon_size',
				'value' => array( 
					'26' => '26',
					'32' => '32', 
					'38' => '38',
					'40' => '40',
					'42' => '42',
					'44' => '44',
					'50' => '50',
				),
				'std'           => '32',
				'description'   => esc_html__('Select social networks size.', 'wt_vcsc')
			),
			array(
				'type'          => 'checkbox',
				'heading'       => esc_html__('Show tooltip title?', 'wt_vcsc'),
				'param_name'    => 'tooltip',
				'value'         => array( esc_html__( 'Yes, please', 'wt_vcsc' ) => 'true' ),
				'description'   => esc_html__('If YES, it shows a tooltip with the social link information.', 'wt_vcsc')
			),
			array(
				'type'          => 'dropdown',
				'heading'       => esc_html__('Tooltip placement', 'wt_vcsc'),
				'param_name'    => 'tooltip_placement',					
				'value'         => array( esc_html__('Top', 'wt_vcsc') => '', esc_html__('Bottom', 'wt_vcsc') => 'bottom', esc_html__('Left', 'wt_vcsc') => 'left', esc_html__('Right', 'wt_vcsc') => 'right'),
				'std'           => 'top',
				'dependency'    => array(
					'element'   => 'tooltip',
					'not_empty'  => true,
				),
				'description'   => esc_html__('Select tooltip placement.', 'wt_vcsc')
			),
			array(
				'type'          => 'wt_multidropdown',
				'heading'       => esc_html__('Social networks', 'wt_vcsc'),
				'admin_label'   => true,
				'param_name'    => 'social_networks',
				'value' => array( 
					esc_html__("No", "wt_vcsc")          => '',
					esc_html__('Website', 'wt_vcsc')     => 'website',
					esc_html__('Email', 'wt_vcsc')       => 'email', 
					esc_html__('Facebook', 'wt_vcsc')    => 'facebook', 
					esc_html__('Twitter', 'wt_vcsc')     => 'twitter',
					esc_html__('Pinterest', 'wt_vcsc')   => 'pinterest', 
					esc_html__('LinkedIn', 'wt_vcsc')    => 'linkedin', 
					esc_html__('Google +', 'wt_vcsc')    => 'google',  
					esc_html__('Dribbble', 'wt_vcsc')    => 'dribbble',   
					esc_html__('YouTube', 'wt_vcsc')     => 'youtube',   
					esc_html__('Vimeo', 'wt_vcsc')       => 'vimeo',   
					esc_html__('Rss', 'wt_vcsc')         => 'rss', 
					esc_html__('Github', 'wt_vcsc')      => 'github',
					esc_html__('Delicious', 'wt_vcsc')   => 'delicious',
					esc_html__('Flickr', 'wt_vcsc')      => 'flickr',
					esc_html__('Lastfm', 'wt_vcsc')      => 'lastfm',
					esc_html__('Tumblr', 'wt_vcsc')      => 'tumblr',
					esc_html__('Deviantart', 'wt_vcsc')  => 'deviantart',
					esc_html__('Skype', 'wt_vcsc')       => 'skype',
					esc_html__('Instagram', 'wt_vcsc')   => 'instagram',
					esc_html__('StumbleUpon', 'wt_vcsc') => 'stumbleupon',
					esc_html__('Behance', 'wt_vcsc')     => 'behance',
					esc_html__('SoundCloud', 'wt_vcsc')  => 'soundcloud',
				),
				'description'   => esc_html__('Select custom social media links.', 'wt_vcsc') .'<b>' . esc_html__('Hold the \'Ctrl\' or \'Shift\' keys while clicking to select multiple items', 'wt_vcsc').'</b> <br>' . esc_html__('Don\'t include \'No\' option in your selection.', 'wt_vcsc')
			),		
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Website Link', 'wt_vcsc'),
					'param_name'         => 'website_link',
					'description'        => esc_html__('Set website link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks',
						'value'   => array( 'website' )
					)
				),		
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Email Link', 'wt_vcsc'),
					'param_name'         => 'email_link',
					'description'        => esc_html__('Set email link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => 'email'
					)
				),
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Facebook Link', 'wt_vcsc'),
					'param_name'         => 'facebook_link',
					'description'        => esc_html__('Set facebook link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'facebook' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Twitter Link', 'wt_vcsc'),
					'param_name'         => 'twitter_link',
					'description'        => esc_html__('Set twitter link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'twitter' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Pinterest Link', 'wt_vcsc'),
					'param_name'         => 'pinterest_link',
					'description'        => esc_html__('Set pinterest link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'pinterest' )
					)
				),
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('LinkedIn Link', 'wt_vcsc'),
					'param_name'         => 'linkedin_link',
					'description'        => esc_html__('Set linkedin link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'linkedin' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Google + Link', 'wt_vcsc'),
					'param_name'         => 'google_link',
					'description'        => esc_html__('Set google + link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'google' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Dribbble Link', 'wt_vcsc'),
					'param_name'         => 'dribbble_link',
					'description'        => esc_html__('Set dribbble link.', 'wt_vcsc'),
					'param_holder_class' => ' border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'dribbble' ) 
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('YouTube Link', 'wt_vcsc'),
					'param_name'         => 'youtube_link',
					'description'        => esc_html__('Set youtube link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'youtube' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Vimeo Link', 'wt_vcsc'),
					'param_name'         => 'vimeo_link',
					'description'        => esc_html__('Set vimeo link.', 'wt_vcsc'),
					'param_holder_class' => ' border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'vimeo' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Rss Link', 'wt_vcsc'),
					'param_name'         => 'rss_link',
					'description'        => esc_html__('Set rss link.', 'wt_vcsc'),
					'param_holder_class' => 'hidden_el border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'rss' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Github Link', 'wt_vcsc'),
					'param_name'         => 'github_link',
					'description'        => esc_html__('Set github link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'github' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Delicious Link', 'wt_vcsc'),
					'param_name'         => 'delicious_link',
					'description'        => esc_html__('Set delicious link.', 'wt_vcsc'),
					'param_holder_class' => 'hidden_el border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'delicious' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Flickr Link', 'wt_vcsc'),
					'param_name'         => 'flickr_link',
					'description'        => esc_html__('Set flickr link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'flickr' )
					)
				),
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Lastfm Link', 'wt_vcsc'),
					'param_name'         => 'lastfm_link',
					'description'        => esc_html__('Set lastfm link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'lastfm' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Tumblr Link', 'wt_vcsc'),
					'param_name'         => 'tumblr_link',
					'description'        => esc_html__('Set tumblr link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'tumblr' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Deviantart Link', 'wt_vcsc'),
					'param_name'         => 'deviantart_link',
					'description'        => esc_html__('Set deviantart link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'deviantart' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Skype Link', 'wt_vcsc'),
					'param_name'         => 'skype_link',
					'description'        => esc_html__('Set skype link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'skype' )
					)
				),
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Instagram Link', 'wt_vcsc'),
					'param_name'         => 'instagram_link',
					'description'        => esc_html__('Set instagram link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'instagram' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('StumbleUpon Link', 'wt_vcsc'),
					'param_name'         => 'stumbleupon_link',
					'description'        => esc_html__('Set stumbleupon link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array( 
						'element' => 'social_networks', 
						'value'   => array( 'stumbleupon' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('Behance Link', 'wt_vcsc'),
					'param_name'         => 'behance_link',
					'description'        => esc_html__('Set behance link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'behance' )
					)
				),	
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__('SoundCloud Link', 'wt_vcsc'),
					'param_name'         => 'soundcloud_link',
					'description'        => esc_html__('Set soundcloud link.', 'wt_vcsc'),
					'param_holder_class' => 'border_box wt_dependency',
					'dependency'         => array(
						'element' => 'social_networks', 
						'value'   => array( 'soundcloud' )
					)
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