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
	<script src="js/easeljs-0.5.0.min.js"></script>
	<script src="js/tweenjs-0.3.0.min.js"></script>
	<script src="js/movieclip-0.5.0.min.js"></script>
	<script src="js/preloadjs-0.2.0.min.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/jquery-form.js"></script>
	<script src="js/jquery-validate.js"></script>
	<script src="js/jquery-fancybox.js"></script>
	<script src="js/modernizr.js"></script>
	<script src="js/app-config.js?date=<?php $date; ?>"></script>
	<script src="js/app.js?date=<?php $date; ?>"></script>
	<?php if($liked != 1) { ?>
		<script type="text/javascript" src="js/like.js?date=<?php $date; ?>"></script>
	<? } ?>

<script>
var canvas, stage, exportRoot;

Modernizr.load({
	test: Modernizr.canvas,
	nope: 'js/excanvas.compiled.js'
});

function init() {
	canvas = document.getElementById("canvas");
	images = images||{};

	var manifest = [
		{src:"images/box1_closed.png", id:"box1_closed"},
		{src:"images/box1_closed_1.png", id:"box1_closed_1"},
		{src:"images/box1_red_closed.png", id:"box1_red_closed"},
		{src:"images/box1_red_closed_1.png", id:"box1_red_closed_1"},
		{src:"images/box1_red.png", id:"box1_red"},
		{src:"images/box1.png", id:"box1"},
		{src:"images/box2_red.png", id:"box2_red"},
		{src:"images/box2.png", id:"box2"},
		{src:"images/img1.png", id:"img1"},
		{src:"images/img1_1.png", id:"img1_1"},
		{src:"images/img1_2.png", id:"img1_2"},
		{src:"images/img1_3.png", id:"img1_3"},
		{src:"images/img2.png", id:"img2"},
		{src:"images/img2_1.png", id:"img2_1"},
		{src:"images/img2_2.png", id:"img2_2"},
		{src:"images/img2_3.png", id:"img2_3"},
		{src:"images/img3.png", id:"img3"},
		{src:"images/img3_1.png", id:"img3_1"},
		{src:"images/img3_2.png", id:"img3_2"},
		{src:"images/img3_3.png", id:"img3_3"},
		{src:"images/img4.png", id:"img4"},
		{src:"images/img4_1.png", id:"img4_1"},
		{src:"images/img4_2.png", id:"img4_2"},
		{src:"images/img4_3.png", id:"img4_3"},
		{src:"images/overTheBox.png", id:"overTheBox"},
		{src:"images/overTheBox_1.png", id:"overTheBox_1"},
		{src:"images/overTheBox_2.png", id:"overTheBox_2"},
		{src:"images/overTheBox_3.png", id:"overTheBox_3"},
		{src:"images/pattern_2.jpg", id:"pattern_2"},
		{src:"images/pattern_2_1.jpg", id:"pattern_2_1"},
		{src:"images/pattern_shadow.png", id:"pattern_shadow"},
		{src:"images/pattern_shadow_1.png", id:"pattern_shadow_1"},
		{src:"images/pattern_shadow_2.png", id:"pattern_shadow_2"},
		{src:"images/pattern_shadow_3.png", id:"pattern_shadow_3"},
		{src:"images/pattern.jpg", id:"pattern"},
		{src:"images/pattern_1.jpg", id:"pattern_1"},
		{src:"images/texture_inside.jpg", id:"texture_inside"},
		{src:"images/texture_inside_1.jpg", id:"texture_inside_1"},
		{src:"images/texture_inside_2.jpg", id:"texture_inside_2"},
		{src:"images/texture_inside_3.jpg", id:"texture_inside_3"}
	];

	var loader = new createjs.PreloadJS(false);
	loader.onFileLoad = handleFileLoad;
	loader.onComplete = console.log('canvas loaded');
	loader.loadManifest(manifest);
}

function handleFileLoad(o) {
	if (o.type == "image") { images[o.id] = o.result; }
}

function handleComplete(animNum) {
	exportRoot = new lib.PassTheParcel_AllAnimations(animNum);

	stage = new createjs.Stage(canvas);
	stage.addChild(exportRoot);
	stage.update();

	createjs.Ticker.setFPS(24);
	createjs.Ticker.addListener(stage);
}
</script>

</head>

<body>

<div id="fb-root"></div>

<div id="page-wrapper">

<canvas id="canvas" width="809" height="988"></canvas>
	<div id="thedark"></div>
	<div id="thered"></div>
	<div id="finalpage"></div>

	<div id="title"></div>
	<div id="love-logo"></div>
	<div id="sydney-logo"></div>

<?php if($liked == 1) {
	require_once('pages.php'); 
} else {
	require_once('like-gate.php');
} ?>

</div>



<script src="js/parcel.js"></script>
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
