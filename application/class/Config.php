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
require_once('exceptions/IOException.php');
require_once('exceptions/ImportException.php');
require_once('exceptions/FileNotFoundException.php');
require_once('exceptions/LostControllerException.php');
final class Config {

	/**
	 * @name $instance
	 * @desc Instancia privada
	 * @var Config
	 * @internal
	 * @static
	 */
	private static $instance;

	/**
	 * @name $defaults
	 * @desc parametros de configuración internos leidos a traves del archivo .ini
	 * @var array
	 * @internal
	 * @static
	 */
	private static $defaults = array();

	/**
	 * @internal
	 * @desc patron singleton, prohibido instanciar o clonar
	 */
	private function __construct(){}
	private function __clone(){}

	/**
	 * @name getInstance
	 * @desc devuelve instancia config
	 * @static
	 */
	public static function getInstance(){
		if( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * @name import
	 * @desc importado standard de clases
	 * @param string $packagePath ruta con underscores a el package sin la extension
	 */
	public function import($packagePath ){
		$filename = CLASSES . str_replace("_",DS,$packagePath ) . '.php';
		if( file_exists( $filename ) ){
	   		require_once $filename;
   			$klass = basename($filename,'.php');
   			if( !class_exists( $klass, false ) && !interface_exists($klass, false) ){
   				throw new ImportException($filename);
   				return false;
   			};
   			return true;
   		}else{
   			throw new FileNotFoundException($filename);
   		}
	}

	/**
	 * @name magicLoad
	 * @desc funcion registrada de autoload
	 * @param string $klass ruta a la clase a cargar
	 * @static
	 */
	static public function magicLoad( $klass ){
		// ruta de los modulos a incluir, trailing slash
		$class_path = Core::getClassPath(); //
		foreach ( $class_path as $key => $path ) {
	    	if( file_exists( $file = $path.$klass.".php" ) ){
	    		@require_once $file;
	    		if( !class_exists( $klass, false ) && !interface_exists($klass, false) ){
	    			throw new ImportException($file);
	    			return false;
	    		}
	    		return true;
	    	}
		}
		throw new ImportException($klass);
	}

	/**
	 * @name loadCurrentController
	 * @desc crea una instancia de el controlador segun el enrutado
	 */
	public function loadCurrentController(){
		return Config::loadController(Router::getController());
	}

	/**
	 * @name loadController
	 * @desc carga un controlador dentro de la carpeta controllers
	 * @param string $name nombre del controlador a cargar
	 */
	public function loadController($name){
		$control = sprintf("%sController",$name);
		try{
			Config::import(sprintf("controllers_%s_%s",$name,$control));
		}catch(ImportException $exc){
			throw new LostControllerException($exc->getErrorFile(),$control);
		}
		return new $control;
	}

	/**
	 * @name readInitFile
	 * @desc parsea un archivo .ini
	 * @param string $filename la ruta al archivo .ini a leer
	 */
	public function readInitFile($filename){
		if(!file_exists($filename)){ throw new FileNotFoundException($filename);  }
		self::$defaults = parse_ini_file($filename,true);
	}

	/**
	 * @name getDefaults
	 * @desc devuelve los parametros por defecto contenidos en el archivo .ini parseado
	 * @static
	 */
	public static function getDefaults(){
		return self::$defaults;
	}

	public static function getDatabaseAccount($account="default"){
		if(empty(self::$defaults["database"][$account])){
			throw new Exception("ese perfil no existe");
		}
		return self::$defaults["database"][$account];
	}

	/**
	 * @name microtime
	 * @desc devuelve una marca de tiempo en formato de segundos
	 * @static
	 */
	public static function microtime(){
		list($usec, $sec) = explode(" ", microtime());
		$microtime = ((float)$usec + (float)$sec);
		return $microtime;
	}

	/**
	 * @name seolink
	 * @desc devuelve el parametro recibido como parametro amigable para las urls
	 * @param string $link el parametro a convertir en seo friendly
	 * @static
	 */
	public static function seolink($link){
		$bfr = "";

		$dict = array(
			"/ç/"=>"c", "/ñ/"=>"n", "/à/"=>"a", "/á/"=>"a", "/ä/"=>"a", "/â/"=>"a", "/è/"=>"e", "/é/"=>"e",
			"/ë/"=>"e", "/ê/"=>"e", "/ì/"=>"i", "/í/"=>"i", "/ï/"=>"i", "/î/"=>"i", "/ò/"=>"o", "/ó/"=>"o",
			"/ö/"=>"o", "/ô/"=>"o", "/ù/"=>"u", "/ú/"=>"u", "/ü/"=>"u", "/û/"=>"u", "/Ç/"=>"C", "/Ñ/"=>"ñ",
			"/À/"=>"A", "/Á/"=>"A", "/Ä/"=>"A", "/Â/"=>"A", "/È/"=>"E", "/É/"=>"E",	"/Ë/"=>"E", "/Ê/"=>"E",
			"/Ì/"=>"I", "/Í/"=>"I", "/Ï/"=>"I", "/Î/"=>"I", "/Ò/"=>"O", "/Ó/"=>"O",	"/Ö/"=>"O", "/Ô/"=>"O",
			"/Ù/"=>"U", "/Ú/"=>"U", "/Ü/"=>"U", "/Û/"=>"U", "/[\x80-\xFF]/"=>"", "/\W+/"=>"-"
		);
		$bfr = preg_replace(array_keys($dict), array_values($dict),$link);
		$bfr = substr($bfr,0,50);
		$bfr = strtolower(urlencode(trim($bfr, "-")));

		return $bfr;
	}
}
?>