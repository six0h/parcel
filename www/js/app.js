/*///////////////*/
/*
/* AUTHOR:	Cody Halovich (cody at telenova dot ca)
/* CLIENT:	Chillspace Print. Web. IT. for Think! Social Media
/* PROJECT:	Love Ottawa
/*
/* DO NOT EDIT THIS DOCUMENT OR ANY FILES RELATED TO THE PARENT PROJECT WITHOUT PERMISSION OF THE AUTHOR.
/*
/*///////////////*/
var imgLoaded = 0,date = new Date();

init();

$(function() { // ENCAPSULATE EVERYTHING IN JQUERY, EVEN FUNCTIONS

function preloader() {

	var i = 0;

	imageObj = new Image();

	images = [
		'img/photos/img1.png',
		'img/photos/img2.png',
		'img/photos/img3.png',
		'img/photos/img4.png',
		'img/panels/discover.png',
		'img/panels/events.png',
		'img/panels/lovesydney.png'
	];

	for(i=0;i<images.length;i++) {
		imageObj.src=images[i];
	}

}

preloader();
/*///////////////////////////////////////////////
/*///////////////////////////////////////////////
// GLOBALS FIRST
/*///////////////////////////////////////////////
/*///////////////////////////////////////////////


// DEFINE GLOBALS
	var	pages = $('#page-wrapper>div'),
		page_tab = 'https://apps3.ionflo.com/passtheparcel/www/home.php',
		channel = '//apps3.ionflo.com/passtheparcel/www/channel.html',
		app_id = '498809820144045',
		user_info = '',
		user_id = '',
		access_token = '',
		animated = 0,
		played = 0;

	var i = 1250;

/*///////////////////////////////////////////////
/*
/* LIKE GATE 
/*
/*///////////////////////////////////////////////

	$('#title').delay(i).animate({'top':'180px'}, 'easeOutQuad').animate({'top':'130px'});
	i = i+100;

	$('#love-logo').delay(i).animate({'left':'50px'}, 'easeOutQuad').animate({'left':'30px'});
	i = i + 100;

	$('#sydney-logo').delay(i).animate({'right':'50px'}, 'easeOutQuad').animate({'right':'30px'});


/*///////////////////////////////////////////////
/*
/* WELCOME 
/*
/*///////////////////////////////////////////////

	function showEnter() {
		$('#enter').css('opacity',0).show().animate({'top':'30px','opacity':0.75}, 'easeOutQuad').animate({'top':'0px','opacity':1,'display':'block'});
	}

	$('.auth').live('click', function() {
		FB.login(function(response) {
			// auth change is monitored by facebook init, no need for a callback here
		}, {scope: 'email,publish_stream'});
	});

	$('.openParcel').live('click', function() {
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: 'ajax/roll.php',
			data: user_info,
			error: function(res) {
				console.log(res);
			},
			success: function(res) {
				console.log(res);
				if(res.status == 200) {
					$('#enter').animate({'top':'+=20px','opacity':0.8}).animate({'top':'-300px','opacity':0});
				} else if(res.status == 999) {
					$('#enter').animate({'top':'+=20px','opacity':0.8}).animate({'top':'-300px','opacity':0}, function() {
						$(this).hide().css('opacity',1);
					});
					$('#result h1').html('Congratulations!')
					$('#result p').html("You've just opened the winning parcel. Now that's got to be a reason to Love Every Second of Sydney in Summer!<br/><br/>We just need a little information so we can send your prize to you.")
									.css('font-size','1.1em');;
					$('#result .button-small, #result #result-btn').hide();
					$('#result').append('<a href="#" id="winEnter" class="button-link">Enter your info <span class="arrow">&gt;</a>');
					$('#result .button-link').css('left','-=10px');
					$('#first_name').val(user_info.first_name);
					$('#last_name').val(user_info.last_name);
					$('#email').val(user_info.email);
					$('#location').val(user_info.location.name);
					$('#fbid').val(user_info.id);
					setTimeout(function() {
						fireAnim();
					}, 1000);
					setTimeout(function() {
						$('#result').css('opacity',0).show().animate({
							'top': '0px',
							'opacity': 1
						}).find('p').css('opacity',1);
					}, 3000);
				} else if(res.status == 201) {
					$('#enter').animate({'top':'+=20px','opacity':0.8}).animate({'top':'-300px','opacity':0});
					$('#result .copy-box h1').html('Not this time!');
					$('#result .copy-box p').html("Sorry that wasn't the lucky layer. But, if you want to have another go, just Pass the Parcel to a friend for the chance to open it again.");
					if(res.num_plays == 2) {
						$('#result h1').html("Still not the one. Better Luck Tomorrow.").css('font-size','1.2em');
						$('#result .copy-box p').html("We've got more parcels with more great Sydney experiences every day. So, remember to come back tomorrow and have another go.<br/><br/>In the meantime, click find out more and discover what Sydney has to offer.").css('font-size','0.9em');
						$('#result .button-small, #result #result-btn').hide();
						$('#result').append('<a href="#" id="finalBtn" class="button-link">Continue <span class="arrow">&gt;</a>').css('margin-left');
					}
					setTimeout(function() {
						$('#result').css('opacity',0).show().animate({
								'top': '0px',
								'opacity': 1
						}).find('p').css('opacity',1);
					}, 1000);
					setTimeout(function() {
						fireAnim();
					}, 3000);
				} else if(res.status == 203) {
					finalPage();
// WRITE CODE TO FORWARD TO THE FINAL PAGE HERE
// USER HAS ALREADY PLAYED TWICE AND GOT THROUGH SOMEHOW


				} else {
					for(err in res.errors) {
						console.log(res);
					}
				}
			}
		});	
	});

	// SHOW THE WINNER FORM
	$('#winEnter').live('click', function() {

		$('#canvas').animate({'opacity':0}, function() {
			$(this).hide();
		});

		$('#result').animate({
			'opacity':0,
			'top':'-=10px'
		}, function() {
			$(this).hide();
		});

		$('#winner-form').show().animate({
			'opacity':1,
			'top':'-=10px'
		});

	});

	// FUNCTION WRAPPER FOR FACEBOOK CODE
	function appRequest(callback) {
		FB.ui({
			method: 'apprequests',
			message: 'Unwrap the parcel and love every second of Sydney in Summer!',
			title: 'Pass the Parcel'
		}, callback)
	}

	// FACEBOOK SHARE W/ CALLBACK
	$('#result-btn').click(function() {
		appRequest(function(res) {
			if(res != undefined) {
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: 'ajax/recordshare.php',
					data: user_info,
					success: function(response) {
						console.log(response);
						if(response.status == 200) {
							$('#result').animate({
								'top': '10px',
								'opacity': 0
							}).hide();
						}
						$('#canvas').animate({
							'opacity': 0,
							'visibility': 'hidden'
						})
						$('#thered').fadeIn();
						registration();
					},
					error: function(response) {
						console.log(response);
						for(err in response.errors) {
							console.log(err);
						}
					}
				})
			}
		});
	});

	// SHOW SHARING BOX
	function showShare() {
			$('#result').css('opacity', 0).show().animate({
				'top': '0px',
				'opacity': 1
			});
	}

	// REGISTER USER
	function registration() {

		$.ajax({
			type: "POST",
			dataType: 'json',
			url: 'ajax/register.php',
			data: user_info,
			success: function(response) {
				console.log(response);
				user_info.access_token = response.access_token;
				user_info.expiry = response.expiry;
				user_info.salt = response.salt;
				if(response.status == 200) {
					$('#auth-btn')
						.html('Open the Parcel <span class="arrow">&gt;</span>')
						.fadeIn();
					$('#enter .copy-box h1').html(user_info.first_name + ', open the parcel for your chance to Love Every Second of Sydney In Summer');
					showEnter();
					$('#fbid').val(user_info.id);
				} else if (response.status == 201) {
					setTimeout(function() {
						showShare();
						fireAnim();
					}, 1000);
				} else if (response.status == 202) {
					$('#enter .copy-box h1').html(user_info.first_name + ', open the parcel one more time for your chance to Love Every Second of Sydney in Summer');
					$('#thered').fadeIn();
					$('#auth-btn').html('Open the Parcel <span class="arrow">&gt;</span>').fadeIn();
					played = 1;
					showEnter();
				} else if (response.status == 203) {
					finalPage();
				}
			},
			error: function(response) {
				console.log(response.responseText);
			}
		});

	}

	// VALIDATOR OPTIONS
	var validOptions = {
               
	        rules: {
                    first_name: "required",
                    last_name: "required",
                    email: {
                            required: true,
                            email: true
                    },
                    location: "required",
                    postal: "required",
					agree: "required"
                },

            messages: {
                    first_name: "Please provide your first name.",
                    last_name: "Please provide your last name.",
                    email: {
                            required: "Please provide your email address.",
                            email: "Please provide a valid email address."
	                },
	                location: "Please tell us what city you're in.",
	                postal: "Please provide your postal code.",
					agree: "Please agree to the terms and conditions."
                },

		errorPlacement: function(error, element) {
			error.appendTo( element.parent('li') );
		},
		wrapper: 'span',
		onkeyup: false, // DO NOT VALIDATE ON KEYUP, WAIT UNTIL BLUR

		// IF VALIDATE IS SUCCESSFUL, SUBMIT THE FORM WITH JQUERY FORM
		submitHandler: function(form) {
			// HIJACK DOS FORM AND SUBMIT THROUGH AJAX
			$(form).ajaxSubmit({
				dataType: 'json',
				success: function(res) {
					console.log(res);
					if(res.status == 200) {
						$('#winner-form').animate({'top':'+=20px','opacity':0}, function() {
							$(this).hide();
						});
						finalPage('win');
					} else if (res.status == 500) {
						console.log(error);
						alert("There was a server error. Please try again.");
					} else {
						for(err in res.errors) console.log(err);
					}
				},

				error: function(res) {
					alert('error');
				}
			});
		}

	};

	$('#winner-form form').validate(validOptions);

	$('#finalBtn').live('click', function() {
		$('#result').fadeOut();
		finalPage();
	});

	$('.button-small').live('click', function() {
		finalPage();
	});

	function finalPage(state) {
		$('#result').css('display','none');
		$('#canvas').css('opacity',0);
		$('#finalpage').fadeIn();

		if(state != 'win') {
			$('#finalPage h1')
				.css({'margin-top':'15px','margin-bottom':'20px'})
				.html('Discover the vibrancy of Sydney');
			$('#finalPage h2').css('display','none');
			$('#finalPage p').css({'font-size':'1em','padding': '0 20px'}).html('See Sydney shine in summer with its spectacular line up of events, relaxed outdoor and beach lifestyle and dazzling display of nature and parks. Visit <a href="http://www.sydney.com/" target="_blank">sydney.com</a> to start planning your next trip.')
			$('#finalPage').fadeIn();
		} else {
			$('#finalPage h1')
				.css({'margin-top':'10px','margin-bottom':'5px'})
				.html('Congratulations.');
			$('#finalPage h2').css({'display':'block','font-size':'1.1em'}).html("We'll contact you shortly with your prize details.");
			$('#finalPage p')
				.css({'font-size':'1em','padding': '0 20px'})
				.html('See Sydney shine in summer with its spectacular line up of events, relaxed outdoor and beach lifestyle and dazzling display of nature and parks. Visit <a href="http://www.sydney.com/" target="_blank">sydney.com</a> to start planning your next trip.')
			$('#finalPage').fadeIn();
		}
	}

//	var fireAnim = function() {
//		this.winner = function() {
//			$('#img1,#img2,#img3,#img4').css({'top':'500px','left':'304px','display':'none'}).parent('#photos').show();
//			$('#img1').animate({'left':'44px','top':'330px'});
//			$('#img2').animate({'left':'210px','top':'230px'});
//			$('#img3').animate({'left':'410px','top':'234px'});
//			$('#img4').animate({'left':'530px','top':'327px'});
//		}
//
//		this.loser = function() {
//			$('#img1').css({'top':'330px','left':'-400px'});
//			$('#img2').css({'top':'230px','left':'-400px'})
//			$('#img3').css({'top':'234px','left':'-400px'})
//			$('#img4').css({'top':'327px','left':'-400px'})
//			$('#photos').show();
//			$('#img1').animate({'left':'44px','top':'330px'});
//			$('#img2').animate({'left':'210px','top':'230px'});
//			$('#img3').animate({'left':'410px','top':'234px'});
//			$('#img4').animate({'left':'530px','top':'327px'});
//		}
//
//		this.hide = function() {
//			$('#photos').fadeOut();
//		}
//	};


/*///////////////////////////////////////////////
/*
/* Initialize Facebook 
/*
/*///////////////////////////////////////////////


	fbInit();

	function fbInit() {
		
		  window.fbAsyncInit = function() {
		     
			var animated = 0;
		     FB.init({
		      appId	 : app_id,	
		      channelUrl : channel, // Channel File
		      status     : true, // check login status
		      cookie     : true, // enable cookies to allow the server to access the session
		      xfbml      : true,  // parse XFBML
		      oauth	 : true
		    });

		    // MAKE CANVAS AUTOGROW
		    FB.Canvas.setAutoGrow();

		    FB.Event.subscribe('auth.statusChange', function(response) {
		    	if(response.status == 'connected') {
				access_token = response.authResponse.accessToken;
				user_id = response.authResponse.userID;
				$('#auth-btn')
					.removeClass('auth')
					.addClass('openParcel')
					.fadeOut();

				FB.api('/me', function(response) {
					user_info = response;
					user_info.access_token = access_token;
					registration();
				});
			} else {
				showEnter();
				animated = 1;
			}
		    });

		  };

		  // Load the SDK Asynchronously
		  (function(d){
		     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
		     if (d.getElementById(id)) {return;}
		     js = d.createElement('script'); js.id = id; js.async = true;
		     js.src = "//connect.facebook.net/en_US/all.js";
		     ref.parentNode.insertBefore(js, ref);
		   }(document));
	}

});

