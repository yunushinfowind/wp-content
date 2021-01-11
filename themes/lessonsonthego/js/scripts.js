jQuery(function($){
	
	if(navigator.appVersion.indexOf("Edge") != -1){
		document.documentElement.className += " edge";
	}

	$('#shiftnav-toggle-main-button').click(function() {
		// $(this).fadeOut();
	});

	$('.shiftnav-panel-close').click(function() {
		// $('#shiftnav-toggle-main-button').fadeIn();
	});

	var screen 					= $('.site-container').width(),
		_form 					= $('.fl-node-5b50eaa9c21d0'),
		_text 					= $('.fl-node-5b50eb54524a5'),
		_footer_logos 			= $('.fl-node-5b50e05374703'),
		_footer_links 			= $('.fl-node-5b50e0537467f'),
		_footer_contact 		= $('.fl-node-5b50e053746c5'),
		_easy_to				= $('.fl-node-5b4fc16188ce7'),
		_let_us					= $('.fl-node-5b4fb9e0bfccb'),
		_custom_tailored		= $('.fl-node-5b4fc12744c3a'),
		_a_local				= $('.fl-node-5b4fc0ff63bd2'),
		_temp_form 				= _text.clone(),
		_temp_text 				= _form.clone(),
		_temp_footer_logos		= _footer_contact.clone(),
		_temp_footer_links		= _footer_logos.clone(),
		_temp_footer_contact	= _footer_links.clone(),
		_temp_let_us			= _easy_to.clone(),
		_temp_a_local			= _let_us.clone(),
		_temp_easy_to			= _a_local.clone();

	if( screen <= 414 )
	{
		$('.fl-node-5b4fa2b30d9ed .fl-heading-text').html("Music Lessons In <br/>Your <em>Home</em>");
		_form.replaceWith( _temp_form );
		_text.replaceWith( _temp_text );
		_footer_links.replaceWith( _temp_footer_links );
		_footer_contact.replaceWith( _temp_footer_contact );
		_footer_logos.replaceWith( _temp_footer_logos );
		_easy_to.replaceWith( _temp_easy_to );
		_let_us.replaceWith( _temp_let_us );
		_a_local.replaceWith( _temp_a_local );
	}


	//SHARE BUTTONS IN SINGLE BLOG PAGE
	if ($('.share-buttons').length) {
		var top = $('.share-buttons').offset().top - $('#navbar').height() + $('#wpadminbar').height();

		$(window).bind('scroll', function() {
			if ($(window).width() > 767) {

				if ($(window).scrollTop() > top) {
					$('.share-buttons').addClass('fixed');
					$('.share-buttons').css('top', $('#navbar').height() + $('#wpadminbar').height() + 100 + 'px');
				} else {
					$('.share-buttons').removeClass('fixed');
					$('.share-buttons').css('top', '');
				}
			}

		});
	}

	//end of SHARE BUTTONS 
	
	$(".popupaoc-link").css("pointer-events", "none");
	$('.teacherform input').blur(function()
	{
		if( !$(this).val() ) {
			  $(".popupaoc-link").css("pointer-events", "none");
		} else {
			$(".popupaoc-link").css("pointer-events", "auto");
		}
	});
	
});