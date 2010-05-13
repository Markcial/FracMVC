<?php
if (function_exists('Dwoo_Plugin_include')===false)
	$this->getLoader()->loadPlugin('include');
ob_start(); /* template body */ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
    	<?php echo Dwoo_Plugin_include($this, 'head.tpl', null, null, null, '_root', null);?>

	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<?php echo Dwoo_Plugin_include($this, 'header.tpl', null, null, null, '_root', null);?>

			</div>
			<div id="content">
				<?php echo Dwoo_Plugin_include($this, (isset($this->scope["tpl"]) ? $this->scope["tpl"] : null), null, null, null, '_root', null);?>

			</div>
			<div id="footer">
				<?php echo Dwoo_Plugin_include($this, 'footer.tpl', null, null, null, '_root', null);?>

			</div>
		</div>
	</body>
</html><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>