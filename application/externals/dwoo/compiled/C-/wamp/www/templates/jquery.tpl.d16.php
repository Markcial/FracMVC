<?php
ob_start(); /* template body */ ?><style type="text/css">
/*<![CDATA[*/
ul#tabs {
display:block;
border:1px solid black;
}
ul#tabs li {
display:inline-block;
width:120px;
border:1px solid red;
}
ul#tabs li:hover {
-webkit-transform-origin:0 0;
-webkit-transform: rotate(90deg);
-webkit-transition: -webkit-transform .15s linear
}
/*]]>*/
</style>
<ul id="tabs">
	<li>Menu 1</li>
	<li>Menu 2</li>
	<li>Menu 3</li>
	<li>Menu 4</li>
	<li>Menu 5</li>
	<li>Menu 6</li>
</ul><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>