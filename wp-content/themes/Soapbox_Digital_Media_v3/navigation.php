<script>
jQuery( document ).ready(function() {
	var open = false;
	jQuery('.mob-trigger').click(function(){
		if(!open) {
			jQuery('.mob-menu').css("opacity","1");
			jQuery('.mob-menu').css("top","0px");
			jQuery('.mob-menu').css("pointer-events","auto");
			jQuery('.mob-menu').css("cursor","pointer");
			jQuery('.mob-trigger').addClass('mob-trigger-rotation');
			open = true;
		} else {
			jQuery('.mob-menu').css("opacity","0");
			jQuery('.mob-menu').css("top","-50px");
			jQuery('.mob-trigger').removeClass('mob-trigger-rotation');
			jQuery('.mob-menu').css("pointer-events","none");
			jQuery('.mob-menu').css("cursor","default");
			open = false;
		}
	});
	jQuery('.short-nav .menu-item-has-children').append('<button class="mob-sub-trigger"> > </button>');
	jQuery('.mob-sub-trigger').click(function(){
		if(jQuery(this).closest('.menu-item-has-children').children('.sub-menu').hasClass('child-menu-visible')) {
			jQuery(this).closest('.menu-item-has-children').children('.sub-menu').removeClass('child-menu-visible');
		} else {
			jQuery(this).closest('.menu-item-has-children').children('.sub-menu').addClass('child-menu-visible');
		}
	});
	
	jQuery('.wide-nav .menu-item-has-children').hover(function(){
		var hoverTimeout;
		clearTimeout(hoverTimeout);
		jQuery(this).children('.sub-menu').addClass('wide-child-visible');
	}, function() {
		var $self = jQuery(this);
		hoverTimeout = setTimeout(function() {
		$self.children('.sub-menu').removeClass('wide-child-visible');});
	});
});
</script>
<div class="short-nav">
	<button class="mob-trigger"><span>-</span></button> <p class="short-menu-button">MENU</p>
	<?php wp_nav_menu( array( 
		'theme_location' 	=> 	'main-menu', 
		'container_class' 	=> 	'mob-menuwrapper',
		'container_id'		=>	'mob-menu',
		'items_wrap'		=>	'<ul id="%1$s" class="mob-menu %2$s">%3$s</ul>',
		 ) );?>
</div>
<div class="wide-nav">
	<div class="wide-menu-wrap">
		<?php wp_nav_menu( array( 
			'theme_location' 	=> 	'main-menu', 
			 ) );?>
	</div>
	<div class="grant hvr-sweep-to-right">
	<a href="/contact-us">GET A QUICK PRINT QUOTE NOW!</a>
	</div>	 	 
</div>