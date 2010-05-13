<?php
ob_start(); /* template body */ ?><ul>
	<li><a href="/desafiador.es/">Portada</a></li>
	<li><a href="/desafiador.es/acerca.php">Acerca</a></li>
	<li><a href="/desafiador.es/ligas.php">Ligas</a></li>
	<li><a href="/desafiador.es/equipos.php">Equipos</a></li>
	<li><a href="/desafiador.es/contacto.php">Contacto</a></li>
</ul><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>