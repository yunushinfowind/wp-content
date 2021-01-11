.masonry {
    margin: <?php echo $settings->item_margin; ?>em 0;
    padding: 0;
    -moz-column-gap: <?php echo $settings->item_margin; ?>em;
    -webkit-column-gap: <?php echo $settings->item_margin; ?>em;
    column-gap: <?php echo $settings->item_margin; ?>em;
    font-size: .85em;
}

.item {
    display: inline-block;
    background: #<?php echo $settings->item_bg_color; ?>;
    padding: <?php echo $settings->item_padding; ?>em;
    margin: 0 0 <?php echo $settings->item_padding; ?>em;
    width: 100%;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-shadow: 0px 1px 1px 0px #<?php echo $settings->item_shadow; ?>;
    border-radius: 3px;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
}

@media only screen and (min-width: 400px) {
    .masonry {
        -moz-column-count: <?php echo $settings->mobile; ?>;
        -webkit-column-count: <?php echo $settings->mobile; ?>;
        column-count: <?php echo $settings->mobile; ?>;
    }
}

@media only screen and (min-width: 700px) {
    .masonry {
        -moz-column-count: <?php echo $settings->tablet; ?>;
        -webkit-column-count: <?php echo $settings->tablet; ?>;
        column-count: <?php echo $settings->tablet; ?>;
    }
}

@media only screen and (min-width: 900px) {
    .masonry {
        -moz-column-count: <?php echo $settings->laptop; ?>;
        -webkit-column-count: <?php echo $settings->laptop; ?>;
        column-count: <?php echo $settings->laptop; ?>;
    }
}

@media only screen and (min-width: 1100px) {
    .masonry {
        -moz-column-count: <?php echo $settings->desktop; ?>;
        -webkit-column-count: <?php echo $settings->desktop; ?>;
        column-count: <?php echo $settings->desktop; ?>;
    }
}

h<?php echo $settings->title_class; ?>.sw-pin-title {
    text-align: <?php echo $settings->title_align; ?>;
}

h<?php echo $settings->title_class; ?>.sw-pin-title a{
    color: #<?php echo $settings->title_color; ?>;
    font-family: <?php echo $settings->title_font['family']; ?>;
    font-weight: <?php echo $settings->title_font['weight']; ?>;
    text-decoration: none;
}

h<?php echo $settings->title_class; ?>.sw-pin-title a:hover{
    color: #<?php echo $settings->title_color_hover; ?>;
    text-decoration: none;
}

.item p{
    color: #<?php echo $settings->excerpt_color; ?>;
    font-family: <?php echo $settings->excerpt_font['family']; ?>;
    font-weight: <?php echo $settings->excerpt_font['weight']; ?>;
    text-align: <?php echo $settings->excerpt_align; ?>;
}

.masonry .readmore {
    text-align: <?php echo $settings->more_align; ?>;
    margin: <?php echo $settings->more_margin_top; ?>px <?php echo $settings->more_margin_side; ?>px;
}

.masonry .readmore a {
    color: #<?php echo $settings->more_color; ?>;
    background-color: #<?php echo $settings->more_bg_color; ?>;
    border-radius: #<?php echo $settings->more_border; ?>px;
    font-family: <?php echo $settings->more_font['family']; ?>;
    font-weight: <?php echo $settings->more_font['weight']; ?>;
    padding: <?php echo $settings->more_padding_top; ?>px <?php echo $settings->more_padding_side; ?>px;
    text-decoration: none;
}

.masonry .readmore a:hover {
    color: #<?php echo $settings->more_color; ?>;
    background-color: #<?php echo $settings->more_bg_color; ?>;
    border-radius: #<?php echo $settings->more_border; ?>px;
    font-family: <?php echo $settings->more_font['family']; ?>;
    font-weight: <?php echo $settings->more_font['weight']; ?>;
    padding: <?php echo $settings->more_padding_top; ?>px <?php echo $settings->more_padding_side; ?>px;
    text-decoration: none;
}

.fl-node-<?php echo $id; ?> .masonry-navbar {
    display: -webkit-box;
    display: -moz-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    justify-content: <?php echo $settings->nav_align; ?>
}

.fl-node-<?php echo $id; ?> .masonry-navbar a {
    color: #<?php echo $settings->nav_color; ?>;
    text-decoration: none;
    background-color: #<?php echo $settings->nav_bg_color; ?>;
    padding: <?php echo $settings->nav_padding_top; ?>px <?php echo $settings->nav_padding_side; ?>px;
    border-radius: <?php echo $settings->nav_border; ?>px;
    margin: 0 <?php echo $settings->nav_margin; ?>px;
}

.fl-node-<?php echo $id; ?> .masonry-navbar a:hover {
    color: #<?php echo $settings->nav_hover_color; ?>;
    background-color: #<?php echo $settings->nav_hover_bg_color; ?>;
}

.fl-node-<?php echo $id; ?> .masonry-navbar a.active {
    color: #<?php echo $settings->nav_active_color; ?>;
    background-color: #<?php echo $settings->nav_active_bg_color; ?>;
}