<?php
/**
 * Contact Form Widget Class
 */
class Wt_Widget_Contact_Form extends WP_Widget {

	function Wt_Widget_Contact_Form() {
		$widget_ops = array('description' => esc_html__( 'An email contact form.', 'wt_admin') );
		parent::__construct('contact_form', THEME_SLUG.' - '.esc_html__('Contact Form', 'wt_admin'), $widget_ops);		
	}
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? esc_html__('Email Us', 'wt_front') : $instance['title'], $instance, $this->id_base);
		$email= $instance['email'];
		$email = str_replace('@','(at)',$email);
		$sitename = get_bloginfo('name');
		$siteurl =  esc_url( home_url() );
		$id = rand(1,1000);
		
		$name_str =  esc_html__('Name *','wt_front');
		$email_str = esc_html__('Email *','wt_front');
		$subject_str = esc_html__('Subject*','wt_front');
		$message_str = esc_html__('Message *','wt_front');
		$submit_str = esc_html__('Submit','wt_front');
	
		if(empty($success)){
			$success = esc_html__('We received your message and we will get back to you as soon as possible. <br /> <strong>Thank You!</strong>','wt_front');
		}

		echo '<section id="wt_contact_form-'.$id.'" class="widget widget_contact_form">';
		if ( $title)
			echo balanceTags( $before_title . $title . $after_title );
		
		?>
		<div class="success alert alert-success alert-dismissable" style="display:none;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php esc_html_e('We received your message and we will get back to you as soon as possible. <br /> <strong>Thank You!</strong>','wt_front');?></div>
		<?php 
			wp_enqueue_script( 'wt-validate' );
			wp_enqueue_script('wt-validate-translation');
		?>
		<form id="wt_contact_form_<?php echo (int)$id ?>" class="wt_contact_form wt_contact_form_sc" action="<?php echo THEME_INCLUDES;?>/sendmail.php" method="post" role="form">
			<div class="fieldset">
                <input type="text" id="contact_name_<?php echo (int)$id ?>" name="contact_name_<?php echo (int)$id ?>" placeholder="<?php echo esc_attr( $name_str ) ?>" class="text_input form-control" value="" minlength="3" required />
            </div>
			
			<div class="fieldset">
                <input type="email" id="contact_email_<?php echo (int)$id ?>" name="contact_email_<?php echo (int)$id ?>" placeholder="<?php echo esc_attr( $email_str ) ?>" class="text_input form-control" value="" required />
            </div>
			
			<div class="fieldset">
            	<textarea name="contact_content_<?php echo (int)$id ?>"  placeholder="<?php echo esc_attr( $message_str ) ?>" class="form-control" value="" cols="30" rows="5" minlength="5" required></textarea>
            </div>
			
			<div class="fieldset"><a href="#" onclick="jQuery('#wt_contact_form_<?php echo (int)$id ?>').submit();return false;" class="contact_button"><span><?php echo esc_attr( $submit_str ) ?></span></a><a href="#" class="reset-form">clear</a></div>
            <div>
            <input type="hidden" value="<?php echo esc_attr( $id ) ?>" name="contact_widget_id" />
			<input type="hidden" value="<?php echo esc_attr( $sitename );?>" name="contact_sitename_<?php echo (int)$id ?>" />
			<input type="hidden" value="<?php echo esc_attr( $siteurl );?>" name="contact_siteurl_<?php echo (int)$id ?>" />
			<input type="hidden" value="<?php echo esc_attr( $email );?>" name="contact_to_<?php echo (int)$id ?>" />
            </div>
		</form>
		<?php
		echo '</section>';
        		
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['email'] = strip_tags($new_instance['email']);

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$email = isset($instance['email']) ? esc_attr($instance['email']) :get_bloginfo('admin_email');
	?>
		<p><label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', 'wt_admin'); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id('email') ); ?>"><?php esc_html_e('Your Email:', 'wt_admin'); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('email') ); ?>" name="<?php echo esc_attr( $this->get_field_name('email') ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" /></p>
		
<?php
	}
}
