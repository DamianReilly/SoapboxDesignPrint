<footer id="footer" role="contentinfo" class="wow fadeInRight">
	   <div class="footer-col">
            <h4>GLASGOW SOUTH STORE</h4>
            <!-- TYPE -->
            <div itemscope itemtype="http://schema.org/ProfessionalService">
                <link itemprop="additionalType" href="http://www.productontology.org/id/Digital_printing" />
                    <div itemprop="name"><strong>Soapbox Design & Print</strong></div>
                <div itemprop="telephone">
                    <p>T: 0141 429 2942</p>
                </div>    
                <div itemprop="email">
                        E: <a href="mailto:glasgow@soapboxdigitalmedia.co.uk">glasgow@soapboxdigitalmedia.co.uk</a>
                </div>
            </div>
            <!-- SPLIT -->
                <p class="tel"><span>–</span></p>
            <!-- ADDRESS -->    
            <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                <p><span itemprop="streetAddress">614 Eglinton Street</span><br>
                <span itemprop="addressLocality">Glasgow </span>
                <span itemprop="addressRegion">Glasgow City</span><br>
                <span itemprop="postalCode">G5 9RR</span>
            </div>
            <!-- GEO -->   
            <div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
                <meta itemprop="latitude" content="55.844431" />
                <meta itemprop="longitude" content="-4.262137" />
            </div>
        </div>
        <div class="footer-col">
            <h4>GLASGOW NORTH STORE</h4>
            <!-- TYPE -->
            <div itemscope itemtype="http://schema.org/ProfessionalService">
                <link itemprop="additionalType" href="http://www.productontology.org/id/Digital_printing" />
                    <div itemprop="name"><strong>Soapbox Design & Print</strong></div>
                <div itemprop="telephone">
                    <p>T: 0141 561 7073</p>
                </div>    
                <div itemprop="email">
                        E: <a href="mailto:paisley@soapboxdigitalmedia.co.uk">paisley@soapboxdigitalmedia.co.uk</a>
                </div>
            </div>
            <!-- SPLIT -->
                <p class="tel"><span>–</span></p>
            <!-- ADDRESS -->    
            <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                    <p><span itemprop="streetAddress">968 Maryhill Road</span><br>
                    <span itemprop="addressLocality">Glasgow </span>
                    <span itemprop="addressRegion">Glasgow City</span><br>
                    <span itemprop="postalCode">G20 7TA</span>
            </div>
            <!-- GEO -->   
            <div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
                    <meta itemprop="latitude" content="55.884307" />
                    <meta itemprop="longitude" content="-4.280374" />
            </div>

        </div>
        <div class="footer-col">
            <h4>LATEST BLOGS</h4>
            <ul>
            <?php $loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 8, 'orderby' => 'date' ) ); ?>
            <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                <li><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></li>
            <?php endwhile; wp_reset_query(); ?>
            </ul>
        </div>
        <div class="footer-col-last">
            <i class="fa fa-twitter"></i><i class="fa fa-facebook"></i><i class="fa fa-google-plus"></i><i class="fa fa-linkedin"></i>
        </div>
	<div class="clearfloat"></div>
	<div class="disclaimer-text">
		<a href="/feed"><i class="fa fa-rss"></i></a> <a href="/terms-and-conditions">Terms and Conditions</a> <span> | </span> <a href="website-disclaimer"> Website Disclaimer</a> <span> | </span> <a href="privacy-policy"> Privacy Policy</a> <span> | </span> <a href="accessibility-policy"> Accessibility Policy</a> <span> | </span> <a href="site-map"> Site Map </a> <span> | </span> 
		<?php echo sprintf( __( '%1$s %2$s %3$s.  All Rights Reserved.'), '&copy;', date( 'Y' ), esc_html( get_bloginfo( 'name' ) ) ); ?>
	</div>
</footer>
</div>
<?php wp_footer(); ?>
        <script async src="/wp-content/themes/Soapbox_Digital_Media_v3/js/vendor/modernizr-2.7.1.min.js"></script>
        <script type="text/javascript">var switchTo5x=true;</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="/wp-content/themes/Soapbox_Digital_Media_v3/js/jquery.easing.min.js"></script>  
        <script type="text/javascript" src="/wp-content/themes/Soapbox_Digital_Media_v3/js/jquery.mixitup.min.js"></script>
        <script type="text/javascript">
            $(function () {
                
                var filterList = {
                
                    init: function () {
                    
                        // MixItUp plugin
                        // http://mixitup.io
                        $('#portfoliolist').mixitup({
                            targetSelector: '.portfolio',
                            filterSelector: '.filter',
                            effects: ['fade'],
                            easing: 'snap',
                            // call the hover effect
                            onMixEnd: filterList.hoverEffect()
                        });             
                    
                    },
                    
                    hoverEffect: function () {
                    
                        // Simple parallax effect
                        $('#portfoliolist .portfolio').hover(
                            function () {
                                $(this).find('.label').stop().animate({bottom: 0}, 200, 'easeOutQuad');
                                $(this).find('img').stop().animate({top: -30}, 500, 'easeOutQuad');             
                            },
                            function () {
                                $(this).find('.label').stop().animate({bottom: 0}, 200, 'easeInQuad');
                                $(this).find('img').stop().animate({top: 0}, 300, 'easeOutQuad');                               
                            }       
                        );              
                    
                    }

                };
                
                // Run the show!
                filterList.init();
                
            });
            
            $(window).scroll(function() {    
            var scroll = $(window).scrollTop();
            if (scroll >= 100) {
                $("#portfolio-top").addClass("grayscale-img")
            }
            if (scroll <= 100) {
                $("#portfolio-top").removeClass("grayscale-img");
            }
        });

        $(".slider-contact-button").click(function() {
                $('html, body').animate({
                scrollTop: $("#about").offset().top
                }, 500);
            });

        $( " div.images img" ).addClass( "aligncenter" );

        $('.disclaimer-text').after('<div class="backToTop"><a href="#">TAKE IT TO THE BRIDGE ^</a></div>');

                $(".backToTop").click(function() {
                $('html, body').animate({
                scrollTop: $(".logo").offset().top
                }, 400);
            });

            if (window.location.origin == window.location.href) {
            
                $(".mobile-c2a .contact-button").click(function() {
                $('html, body').animate({
                scrollTop: $("#about").offset().top
                }, 500);
            });
            
            }

            else {
            
                $(".mobile-c2a .contact-button").click(function() {
                $('html, body').animate({
                scrollTop: $("#innerform").offset().top
                }, 500);
            });
            
            }


        </script>
        <script src="/wp-content/themes/Soapbox_Digital_Media_v3/jquery.flexslider-min.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(window).load(function() {
            $('.flexslider').flexslider({
                animation: "slide",
                slideshowSpeed: 4000,
                touch: true
            });
        });
        </script>
        <script src="/wp-content/themes/Soapbox_Digital_Media_v3/js/wow.min.js"></script>
        <script>

              var wow = new WOW(
                  {
                    boxClass:     'wow',      // animated element css class (default is wow)
                    animateClass: 'animated', // animation css class (default is animated)
                    offset:       0,          // distance to the element when triggering the animation (default is 0)
                    mobile:       false       // trigger animations on mobile devices (true is default)
                  }
                );
                wow.init();

        </script>
</body>
</html>
