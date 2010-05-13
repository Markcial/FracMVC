<?php
/**
 * @copyright (C) 2010 Markcial
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 **/

//error_reporting(E_ERROR);

// base url
define('BASEURL',str_replace(basename($_SERVER["SCRIPT_FILENAME"]),"",$_SERVER["SCRIPT_NAME"]));
// minimal variable environment
define('DS',DIRECTORY_SEPARATOR);
define('APPROOT',dirname(__FILE__).DS);
define('CFG',APPROOT.'cfg'.DS);
define('CLASSES',APPROOT.'class'.DS);
define('IFACES',CLASSES.'ifaces'.DS);
define('ROUTER',CLASSES.'router'.DS);
define('CONFIG',APPROOT.'cfg'.DS);
define('EXCEPT',CLASSES.'exceptions'.DS);
define('CTLS',CLASSES.'controllers'.DS);
define('MDLS',CLASSES.'models'.DS);
$classpath = array(
	ROUTER,
	IFACES,
	CTLS,
	MDLS,
	EXCEPT
);
define('TPL',APPROOT.'tpl'.DS);
define('TESTS',APPROOT.'tests'.DS);
//importing base singleton config class
require_once(CLASSES.'Config.php');
Config::import('Core');
Core::setClassPath($classpath);
// import exception handler
Config::import("exceptions_ExceptionHandler");
set_exception_handler(array("ExceptionHandler","handleException"));
//parse configuration file
Config::readInitFile(CONFIG.'config.ini');
function varDump($ob){
	ExceptionHandler::varDump($ob);
}
spl_autoload_register(array("Config","magicLoad"));

?>