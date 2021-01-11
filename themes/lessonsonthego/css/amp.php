<?php
/* NOTE:

AMP styles must be inline. Which is why we including this file at Iniit. Which then runs the function below to file the 

//* Enqueue stylesheet for AMP */
add_action('amp_post_template_css','ampforwp_add_custom_css_example', 11);
function ampforwp_add_custom_css_example() { 

/* Set color variables for quick and easy customization */
$bg_color           = "#044e6c";
$text_color         = "#2a2a2a";
$link_color         = "#0f6687";
$link_hover_color   = "#044e6c";
$heading_color      = "#044e6c";
$custom_color       = "#f1f1f1";
$custom_color2      = "#065f83";

?>

    /******* Thrive Custom CSS *******/

    /******* Default Styles */  
    body {
        background-color: <?php echo $bg_color; ?>;
    }

    body,
    p,
    ul li,
    ol li,
    .the_content p {
        color: <?php echo $text_color; ?>;
    }

    a {
        color: <?php echo $link_color; ?>;
    }

    a:hover {
        color: <?php echo $link_hover_color; ?>;
        text-decoration: underline;
    } 

    h1, h2, h3, h4, h5, h6 {
        color: <?php echo $heading_color; ?>;
    }

    main .amp-wp-content {
        background: #fff;
    }

    /******* Header (Logo Area) */
    body #header {
        background: <?php echo $custom_color; ?> none repeat scroll 0 0;
        text-align: center;
    }

    /******* Navigation */
    .nav_container a:hover {
        color: #fff;
        text-decoration: none;
    }

    .nav_container:hover {
        background-color: <?php echo $custom_color2; ?>;
    }

    /******* Logo */
    .amp-wp-content amp-img {
        margin: 5px;
    }

    body .amp-logo {
    }

    /******* Content */

    h1.amp-wp-title {
        font-size: 1.75em;
    }

    h2 {
        font-size: 1.25em;
    }

    .related_posts h3, 
    .comments_list h3 {
        font-size: 17px;
    }

    .single-post main {
        background: <?php echo $custom_color; ?> none repeat scroll 0 0;
        margin: 0 auto;
        padding: 12px 0 10px;
        width: 100%;
    }

    article {
        margin: 0 auto;
        max-width: 640px;
        padding: 0 20px;
    }

    /******* Hide Comment not working for some reason */
    body .comment-button-wrapper {
        display: none;
    }

    /******* Related Posts Styles */
    ul.related_post {
        margin: 0px;
        padding: 0px;
    }

    body ul.related_post li {
        display: inline-block;
        padding: 0 4% 20px 0;
        position: relative;
        vertical-align: top;
        width: 46%;
    }

    .related_posts .related_link a {
        color: <?php echo $link_color; ?>
    }
        
    .related_posts ol li p {
        color: <?php echo $text_color; ?>
    }

    /******* Custom Banner appended to bottom of content */

    .amp-custom-banner-after-post {
        border-top: 4px solid <?php echo $heading_color; ?>;
        margin-top: 20px;
        padding: 0 0 10px;
        text-align: center;
    }

    .amp-custom-banner-after-post > h2 {
        margin-bottom: 5px;
    }

    /******* Amp Comment Button, can be used on custom banners and content */

    .button,
    .ampforwp-comment-button {
        display: table;
        background: <?php echo $link_hover_color; ?>;
        border: medium none;
        border-radius: 0;
        color: #fff;
        font-weight: 900;
        padding: 12px 22px;
        text-decoration: none;
        text-shadow: none;
        text-transform: uppercase;
        margin: 0px auto;
    }

    .button:hover,
    .ampforwp-comment-button:hover {
        background-color: <?php echo $custom_color2; ?>;
        color: #fff;
        text-decoration: none;
    }

    /******* Footer */

    #footer {
        background: <?php echo $bg_color; ?> none repeat scroll 0 0;
        font-size: 14px;
        padding: 20px 0;
        text-align: center;
    }

    #footer p {
        color: #fff;
    }

    #footer p:first-child {
        margin-bottom: 22px;
    }

    #footer a { 
        color: #fff;
    } 

<?php 
}
