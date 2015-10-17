<?php get_header(); ?>
</div> <!-- End headerWrapper -->
<div id="wt_containerWrapper" class="clearfix">
	<?php wt_theme_generator('wt_breadcrumbs',$post->ID); ?>   
    <?php wt_theme_generator('wt_custom_header',$post->ID); ?>
    <?php wt_theme_generator('wt_containerWrapp',$post->ID);?>
        <div id="wt_container" class="clearfix">
            <?php wt_theme_generator('wt_content',$post->ID);?>
                <div class="container">
                    <?php if($layout != 'full') {
                        echo '<div class="row">';
                        	echo '<div id="wt_main" role="main" class="col-md-9">'; 
                        	echo '<div id="wt_mainInner">';
                    }?> 
                       
                    <?php if ( have_posts() ) the_post(); ?>
                    <?php wt_theme_generator('wt_blog_author_info'); ?>
                    <?php
                    	rewind_posts();
                    	get_template_part('loop','author');
                    ?>
                    <?php if($layout != 'full') {
							echo '</div> <!-- End wt_mainInner -->'; 
							echo '</div> <!-- End wt_main -->'; 
                    }?>
                    <?php if($layout != 'full') {
							echo '<aside id="wt_sidebar" class="col-md-3">';
							get_sidebar(); 
							echo '</aside> <!-- End wt_sidebar -->'; 
                        echo '</div> <!-- End row -->'; 
                    }?>
                </div> <!-- End container -->
            </div> <!-- End wt_content -->
        </div> <!-- End wt_container -->
    </div> <!-- End wt_containerWrapp -->
</div> <!-- End wt_containerWrapper -->
<?php get_footer(); ?>