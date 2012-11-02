<?php
require_once('../config.php');
require_once( BASE_PATH . 'functions.php');
require_once( BASE_PATH . 'sdk/facebook-sdk/facebook.php');
date_default_timezone_set('Australia/Sydney');

$banned = check_bans();
if($banned > 0) {
	?>
	<script type="text/javascript">
		alert('Sorry, you are not eligible to enter.');
	</script>
	<?php

	exit();
}

$date = date('U'); $time = date('U');

$creds = array( // FACEBOOK APP CREDS
        'appId' => APP_ID,
		'secret' => APP_SECRET,
		'cookie' => true
);

// INIT FACEBOOK
$facebook = new Facebook($creds);
$sr = $facebook->getSignedRequest(); // GET SIGNED REQUEST FROM FB

// FIND OUT IF USER LIKED PAGE
$liked = $sr['page']['liked'];


?>

<!DOCTYPE html>
<html>

<head>

	<title></title>
	<meta charset="utf-8" />

	<link rel="stylesheet" type="text/css" href="css/style.css?date=<?php $date; ?>" />
	<link rel="stylesheet" type="text/css" href="css/fonts.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" />

	<script src="js/html5shiv.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/jquery-form.js"></script>
	<script src="js/jquery-validate.js"></script>
	<script src="js/jquery-fancybox.js"></script>
	<script src="js/modernizr.js"></script>

<script>
Modernizr.load({
	test: Modernizr.canvas,
	yep: 'js/app.js',
	nope: 'js/app-ie.js'
});
</script>

</head>

<body>

<div id="fb-root"></div>

<div id="page-wrapper">

	<div id="thedark"></div>
	<div id="thered"></div>
	<div id="finalpage"></div>

	<div id="title"></div>
	<div id="love-logo"></div>
	<div id="sydney-logo"></div>

	<div id="spriteBox"></div>

<?php if($liked == 1) {
	require_once('pages.php'); 
} else {
	require_once('like-gate.php');
} ?>


</div>

<script src="js/sydneypl.js"></script>
<script src="js/app-config.js?date=<?php $date; ?>"></script>
<script src="js/app.js?date=<?php $date; ?>"></script>
<?php if($liked != 1) { ?>
	<script type="text/javascript" src="js/like.js?date=<?php echo $date; ?>"></script>
<? } ?>

<script type="text/javascript">

	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-25465482-1']);
	_gaq.push(['_setDomainName', 'ionflo.com']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();

</script>

</body>
</html>

