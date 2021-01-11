<?php 

add_shortcode( 'hours_open', 'custom_hours_open' );

function custom_hours_open( $atts ) {
	ob_start();

    $_day = date('l'); ?>

	<ul class="hours-open">
        <li class="<?php if ( $_day == 'Monday' ) echo 'open-today ua-icon-circle-check'; ?>"><b>Monday</b> <span>10:00am - 06:00pm</span></li>
        <li class="<?php if ( $_day == 'Tuesday' ) echo 'open-today ua-icon-circle-check'; ?>"><b>Tuesday</b> <span>10:00am - 06:00pm</span></li>
        <li class="<?php if ( $_day == 'Wednesday' ) echo 'open-today ua-icon-circle-check'; ?>"><b>Wednesday</b> <span>10:00am - 06:00pm</span></li>
        <li class="<?php if ( $_day == 'Thursday' ) echo 'open-today ua-icon-circle-check'; ?>"><b>Thursday</b> <span>10:00am - 06:00pm</span></li>
        <li class="<?php if ( $_day == 'Friday' ) echo 'open-today ua-icon-circle-check'; ?>"><b>Friday</b> <span>10:00am - 05:00pm</span></li>
        <li class="<?php if ( $_day == 'Saturday' ) echo 'close-today'; ?>"><b>Saturday</b> <span>CLOSED</span></li>
        <li class="<?php if ( $_day == 'Sunday' ) echo 'close-today'; ?>"><b>Sunday</b> <span>CLOSED </span></li>
    </ul>

    <?php $myvariable = ob_get_clean(); return $myvariable;

}

/***** ***** ****** ***** ***** ****** ***** ***** ***** ****** ***** ***** ****** ***** ***** ***** ****** ***** ***** ****** ***** ***** ***** ****** ***** ***** ****** *****/
/***** ***** ****** ***** ***** ****** ***** ***** ***** ****** ***** ***** ****** ***** ***** ***** ****** ***** ***** ****** ***** ***** ***** ****** ***** ***** ****** *****/
/***** ***** ****** ***** ***** ****** ***** ***** ***** ****** ***** ***** ****** ***** ***** ***** ****** ***** ***** ****** ***** ***** ***** ****** ***** ***** ****** *****/

add_shortcode( 'open_today', 'custom_open_today' );

function custom_open_today( $atts ) {
    ob_start();

    $_day = date('l');

    $current_time = date('H:i:s');
    
    $start_time = DateTime::createFromFormat('H:i:s','10:00:00');
    $start_time = $start_time->format('d/m/Y');

    $end_time = DateTime::createFromFormat('H:i:s','18:00:00');

    $friday_end_time = DateTime::createFromFormat('H:i:s','17:00:00');


    if ( ( in_array( $_day, array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday' ) ) ) && ( $current_time >= $start_time ) && ( $current_time <= $end_time ) ) : ?>
        <h4 class="open-today-with-time"><span>Open Today</span> 10:00am - 06:00pm</h4>

    <?php elseif ( ( $_day == 'Friday' ) && ( $current_time >= $start_time ) && ( $current_time <= $friday_end_time ) ) : ?>
        <h4 class="open-today-with-time"><span>Open Today</span> 10:00am - 05:00pm</h4>

    <?php elseif ( in_array( $_day, array( 'Saturday', 'Sunday' ) ) ) : ?>
        <h4 class="open-today-with-time"><span>Closed Today</span></h4>

    <?php else : ?>
        <h4 class="open-today-with-time"><span>Closed for the day</span>. We will be open tomorrow at 10:00am.</h4>

    <?php endif;

    $myvariable = ob_get_clean(); return $myvariable;

}