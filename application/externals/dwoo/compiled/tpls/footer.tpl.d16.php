<?php
ob_start(); /* template body */ ?><p>&copy; pie de pagina con enlaces o disclaimers</p><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>