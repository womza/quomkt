<?php get_header(); ?>
<?php
if (is_tax()) {
	$layout = wt_get_option('portfolio','layout');
}
else {
	$layout= wt_get_option('blog','layout');
}
?>
</div> <!-- End headerWrapper -->
<div id="wt_containerWrapper" class="clearfix">
	<?php wt_theme_generator('wt_breadcrumbs',$post->ID); ?>
	<?php wt_theme_generator('wt_custom_header',$post->ID); ?>
	<?php wt_theme_generator('wt_containerWrapp',$post->ID);?>
        <div id="wt_container" class="clearfix">
            <?php wt_theme_generator('wt_content',$post->ID);?>
                <div id="wt_container" class="clearfix">
                <div class="container">
                    <?php if($layout != 'full') {
                         echo '<div class="row">';
                        echo '<div id="wt_main" role="main" class="col-md-9">'; 
                        echo '<div id="wt_mainInner">';
                    }?>
                    <?php 
                        if ( $post->post_type == 'portfolio' ) {
                            get_template_part('loop-portfolio','archive');
                        }
                        else {
                            get_template_part('loop','archive');	
                        }
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
                    </div>
                </div> <!-- End container -->
            </div> <!-- End wt_content -->
        </div> <!-- End wt_container -->
	</div> <!-- End wt_containerWrapp -->
</div> <!-- End wt_containerWrapper -->
<?php get_footer(); ?>