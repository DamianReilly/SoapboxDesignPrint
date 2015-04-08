<?php 
function addLocation($data)
{
	global $wpdb; 
	$table_name = $wpdb->prefix . "djgeositemap";
	$post = array('name'=>$data["djgeositemap_name"],
	'address'=>$data["djgeositemap_address"],
	'city' => $data["djgeositemap_city"],
	'zipcode' => $data["djgeositemap_zipcode"],
	'country' => $data["djgeositemap_country"],

	);

	$valid = true;
	foreach($post as $key =>$value )
	{
		if($value == "")
		{
			echo "Please enter ".$key."<br/>";
			$valid = false;
		}
	}

	$post["description"] = $data["djgeositemap_description"];
	$post["phone"] = $data["djgeositemap_phone"];
	$post["state"] = $data["djgeositemap_state"];

	$post["ll"] = $data["djgeositemap_ll"];
 
	if($post["ll"] != "" && strlen($post["ll"]) > 3)
	{
		$post["ll"] = substr($post["ll"],1);
		$post["ll"] = substr($post["ll"],0,(strlen($post["ll"])-1));
	}

	if($valid)
	{

		$result = $wpdb->insert( 
		$table_name, 
		array( 
		'name' => $post["name"], 
		'address' => $post["address"],
		'city' => $post["city"],
		'state' =>  $post["state"],
		'zipcode' =>  $post["zipcode"],
		'country' =>  $post["country"],
		'phone' =>  $post["phone"],
		'desc' =>  $post["description"],
		'll' => $post["ll"],
		), 
		array( 
		'%s', 
		'%s',
		'%s', 
		'%s',
		'%s', 
		'%s',
		'%s', 
		'%s',
		'%s'
		)); 
		if($result)
			echo "<br/><br/><span  class='s_message' >New location has been added</span>";
		else
			echo "<br/><br/><span class='f_message'  >Please try again</span>";

	}

}

function saveLocation($data)
{
	global $wpdb; 
 
	$table_name = $wpdb->prefix . "djgeositemap";
	$base_url = "options-general.php?page=GeoPressByTheWPcoach/djgeositemap.php";
	$locationid = intval($data["locationid"]);
      
	$post = array('name'=>$data["djgeositemap_name"],
	'address'=>$data["djgeositemap_address"],
	'city' => $data["djgeositemap_city"],
	'zipcode' => $data["djgeositemap_zipcode"],
	'country' => $data["djgeositemap_country"],

	);

	$valid = true;
	foreach($post as $key =>$value )
	{
		if($value == "")
		{
			echo "Please enter ".$key."<br/>";
			$valid = false;
		}
	}

	$post["description"] = $data["djgeositemap_description"];
	$post["phone"] = $data["djgeositemap_phone"];
	$post["state"] = $data["djgeositemap_state"];

	$post["ll"] = $data["djgeositemap_ll"];
 
	if($post["ll"] != "" && strlen($post["ll"]) > 3)
	{
		$post["ll"] = substr($post["ll"],1);
		$post["ll"] = substr($post["ll"],0,(strlen($post["ll"])-1));
	}
 
	if($valid)
	{
		$result = $wpdb->update( 
		$table_name, 
		array( 
			'name' => $post["name"], 
			'address' => $post["address"],
			'city' => $post["city"],
			'state' =>  $post["state"],
			'zipcode' =>  $post["zipcode"],
			'country' =>  $post["country"],
			'phone' =>  $post["phone"],
			'desc' =>  $post["description"],
			'll' => $post["ll"]
		), 
		array( 'id' => $locationid ), 
		array( 
			'%s', 
			'%s',
			'%s', 
			'%s',
			'%s', 
			'%s',
			'%s', 
			'%s',
			'%s'
		), 
		array( '%d' ) 
		);

		if($result)
			echo "<br/><br/><span class='s_message'>Location has been saved.</span>
            Please click <a href='".$base_url."'>Here</a> back to main page.
			";
		else
			echo "<br/><br/><span class='f_message'  >Please try again</span> or  Please click <a href='".$base_url."'>Here</a> back to main page. ";
	}
}

function delLocation($id )
{
   global $wpdb; 
   $table_name = $wpdb->prefix . "djgeositemap";
   $base_url = "options-general.php?page=GeoPressByTheWPcoach/djgeositemap.php";
   $result = $wpdb->query(
      $wpdb->prepare( 
	"
	DELETE FROM $table_name 
	WHERE id = '%d' 
	", 
        array(
		$id
	) 
   ));

   if($result)
       echo "<br/><br/><span class='s_message'  >Location (".$id.") has been deleted</span>  Please click <a href='".$base_url."'>Here</a> back to main page. ";
   else
       echo "<br/><br/><span class='f_message'  >Please try again</span> or  Please click <a href='".$base_url."'>Here</a> back to main page. ";

   return $result ;
}

function fileSave($data)
{
	global $wpdb; 

	$table_name = $wpdb->prefix . "djgeositemap";
	$kml_desc = trim($data["djgeositemap_desc_kml"]);
	$kml_author = trim($data["djgeositemap_author"]);

	update_option("kml_desc", $kml_desc );
	update_option("kml_author", $kml_author );

	$locations =  $wpdb->get_results( 
	"
	SELECT * 
	FROM $table_name
	");



$kmlfile = '<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2">
<Document>
	<name>'.$kml_author.'</name>
	<description>
	<![CDATA[
		'.$kml_desc.'
	]]>
	</description>';

	if($locations)
	{
		foreach ( $locations as $location) 
		{
			$tmp_desc = $location->desc;

			$keywords = array("{name}", "{address}", "{city}", "{zipcode}", "{state}", "{country}", "{phone}");
			$replace = array($location->name,$location->address,$location->city,$location->zipcode,$location->state,$location->country,$location->phone);

			$tmp_desc = str_replace($keywords , $replace , $tmp_desc);
			$tmp_ll = $location->ll;
			if($tmp_ll != "");
			{
				$split = split(",",$tmp_ll);
				$tmp_ll = $split["1"].",".$split["0"];
			}
$kmlfile .= '
	<Placemark>
		<name>'.$location->name.'</name>
		<description>
		<![CDATA[
			'.$tmp_desc.'
		]]>
		</description>
		<address>'.$location->address.','.$location->city.','.$location->state.','.$location->zipcode.'</address>
		<phoneNumber>'.$location->phone.'</phoneNumber>
		<Point>
			<coordinates>'.$tmp_ll.'</coordinates>
		</Point>
	</Placemark>
';
		}
	}
 
  
	 

$kmlfile .= '
</Document>
</kml>
 ';
	$kmlfilename = "locations.kml";
	file_put_contents(ABSPATH.$kmlfilename , $kmlfile );



$geositemapxml .='<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	  xmlns:geo="http://www.google.com/geo/schemas/sitemap/1.0">
	<url>      
		<loc>'.get_bloginfo("url").'/'.$kmlfilename.'</loc>
		<geo:geo>
			<geo:format>kml</geo:format>
		</geo:geo>
	</url>
</urlset>
';

	$geositemapname = "geositemap.xml";
	file_put_contents(ABSPATH.$geositemapname , $geositemapxml );

	update_option("djgeositemap_kml_lastdate", date('m-d-Y g:i a') );

	if(file_exists(ABSPATH.$geositemapname))
	{
		echo "<iframe style='width:1px;height:1px;border:0px;float:left' src='http://www.google.com/webmasters/sitemaps/ping?sitemap=".get_bloginfo("url")."/".$geositemapname."'></iframe>";
	}
}