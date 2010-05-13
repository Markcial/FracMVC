<?php
define('DWOO_INCLUDE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
function dwooAutoload($class)
{
    if (substr($class, 0, 5) === 'Dwoo_') {
        include DWOO_INCLUDE_PATH . strtr($class, '_', DIRECTORY_SEPARATOR).'.php';
    }
    return true;
}
spl_autoload_register('dwooAutoload');
include 'Dwoo.php';