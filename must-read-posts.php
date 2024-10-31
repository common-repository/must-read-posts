<?php
/*
Plugin Name: Must Read Posts
Plugin URI: http://trick77.com/2008/12/29/wordpress-plugin-widget-must-read-posts
Description: Retrieves posts and pages with a certain custom field (e.g. to permanently show your most recommended posts in a widget) and displays them in a list. Use it as a widget or place it in your templates or exec-php fragments using <code>&lt;?php get_mustread(); ?&gt;</code>
Version: 2.0.2
Author: trick77
Author URI: http://trick77.com/
*/

// widget core
function widget_mustread($args) {
	extract($args);
	
	$options = get_option("trick77_widget_mustread");
	if (!is_array( $options )) {
		$options = array('title' => 'Must Read Posts', 'limit' => 10, 'fkey' => 'must-read', 'sorder' => 'custom');
	}
	
	echo $before_widget;
	echo $before_title;
	echo $options['title'];
	echo $after_title;
	
	global $wpdb, $post, $sortcrit;
	
	switch ($options['sorder']) {
		case "date_asc": 
			$sortcrit = "post_date ASC"; 
			break;
		case "date_desc": 
			$sortcrit = "post_date DESC"; 
			break;
		case "rnd": 
			$sortcrit = "RAND()"; 
			break;
		case "custom": 
			$sortcrit = "meta_value"; 
			break;
		default: 
			$sortcrit = "meta_value"; 
			break;
	}

	$sql = "SELECT $wpdb->posts.ID, post_title, post_name, post_date FROM $wpdb->posts, $wpdb->postmeta WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND meta_key = '". $options['fkey'] ."' AND meta_value like 'true%' AND post_date_gmt < '".gmdate("Y-m-d H:i:s")."' AND post_status = 'publish' AND post_password = '' ORDER BY ". $sortcrit ." LIMIT ". $options['limit'] ."";
	$mustread = $wpdb->get_results($sql);
	echo "<ul>";
	foreach ($mustread as $post) {
		$post_title = strip_tags(stripslashes($post->post_title));
		echo "<li><a href=\"".get_permalink()."\">$post_title</a></li>";
	}
	echo "</ul>";
	echo $after_widget;
}

function widget_mustread_control() {
  $options = get_option("trick77_widget_mustread");

  if (!is_array( $options )) {
		$options = array('title' => 'Must Read Posts', 'limit' => 10, 'fkey' => 'must-read', 'sorder' => 'custom');
  }      
  
  if ($_POST['mustread-Submit']) {
    	$options['title'] = htmlspecialchars($_POST['mustread-WidgetTitle']);
	$options['limit'] = htmlspecialchars($_POST['mustread-Limit']);
	$options['fkey'] = htmlspecialchars($_POST['mustread-Fkey']);
	$options['sorder'] = htmlspecialchars($_POST['mustread-SOrder']);
	
	
	if ($options['title'] == '') $options['title'] = "Must Read Posts";
	
	if ( (!is_numeric($options['limit'])) || ($options['limit'] <= 0) ) $options['limit'] = 10;
	
	if ($options['fkey'] == '') $options['fkey'] = "must-read";

	if ($options['sorder'] == '') $options['sorder'] = "custom";
	
    update_option("trick77_widget_mustread", $options);
  }

?>
  <p>
    <label for="mustread-WidgetTitle">Widget Title: </label>
    <input type="text" id="mustread-WidgetTitle" name="mustread-WidgetTitle" value="<?php echo $options['title'];?>" class="widefat" />
    <label for="mustread-Limit">Show only </label>
    <input type="text" id="mustread-Limit" name="mustread-Limit" value="<?php echo $options['limit'];?>" class="widefat" style="width:27px" /> posts<br />    
    <label for="mustread-Fkey">Custom field name key:</label>
    <input type="text" id="mustread-Fkey" name="mustread-Fkey" value="<?php echo $options['fkey'];?>" class="widefat" /><br />    
    <br /><label for="mustread-SOrder">Sort order:</label><br />
    	<input type="radio" id="mustread-SOrder" name="mustread-SOrder" value="date_asc" <?php if ($options['sorder'] == 'date_asc') echo " checked "; ?> />&nbsp;Date (oldest first)<br /> 
    	<input type="radio" id="mustread-SOrder" name="mustread-SOrder" value="date_desc" <?php if ($options['sorder'] == 'date_desc') echo " checked "; ?> />&nbsp;Date (latest first)<br /> 
    	<input type="radio" id="mustread-SOrder" name="mustread-SOrder" value="rnd" <?php if ($options['sorder'] == 'rnd') echo " checked "; ?> />&nbsp;Random<br /> 
    	<input type="radio" id="mustread-SOrder" name="mustread-SOrder" value="custom" <?php if ($options['sorder'] == 'custom') echo " checked "; ?> />&nbsp;Custom (Tag ordering)<br />     
 	<input type="hidden" id="mustread-Submit" name="mustread-Submit" value="1" /> 
  </p>
<?php
}

function init_get_mustread(){
    // check for the required WP functions, die silently for pre-2.2 WP.
    if ( !function_exists('wp_register_sidebar_widget'))
	return;
	
    wp_register_sidebar_widget('widget_mustread', 'Must Read Posts', 'widget_mustread', array('classname' => 'widget_mustread', description => 'Must read posts/pages on your blog'));
    wp_register_widget_control('widget_mustread', 'Must Read Posts', 'widget_mustread_control', array('width' => 200));
}

add_action("plugins_loaded", "init_get_mustread");


// plugin core
function get_mustread($title = "Must Read Posts", $limit = 15, $fkey = 'must-read', $sorder = 'custom' ) {
	global $wpdb, $post, $sortcrit;
	
	if ((!is_string($title)) || ($title == '')) $title = "Must Read Posts";
	if ((!is_numeric($limit)) || ($limit <= 0) || ($limit == '')) $limit = 25;
	if ((!is_string($fkey)) || ($fkey == '')) $fkey = "must-read";
	if ((!is_string($sorder)) || ($sorder == '')) $sorder = "custom";
	
	switch ($sorder) {
		case "date_asc": 
			$sortcrit = "post_date ASC"; 
			break;
		case "date_desc": 
			$sortcrit = "post_date DESC"; 
			break;
		case "rnd": 
			$sortcrit = "RAND()"; 
			break;
		case "custom": 
			$sortcrit = "meta_value"; 
			break;
		default: 
			$sortcrit = "meta_value"; 
			break;
	}

	$sql = "SELECT $wpdb->posts.ID, post_title, post_name, post_date FROM $wpdb->posts, $wpdb->postmeta WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND meta_key = '". $fkey ."' AND meta_value like 'true%' AND post_date_gmt < '".gmdate("Y-m-d H:i:s")."' AND post_status = 'publish' AND post_password = '' ORDER BY " . $sortcrit ." ". $options['limit'] ."";
	$mustread = $wpdb->get_results($sql);
	
	
	echo "<h2 class=\"widgettitle\">$title</h2>";
	echo "<ul>";
	foreach ($mustread as $post) {
		$post_title = strip_tags(stripslashes($post->post_title));
		echo "<li><a href=\"".get_permalink()."\">$post_title</a></li>";
	}
	echo "</ul>";
}

?>
