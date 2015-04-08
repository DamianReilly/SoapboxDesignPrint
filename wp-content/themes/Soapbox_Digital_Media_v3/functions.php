<?php
add_action( 'after_setup_theme', 'blankslate_setup' );

function blankslate_setup() {
	load_theme_textdomain( 'blankslate', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 640;
	register_nav_menus(
		array( 'main-menu' => __( 'Main Menu', 'blankslate' ) )
	);
}

add_action( 'wp_enqueue_scripts', 'blankslate_load_scripts' );
function blankslate_load_scripts() {
	wp_enqueue_script( 'jquery' );
}

add_action( 'comment_form_before', 'blankslate_enqueue_comment_reply_script' );
function blankslate_enqueue_comment_reply_script() {
	if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}

add_filter( 'the_title', 'blankslate_title' );

function blankslate_title( $title ) {
	if ( $title == '' ) {
		return '&rarr;';
	} else {
		return $title;
}
}
add_filter( 'wp_title', 'blankslate_filter_wp_title' );

function blankslate_filter_wp_title( $title ) {
	return $title . esc_attr( get_bloginfo( 'name' ) );
}

add_action( 'widgets_init', 'blankslate_widgets_init' );

function blankslate_widgets_init() {
	register_sidebar( array (
		'name' => __( 'Sidebar Widget Area', 'blankslate' ),
		'id' => 'primary-widget-area',
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

function blankslate_custom_pings( $comment ) {
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
	<?php 
}

add_filter( 'get_comments_number', 'blankslate_comments_number' );

function blankslate_comments_number( $count ) {
	if ( !is_admin() ) {
		global $id;
		$comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
		return count( $comments_by_type['comment'] );
	} else {
		return $count;
	}
}

/*  ADD WIDGET AREAS */

function arphabet_widgets_init() {

	register_sidebar( array(
		'name' => 'Slider Widget Area',
		'id' => 'slider-widget-area',
		'before_widget' => '<div class="slider-widget-area">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="slider-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Header Widget Area',
		'id' => 'header-widget-area',
		'before_widget' => '<div class="header-widget-area">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="header-widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Content Top Widget Area',
		'id' => 'content-top-widget-area',
		'before_widget' => '<div class="content-top-widget-area">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="content-top-widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Content Bottom Widget Area',
		'id' => 'content-bottom-widget-area',
		'before_widget' => '<div class="content-bottom-widget-area">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="content-bottom-widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Footer Widget Area',
		'id' => 'footer-widget-area',
		'before_widget' => '<div class="footer-widget-area">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="footer-widget-title">',
		'after_title' => '</h2>',
	) );
}
add_action( 'widgets_init', 'arphabet_widgets_init' );

//  MENU PARENT / CHILD CONTROL

add_filter( 'wp_nav_menu_objects', 'add_menu_parent_button' );
function add_menu_parent_button( $items ) {
	
	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {

		}
	}
	
	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {

		}
	}
	
	return $items;    
}

if ( function_exists( 'add_image_size' ) ) { 
   	add_image_size( 'top-thumb', 200, 200, array( 'left', 'top' ) );// please give another name if its not major requirement of this
	}

// Content Call to action
function soapbox_filterhook_signoff ( $entry ) {

		if ( is_single() || is_page() ) {

		$entry .= '<div class="sign-off"><i class="fa fa-phone"></i> CALL US ON 0141 429 1356 NOW</div>';
		
		}

		return $entry;
}

add_filter( 'the_content', 'soapbox_filterhook_signoff' );

// Author Box
function soapbox_filterhook_author ( $author_info ) {

		if ( is_single() ) {

		$author = get_the_author_link();
		$author_bio = get_the_author_meta('description');
		$author_image = get_avatar( get_the_author_email('50'));

		$author_info .= '<div class="author-box">' . $author_image . '<h4>By '. $author .'</h4><br>' . $author_bio . '</div>' ;
		
		}

		return $author_info;
}

add_filter( 'the_content', 'soapbox_filterhook_author' );

// Remove & replace category link from permalink
function wpa_alter_cat_links( $termlink, $term, $taxonomy ){
    
    if( 'category' != $taxonomy ) return $termlink;

    return str_replace( '/category', '', $termlink );
}

add_filter( 'term_link', 'wpa_alter_cat_links', 10, 3 );

// Breadcrumbs
function wordpress_breadcrumbs() {
  $delimiter = '<span class="delimiter"> > </span>';
  $currentBefore = '<span class="current">';
  $currentAfter = '</span>';
  if ( !is_home() && !is_front_page() || is_paged() ) {
    echo '<div id="crumbs">' . '<a href="' . get_home_url() . '">' . 'Home' . '</a>' . ' ' . $delimiter . ' ' ;
    global $post;
	if ( is_page() && !$post->post_parent ) {
		echo $currentBefore;
		the_title();
		echo $currentAfter; }
	elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] =  '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
    }
    echo '</div>';
  }
}

function the_post_breadcrumb() {
	if (!is_home()) {
		echo '<a href="';
		echo get_home_url();
		echo '">';
		echo 'HOME';
		echo "</a>  ";
		echo '<span class="delimiter"> > </span>';
		if (is_category() || is_single()) {
			the_category('title_li=');
			echo '<span class="delimiter"> > </span>';
			if (is_single()) {
				echo "  ";
				echo '<span class="current">';
				echo 
				the_title();
				echo '</span>';
			}
		}
	}
}


// Opening Hours

function opening_hours() {
	date_default_timezone_set('Europe/London'); // timezone 

$weekday = date(l); // today
//print $weekday; // Debug
//print date("H:i"); // debug

// Set open and closing time for each day of the week
if ($weekday == "Saturday" || $weekday == "Sunday") {
    $open_from = "00:00";
    $open_to = "00:00";
}
else {
    $open_from = "08:30";
    $open_to = "17:30";
}

// now check if the current time is before or after opening hours
if (date("H:i") < $open_from || date("H:i") > $open_to ) {
    echo "<div class=\"opening-times\">" .  " <span class=\"opening-class\"><i class=\"fa fa-clock-o\"></i>SORRY WE'RE CLOSED</span><br>" . "We're open: Mon to Fri, 8.30am – 17.30pm. <br>Get in touch: Fill out the contact form." . "</div>";
}

// show the checkout button
else {
    echo "<div class=\"opening-times\">" .  " <span class=\"opening-class\"><i class=\"fa fa-clock-o\"></i>WE'RE OPEN!</span><br>" . "Visit us between 8.30am – 17.30pm. <br>Why not pop by for a chat? <br>Or, give us a call right now." . "</div>";
}
}

// Print WP Hooks
function list_hooked_functions($tag=false){
 global $wp_filter;
 if ($tag) {
  $hook[$tag]=$wp_filter[$tag];
  if (!is_array($hook[$tag])) {
  trigger_error("Nothing found for '$tag' hook", E_USER_WARNING);
  return;
  }
 }
 else {
  $hook=$wp_filter;
  ksort($hook);
 }
 echo '<pre>';
 foreach($hook as $tag => $priority){
  echo "<br />&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";
  ksort($priority);
  foreach($priority as $priority => $function){
  echo $priority;
  foreach($function as $name => $properties) echo "\t$name<br />";
  }
 }
 echo '</pre>';
 return;
}

// Share buttons - top

function add_social_before_the_content( $content ) {

		if ( is_single() ) {

		    $custom_content = '';
    		$custom_content .= $content;
			return $custom_content;
		}

		else {
			return $content;
		}

}

add_filter( 'the_content', 'add_social_before_the_content' );

//WOO COMMERCE HOOKS 

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

// Remove Product Tab

add_filter( 'woocommerce_product_tabs', 'sb_woo_remove_reviews_tab', 98);
function sb_woo_remove_reviews_tab($tabs) {

 unset($tabs['reviews']);

 return $tabs;
}