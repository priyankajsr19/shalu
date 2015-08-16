<html>
<head>
	<script type="text/javascript"  src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript" src="http://davidjbradshaw.com/iframe-resizer/js/iframeResizer.min.js"></script>
	<style ttye="text/css">
		html, body, iframe { height: 100%; }
.fluidMedia {
    position: relative;
    padding-bottom: 56.25%; /* proportion value to aspect ratio 16:9 (9 / 16 = 0.5625 or 56.25%) */
    padding-top: 30px;
    height: 0;
    overflow: hidden;
}

.fluidMedia iframe {
    position: absolute;
    top: 0; 
    left: 0;
    width: 100%;
    height: 100%;
}
	</style>
</head>
<body>
<div class="fluidMedia">
	<iframe src="http://milaap.org/wishies/indusdiva" frameborder="0" scrolling="no" style="position:absolute;height:100%; width:100%"></iframe>
</div>
</body>
<script type="text/javascript">
	$(document).ready(function(){
		$('iframe').iFrameResize();
	});
</script>
</html>
