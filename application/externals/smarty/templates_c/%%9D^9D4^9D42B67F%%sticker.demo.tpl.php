<?php /* Smarty version 2.6.26, created on 2010-04-01 11:06:18
         compiled from sticker.demo.tpl */ ?>
<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
		<?php echo '
		<script type="text/javascript">
			/*<![CDATA[*/
			jQuery.fn.extend({
				newsTicker:function(options){
					
					settings = jQuery.extend({
						fadeInTime:2500,
						fadeOutTime:1200,
						tickerShowTimeAfterSlide:1200,
						tickerShowTime:3000,
						scrollPixelsPerSecond:40,
						headerWidth:\'120px\',
						maskedContentWidth:\'500px\'
					}, options);

			  		this.each(function(i,el){
						var tickerDiv = $(el).append(\'<div class="ticker-content" />\').find(\'div.ticker-content\');
						var ptr = 0;
						var tickers = $(el).find(\'.ticker\');
						var ticker = $(tickers[ptr]);
						var header = tickerDiv.append(\'<h3 class="ticker-title"><span class="ticker-title-content" /></h3>\').find(\'h3.ticker-title span.ticker-title-content\').hide();
						var mask = tickerDiv.append(\'<div class="ticker-mask" />\').find(\'div.ticker-mask\');
						var content = mask.append(\'<p class="ticker-inner" />\').find(\'p.ticker-inner\').hide();
						header.parent().width(settings.headerWidth);
						mask.width(settings.maskedContentWidth);
						tickerDiv.width(header.parent().outerWidth(true) + mask.outerWidth(true));
						var onTickerHided = function(){
							header.hide().html("");
							content.hide().html("");
							content.css({left:\'0px\'});
							ptr<tickers.length-1?ptr++:ptr=0;
							showTicker();
						}
						var onEndTickerShowed = function(){
							setTimeout( function(){ ticker.fadeOut(settings.fadeOutTime,onTickerHided) },settings.tickerShowTimeAfterSlide);
						}
						
						var showTicker = function(){
							ticker = $(tickers[ptr]);
							var offsetContainerWidth = mask.width();
							var headerContent = ticker.find(\'h4\').html();
							header.html(headerContent).fadeIn(settings.fadeInTime);
							var bodyContent = ticker.find(\'p\').html();
							content.html(bodyContent);
							var offsetContentWidth = content.outerWidth(true);
							content.fadeIn(settings.fadeInTime);
							var despWidth = offsetContentWidth - offsetContainerWidth;
							if(despWidth > 0 ){
								var scrollSpeed = (despWidth / settings.scrollPixelsPerSecond)*1000;
								content.animate({left:(despWidth*-1)+\'px\'},scrollSpeed,"linear",onEndTickerShowed)
							}else{
								setTimeout(onEndTickerShowed,settings.tickerShowTime);
							}
						}
						tickers.hide();
						showTicker();
					})
				}
			});
			$(document).ready(function(){
				$(\'#newsTicker\').newsTicker();
			})
			/*]]>*/
		</script>
		<style type="text/css">
			.ticker-content {
				-moz-border-radius:10px;
				-webkit-border-radius:10px;
				border-radius:10px;
				
				font-family:Tahoma,Geneva,sans-serif;
				background:#dce9f1;
				float:left;
				position:relative;
			}
			.ticker-content h3.ticker-title {
				-moz-border-radius-topleft:10px;
				-moz-border-radius-bottomleft:10px;
				-webkit-border-top-left-radius:10px;
				-webkit-border-bottom-left-radius:10px;
				border-radius-top-left:10px;
				border-radius-bottom-left:10px;
				
				border-right:2px solid white;
				
				text-align:right;
				color:#034ea1;
				font-size:14px;
				margin:0px;
				padding:7px 12px;
				background:#cdddec;
				float:left;
			}
			.ticker-content div.ticker-mask {
				float:left;
				height:30px;
				position:relative;
				margin:0px 10px;
				overflow:hidden;
			}
			.ticker-content p.ticker-inner {
				color:#555356;
				font-size:14px;
				margin:0 5px;
				padding:7px 12px;
				font-weight:bold;
				position:absolute;
				white-space:nowrap;
			}
			/*no js content*/
			.ticker {
				font-family:Tahoma,Geneva,sans-serif;
				border-bottom:1px solid #004F9F;
			}
			.ticker h4 {
				font-size:15px;
				color:#004F9F;
				padding-bottom:7px;
				margin:4px 0px;
			}
			.ticker p {
				font-size:12px;
				color:#535353;
				margin:4px 0px;
			}
			/*explorer patches*/
			.ticker-content h3.ticker-title {
				background:url(cap.left.jpg) top left no-repeat #CDDDEC\\9;
			}
			
			.ticker-content {
				background:url(cap.right.jpg) top right no-repeat #DCE9F1\\9;
			}
			
		</style>
		'; ?>

		<title>News Ticker</title>
	</head>
	<body>
		<div id="newsTicker">
			<div class="ticker"><h4>Prueba 1</h4><p>contenido dentro de la prueba 1 contenido dentro de la prueba 1 contenido dentro de la prueba 1 contenido dentro de la prueba 1 contenido dentro de la prueba 1 contenido dentro de la prueba 1 contenido dentro de la prueba 1 contenido dentro de la prueba 1 contenido dentro de la prueba 1 contenido dentro de la prueba 1 contenido dentro de la prueba 1 fiin!</p></div>
			<div class="ticker"><h4>Prueba 2</h4><p>contenido dentro de la prueba 2</p></div>
			<div class="ticker"><h4>Prueba 3</h4><p>contenido dentro de la prueba 3</p></div>
			<div class="ticker"><h4>Prueba 4</h4><p>contenido dentro de la prueba 4</p></div>
			<div class="ticker"><h4>Prueba 5</h4><p>contenido dentro de la prueba 5</p></div>
			<div class="ticker"><h4>Prueba 6</h4><p>contenido dentro de la prueba 6</p></div>
		</div>
	</body>
</html>