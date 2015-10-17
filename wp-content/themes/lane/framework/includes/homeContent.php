<?php 
$homeContent    = wt_get_option('general','one_page_home');
$scrollNext 	= wt_get_option('general','scroll_to_next');
$bgType 		= wt_get_option('background','background_type');
$youtubeLink 	= wt_get_option('background','video_link');
$slide_bg_1 	= wt_get_option('background','slide_bg_1');
$slide_bg_2 	= wt_get_option('background','slide_bg_2');
$slide_bg_3 	= wt_get_option('background','slide_bg_3');
$slide_bg_4 	= wt_get_option('background','slide_bg_4');
$slide_bg_5 	= wt_get_option('background','slide_bg_5');
$video_bg 		= wt_get_option('background','video_link');
$video_controls = wt_get_option('background','video_controls');
$overlayType    = wt_get_option('general','overlay_type');

if($video_controls) {
	$video_controls_out = "true";
} else {	
	$video_controls_out = "false";
}
?>
<?php if($bgType == 'revSlider'): ?>
<section id="wt_section_home" class="wt_revSlider">
	<?php if($overlayType =='pattern') :?>
    	<div class="wt_pattern_overlay"></div>
    <?php endif; ?>
    <?php if($overlayType =='color') :?>
   		<div class="wt_color_overlay"></div>
    <?php endif; ?>
    <?php if($overlayType =='dark') :?>
   		<div class="wt_dark_overlay"></div>
    <?php endif; ?>
    
    <div id="wt_home_content">
    <?php if($scrollNext == true) :?>
    	<div class="wt_center">
          <div class="wt_call_action_alt">
            <a class="btn-start wt_scroll" href="#about"><i class="entypo-down-dir"></i></a>
          </div>
        </div>
	<?php endif; ?>
   <?php  echo do_shortcode('[rev_slider '.wt_get_option('background', 'rev_slideshow').']'); ?>
    </div>
</section>
<?php endif; ?>
<?php if($bgType == 'pattern') :?>
<section id="wt_section_home">

	<?php if($overlayType =='pattern') :?>
    	<div class="wt_pattern_overlay"></div>
    <?php endif; ?>
    <?php if($overlayType =='color') :?>
   		<div class="wt_color_overlay"></div>
    <?php endif; ?>
    <?php if($overlayType =='dark') :?>
   		<div class="wt_dark_overlay"></div>
    <?php endif; ?>
  
    <div id="wt_home_content">
    <?php if($scrollNext == true) :?>
    	<div class="wt_center">
          <div class="wt_call_action_alt">
            <a class="btn-start wt_scroll" href="#about"><i class="entypo-down-dir"></i></a>
          </div>
        </div>
	<?php endif; ?>
        <div class="container">
           <?php if (class_exists('WPBakeryVisualComposerAbstract')) { ?>
           <div class="row">
           <?php } ?>
			   <?php 
                $the_query = new WP_Query( 'page_id='.$homeContent.'' );
                while ( $the_query->have_posts() ) :
                    $the_query->the_post();
                        the_content();
                endwhile;
                wp_reset_postdata();
                ?>
            <?php if (class_exists('WPBakeryVisualComposerAbstract')) { ?>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php elseif($bgType == 'parallax') :?>
<section id="wt_section_home">
    
	<?php if($overlayType =='pattern') :?>
    	<div class="wt_pattern_overlay"></div>
    <?php endif; ?>
    <?php if($overlayType =='color') :?>
    	<div class="wt_color_overlay"></div>
    <?php endif; ?>
    <?php if($overlayType =='dark') :?>
   		<div class="wt_dark_overlay"></div>
    <?php endif; ?>
  
  <div id="wt_home_content">
    <?php if($scrollNext == true) :?>
    	<div class="wt_center">
          <div class="wt_call_action_alt">
            <a class="btn-start wt_scroll" href="#about"><i class="entypo-down-dir"></i></a>
          </div>
        </div>
	<?php endif; ?>
    <div class="container">
       <?php if (class_exists('WPBakeryVisualComposerAbstract')) { ?>
           <div class="row">
           <?php } ?>
			   <?php 
                $the_query = new WP_Query( 'page_id='.$homeContent.'' );
                while ( $the_query->have_posts() ) :
                    $the_query->the_post();
                        the_content();
                endwhile;
                wp_reset_postdata();
                ?>
            <?php if (class_exists('WPBakeryVisualComposerAbstract')) { ?>
            </div>
            <?php } ?>
    </div>
  </div>
</section>
<?php elseif($bgType == 'image_bg') :?>
<section id="wt_section_home">

	<?php if($overlayType =='pattern') :?>
    	<div class="wt_pattern_overlay"></div>
    <?php endif; ?>
    <?php if($overlayType =='color') :?>
    	<div class="wt_color_overlay"></div>
    <?php endif; ?>
    <?php if($overlayType =='dark') :?>
   		<div class="wt_dark_overlay"></div>
    <?php endif; ?>
    
	<div id="wt_home_content">
    <?php if($scrollNext == true) :?>
    	<div class="wt_center">
          <div class="wt_call_action_alt">
            <a class="btn-start wt_scroll" href="#about"><i class="entypo-down-dir"></i></a>
          </div>
        </div>
	<?php endif; ?>
    <div class="container">
	   <?php if (class_exists('WPBakeryVisualComposerAbstract')) { ?>
       <div class="row">
       <?php } ?>
           <?php 
            $the_query = new WP_Query( 'page_id='.$homeContent.'' );
            while ( $the_query->have_posts() ) :
                $the_query->the_post();
                    the_content();
            endwhile;
            wp_reset_postdata();
            ?>
        <?php if (class_exists('WPBakeryVisualComposerAbstract')) { ?>
        </div>
        <?php } ?>
	</div>
	</div>
</section>
<?php elseif($bgType == 'video') :?>
<?php
wp_enqueue_script('jquery-YTPlayer');
wp_enqueue_style('YTPlayer');
?>
<section id="wt_section_home">
  <div class="wt_bg_video_mobile" style="background-image: url(<?php echo wt_get_option('background','video_mobile_bg'); ?>);"></div>
  <div class="wt_bg_video">
	<a id="bgndVideo_home" class="wt_youtube_player_home" data-property="{videoURL:'<?php echo esc_url( $video_bg ); ?>', containment:'#wt_section_home', showControls:<?php echo esc_attr( $video_controls_out ); ?>, autoPlay:true, loop:true, mute:true, startAt:0, opacity:1, ratio:'4/3', addRaster:false, quality:'default'}"></a>
   </div>
   
  <?php if($overlayType =='pattern') :?>
      <div class="wt_pattern_overlay"></div>
  <?php endif; ?>
   <?php if($overlayType =='color') :?>
      <div class="wt_color_overlay"></div>
  <?php endif; ?>
    <?php if($overlayType =='dark') :?>
   		<div class="wt_dark_overlay"></div>
    <?php endif; ?>
  
  <div id="wt_home_content">
    <?php if($scrollNext == true) :?>
    	<div class="wt_center">
          <div class="wt_call_action_alt">
            <a class="btn-start wt_scroll" href="#about"><i class="entypo-down-dir"></i></a>
          </div>
        </div>
	<?php endif; ?>
    <div class="container">
       <?php if (class_exists('WPBakeryVisualComposerAbstract')) { ?>
       <div class="row">
       <?php } ?>
           <?php 
            $the_query = new WP_Query( 'page_id='.$homeContent.'' );
            while ( $the_query->have_posts() ) :
                $the_query->the_post();
                    the_content();
            endwhile;
            wp_reset_postdata();
            ?>
        <?php if (class_exists('WPBakeryVisualComposerAbstract')) { ?>
        </div>
        <?php } ?>
    </div>
  </div>
</section>
<?php elseif($bgType == 'slideshow') :?>
<?php
wp_enqueue_script( 'jquery-supersized');
wp_enqueue_script( 'jquery-supersized-shutter');
?>
<section id="wt_section_home">
  <div class="wt_fullscreen_slider" data-images='["<?php if(!empty($slide_bg_1)) { echo esc_url( $slide_bg_1 ) .'"'; } ?><?php if(!empty($slide_bg_2)) { echo ', "' . esc_url( $slide_bg_2 ) .'"'; } ?><?php if(!empty($slide_bg_3)) { echo ', "' . esc_url( $slide_bg_3 ) .'"';  }?><?php if(!empty($slide_bg_4)) { echo ', "' . esc_url( $slide_bg_4 ) .'"'; } ?><?php if(!empty($slide_bg_5)) { echo ', "' . esc_url( $slide_bg_5 ) .'"'; } ?>]' data-autoplay="true" data-slideinterval="7000" data-transitionspeed="1500" data-transition="1">
    <div id="progress-back" class="load-item">
      <div id="progress-bar"></div>
    </div>
  </div>
  
  <?php if($overlayType =='pattern') :?>
      <div class="wt_pattern_overlay"></div>
  <?php endif; ?>
   <?php if($overlayType =='color') :?>
      <div class="wt_color_overlay"></div>
  <?php endif; ?>
    <?php if($overlayType =='dark') :?>
   		<div class="wt_dark_overlay"></div>
    <?php endif; ?>
  
  <div id="wt_home_content">
    <?php if($scrollNext == true) :?>
    	<div class="wt_center">
          <div class="wt_call_action_alt">
            <a class="btn-start wt_scroll" href="#about"><i class="entypo-down-dir"></i></a>
          </div>
        </div>
	<?php endif; ?>
    <div class="container">
	   <?php if (class_exists('WPBakeryVisualComposerAbstract')) { ?>
       <div class="row">
       <?php } ?>
           <?php 
            $the_query = new WP_Query( 'page_id='.$homeContent.'' );
            while ( $the_query->have_posts() ) :
                $the_query->the_post();
                    the_content();
            endwhile;
            wp_reset_postdata();
            ?>
        <?php if (class_exists('WPBakeryVisualComposerAbstract')) { ?>
        </div>
        <?php } ?>
    </div>
  </div>
</section>
<?php endif; ?>