<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

function custom_login_logo() {
    echo '<style type="text/css">
            body{
                background-color: #d7d8d9;
                background-image: url("'. get_bloginfo( 'template_directory' ) .'/images/home-09.png");
                background-position: center center;
                background-repeat: repeat-y;
                color: #000;
                font-family: Arial,Helvetica,sans-serif;
                font-size: 10px;
            }
            .login h1 a {width: auto !important; background-image:url('. get_bloginfo( 'template_directory' ) .'/images/logo-c.png) !important; background-size: auto !important;}
            #loginform{
                    background: none repeat scroll 0 0 #fff;
                    border-radius: 10px;
                    box-shadow: 4px 4px 0 #333;
                    height: 160px;
                    padding: 10px 20px;
                    width: 260px;
            }
            #loginform p label{
                color: #939393;
                margin-bottom: 2px;
            }
            
            .input{
                background-color: #f4f4f4 !important;
                border: thin solid #9b9b9b !important;
                height: 30px !important;
                width: 260px !important;
            }
            #wp-submit{
                background-color: #000 !important;
                color: #fff !important;
                font-size: 9px !important;
                height: 25px !important;
                margin-top: -3px !important;
                border: none;
            }
            
            .login .message {
                border-left: 4px solid #EB1A1A;
            }
        </style>';
}

add_action('login_head', 'custom_login_logo');

register_nav_menus(
            array(
                'top-menu' => 'Menu superior'
            )
        );

add_theme_support('post-thumbnails');
add_image_size("slider_thumbs", 960, 351, true);
add_image_size("list_articles_thumbs", 350, 250, true);

function digwp_bloginfo_shortcode( $atts ) {
   extract(shortcode_atts(array(
       'key' => '',
   ), $atts));
   return get_bloginfo($key);
}

add_shortcode('bloginfo', 'digwp_bloginfo_shortcode');

add_action( 'wp_login_failed', 'pu_login_failed' ); // hook failed login

function pu_login_failed( $user ) {
  	// check what page the login attempt is coming from
  	$referrer = $_SERVER['HTTP_REFERER'];

  	// check that were not on the default login page
	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) {
		// make sure we don't already have a failed login attempt
		if ( !strstr($referrer, '?login=failed' )) {
			// Redirect to the login page and append a querystring of login failed
	    	wp_redirect( $referrer . '?login=failed');
	    } else {
	      	wp_redirect( $referrer );
	    }

	    exit;
	}
}
?>
