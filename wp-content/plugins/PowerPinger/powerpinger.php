<?php
/*
Plugin Name: Power Pinger
Plugin URI: http://imsuccesscenter.com
Description: Seans custom plugin for auto visitor pinging a page when a visitor comes to the site and uses a hudden frame to have them pingomatic the page...
Author: Sean Donahoe
Version: 1.1
Author URI: http://imsuccesscenter.com

*/

class powerpinger {

	function powerpinger() {

		// make sure we have the right paths...
		if ( !defined('WP_PLUGIN_URL') ) {
			if ( !defined('WP_CONTENT_DIR') ) define('WP_CONTENT_DIR', ABSPATH.'wp-content');
			if ( !defined('WP_CONTENT_URL') ) define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
			if ( !defined('WP_PLUGIN_DIR') ) define('WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins');
			define('WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins');
		}// end if

		register_deactivation_hook(__FILE__, array(&$this, 'deactivate'));

		//add quick links to plugins page
		$plugin = plugin_basename(__FILE__);
		if ( is_admin() )
			add_filter("plugin_action_links_$plugin", array(&$this, 'settings_link'));

		   add_action('wp_footer', array( &$this, 'power_pingit' ));	

	}// end function
	
	function power_pingit() {
		global $wp_query,$wpdb;
		
     	// Is this plugin enabled
		$options = $this->get_options();
		if (!$options['enabled']){ return; }	
		
		// Check we are not a match for the static ip
		if (isset($options['staticip'])){
			$ip=$_SERVER['REMOTE_ADDR'];
			if ($ip==$options['staticip']){return;}
		}
		
		$method=$options['method'];
		$testmode=$options['testmode'];	
		
		$onhome=$options['onhome'];	
		$onpage=$options['onpage'];	
		$onpost=$options['onpost'];	
		

		// Make sure we are on a single post, page or homepage
		if (!is_single() && !is_page() && !is_front_page()){
			 return;	
		}
		
		if ( (is_single() && $onpost!="ON") || (is_front_page() && $onhome!="ON") || (is_page() && $onpage!="ON") ){

			return;
		}


		// See if we have a referrer		
		$referer = $this->get_referer();
					// Process and see what url we are going to ping...
		if ($referer){
			$results = $this->processreferer($referer);
			if (is_array($results) && $results['type']=="EXTERNAL"){
				$urltoping=$referer;
			}else{
				$urltoping= get_permalink();
			}
		}else{
			$urltoping= get_permalink();
		}
		
		// Get the title...
		$title=get_the_title();
		if (empty($title)){
			$title=get_bloginfo('name');
		}
		
		// Set RSS feed (why not boost that again as well ;)
		$rssurl=get_bloginfo('rss2_url');
		
		// Check Test Mode...

		if (!empty($testmode)){
			$iframeparam="height:100px;width:100%;";
		}else{
			$iframeparam="width:1px;height:1px;border:0px;display:none;";
		}


		if (!empty($urltoping) && !empty($title)){

			if( empty($testmode) && $method == 'js' ) {
		  		$pingomatic_url = '"http://pingomatic.com/ping/?title='.urlencode($title).'&blogurl='.urlencode($urltoping).'&rssurl='.urlencode($rssurl).'&chk_weblogscom=on&chk_blogs=on&chk_technorati=on&chk_feedburner=on&chk_syndic8=on&chk_newsgator=on&chk_feedster=on&chk_myyahoo=on&chk_pubsubcom=on&chk_blogdigger=on&chk_blogrolling=on&chk_blogstreet=on&chk_moreover=on&chk_weblogalot=on&chk_icerocket=on&chk_newsisfree=on&chk_topicexchange=on&chk_google=on&chk_tailrank=on&chk_bloglines=on&chk_postrank=on&chk_skygrid=on&chk_collecta=on&chk_audioweblogs=on&chk_rubhub=on&chk_geourl=on&chk_a2b=on&chk_blogshares=on"';
	
			  	echo( '<script type="text/javascript"> '.
				'var title = escape( document.getElementsByTagName("title")[0].innerHTML );'.
				'var ifr = document.createElement("iframe");'.
				'var ref = escape( document.referrer );'.
				'ifr["src"] = '.$pingomatic_url.';'.
				'ifr["border"] = 0;'.
				'ifr["width"] = 1;'.
				'ifr["height"] = 1;'.
				'document.getElementsByTagName("body")[0].appendChild(ifr);'.
				'</script>' );
			} else {
			  	$pingomatic_url = 'http://pingomatic.com/ping/?title='.urlencode($title).'&blogurl='.urlencode($urltoping).'&rssurl='.urlencode($rssurl).'&chk_weblogscom=on&chk_blogs=on&chk_technorati=on&chk_feedburner=on&chk_syndic8=on&chk_newsgator=on&chk_feedster=on&chk_myyahoo=on&chk_pubsubcom=on&chk_blogdigger=on&chk_blogrolling=on&chk_blogstreet=on&chk_moreover=on&chk_weblogalot=on&chk_icerocket=on&chk_newsisfree=on&chk_topicexchange=on&chk_google=on&chk_tailrank=on&chk_bloglines=on&chk_postrank=on&chk_skygrid=on&chk_collecta=on&chk_audioweblogs=on&chk_rubhub=on&chk_geourl=on&chk_a2b=on&chk_blogshares=on';
			    echo'<iframe src="'.$pingomatic_url.'" border="0" style="'.$iframeparam.'"></iframe>';
			   
			}
		}
	
		
		return;
	}

	function should_ping(){
		if (is_single()){
			return true;
		}
		
		return false;
	}


	function activate() {
		// stuff to do when the plugin is activated
	}// end function
	
	function deactivate() {
		// stuff to do when plugin is deactivated
		$options = $this->get_options();
		if ( $options['remove_settings'] )
			delete_option('powerpinger');
	}// end function
	
	function settings_link($links) {
		$settings_link = '<a href="options-general.php?page=PowerPinger/admin.php">Settings</a>';
		array_unshift($links,$settings_link);
		return $links;
	}// end function
	
	function get_options() {
		$options = get_option('powerpinger');
		if ( !is_array($options) )
			$options = $this->set_defaults();
		return $options;
	}// end function
	
	function set_defaults() {
		$options = array(
			'method' => 'iframe',
			'enabled' => 'ON',
			'staticip' => '',
			'testmode' => '',
			'onhome' => '',
			'onpage' => 'ON',
			'onpost' => 'ON',
		);
		update_option('powerpinger', $options);
		return $options;
	}// end function
	
	function get_referer() {
	   if (!isset($_SERVER['HTTP_REFERER']) || ($_SERVER['HTTP_REFERER'] == '')) return false;
	   $referer_info = parse_url($_SERVER['HTTP_REFERER']);
	   $referer = $referer_info['host'];
	   if(substr($referer, 0, 4) == 'www.')
	       $referer = substr($referer, 4);
	   return $referer;
	}
	
	function processreferer($referer) {
	
	    $search_engines = array(
	    		'google.com',
				'go.google.com',
				'images.google.com',
				'video.google.com',
				'news.google.com',
				'blogsearch.google.com',
				'maps.google.com',
				'local.google.com',
				'search.yahoo.com',
				'search.msn.com',
				'bing.com',
				'msxml.excite.com',
				'search.lycos.com',
				'alltheweb.com',
				'search.aol.com',
				'search.iwon.com',
				'ask.com',
				'ask.co.uk',
				'search.cometsystems.com',
				'hotbot.com',
				'overture.com',
				'metacrawler.com',
				'search.netscape.com',
				'looksmart.com',
				'dpxml.webcrawler.com',
				'search.earthlink.net',
				'search.viewpoint.com',
				'mamma.com');
	    $result = array();
	    
	    // Make sure it isn't and internal referrer 
	    $our_domain = preg_replace( '/^www\./', '', $_SERVER[ 'HTTP_HOST' ] );
	    
	    if( $referer != '' && // Actually contains something
		  preg_match( '@^http://@', $referer ) && // Not a relative URI
		  !preg_match( '@^http://.*'.$our_domain.'/.*@', $referer )
		){
			if (in_array($referer, $search_engines)) {
	       		$result['type']="SEARCHENGINE";
	    	}else{
	    		$result['type']="EXTERNAL";
	    	}
		}else{
			$result['type']="INTERNAL";
		}
	
	    return $result;
    
	}

}// end class
$powerpinger = new powerpinger;

if ( is_admin() )
	include_once dirname(__FILE__).'/admin.php';
