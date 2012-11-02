
var canvas, stage, exportRoot;

function init() {
	canvas = document.getElementById("canvas");
	images = images||{};

	var manifest = [
		{src:"images/box1_closed.png", id:"box1_closed"},
		{src:"images/box1_red_closed.png", id:"box1_red_closed"},
		{src:"images/box1_red.png", id:"box1_red"},
		{src:"images/box1.png", id:"box1"},
		{src:"images/box2_red.png", id:"box2_red"},
		{src:"images/box2.png", id:"box2"},
		{src:"images/pattern_2.jpg", id:"pattern_2"},
		{src:"images/pattern_shadow.png", id:"pattern_shadow"},
		{src:"images/pattern.jpg", id:"pattern"},
		{src:"images/texture_inside.jpg", id:"texture_inside"}
	];

	var loader = new createjs.PreloadJS(false);
	loader.onFileLoad = handleFileLoad;
	loader.onComplete = handleComplete;
	loader.loadManifest(manifest);
}

function handleFileLoad(o) {
	if (o.type == "image") { images[o.id] = o.result; }
}

function handleComplete() {

	exportRoot = new lib.PassTheParcel_AllAnimations();

	stage = new createjs.Stage(canvas);
	stage.addChild(exportRoot);
	stage.update();

	createjs.Ticker.setFPS(24);
	createjs.Ticker.addListener(stage);

}

function fireAnim() {

	exportRoot.instance_2;

}
