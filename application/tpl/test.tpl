<!doctype html>
<html>
	<head>
		<title>HTML5 test</title>
	</head>
	<body>
	<video id="videoPlayer" currentTime="204" autoplay autobuffer src="http://v18.lscache5.c.youtube.com/videoplayback?ip=0.0.0.0&sparams=id%2Cexpire%2Cip%2Cipbits%2Citag%2Calgorithm%2Cburst%2Cfactor%2Coc%3AU0dWRVBQUl9FSkNNNl9ISlZJ&fexp=906600%2C901801&algorithm=throttle-factor&itag=18&ipbits=0&burst=40&sver=3&expire=1270054800&key=yt1&signature=25DF1FC57C45F9A16F8CFF240694DEB61D1A1719.30866B26A5561FA101E74B8C991D337C4AFDE41D&factor=1.25&id=87e9262e47c5aed5"></video>
		{literal}
		<script type="text/javascript">
			function $(elm){return document.getElementById(elm)};
			var firstVid = "";
			var secVid = "http://v21.lscache1.c.youtube.com/videoplayback?ip=0.0.0.0&sparams=id%2Cexpire%2Cip%2Cipbits%2Citag%2Calgorithm%2Cburst%2Cfactor%2Coc%3AU0dWRVBQUl9FSkNNNl9ISlZJ&fexp=906600%2C901801&algorithm=throttle-factor&itag=18&ipbits=0&burst=40&sver=3&expire=1270054800&key=yt1&signature=A53001613F062EC97F89A0BFE42239650BE6222E.42C6A86F746786B1A627B4EAC7B077CDCC24720F&factor=1.25&id=9986573551d57e17";
			var vid = $('videoPlayer');
			window.onload = function(){
				vid.addEventListener("oncanplay", function(e){
					console.log("on play!")
					vid.currentTime = 207;
				}, true);
				vid.addEventListener("onend", function(evt){
					console.log('playing next video!');
					vid.src = secVid;
				}, true);
			}
		</script>
		{/literal}
	</body>
</html>