<div class="login-form">
    
    <?php

    $login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;

    $redirect = $settings->url_redirect;

    $args = array(
        'redirect' => $redirect, 
        'id_username' => 'user',
        'id_password' => 'pass',
    );

    wp_login_form( $args );

    ?>
    
</div>