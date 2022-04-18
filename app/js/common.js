$(function() {

	$('.slider__inner').slick({
		dots: true,
		arrows: false,
		infinite: false,
		speed: 300,
		slidesToShow: 1,
	});


	$(".header__menu, .main__content-action").on("click","a", function (e) {
		e.preventDefault();
		var id  = $(this).attr('href'),
			top = $(id).offset().top;
		$('body,html').animate({scrollTop: top}, 600);
	});


	//SVG Fallback
	if(!Modernizr.svg) {
		$("img[src*='svg']").attr("src", function() {
			return $(this).attr("src").replace(".svg", ".png");
		});
	};

	//E-mail Ajax Send
	$(".form__contact").submit(function(e) { //Change
		e.preventDefault();

		var th = $(this);
		var name = $(this).find('#input_name').val();
		var email = $(this).find('#input_email').val();
		var phone = $(this).find('#input_phone').val();

		if( (name != '') && (email != '') && (phone != '') ){
			$.ajax({
				type: "POST",
				url: "mail.php", //Change
				data: th.serialize()
			}).done(function(ret) {

				console.log(ret);

				if( ret == 'success' ){
					$('.form__inner').hide('slow');
					$('.form__success').show('slow');

					setTimeout(function() {
						th.trigger("reset");
						$('.form__inner').show('slow');
						$('.form__success').hide('slow');
					}, 5000);
				}else{
					alert('Error! Maybe, You are Robot.');
				}

			}).fail(function (jqXHR, textStatus) {
				console.log('ajax fail');
			});
		}else{
			$(this).find('.error_msg').html('Error. Please, fill in all the fields form!').show();
		}

	});

});
