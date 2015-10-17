<?php
wt_setPostViews(get_the_ID());
$blog_page = wt_get_option('blog','blog_page');
if($blog_page == $post->ID){
	return require(THEME_DIR . "/template_blog.php");
}
$featured_image_type = wt_get_option('blog', 'single_featured_image_type');
$type = get_post_meta($post->ID, '_intro_type', true);
$layout= wt_get_option('blog','layout');
?>
<?php get_header(); ?>
</div> <!-- End headerWrapper -->
<div id="wt_containerWrapper" class="clearfix">
    <?php wt_theme_generator('wt_breadcrumbs',$post->ID); ?>
	<?php wt_theme_generator('wt_custom_header',$post->ID); ?>
    <?php wt_theme_generator('wt_containerWrapp',$post->ID);?>
        <div id="wt_container" class="clearfix">
            <?php wt_theme_generator('wt_content',$post->ID);?>
                <div class="container">
                    <div class="row">
						<?php if($layout == 'full') {
                            echo '<div class="col-md-12">';
                        }?>
						<?php if($layout == 'left') {
                            echo '<aside id="wt_sidebar" class="col-md-3">';
                            get_sidebar(); 
                            echo '</aside> <!-- End wt_sidebar -->'; 
                        }?>
                        <?php if($layout != 'full') {
                            echo '<div id="wt_main" role="main" class="col-md-9">'; 
                            echo '<div id="wt_mainInner">';
                        }?> 
                        <article id="post-<?php the_ID(); ?>" class="blogEntry wt_blog_entry wt_entry_<?php echo esc_attr( $featured_image_type );?>">
                            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                            <?php 
                            if(wt_is_enabled(get_post_meta($post->ID, '_featured_image', true), wt_get_option('blog','featured_image'))){ ?>
                            <?php
                            $thumbnail_type = get_post_meta($post->ID, '_thumbnail_type', true);
                                switch($thumbnail_type){					
                                    case "timage" : 
										echo '<header class="blogEntry_frame">';
                                        echo wt_theme_generator('wt_blog_featured_image',$featured_image_type,$layout);
										echo '</header>';
                                        break;
                                    case "tvideo" : 
                                        $video_link = get_post_meta($post->ID, '_featured_video', true);
										echo '<header class="blogEntry_frame">';
                                        echo '<div class="blog-thumbnail-video">';
                                        echo wt_video_featured($video_link,$featured_image_type,$layout,$height='',$width='');
                                        echo '</div>';
										echo '</header>';							
                                        break;
                                    case "tplayer" : 
                                        $player_link = get_post_meta($post->ID,'_thumbnail_player', true);
										echo '<header class="blogEntry_frame">';
                                        echo '<div class="blog-thumbnail-player">';
                                        echo wt_media_player($featured_image_type,$layout,$player_link);
                                        echo '</div>';
										echo '</header>';							
                                        break;
                                    case "tslide" : 
										echo '<header class="blogEntry_frame">';
                                        echo '<div class="blog-thumbnail-slide">';
                                        echo wt_get_slide($featured_image_type,$layout);
                                        echo '</div>';
										echo '</header>';							
                                        break;
                                }
                            }				
                            ?>
                                                        
                            <footer class="blogEntry_metadata">
                            	<?php echo wt_theme_generator('wt_blog_single_meta'); ?>
                            </footer>
                            
                            <?php the_content(); ?>
                            
                            <?php wp_link_pages( array( 'before' => '<div class="wp-pagenavi post_navi"><span class="page-links-title">' . esc_html__( 'Pages:', 'wt_front' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                            
							<?php edit_post_link(esc_html__('Edit', 'wt_front'),'<p class="entry_edit">','</p>'); ?>
                            
                            <?php echo wt_theme_generator('wt_blog_single_meta_footer'); ?>
                            
                            <?php if(wt_get_option('blog','author') || wt_get_option('blog','related_popular')):?>
                            <footer>
							<?php endif; ?>
                            
                                <?php if(wt_get_option('blog','author')): wt_theme_generator('wt_blog_author_info'); endif;?>
                                <?php if(wt_get_option('blog','related_popular')):?>
                                <section class="wt_tabs_wrap relatedPopularPosts">
                                <ul class="wt_tabs"> 
                                    <li><a href="#tab1" class="current"><?php esc_html_e('Related Posts','wt_front') ?></a></li>
                                    <li><a href="#tab2"><?php esc_html_e('Popular Posts','wt_front') ?></a></li>             
                                </ul>
                                <div class="panes blogPosts">
                                    <div class="pane" style="display:block">
                                        <?php wt_theme_generator('wt_blog_related_posts');?>
                                        <div class="wt_clearboth"></div>
                                    </div>
                                    <div class="pane">
                                        <?php wt_theme_generator('wt_blog_popular_posts');?>
                                        <div class="wt_clearboth"></div>
                                    </div>
                                </div>
                                </section>
                                <?php endif;?>  
                                                  
                            <?php if(wt_get_option('blog','author') || wt_get_option('blog','related_popular')):?>
                            </footer>
							<?php endif; ?>
                                
							<?php if(wt_get_option('blog','entry_navigation')):?>
                           <div class="entry_navigation">
                                <div class="nav-previous pull-left">
                                	<?php echo '<span class="meta-nav"><i class="fa-angle-double-left"></i> ' . esc_html_x( 'Previous', 'wt_front' ) . '</span>'; ?>
									<?php previous_post_link( '%link', '%title', true ); ?>
                                </div>
                                <div class="nav-next pull-right">
                                	<?php echo '<span class="meta-nav">' . esc_html_x( 'Next ', 'wt_front' ) . '<i class="fa-angle-double-right"></i></span>'; ?>
									<?php next_post_link( '%link', '%title', true ); ?>
                                </div>
                            </div>
                            <?php endif;?>
                                
                            <?php comments_template( '', true ); ?>
                            <?php //comment_form(); ?>
                            <?php endwhile; // end of the loop.?>
                        </article> <!-- End blogEntry -->
                        
                        <?php if($layout != 'full') {
                            echo '</div> <!-- End wt_mainInner -->'; 
                            echo '</div> <!-- End wt_main -->'; 
                        }?>
                        
                        <?php if($layout == 'right') {
                            echo '<aside id="wt_sidebar" class="col-md-3">';
                            get_sidebar(); 
                            echo '</aside> <!-- End wt_sidebar -->'; 
                        }?>                        
                        
						<?php if($layout == 'full') {
                            echo '</div>';
                        }?>
                    </div> <!-- End row -->
                </div> <!-- End container -->
            </div> <!-- End wt_content -->
        </div> <!-- End wt_container -->
    </div> <!-- End wt_containerWrapp -->
</div> <!-- End wt_containerWrapper -->
<?php get_footer(); ?>