.sw-gmap-<?php echo $id; ?> {
    position: absolute;
}
.sw-gmap {
    height: <?php echo $settings->height; ?>px;
    width: 100%;
}

.draggable-holder{
    z-index: 1;
    position: relative;
    top: 0;
    margin: 5px;
    height: <?php echo $settings->height; ?>px;
    <?php if ($settings->draggable == 'false') { ?>
    width: 350px;
    <?php } else { ?>
    width: 100%;
    <?php } ?>
}

.place-card {
    -webkit-box-shadow: 0px 0px 20px -1px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 0px 20px -1px rgba(0,0,0,0.75);
    box-shadow: 0px 0px 20px -1px rgba(0,0,0,0.75);
    display: flex; 
    display: -webkit-box;
    display: -moz-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    width: 350px; 
    background-color: #fff; 
    padding: 10px;
<?php if ($settings->draggable == 'true') { ?>
    cursor: move;
<?php } ?>
}

.place-card p {
    padding: 0 20px;
}

.place-card a {
    width: 40%; 
    padding: 10px 20px; 
    text-align: center;
}
.place-card .icon {
    font-size: 24px;
}

.address-title {
    line-height: 250%;
    font-weight: bold;
}