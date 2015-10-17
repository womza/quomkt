<?php
/* Plugin Name: Minimalist Instagram Widget
Plugin URI: http://impression11.co.uk/
Version: 1.8
Description: A minimalist Instagram widget to display your photos and videos.
Author: Ethan Gibson
Author URI: http://impression11.co.uk/
*/
require_once (dirname(__FILE__) . '/options.php');
function printinsta($instaarray, $row, $count, $video)
	{
	global $wp_version;
	$countcheck = 0;
	$options = get_option('instagram_plugin_options');
	$cache = '';
	$cache.= '<style>.row' . $row . '{width:' . (100 / $row) . '%}</style>';
	$cache.= '<ul id="instagram">';
	foreach($instaarray as $insta)
		{
		if ($count > $countcheck)
			{
			if (isset($insta['title']))
				{
				$title = $insta['title'];
				}
			  else
				{
				$title = '';
				}

			if ($insta['type'] == "video" && $wp_version >= 3.6 && $video == 1)
				{
				
				if ($options['https'] == 1)
				{
				$insta['video'] = preg_replace("/^http:/i", "https:",$insta['video']);
				}
				$cache.= '<li class="row' . $row . '">' . do_shortcode('[video preload="metadata" src="' . $insta['video'] . '"]') . '</li>';
				}
			  else{
			  if ($options['https'] == 1 )
				{
				$insta['image'] = preg_replace("/^http:/i", "https:",$insta['image']);
				$insta['thumbnail'] = preg_replace("/^http:/i", "https:",$insta['thumbnail']);
				}
				
				$cache.= '<li class="row' . $row . '"><a href="' . $insta['image'] . '" title="' . $title . '" rel="lightbox" ><img title="' . $title . '" src="' . $insta['thumbnail'] . '" /></a></li>';
				}

			$countcheck = $countcheck + 1;
			}
		}

	$cache.= '</ul>';
	return $cache;
	}

add_shortcode('minstagram', 'minstagram');

function minstagram($atts)
	{
	extract(shortcode_atts(array(
		'count' => '4',
		'row' => '2',
		'video' => 0,
		'username' => ''
	) , $atts));
	$options = get_option('instagram_plugin_options');

	// Ensure the widget is correctly configured.
	// Compromise for now while the old User ID setting is still available

	if (isset($options['ui']) || isset($username))
		{
		$usercheck = 1;
		}

	if ($count == '' || $options['at'] == '' || !$usercheck == 1)
		{
		return 'Please ensure this plugin is correctly configured under "Instagram Options" & "Widgets"';
		}
	  else
		{
		if (!$username == '')
			{
			$file = plugin_dir_path(__FILE__) . $username . '_insta.php';

			}
		  else
			{
			$file = plugin_dir_path(__FILE__) . $options['ui'] . '_insta.php';
			}

		// If the cache is set but doesn't have a time set it to 1 hour

		if ($options['cache_exp'] == "")
			{
			$options['cache_exp'] = 1;
			}

		if ($options['caching'] == 1 && file_exists($file) && time() - filemtime($file) < $options['cache_exp'] * 3600)
			{
			include $file;

			$instahtml.= printinsta($instaarray, $row, $count, $video);

			// Tell us how long the cache is set for so we know it's working!

			$instahtml.= '<!-- Cached File (' . $options['cache_exp'] . ' hours) -->';
			return $instahtml;
			}
		  else
			{

			// Supply a user id and an access token

			$userid = $options['ui'];
			$accessToken = $options['at'];

			// Gets our data

			if (!$username == '')
				{
				$query = http_build_query(array(
					'q' => $username,
					'count' => 10,
					'access_token' => $accessToken
				));
				$url = "https://api.instagram.com/v1/users/search?{$query}";
				$result = wp_remote_get($url, array(
					'timeout' => 15
				));
				$result = $result['body'];
				$result = json_decode($result);
				if (isset($result->data))
					{
					foreach($result->data as $test11)
						{
						$username = strtolower($username);
						if ($username == $test11->username)
							{
							$newid = $test11->id;
							}
						}
					}
				  else
					{
					$debuginf .= 'Please check the instagram widget has been set up correctly';
					if ($options['debug'] == 1)
						{
						$debuginf .= '<h3>Debug Info</h3>';
						$debuginf .= print_r($result, true);
						$debuginf .= '<br />';
						}
					return $debuginf;
					}

				$userid = $newid;
				}

			if (file_exists($file) && $options['caching'] == 1)
				{
				include $file;

				}

			if (!isset($instaarray))
				{
				$instaarray = array();
				$since_id = 0;
				}
			  else
				{
				$since_id = max(array_keys($instaarray));
				}

			// Pulls and parses data.

			$result = wp_remote_get("https://api.instagram.com/v1/users/{$userid}/media/recent/?access_token={$accessToken}&count=15&min_id={$since_id}", array(
				'timeout' => 15
			));
			$result = json_decode($result['body']);

			// get the url of where cached images will go

			$cacheurl = plugins_url() . '/minimalist-instagram-widget/cache';

			// get plugin path for placing cached images

			$dir = plugin_dir_path(__FILE__);
			if (count($result->data) < 1)
				{
				$host = 'instagram.com';
				if ($socket = @fsockopen($host, 80, $errno, $errstr, 30))
					{
					$debuginf.= 'Please check your Account Details and ensure your Instagram Account has photos';
					if ($options['debug'] == 1)
						{
						$debuginf.= '<h3>Debug Info</h3>';
						print_r($result);
						if ($userid == '')
							{
							$debuginf.= 'Please check that the username you entered exists.';
							}
						}
						return $debuginf;
					fclose($socket);
					}
				  else
					{
					return 'It appears that Instagram may be down or that your website is being blocked by their API, please contact Instagram Support.';
					}
				}
			  else
				{
				foreach($result->data as $data)
					{
					if ($options['caching'] == 1)
						{
						$imgfile = substr($data->images->thumbnail->url, strrpos($data->images->thumbnail->url, '/') , strlen($data->images->thumbnail->url));

						// add the image name onto the path

						$newdir = $dir . 'cache' . $imgfile;

						// pull the image from instagrams servers

						if (!file_exists($newdir))
							{
							copy($data->images->thumbnail->url, $newdir);
							}
						}

					// Switch the size for a bigger one to link to

					if ($options['caching'] == 1)
						{
						$data->images->thumbnail->url = $cacheurl . $imgfile;
						}

					$instaarray[$data->id]['type'] = $data->type;
					
					$https = 1;

					$instaarray[$data->id]['thumbnail'] = $data->images->thumbnail->url;
					$instaarray[$data->id]['image'] = $data->images->low_resolution->url;

					if (isset($data->videos->low_resolution->url))
						{
						
						$instaarray[$data->id]['video'] = $data->videos->low_resolution->url;
												
						}

					if (isset($data->caption->text))
						{
						$instaarray[$data->id]['title'] = $data->caption->text;
						}



					krsort($instaarray);
					if ($options['caching'] == 1)
						{
						$var_str = var_export($instaarray, true);
						$var = "<?php\n\n\$instaarray = $var_str;\n\n?>";
						file_put_contents(plugin_dir_path(__FILE__) . $username . '_insta.php', $var);
						}
					}

				return printinsta($instaarray, $row, $count, $video);
				}
			}
		}
	}

class wp_insta extends WP_Widget

	{
	public

	function __construct()
		{
		parent::__construct('wordpress-insta', 'Minimalist Instagram Widget', array(
			'description' => 'Displays your Instagram Photos in the sidebar.'
		));
		}

	public

	function widget($args, $instance)
		{
		echo $args['before_widget'];
		echo $args['before_title'] . $instance['title'] . $args['after_title'];
		echo do_shortcode('[minstagram username="' . $instance['username'] . '" count="' . $instance['count'] . '" row="' . $instance['row'] . '" video="' . $instance['video'] . '"]');
		echo $args['after_widget'];
		}

	public

	function form($instance)
		{

		// removed the for loop, you can create new instances of the widget instead

?>

<p>
  <label for="<?php
		echo $this->get_field_id('title'); ?>">Widget Title</label>
  <br />
  <input type="text" class="img" name="<?php
		echo $this->get_field_name('title'); ?>" id="<?php
		echo $this->get_field_id('title'); ?>" value="<?php
		echo $instance['title']; ?>" />
</p>
<p>
  <label for="<?php
		echo $this->get_field_id('username'); ?>">Instagram Username</label>
  <br />
  <input type="text" class="img" name="<?php
		echo $this->get_field_name('username'); ?>" id="<?php
		echo $this->get_field_id('username'); ?>" value="<?php
		echo $instance['username']; ?>" />
</p>

<p>
  <label for="<?php
		echo $this->get_field_id('count'); ?>"># of Photos</label>
  <br />
  <input type="text" class="img" name="<?php
		echo $this->get_field_name('count'); ?>" id="<?php
		echo $this->get_field_id('count'); ?>" value="<?php
		echo $instance['count']; ?>" />
</p>
<p>
  <label for="<?php
		echo $this->get_field_id('video'); ?>">
    <?php
		_e('Enable Video'); ?>
  </label>
  <select name="<?php
		echo $this->get_field_name('video'); ?>" id="<?php
		echo $this->get_field_id('video'); ?>" class="widefat">
    <option value="0"<?php
		selected($instance['video'], '0'); ?>>
    <?php
		_e('False'); ?>
    </option>
    <option value="1"<?php
		selected($instance['video'], '1'); ?>>
    <?php
		_e('True'); ?>
    </option>
  </select>
</p>
<p>
  <label for="<?php
		echo $this->get_field_id('row'); ?>">
    <?php
		_e('Photos per row'); ?>
  </label>
  <select name="<?php
		echo $this->get_field_name('row'); ?>" id="<?php
		echo $this->get_field_id('row'); ?>" class="widefat">
    <option value="1"<?php
		selected($instance['row'], '1'); ?>>
    <?php
		_e('1'); ?>
    </option>
    <option value="2"<?php
		selected($instance['row'], '2'); ?>>
    <?php
		_e('2'); ?>
    </option>
    <option value="3"<?php
		selected($instance['row'], '3'); ?>>
    <?php
		_e('3'); ?>
    </option>
    <option value="4"<?php
		selected($instance['row'], '4'); ?>>
    <?php
		_e('4'); ?>
    </option>
    <option value="5"<?php
		selected($instance['row'], '5'); ?>>
    <?php
		_e('5'); ?>
    </option>
    <option value="6"<?php
		selected($instance['row'], '6'); ?>>
    <?php
		_e('6'); ?>
    </option>
    <option value="7"<?php
		selected($instance['row'], '7'); ?>>
    <?php
		_e('7'); ?>
    </option>
    <option value="8"<?php
		selected($instance['row'], '8'); ?>>
    <?php
		_e('8'); ?>
    </option>
  </select>
</p>
<?php
		}
	}

add_action('widgets_init', create_function('', 'return register_widget("wp_insta");'));

function wp_insta_head()
	{
	wp_enqueue_style('minimal-insta', plugins_url('wp-insta.css', __FILE__) , null, null);
	wp_enqueue_script('jQuery');
	}

add_action('init', 'wp_insta_head', 1);

function wp_insta_foot()
	{
	wp_enqueue_script('slimebox', plugins_url('slimbox2.js', __FILE__) , null, null);
	}
$options = get_option('instagram_plugin_options');
if(!$options['light']==1){
add_action('wp_footer', 'wp_insta_foot', 10);}