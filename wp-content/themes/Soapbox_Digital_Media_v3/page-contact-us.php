<?php get_header(); ?>
<?php get_template_part('templates/page', 'offices'); ?>
<?php get_sidebar(); ?>

<div class="clearfloat"></div>

<?php get_template_part('templates/page', 'map'); ?>

<div class="clearfloat"></div>


<?php get_template_part('templates/page', 'c2a'); ?>
<?php get_template_part('templates/page', 'innerservices'); ?>
<?php get_template_part('templates/page', 'testimonials'); ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
    $('.click').click(function () {
        $('#contact-2').slideToggle('slow');
                $('.pop').delay(1100).fadeIn(1000);
    });
</script>
<?php get_footer(); ?>