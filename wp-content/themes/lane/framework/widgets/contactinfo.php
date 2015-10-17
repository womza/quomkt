<?php
/**
 * Contact Info Widget Class
 */
class Wt_Widget_Contact_Info extends WP_Widget {

	function Wt_Widget_Contact_Info() {
		$widget_ops = array('classname' => 'widget_contact_info', 'description' => esc_html__( 'A list of contact informations', 'wt_admin') );
		parent::__construct('contact_info',THEME_SLUG.' - '. esc_html__('Contact Info', 'wt_admin'), $widget_ops);
		
	}
	
	function widget( $args, $instance ) {		
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? esc_html__('', 'wt_front') : $instance['title'], $instance, $this->id_base);
		
		$name = $instance['name'];
		$email= $instance['email'];
		$email = str_replace('@','(at)',$email);
		$link = $instance['link'];
		$twitter = $instance['twitter'];
		$phone = $instance['phone'];
		$cellphone = $instance['cellphone'];
		$address = $instance['address'];
		$city = $instance['city'];
		$state = $instance['state'];
		$zip = $instance['zip'];
		$text = $instance['text'];		
						
		echo balanceTags( $before_widget );
		if ( $title)
			echo balanceTags( $before_title . $title . $after_title );
		
		?>
        <div class="wt_contactInfo">
			<div class="wt_contactInfoWrap">   
			<?php if(!empty($text)):?><p class="wt_contactText"><?php echo esc_attr( $text );?></p><?php endif;?>	
			<?php if(!empty($name)):?><p class="wt_contactName"><i class="fa fa-user"></i><?php echo esc_attr( $name );?></p><?php endif;?>
            <?php if(!empty($address)):?><p class="wt_contactAddress"><i class="fa fa-map-marker"></i><?php echo esc_attr( $address ); ?><?php if(!empty($city)||!empty($zip)):?>, <?php endif;?><?php endif;?>
			<?php if(!empty($city)||!empty($zip)):?>
           		<?php if(empty($address)):?><p class="wt_contactAddress"><i class="fa fa-map-marker"></i><?php endif;?>
				<?php if(!empty($city)):?><?php echo esc_attr( $city );?>, <?php endif;?>
				<?php if(!empty($zip)):?><?php echo esc_attr( $zip );?>, <?php endif;?>
				<?php if(!empty($state)):?><?php echo esc_attr( $state );?><?php endif;?>
			</p><?php endif;?>
			<?php if(!empty($phone)):?><p class="wt_contactPhone"><i class="fa fa-phone"></i><?php echo esc_attr( $phone );?></p><?php endif;?>
			<?php if(!empty($cellphone)):?><p class="wt_contactCellPhone"><i class="fa fa-phone-square"></i><?php echo esc_attr( $cellphone );?></p><?php endif;?>
			<?php if(!empty($email)):?><p class="wt_contactMail"><i class="fa fa-envelope"></i><a href="mailto:<?php echo esc_attr( $email );?>" class="nospam"><?php echo esc_attr( $email );?></a></p><?php endif;?>
			<?php if(!empty($link)):?><p class="wt_contactLink"><i class="fa fa-link"></i><a href="<?php echo esc_attr( $link );?>" target="_blank"><?php echo esc_attr( $link );?></a></p><?php endif;?>
			<?php if(!empty($twitter)):?><p class="wt_contactTwitter"><i class="fa fa-twitter"></i><a href="<?php echo esc_attr( $twitter );?>" target="_blank"><?php echo esc_attr( $twitter );?></a></p><?php endif;?>
					
			</div>
        </div>
		<?php
		echo  balanceTags( $after_widget );

	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['name'] = strip_tags($new_instance['name']);
		$instance['email'] = strip_tags($new_instance['email']);
		$instance['link'] = strip_tags($new_instance['link']);
		$instance['twitter'] = strip_tags($new_instance['twitter']);
		$instance['phone'] = strip_tags($new_instance['phone']);
		$instance['cellphone'] = strip_tags($new_instance['cellphone']);
		$instance['address'] = strip_tags($new_instance['address']);
		$instance['city'] = strip_tags($new_instance['city']);
		$instance['state'] = strip_tags($new_instance['state']);
		$instance['zip'] = strip_tags($new_instance['zip']);
		$instance['text'] = strip_tags($new_instance['text']);
		

		return $instance;
	}

	function form( $instance ) {
		//Defaults		
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$name = isset($instance['name']) ? esc_attr($instance['name']) : '';
		$email = isset($instance['email']) ? esc_attr($instance['email']) : '';
		$link = isset($instance['link']) ? esc_attr($instance['link']) : '';
		$twitter = isset($instance['twitter']) ? esc_attr($instance['twitter']) : '';
		$phone = isset($instance['phone']) ? esc_attr($instance['phone']) : '';
		$cellphone = isset($instance['cellphone']) ? esc_attr($instance['cellphone']) : '';
		$address = isset($instance['address']) ? esc_attr($instance['address']) : '';
		$city = isset($instance['city']) ? esc_attr($instance['city']) : '';
		$state = isset($instance['state']) ? esc_attr($instance['state']) : '';
		$zip = isset($instance['zip']) ? esc_attr($instance['zip']) : '';
		$text = isset($instance['text']) ? esc_attr($instance['text']) : '';
	?>

		<p><label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', 'wt_admin'); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
		
		<p><label for="<?php echo esc_attr( $this->get_field_id('name') ); ?>"><?php esc_html_e('Name:', 'wt_admin'); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('name') ); ?>" name="<?php echo esc_attr( $this->get_field_name('name') ); ?>" type="text" value="<?php echo esc_attr( $name ); ?>" /></p>
		
        <p><label for="<?php echo esc_attr( $this->get_field_id('email') ); ?>"><?php esc_html_e('Email:', 'wt_admin'); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('email') ); ?>" name="<?php echo esc_attr( $this->get_field_name('email') ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" /></p>     
        
		<p><label for="<?php echo esc_attr( $this->get_field_id('link') ); ?>"><?php esc_html_e('Link:', 'wt_admin'); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('link') ); ?>" name="<?php echo esc_attr( $this->get_field_name('link') ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" /></p>   
        
		<p><label for="<?php echo esc_attr( $this->get_field_id('twitter') ); ?>"><?php esc_html_e('Twitter:', 'wt_admin'); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('twitter') ); ?>" name="<?php echo esc_attr( $this->get_field_name('twitter') ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" /></p>   
        
		<p><label for="<?php echo esc_attr( $this->get_field_id('phone') ); ?>"><?php esc_html_e('Phone:', 'wt_admin'); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('phone') ); ?>" name="<?php echo esc_attr( $this->get_field_name('phone') ); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>" /></p>
        
		<p><label for="<?php echo esc_attr( $this->get_field_id('cellphone') ); ?>"><?php esc_html_e('Cell phone:', 'wt_admin'); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('cellphone') ); ?>" name="<?php echo esc_attr( $this->get_field_name('cellphone') ); ?>" type="text" value="<?php echo esc_attr( $cellphone ); ?>" /></p>
				
		<p><label for="<?php echo esc_attr( $this->get_field_id('address') ); ?>"><?php esc_html_e('Address:', 'wt_admin'); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('address') ); ?>" name="<?php echo esc_attr( $this->get_field_name('address') ); ?>" type="text" value="<?php echo esc_attr( $address ); ?>" /></p>
		
		<p><label for="<?php echo esc_attr( $this->get_field_id('city') ); ?>"><?php esc_html_e('City:', 'wt_admin'); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('city') ); ?>" name="<?php echo esc_attr( $this->get_field_name('city') ); ?>" type="text" value="<?php echo esc_attr( $city ); ?>" /></p>
        
		<p><label for="<?php echo esc_attr( $this->get_field_id('zip') ); ?>"><?php esc_html_e('Zip:', 'wt_admin'); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('zip') ); ?>" name="<?php echo esc_attr( $this->get_field_name('zip') ); ?>" type="text" value="<?php echo esc_attr( $zip ); ?>" /></p>
        
		<p><label for="<?php echo esc_attr( $this->get_field_id('state') ); ?>"><?php esc_html_e('State:', 'wt_admin'); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('state') ); ?>" name="<?php echo esc_attr( $this->get_field_name('state') ); ?>" type="text" value="<?php echo esc_attr( $state ); ?>" /></p>	
        
		<p><label for="<?php echo esc_attr( $this->get_field_id('text') ); ?>"><?php esc_html_e('Introduce text:', 'wt_admin'); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('text') ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" /></p>	
		
<?php
	}

}
