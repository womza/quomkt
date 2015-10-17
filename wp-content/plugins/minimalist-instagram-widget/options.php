<?php
add_action( 'admin_init', 'instagram_options_init1' );
add_action( 'admin_menu', 'instagram_options_add_page1' );
function instagram_options_init1(){
	register_setting( 'instagram_options', 'instagram_plugin_options', 'instagram_options_validate' );
}
function instagram_options_add_page1() {
	add_menu_page( __( 'Instagram Widget', 'sampletheme' ), __( 'Instagram Options', 'sampletheme' ), 'edit_theme_options', 'instagram_options', 'instagram_options_do_page1', plugins_url('img/logo.png',__FILE__ ) );
}
function instagram_options_do_page1() {
	global $select_options, $radio_options;
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;?>

<div class="wrap">
  <?php screen_icon(); echo "<h2>Minimalist Instagram Options</h2>"; ?>
  <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
  <div class="updated fade">
    <p><strong>
      <?php _e( 'Options saved', 'sampletheme' ); ?>
      </strong></p>
  </div>
  <?php endif; ?>
  <form method="post" action="options.php">
    <?php settings_fields( 'instagram_options' ); ?>
    <?php $options = get_option( 'instagram_plugin_options' ); ?>
    <h3>Options:</h3>
    <p>If you do not already have your Instagram Access Token, you can retrieve it here: <a target="_blank" href="http://impression11.co.uk/minimalist-instagram-widget/">http://impression11.co.uk/minimalist-instagram-widget/</a>. Copy and paste it below.</p>
                    <p>Your Instagram User ID is no longer required, you can simply enter the username of the Instagram account you want to display in the widget or in the shortcode:</p>
                    <stong>[minstagram username="your_username_here"]</stong> <p>This allows you to display multiple accounts across your website. The User ID will still be used if a username is not provided, but may be phased out in future.</p>

    <table class="form-table">
      <tr valign="top">
        <th scope="row"><?php _e( 'Instagram User ID (Legacy)', 'sampletheme' ); ?>
        </th>
        <td>
        <input  id="ui" class="regular-text" type="text" name="instagram_plugin_options[ui]" value="<?php esc_attr_e( $options['ui'] ); ?>" /></td>
      </tr> 
      <tr valign="top">
        <th scope="row"><?php _e( 'Access Token', 'sampletheme' ); ?></th>
        <td><input  id="at" class="regular-text" type="text" name="instagram_plugin_options[at]" value="<?php esc_attr_e( $options['at'] ); ?>" /></td>
      </tr> 
    </table>
    <h3>Caching Options</h3>
    <table class="form-table">
 <tr valign="top">
        <th scope="row"><?php _e( 'Enable Caching', 'sampletheme' ); ?></th>
        <td><input id="caching" name="instagram_plugin_options[caching]" type="checkbox" value="1" <?php checked( '1', $options['caching'] ); ?> /></td>
      </tr>
      <tr valign="top">
        <th scope="row"><?php _e( 'Cache Expiry (Hrs)', 'sampletheme' ); ?></th>
        <td><input  id="cache_exp" class="regular-text" type="text" name="instagram_plugin_options[cache_exp]" value="<?php esc_attr_e( $options['cache_exp'] ); ?>" /></td>
      </tr> 
    </table>
    <h3>Lightbox</h3>
        <p>This widget includes it's own Lightbox script, however if a theme or another plugin has it's own they can interfere with each other. Use this option to disable this widget's lightbox script.</p>
    <table class="form-table">
 <tr valign="top">
        <th scope="row"><?php _e( 'Disable Lightbox', 'sampletheme' ); ?></th>
        <td><input id="light" name="instagram_plugin_options[light]" type="checkbox" value="1" <?php checked( '1', $options['light'] ); ?> /></td>
      </tr>
    </table>
    <h3>HTTPS Mode</h3>
        <p>If your website uses HTTPS you can use this to load Instagram images and video through HTTPS. If you do not have HTTPS available on your website and this is enabled with caching images may fail to show.</p>
    <table class="form-table">
 <tr valign="top">
        <th scope="row"><?php _e( 'Enable HTTPS', 'sampletheme' ); ?></th>
        <td><input id="https" name="instagram_plugin_options[https]" type="checkbox" value="1" <?php checked( '1', $options['https'] ); ?> /></td>
      </tr>
    </table>
     <h3>Debug Mode</h3>
        <p>If Debug mode is active it will give a read out of technical infomation along with the friendly error message, use this to figure out exactly what is wrong</p>
    <table class="form-table">
 <tr valign="top">
        <th scope="row"><?php _e( 'Enable Debug Mode', 'sampletheme' ); ?></th>
        <td><input id="debug" name="instagram_plugin_options[debug]" type="checkbox" value="1" <?php checked( '1', $options['debug'] ); ?> /></td>
      </tr>
    </table>
        <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'sampletheme' ); ?>" />
    </p>
  </form>
</div>
<?php
}
function instagram_options_validate( $input ) {
	$input['at'] = wp_filter_nohtml_kses( $input['at'] );
	$input['ui'] = wp_filter_nohtml_kses( $input['ui'] );
	$input['cache_exp'] = wp_filter_nohtml_kses( $input['cache_exp'] );
	if ( ! isset( $input['caching'] ) )
		$input['caching'] = null;
		$input['caching'] = ( $input['caching'] == 1 ? 1 : 0 );
if ( ! isset( $input['debug'] ) )
		$input['debug'] = null;
		$input['debug'] = ( $input['debug'] == 1 ? 1 : 0 );
if ( ! isset( $input['light'] ) )
		$input['light'] = null;
		$input['light'] = ( $input['light'] == 1 ? 1 : 0 );
		if ( ! isset( $input['https'] ) )
		$input['https'] = null;
		$input['https'] = ( $input['https'] == 1 ? 1 : 0 );
	return $input;
}