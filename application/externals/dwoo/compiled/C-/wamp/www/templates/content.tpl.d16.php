<?php
if (function_exists('Dwoo_Plugin_include')===false)
	$this->getLoader()->loadPlugin('include');
ob_start(); /* template body */ ;
echo Dwoo_Plugin_include($this, "base.tpl", null, null, null, '_root', null);
 /* end template body */
return $this->buffer . ob_get_clean();
?>