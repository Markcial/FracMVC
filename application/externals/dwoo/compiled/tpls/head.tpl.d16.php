<?php
ob_start(); /* template body */ ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="<?php echo $metadata["titulo"]; ?>" />
<meta name="description" content="<?php echo $metadata["descripcion"]; ?>" />    
<meta name="keywords" content="<?php echo $metadata["keywords"]; ?>" />
<link rel="stylesheet" href="/desafiador.es/media/css/reset.css" media="screen"/>
<link rel="stylesheet" href="/desafiador.es/media/css/main.css" media="screen"/>
<!--[if IE 6]>
<link rel="stylesheet" href="/desafiador.es/media/css/ie6.css" media="screen"/>
<![endif]-->
<script type="text/javascript" src="/desafiador.es/media/js/jquery.min.js"></script>
<script type="text/javascript" src="/desafiador.es/media/js/main.js"></script>
<title> :: Home :: </title><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>