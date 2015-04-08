<?php session_start(); ?>
<?php
/*
Plugin Name: Geo Press by The WP Coach
Plugin URI: http://thewpcoach.com
Description: This plugin will add a Geo sitemap and locations.kml file to your site and give you the ability to add the properly formatted vCard so it's visible on your site's sidebar. It will also ping Google about the new or changed geo sitemap.
Version: 1.0
Author: Darren Jackson
Author URI: dj@thewpcoach.com
*/

define('DJGEOSITEMAP_VERSION', '1.0');
define('DJGEOSITEMAP_PLUGIN_URL', plugin_dir_url( __FILE__ ));
require_once('function.php');

add_action('admin_menu', 'djgeositemap_config_page');

// Load the textdomain
load_plugin_textdomain('djgeositemap', false, dirname(plugin_basename(__FILE__)));

// action links
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'djgeositemap_settings_link', 10, 1);
function djgeositemap_settings_link($links) {
	$links[] = '<a href="'.admin_url('options-general.php?page=GeoPressByTheWPcoach/djgeositemap.php').'">'.__('Settings', 'djgeositemap').'</a>';
	return $links;
}

/*********** Widget ********************/
class DjgeositemapWidget extends WP_Widget {
	
	function DjgeositemapWidget()
	{		
		parent::WP_Widget( false, __('Geo Press Widget', 'wp-djgeositemap'),  array('description' => __('Use this widget to display the addresses you\'ve used in the Geo Press Plugin. This will display the addresses in a very Google friendly vCard format on your site.', 'wp-Djgeositemap')) );
	}

	function widget($args, $instance)
	{ 
		global $wpdb;
		$title = empty( $instance['title'] ) ? __('Djgeositemap', 'wp-djgeositemap') : $instance['title'];
		echo $args['before_widget'];
		echo $args['before_title'] . $title . $args['after_title'];

	 
		$table_name = $wpdb->prefix . "djgeositemap";

		$locations =  $wpdb->get_results( 
	"
	SELECT * 
	FROM $table_name
	");
	
		if($locations)
		{
			foreach ( $locations as $location) 
			{

				$tmp_ll = $location->ll;
				if($tmp_ll != "");
				{
					$split = split(",",$tmp_ll);
				 
				}

?>



<div class="vcard">
   <span class="fn org"><?php echo $location->name; ?></span>
     <div class="adr"> 
        <span class="street-address"><?php echo $location->address; ?></span>, <br/><span class="locality"><?php echo $location->city; ?></span>, <span class="region"><?php echo $location->state; ?></span> <span class="zip"><?php echo $location->zipcode; ?></span>
     </div>   
     <span class="geo">
        <span class="latitude">
           <span class="value-title" title="<?php echo $split[0] ?>"></span>
        </span>
        <span class="longitude">
           <span class="value-title" title="<?php echo $split[1] ?>"></span>
        </span>
     </span>
   Phone: <span class="tel"><?php echo $location->phone; ?></span><br/>
   <a href="<?php echo get_bloginfo("url");?>" class="url"><?php echo get_bloginfo("url");?></a> 
   <p></p>
</div>

<?php


   
			}
		}
  
		echo $args['after_widget'];
	}

	function update($new_instance) 
	{
		return $new_instance;
	}

	function form($instance) 
	{	 
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp-djgeositemap'); ?></label>
			<input type="text" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />		
		</p>
	 
	 
		
		 
		<?php 
	}
	
}





 


function Djgeositemap_widgets_init()
{
	register_widget('DjgeositemapWidget');	
}	

add_action('widgets_init', 'Djgeositemap_widgets_init');


 
/*********** End of Widget ********************/
  


function djgeositemap_config_page() {
	global $wpdb;

	 

	if ( function_exists('add_submenu_page') )
		add_submenu_page('options-general.php',
			__('Geo Press', "djgeositemap"),
			__('Geo Press', "djgeositemap"),
			'manage_options', __FILE__, 'djgeositemap_conf');
}


function djgeositemap_install() {
   global $wpdb; 

   $table_name = $wpdb->prefix . "djgeositemap";
      
   $sql = "CREATE TABLE IF NOT EXISTS  " . $table_name . " (
	  id bigint(20) NOT NULL AUTO_INCREMENT,
	  name VARCHAR(255) DEFAULT '' NOT NULL,
	  address VARCHAR(255) DEFAULT '' NOT NULL,
	  city VARCHAR(255) DEFAULT '' NOT NULL,
	  state VARCHAR(255) DEFAULT '' NOT NULL,
	  zipcode VARCHAR(255) DEFAULT '' NOT NULL,
	  country VARCHAR(255) DEFAULT '' NOT NULL,
	  phone VARCHAR(255) DEFAULT '' NOT NULL,
	  `desc`  TEXT COLLATE utf8_unicode_ci NOT NULL,
	  `ll` VARCHAR(255) DEFAULT '' NOT NULL,
	  PRIMARY KEY (`id`)
    );";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);
 
   add_option("djgeositemap_version", DJGEOSITEMAP_VERSION);
}
 

register_activation_hook(__FILE__,'djgeositemap_install');
//add_action('plugins_loaded','djgeositemap_install'); 



function djgeositemap_admin_init() {
 
	wp_register_style('djgeositemap_style.css', plugins_url('/style.css', __FILE__));
	wp_enqueue_style('djgeositemap_style.css');

}
add_action('admin_init', 'djgeositemap_admin_init');



 

function djgeositemap_conf() { 
	global $wpdb;
	$table_name = $wpdb->prefix . "djgeositemap";
	$base_url = "options-general.php?page=".$_GET["page"];
   
   
	if(isset($_POST["locationid"]) && isset($_POST["savelocation"]))
	{
		saveLocation($_POST);
	}



	if(isset($_POST["addlocation"]))
	{
		addLocation($_POST);
	}
   
	/** get all current locations data from database **/
	$locations =  $wpdb->get_results( 
	"
	SELECT * 
	FROM $table_name
	");

 
	$id = intval($_GET["id"]);


	if($_GET["action"] == "del" && $id != 0)
	{
		return delLocation($id );
	}


?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type='text/javascript' src='<?php echo  plugins_url('/script.js', __FILE__);?>'></script>

<div id="djgeositemap-wrap">


	<h2><?php _e('Geo Press', "djgeositemap"); ?></h2>

	<h3><label><?php _e('Fill in your location details:', 'djgeositemap'); ?></label></h3>

	<form action="" method="post" id="djgeositemap-conf">


<?php


if($_GET["action"] == "edit" && $id != 0)
{
	$location =  $wpdb->get_results( 
	"
	SELECT * 
	FROM $table_name where id= $id
	");

}

if(isset($_POST["fileGeneration"]))
{
	fileSave($_POST);

}


if($_GET["action"] == "edit" && ($location))
{
   
      $location = $location[0];
?>

      <h4><label for="djgeositemap_name"><?php _e('Name *', 'djgeositemap'); ?></label></h4>
      <p><input class="djgeositemap-field djgeositemap-require" id="djgeositemap_name" alt="Your business name" name="djgeositemap_name" type="text" value="<?php echo $location->name;?>" maxlength="255"  /></p>


      <h4><label for="djgeositemap_address"><?php _e('Address*', 'djgeositemap'); ?></label></h4>
      <p><input class="djgeositemap-field djgeositemap-require" id="djgeositemap_address" alt="Your address" name="djgeositemap_address" type="text"maxlength="255" value="<?php echo $location->address;?>" /></p>


      <h4><label for="djgeositemap_city"><?php _e('City*', 'djgeositemap'); ?></label></h4>
      <p><input class="djgeositemap-field djgeositemap-require" id="djgeositemap_city" alt="Your city" name="djgeositemap_city" type="text" value="<?php echo $location->city;?>" maxlength="255" /></p>

      <h4><label for="djgeositemap_state"><?php _e('State', 'djgeositemap'); ?></label></h4>
      <p><input class="djgeositemap-field" id="djgeositemap_state"  alt="OR" name="djgeositemap_state" type="text" value="<?php echo $location->state;?>" maxlength="255"   /></p>

      <h4><label for="djgeositemap_zipcode"><?php _e('Zipcode*', 'djgeositemap'); ?></label></h4>
      <p><input class="djgeositemap-field djgeositemap-require" id="djgeositemap_zipcode" name="djgeositemap_zipcode" type="text" alt="12345" value="<?php echo $location->zipcode;?>" maxlength="255"   /></p>

      <h4><label for="djgeositemap_country"><?php _e('Country*', 'djgeositemap'); ?></label></h4>
      <p><select class="djgeositemap-select" name="djgeositemap_country" id="djgeositemap_country">
         <option value="United States">United States</option>
         <option value="United Kingdom">United Kingdom</option>
         <option value="Australia">Australia</option>
         <option value="Canada">Canada</option>
         <option value="France">France</option>
         <option value="New Zealand">New Zealand</option>
         <option value="Spain">Spain</option>
         <option value="Germany">Germany</option>
         <option value="Singapore">Singapore</option>
         <option value="Poland">Poland</option>
         </select></p>  



      <h4><label for="djgeositemap_phone"><?php _e('Main phone number', 'djgeositemap'); ?></label></h4>
      <p><input class="djgeositemap-field" id="djgeositemap_phone" alt="(123) 456-7890" name="djgeositemap_phone" value="<?php echo $location->phone;?>" type="text" maxlength="255"   /></p>


      <h4><label for="djgeositemap_ll"><?php _e('Latitude and Longitude', 'djgeositemap'); ?></label></h4>
      <p><input class="djgeositemap-field" id="djgeositemap_ll" alt="" name="djgeositemap_ll"  value="<?php echo $location->ll;?>" type="text" maxlength="255"   />
      <ul>
      	<li><a class="button href="#" onClick="return lookup();">Lookup</a></li>
       </ul></p>


      <h4><label for="djgeositemap_description"><?php _e('Description', 'djgeositemap'); ?></label></h4><br/>
      HTML is Allowed
      <p><textarea class="djgeositemap-textarea" id="djgeositemap_description" name="djgeositemap_description"><?php echo $location->desc;?></textarea></p>

<div id="small-text">
For the description you can use variables mentioned below click to insert. The variables will be replaced by the corresponding values of this form. You can also use basic HTML like Header Tages, Images, Links, etc. if needed.
<p>
<ul id="djgeositemap-short">
<li>{name}</li>
<li>{address}</li>
<li>{city}</li>
<li>{zipcode}</li>
<li>{state}</li>
<li>{country}</li>
<li>{phone}</li>
</ul>
</p>
</div>


      </p>
      <input type="hidden" name="locationid" value="<?php echo $location->id; ?>" />
      <p class="submit" style="text-align: left"><?php wp_nonce_field('djgeositemap', 'djgeositemap-admin'); ?><input type="submit" onClick="return formSubmit();" name="savelocation" value="<?php _e('Save Location', 'djgeositemap'); ?> &raquo;" /></p>

<?php
 
}else{

?>

      <h4><label for="djgeositemap_name"><?php _e('Name *', 'djgeositemap'); ?></label></h4>
      <p><input class="djgeositemap-field djgeositemap-require" id="djgeositemap_name" alt="Your business name" name="djgeositemap_name" type="text" value="Your business name" maxlength="255"   /></p>


      <h4><label for="djgeositemap_address"><?php _e('Address*', 'djgeositemap'); ?></label></h4>
      <p><input class="djgeositemap-field djgeositemap-require" id="djgeositemap_address" alt="Your address" name="djgeositemap_address" type="text" value="Your address" maxlength="255"   /></p>


      <h4><label for="djgeositemap_city"><?php _e('City*', 'djgeositemap'); ?></label></h4>
      <p><input class="djgeositemap-field djgeositemap-require" id="djgeositemap_city" alt="Your city" name="djgeositemap_city" type="text" value="Your city" maxlength="255"  /></p>

      <h4><label for="djgeositemap_state"><?php _e('State', 'djgeositemap'); ?></label></h4>
      <p><input class="djgeositemap-field" id="djgeositemap_state"  alt="OR" name="djgeositemap_state" type="text" value="OR" maxlength="255"   /></p>

      <h4><label for="djgeositemap_zipcode"><?php _e('Zipcode*', 'djgeositemap'); ?></label></h4>
      <p><input class="djgeositemap-field djgeositemap-require" id="djgeositemap_zipcode" name="djgeositemap_zipcode" type="text" alt="12345" value="12345" maxlength="255"   /></p>

      <h4><label for="djgeositemap_country"><?php _e('Country*', 'djgeositemap'); ?></label></h4>
      <p><select class="djgeositemap-select" name="djgeositemap_country" id="djgeositemap_country">
         <option value="United States">United States</option>
         <option value="United Kingdom">United Kingdom</option>
         <option value="Australia">Australia</option>
         <option value="Canada">Canada</option>
         <option value="France">France</option>
         <option value="New Zealand">New Zealand</option>
         <option value="Spain">Spain</option>
         <option value="Germany">Germany</option>
         <option value="Singapore">Singapore</option>
         <option value="Poland">Poland</option>
         </select></p> 



      <h4><label for="djgeositemap_phone"><?php _e('Main phone number', 'djgeositemap'); ?></label></h4>
      <p><input class="djgeositemap-field" id="djgeositemap_phone" alt="(123) 456-7890" name="djgeositemap_phone" value="(123) 456-7890" type="text" maxlength="255"   /></p>


      <h4><label for="djgeositemap_ll"><?php _e('Latitude and Longitude', 'djgeositemap'); ?></label></h4>
      <p><input class="djgeositemap-field" id="djgeositemap_ll" alt="" name="djgeositemap_ll" value="" type="text" maxlength="255"   />
      <ul>
      	<li><a class="button href="#" onClick="return lookup();">Lookup</a></li>
      </ul>
      </p>

      <h4><label for="djgeositemap_description"><?php _e('Description', 'djgeositemap'); ?></label></h4>
      
		<p><textarea class="djgeositemap-textarea" id="djgeositemap_description" name="djgeositemap_description"><?php echo $location->desc;?></textarea></p>

<div id="small-text">
For the description you can use variables mentioned below click to insert. The variables will be replaced by the corresponding values of this form. You can also use basic HTML like Header Tages, Images, Links, etc. if needed.
<p>
<ul id="djgeositemap-short">
<li>{name}</li>
<li>{address}</li>
<li>{city}</li>
<li>{zipcode}</li>
<li>{state}</li>
<li>{country}</li>
<li>{phone}</li>
</ul>
</p>
</div>


      </p>

      <p class="submit" style="text-align: left"><?php wp_nonce_field('djgeositemap', 'djgeositemap-admin'); ?><input type="submit" onClick="return formSubmit();" name="addlocation" value="<?php _e('Add Location', 'djgeositemap'); ?> &raquo;" /></p>

<?php
}
?>
   </form>

<hr/>
<p>&nbsp;</p>

 
<h3><label><?php _e('Current Locations:', 'djgeositemap'); ?></label></h3>




</div>

<div id="current-locations-list">
<ul>
<li id="current-locations-title">
   <div class="current-locations-name">
   Name
   </div>
   <div class="current-locations-details">
   Details
   </div>
   <div class="current-locations-action">
   &nbsp;
   </div>
</li>
<?php
 
if($locations)
{
   foreach ( $locations as $location) 
   {
      echo "<li><div class='current-locations-name'>".$location->name."</div><div class='current-locations-details'>".$location->address.",".$location->zipcode." ".$location->city." (".$location->country.")</div><div class='current-locations-action'><a href='".$base_url."&action=edit&id=".$location->id."'>Edit</a> <a href='".$base_url."&action=del&id=".$location->id."'>Del</a></div></li>";
   }
}

?>

</ul>
</div>

<div id="generate-file-area">
	<form action="" method="post">
		<h4><label for="djgeositemap_desc_kml"><?php _e('Description for your KML file', 'djgeositemap'); ?></label></h4>
		<p><input class="djgeositemap-field" id="djgeositemap_desc_kml" alt="Please Fill In Company Name" name="djgeositemap_desc_kml" value="<?php if(get_option("kml_desc") == "") echo "Locations for Darren Jackson LLC."; else echo get_option("kml_desc");?>" type="text" maxlength="255"   /></p>

		<h4><label for="djgeositemap_author"><?php _e('Author', 'djgeositemap'); ?></label></h4>
		<p><input class="djgeositemap-field" id="djgeositemap_author" alt="Author" name="djgeositemap_author" value="<?php if(get_option("kml_author") == "") echo "Author"; else echo get_option("kml_author");?>" type="text" maxlength="255"   /></p>

		<p class="submit" style="text-align: left"><?php wp_nonce_field('djgeositemap', 'djgeositemap-admin'); ?><input type="submit" onClick="return generateSubmit();" name="fileGeneration" value="<?php _e('Generate Geo Sitemap', 'djgeositemap'); ?> &raquo;" /></p>
        <p>
		<h4>Last Creation Date: <?php  echo get_option("djgeositemap_kml_lastdate"); ?></h4>
		</p>
        <p><a target="_blank" class="button" href="<?php bloginfo('wpurl'); ?>/geositemap.xml">Download Geo Sitemap</a> - 
        	Right click over the top of the "Download Button" then click "Save Link As" to download the sitemap.</p>

	</form>

</div>     
<?php
}