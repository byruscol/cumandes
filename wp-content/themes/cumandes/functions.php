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

function ad_login_footer() {
    $ref = wp_get_referer();
    if ($ref) :
?>
<script type="text/javascript">
    var list = document.getElementById("backtoblog").getElementsByTagName("a");
    list[0].href = "http://www.cumandes.com";
</script>
<?php
    endif;
}

add_action('login_head', 'custom_login_logo');
add_action('login_footer', 'ad_login_footer');



?>
