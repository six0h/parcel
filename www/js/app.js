/*///////////////*/
/*
/* AUTHOR:	Cody Halovich (cody at telenova dot ca)
/* CLIENT:	Chillspace Print. Web. IT. for Think! Social Media
/* PROJECT:	Love Ottawa
/*
/* DO NOT EDIT THIS DOCUMENT OR ANY FILES RELATED TO THE PARENT PROJECT WITHOUT PERMISSION OF THE AUTHOR.
/*
/*///////////////*/

$(function() { // ENCAPSULATE EVERYTHING IN JQUERY, EVEN FUNCTIONS

/*///////////////////////////////////////////////
/*///////////////////////////////////////////////
// OK, LETS TAKE CARE OF GLOBAL STUFF FIRST
/*///////////////////////////////////////////////
/*///////////////////////////////////////////////


// DEFINE GLOBALS
	var	pages = $('#page-wrapper>div'),
		page_tab = 'https://home.codyhalovich.com/nsw/www/home.php',
		channel = '//home.codyhalovich.com/nsw/www/channel.html',
		app_id = '352599924799511',
		user_info = '',
		user_id = '';

	var i = 300;


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
		$('#enter').animate({'top':'30px'}, 'easeOutQuad').animate({'top':'0px'});
	}

	$('.auth').live('click', function() {
		FB.login(null, {scope: 'email,publish_stream'});
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
				} else {
					for(err in res.errors) {
						
					}
				}
			}
		});	
	});

//INITIALIZE FACEBOOK
	fbInit();

	function fbInit() {
		  window.fbAsyncInit = function() {
		     
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
				$('#auth-btn')
					.removeClass('auth')
					.addClass('openParcel')
					.fadeOut()
					.html('Open the Parcel <span class="arrow">&gt;</span>')
					.fadeIn();
				FB.api('/me', function(response) {
					$('#enter .copy-box h1').html('Hi, ' + response.first_name + '! <br />Open the parcel for your chance to Love Every Second of Sydney In Summer');
					user_info = response;
				});
			}
			showEnter();
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
