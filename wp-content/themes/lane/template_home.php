<?php 
$homeContent = wt_get_option('general','one_page_home');
$overlayType    = wt_get_option('general','overlay_type');
get_header(); ?>
</div> <!-- End headerWrapper -->
<div id="wt_containerWrapper" class="clearfix">
    <?php //wt_theme_generator('wt_custom_header',$post->ID); ?>
    <?php wt_theme_generator('wt_containerWrapp',$post->ID);?>
    <?php if($overlayType =='pattern') :?>
    	<div class="wt_pattern_overlay"></div>
    <?php endif; ?>
    <?php if($overlayType =='color') :?>
   		<div class="wt_color_overlay"></div>
    <?php endif; ?>
    <?php if($overlayType =='dark') :?>
   		<div class="wt_dark_overlay"></div>
    <?php endif; ?>
        <div id="wt_container" class="clearfix">
				<?php 
                if (!empty($homeContent)):
                if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php if(has_post_thumbnail()): ?>
                    <div class="styled_image">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                    <?php endif; ?>
                     <?php 
                    $the_query = new WP_Query( 'page_id='.$homeContent.'' );
                    while ( $the_query->have_posts() ) :
                        $the_query->the_post();
                            the_content();
                    endwhile;
                    wp_reset_postdata();
                    ?>
                <?php endwhile; endif; else: ?>
                <div class="container">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php if(has_post_thumbnail()): ?>
                    <div class="styled_image">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                    <?php endif; ?>
                     <?php 
                     the_content(); ?>
                <?php endwhile; else: ?>
                <?php endif; ?>
                </div>
                <?php endif; ?>
        </div> <!-- End wt_container -->
	</div> <!-- End wt_containerWrapp -->
</div> <!-- End wt_containerWrapper -->
<?php get_footer(); ?>