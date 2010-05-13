<?php
ob_start(); /* template body */ ?>Not found!<?php  /* end template body */
return $this->buffer . ob_get_clean();
?>