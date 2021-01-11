<?php
$address = $settings->center_address;
$addressTitle = (strstr($address, ',') ? substr($address, 0, strpos($address, ',')) : $address);
?>
<div class="sw-gmap sw-gmap-<?php echo $id; ?>"></div>
<?php if ($settings->placecard != 'false') { ?>
    <div class="draggable-holder">
        <div class="place-card">
            <p><span class="address-title"><?php echo $addressTitle; ?></span><br /><?php echo $address; ?></p>
            <a target="_blank" href="//maps.google.com/?q=<?php echo $address; ?>"><i class="icon <?php echo $settings->map_icon; ?>"></i><br/>Directions</a>
        </div>
    </div>
<?php } ?>