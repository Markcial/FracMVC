<?php
ob_start(); /* template body */ ?><style type="text/css">
/*<![CDATA[*/
#gmap {
	width: 600px; 
	height: 500px;
	float:left;
}
fieldset {
	float:left;
	width:400px;
	margin-left:20px;
}
fieldset form ul li {
	margin:20px 10px;
}
/*]]>*/
</style>
<div id="gmap"></div>
<fieldset id="controls">
	<legend>Localizador estaciones</legend>
	<form action="/test/submit" method="post">
		<ul>
			<li>
				<label for="id">Id numerico : </label>
				<input type="text" class="text" name="id" />
			</li>
			<li>
				<label for="direccion">Dirección : </label>
				<input type="text" class="text" name="direccion" />
			</li>
			<li>
				<label for="coordenadas">Coordenadas : </label>
				<input type="text" class="text" name="coordenadas"  />
			</li>
			<li>
				<input type="button" class="button" name="buscar" value="buscar" />
				<input type="submit" class="submit button" name="enviar" value="enviar" />
			</li>
		</ul>
	</form>
</fieldset>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true_or_false&amp;key=ABQIAAAAoJTt8_o8nUyDU0bRqeoinBR5Fqa7o-f4Xz9RBAXVhH5TRcXLvBS8cYC0JC8BLMGXNflzRukAtZFfRg" type="text/javascript"></script>
<script type="text/javascript">
/*<![CDATA[*/
	var map = null;
	var geocoder = null;
    if (GBrowserIsCompatible()) {
		geocoder = new GClientGeocoder();
        map = new GMap2(document.getElementById("gmap"));
        map.setUIToDefault();
        map.setCenter(new GLatLng(41.400489,2.177106), 17);
	}
	
	var showAddress = function(address){
		if(geocoder){
        	geocoder.getLatLng(
	          address,
	          function(point) {
	            if (!point) {
	              //alert(address + " not found");
	              console.log(address + " not found");
	            } else {
	              map.setCenter(point, 13);
	              var marker = new GMarker(point);
	              map.addOverlay(marker);
	              marker.openInfoWindowHtml(address);
	              $('fieldset#controls form input[name=coordenadas]').val(point.y+","+point.x);
	            }
	          }
	        );
		}
	}
	
	$('fieldset#controls form input[type=button][name=buscar]').bind('click',function(){
		var direccion = $('fieldset#controls form input[name=direccion]').val();
		showAddress(direccion);
	})
/*]]>*/
</script>
<?php  /* end template body */
return $this->buffer . ob_get_clean();
?>