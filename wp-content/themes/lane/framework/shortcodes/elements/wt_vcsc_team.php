<?php

// File Security Check
if (!defined('ABSPATH')) die('-1');

/*
Register WhoaThemes shortcode.
*/

class WPBakeryShortCode_WT_team extends WPBakeryShortCode {
	
	private $wt_sc;
	
	public function __construct($settings) {
        parent::__construct($settings);
		$this->wt_sc = new WT_VCSC_SHORTCODE;
	}
	
	public function singleParamHtmlHolder($param, $value) {
        $output = '';
        // Compatibility fixes
        $old_names = array('yellow_message', 'blue_message', 'green_message', 'button_green', 'button_grey', 'button_yellow', 'button_blue', 'button_red', 'button_orange');
        $new_names = array('alert-block', 'alert-info', 'alert-success', 'btn-success', 'btn', 'btn-info', 'btn-primary', 'btn-danger', 'btn-warning');
        $value = str_ireplace($old_names, $new_names, $value);
        //$value = esc_html__($value, "wt_vcsc");
        //
        $param_name = isset($param['param_name']) ? $param['param_name'] : '';
        $type = isset($param['type']) ? $param['type'] : '';
        $class = isset($param['class']) ? $param['class'] : '';

        if ( isset($param['holder']) == false || $param['holder'] == 'hidden' ) {
            $output .= '<input type="hidden" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.$value.'" />';
            if(($param['type'])=='attach_image') {
                $img = wpb_getImageBySize(array( 'attach_id' => (int)preg_replace('/[^\d]/', '', $value), 'thumb_size' => 'thumbnail' ));
                $output .= ( $img ? $img['thumbnail'] : '<img width="150" height="150" src="' . vc_asset_url( 'vc/blank.gif' ) . '" class="attachment-thumbnail"  data-name="' . $param_name . '" alt="" title="" style="display: none;" />') . '<img src="' . THEME_URI . '/framework/shortcodes/assets/lib/img/admin/wt.png' . '" class="no_image_image' . ( $img && !empty($img['p_img_large'][0]) ? ' image-exists' : '' ) . '" /><a href="#" class="column_edit_trigger' . ( $img && !empty($img['p_img_large'][0]) ? ' image-exists' : '' ) . '">' . esc_html__( 'Add image', 'wt_vcsc' ) . '</a>';
            }
        }
        else {
            $output .= '<'.$param['holder'].' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">'.$value.'</'.$param['holder'].'>';
        }
        return $output;
    }
			
	protected function content($atts, $content = null) {
		
		extract( shortcode_atts( array(
			'image'            => '',
			'img_size'         => 'thumbnail',
    		'alignment'        => 'center',
    		'style'            => '',
    		'border_color'     => '',
    		'img_link_large'   => false,
    		'link'             => '',
			'team_name'        => '',
			'team_job'         => '',
			'overlay_content'  => false,		
			'team_socials'     => '',
			
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
		
		$sc_class = 'wt_team_sc';	
					
		$id = mt_rand(9999, 99999);
		if (trim($el_id) != false) {
			$el_id = esc_attr( trim($el_id) );
		} else {
			$el_id = $sc_class . '-' . $id;
		}
				
		$style = ($style!='') ? $style : '';
		$el_style = '';		
		
		$img_size = esc_html($img_size);
		
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
		
		if ( $img == NULL ) $img['thumbnail'] = '<img class="'.$style.'" src="'.$this->assetUrl('vc/no_image.png').'" />';//' <small>'.esc_html__('This is image placeholder, edit your page to replace it.', 'wt_vcsc').'</small>';
					
		// parse link
		$link = ($link=='||') ? '' : $link;
		$link = vc_build_link($link);
		$a_href = $link['url'];
		
		$a_title = $link['title'];
		$a_title_output = ($a_title!='') ? ' title="' . esc_attr( $a_title ) .'"' : '';
		
		$a_target = $link['target'];
		$a_target_output = ($a_target!='') ? ' target="' . $a_target .'"' : '';
				
		$link_to = '';
		$a_class = '';
		
		if ($img_link_large==true) {
			$link_to = wp_get_attachment_image_src( $img_id, 'large');
			$link_to = $link_to[0];
			
			wp_enqueue_script( 'prettyphoto' );
			wp_enqueue_style( 'prettyphoto' );
			$a_class = ' class="prettyphoto"';
			$a_target_output = '';
		}
		else if (!empty($a_href)) {
			$link_to = esc_url( $a_href );
		}
		
		if(!empty($link_to) && !preg_match('/^(https?\:\/\/|\/\/)/', $link_to)) $link_to = 'http://'.$link_to;
		$img_output = ($style=='vc_box_shadow_3d') ? '<span class="vc_box_shadow_3d_wrap">' . $img['thumbnail'] . '</span>' : $img['thumbnail'];
		$image_string = !empty($link_to) ? '<a'.$a_class.' href="'.$link_to.'"' . $a_title_output . $a_target_output .'>'.$img_output.'</a>' : $img_output;
				
		trim($team_name) == false ? $team_name = esc_html( $team_name ) : '';	
		trim($team_job) == false ? $team_job = esc_html( $team_job ) : '';
		
		// Add overlay class
		if ( $overlay_content == true ) {
			$team_overlay_out = ' wt_team_overlay';
		} else {
			$team_overlay_out = ' wt_team_regular';
		}
		
		$el_class = esc_attr( $this->getExtraClass($el_class) );
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $sc_class.$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);
		$css_class .= ' wt_align_'.$alignment . $team_overlay_out;		
		$css_class .= $this->wt_sc->getWTCSSAnimationClass($css_animation,$anim_type);
		$anim_data = $this->wt_sc->getWTCSSAnimationData($css_animation,$anim_delay);
				
		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
		
		$team_soc_output = '';	
				
		if($team_socials != ''){
			 
			$team_socials = array_map( 'trim', explode( ',', $team_socials ) );	
					
			if(is_array($team_socials) && !empty($team_socials)){
				$team_soc_output .= "\n\t\t\t" . '<ul class="wt_team_social">'; 
				
					foreach ( $team_socials as $index=>$icon ) {
						$icon_link = $icon.'_link';
						
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
						
						if ($$icon_link == false) { // if there is not set the social link, put '#' as a placeholder
							$team_soc_output .= "\n\t\t\t\t" . '<li>';
								$team_soc_output .= "\n\t\t\t\t\t" . '<a class="'.$icon.'" href="#" title="'.$icon.'" target="_blank">'.$icon_output.'</a>'; 
							$team_soc_output .= "\n\t\t\t\t" . '</li>';
						} else {
							$team_soc_output .= "\n\t\t\t\t" . '<li>';
								$team_soc_output .= "\n\t\t\t\t\t" . '<a class="'.$icon.'" href="'.esc_url( $$icon_link ).'" title="'.$icon.'" target="_blank">'.$icon_output.'</a>'; 
							$team_soc_output .= "\n\t\t\t\t" . '</li>';
						}
					}
				
				$team_soc_output .= "\n\t\t\t" . '</ul>'; 
			}
		}
		
		$output = '<div id="'.$el_id.'" class="'.$css_class.'"'.$anim_data.'>';
	        $output .= "\n\t".'<div class="wt_view">';
				$output .= "\n\t\t".$image_string;
					$output .= $team_soc_output;
				
				if ( $overlay_content == true ) {
					//$output .= $team_soc_output;
					$output .= "\n\t\t".'<div class="wt_team_content">';
						$output .= "\n\t\t".'<div class="wt_team_description">';
							$output .= "\n\t\t\t".$content;
						$output .= "\n\t\t".'</div>';
					$output .= "\n\t\t".'</div>';
				}
				
	        $output .= "\n\t".'</div>';
			
	        $output .= "\n\t".'<div class="wt_team_info">';
				$output .= "\n\t\t".'<h4 class="wt_team_title">'.$team_name.'</h4>';
				$output .= "\n\t\t".'<p class="wt_team_job">'.$team_job.'</p>';
				
				if ( $overlay_content == false ) {
					$output .= "\n\t\t".'<div class="wt_team_content">';
						$output .= "\n\t\t".'<div class="wt_team_description">';
							$output .= "\n\t\t\t".$content;
						$output .= "\n\t\t".'</div>';
					$output .= "\n\t\t".'</div>';
				}
				
	        $output .= "\n\t".'</div>';
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
		'name'          => esc_html__('WT Team', 'wt_vcsc'),
		'base'          => 'wt_team',
		'icon'          => 'wt_vc_ico_team',
		'class'         => 'wt_vc_sc_team',
		'category'      => esc_html__('by WhoaThemes', 'wt_vcsc'),
		'description'   => esc_html__('Team members', 'wt_vcsc'),
		'params'        => array(
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
				'heading'       => esc_html__('Image alignment', 'wt_vcsc'),
				'param_name'    => 'alignment',
				'value'         => array(esc_html__('Align left', 'wt_vcsc') => 'left', esc_html__('Align right', 'wt_vcsc') => 'right', esc_html__('Align center', 'wt_vcsc') => 'center'),
				'std'           => 'center',
				'description'   => esc_html__('Select image alignment.', 'wt_vcsc')
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
				'description'   => esc_html__( 'Select border color for your element.', 'wt_vcsc' )
			),
			array(
				'type'          => 'checkbox',
				'heading'       => esc_html__('Link to large image?', 'wt_vcsc'),
				'param_name'    => 'img_link_large',
				'description'   => esc_html__('If selected, image will be linked to the larger image.', 'wt_vcsc'),
				'value'         => Array(esc_html__('Yes, please', 'wt_vcsc') => 'yes')
			),
			array(
				'type'          => 'vc_link',
				'heading'       => esc_html__('URL (Link)', 'wt_vcsc'),
				'param_name'    => 'link',
				'description'   => esc_html__( 'Select URL if you want this image to have a link.', 'wt_vcsc' ),
				'dependency'    => array(
					'element'   => 'img_link_large',
					'is_empty'  => true,
					//'callback'  => 'wpb_single_image_img_link_dependency_callback'
				)
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Team member name', 'wt_vcsc'),
				'holder'        => 'div',
				'param_name'    => 'team_name',
				'description'   => esc_html__('Set team member name.', 'wt_vcsc')
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Team member job title', 'wt_vcsc'),
				'param_name'    => 'team_job',
				'description'   => esc_html__('Set team member job title.', 'wt_vcsc')
			),			
			array(
				'type'          => 'checkbox',
				'heading'       => esc_html__('Overlay content on image?', 'wt_vcsc'),
				'param_name'    => 'overlay_content',
				'description'   => esc_html__('If selected, the content and socials will overlay on the image.', 'wt_vcsc'),
				'value'         => Array(esc_html__('Yes, please', 'wt_vcsc') => 'yes')
			),		
			array(
				'type'          => 'textarea_html',
				'holder'        => 'div',
				'class'         => 'hidden_el',
				'heading'       => esc_html__('Team member description', 'wt_vcsc'),
				'param_name'    => 'content',
				'value'         => '<p>' . esc_html__( 'I am text block. Click edit button to change this text.', 'wt_vcsc' ). '</p>',
				'description'   => esc_html__('Enter team member description.', 'wt_vcsc')
			),
			array(
				'type'          => 'wt_multidropdown',
				'heading'       => esc_html__('Team member socials', 'wt_vcsc'),
				'param_name'    => 'team_socials',
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
						'element' => 'team_socials',
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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
						'element' => 'team_socials', 
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