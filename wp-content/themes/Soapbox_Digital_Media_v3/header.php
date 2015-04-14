<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php wp_title( ' | ', true, 'right' ); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="format-detection" content="telephone=no">
        <link rel="shortcut icon" href="/wp-content/themes/Soapbox_Digital_Media_v3/favicon.ico" />
        <link href="/wp-content/themes/Soapbox_Digital_Media_v3/stylesheets/screen.css" rel="stylesheet" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,400italic' rel='stylesheet' type='text/css'>
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        
        <style type="text/css">

            <?php if( is_front_page() ) : ?>
                h3 {
                   padding: 2.25em 0 1em; 
                }
                @media (min-width: 600px) {
                    h3 {
                        padding: 1em 0; 
                    }
                }  
            <?php endif; ?>
            
            <?php if( is_page('blog') ) : ?>
                main {
                    padding: 2.5em 1.4em 1em;
                }
                main h2 {
                    padding-bottom: 0.2em;
                }    
                main img {
                    border-top: none;
                    border-bottom: none;
                }
            <?php endif; ?>


            <?php if ( is_page('contact-us') ) : ?>
                main {
                    background: none;
                    padding-top: 0;
                    padding-bottom: 2.5em;
                    border-top: none;
                }
                main p, main a {
                    color: white;
                    margin-bottom: 0px;
                }
                @media (min-width: 900px) {
                    aside {
                    width: 33.33333%;
                    float: right;
                    margin-right: 0;
                    margin-top: 155px;
                    }
                }  
            <?php endif; ?>

            
            <?php if( is_post_type_archive('portfolio') ) : ?>
                #portfolio {
                    background: none;
                }
                .inner-slider {
                    display: none;
                }    
                .inner-content {
                    margin-top: 0;
                }  
                aside {
                    margin-top: 0;
                }
            <?php endif; ?>
            
            <?php if( is_singular('portfolio') ) : ?>

                .author-box {
                    display: none;
                }
                #crumbs {
                    display: none;
                }
   
                .inner-content {
                    margin-top: 0;
                }

                .entry-content p:first-child {
                    font-weight: 400;
                    font-size: 1.3em;
                    color: white;
                    margin-bottom: 1em;
                }

                .entry-content p {
                    color: #909090;
                }

                main {
                    background: none;
                    border-top: none;
                }

                @media (min-width: 900px) {
                    main {
                    margin-top: 0px;
                    }
                }

                main img {
                    border-top: none;
                    border-bottom: none;
                }  
                .portfolio-services {
                    padding-left: 1.4em;
                }
                @media (min-width: 900px) {
                    .portfolio-services {
                        margin-top: 1.25em;
                    }
                } 
                aside {
                    margin-top: 0px;
                }

                .sign-off {
                    display: none;
                }

                #portfolio-main {
                    border-top: none;
                    margin-top: 0;
                }

                .addtoany_share_save_container {
                    display: none !important;
                }
            <?php endif; ?>

            <?php if( is_page('thank-you') ) : ?>
                aside {
                    display: none;
                }
                main {
                    width: 100%;
                }
            <?php endif; ?>

            <?php if( is_woocommerce() ) : ?>
                .author-box {
                    display: none;
                }
                .tabs {
                    display: none;
                }
                .inner-slider {
                    background: none;
                    background-color: #252525;
                }
            <?php endif; ?>

        </style>
    <?php wp_head(); ?>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div id="wrap">
        
    <?php get_template_part('templates/page', 'headerbar'); ?>

    <nav role="navigation">
        <?php get_template_part( 'navigation' ); ?>
    </nav>  