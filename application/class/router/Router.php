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
Config::import("exceptions_RouterException");
Config::import("exceptions_RouteNotDefinedException");
class Router {
    /**
     * @name $pattern
     * @desc Sirve para procesar la url i asignar las partes de enrutado a las partes de $_routing;
     * @var String patron de enrutado interno
     * @internal
     */
	private static $patterns;

	/**
	 * @name $pathInfo
	 * @desc Alias interno para procesar el pathinfo
	 * @var String
	 * @internal
	 */
    private static $pathInfo;

    /**
     * @name $routeData
     * @desc Variable interna, sirve para asociar las piezas de la url enrutada
     *       a sus respectivos controlador, accion, parametros, etc...
     * @var Array
     * @internal
     */
    private static $routeData = array();

    /**
     * @name $instance
     * @desc La instancia singleton de la clase Router
     * @var Router
     * @internal
     */
    private static $instance;

    /**
     * @desc no permite instanciacion, clase singleton
     * @internal
     */
	private function __construct(){}
	private function __clone(){}

	/**
	 * @name getInstance
	 * @desc metodo publico para conseguir la instancia singleton inicializada
	 * @static
	 */
	public static function getInstance(){
		if(empty(self::$instance)){
			self::$instance = new self;
			self::$instance->init();
		}
		return self::$instance;
	}

	/**
	 * @name redirect
	 * @desc Redirige a la url enviada
	 * @param String $url
	 * @static
	 */
    static function redirect(String $url){
		header("Location: $url");
    }

    /**
     * @name start
     * @desc inicia el procesado de la url i de el enrutado asignado
     */
    static public function init(){
    	Router::getPathInfo();
    	if( !empty(self::$patterns) ){
    		Router::route();
    	}else{
        	throw new RouteNotDefinedException;
    	}
    }

	/**
     * @name getRouteData
     * @desc devuelve el nombre del controlador si este esta asociado
     */
    public function getRouteData(){
    	if(empty(self::$routeData)){
    		throw new RouterException("No hay información en routeData, probablemente el router no se ha inicializado o bien no se asigno una ruta");
    	}else{
    		return self::$routeData;
    	}
    }

    /**
     * @name getController
     * @desc devuelve el nombre del controlador si este esta asociado
     */
    public function getController(){
    	if(empty(self::$routeData["controller"])){
    		throw new RouterException("No se encontro el controlador relacionado, probablemente el router no se ha inicializado o bien no se asigno una ruta");
    	}else{
    		return self::$routeData["controller"];
    	}
    }

    /**
     * @name getAction
     * @desc devuelve el nombre de la accion si esta esta asociado
     */
    public function getAction(){
    	if(empty(self::$routeData["action"])){
    		throw new RouterException("No se encontro la acción asociada, probablemente el router no se ha inicializado o bien no se asigno una ruta");
    	}else{
    		return self::$routeData["action"];
    	}
    }

    public function getParams(){
		$params = self::$routeData;
		unset($params["controller"]);
		unset($params["action"]);
    	return $params;
    }

    /**
     * @name addRoute
     * @desc metodo para asignar el comportamiento de enrutado
     * @uses package : router_Routes
     * @param String $route
     * @static
     */
    static public function addRoute($route){
    	self::$patterns[] = $route;
    }

    /**
     * @name reset
     * @desc resetea las rutas i el procesado interno de la clase Router
     * @static
     */
    static public function reset(){
        self::$routeData = array();
        self::$patterns = array();
    }

    /**
     * @name notfound
     * @desc envia unas cabeceras de no encontrado sin cortar la ejecucion
     */
    public function notfound(){
        Router::headers('HTTP/1.0 404 Not Found');
    }

    /**
     * @name getPathInfo
     * @desc consigue el path info a traves de server o bien mod rewrite
     * @internal
     */
    private function getPathInfo(){
        if(!empty($_SERVER['REDIRECT_URL'])){
        	$script = explode("/",$_SERVER["SCRIPT_NAME"]);
        	array_pop($script);
        	$folder = implode("/",$script);
        	self::$pathInfo = str_replace($folder,"",$_SERVER["REQUEST_URI"]);
        }else if(!empty($_SERVER["PATH_INFO"])){
    		self::$pathInfo = $_SERVER["PATH_INFO"];
        }
    }

    /**
     * @name headers
     * @desc asigna cabezeras de manera mas rapida
     * @static
     */
    static function headers(){
        $hdrs = func_get_args();
        foreach ( $hdrs as $key => $value ) {
        isset($key) ?
                header("$key: $value"):
                header("$value");
        };
    }

    /**
     * @name route
     * @desc funcion interna de enrutado a traves de pathinfo y segun el patron enviado
     * @static
     * @internal
     */
    private static function route(){
    	$routeNotFoundFlag = true;
    	foreach(self::$patterns as $pattern ){
	        $patternPieces = explode("|", $pattern );
	        $pathPieces = explode("/", preg_replace("/^\/|\/$/","",self::$pathInfo));
			$pathPiecesLength = count($pathPieces);
	        $lastPatternPiecesLength = count($patternPieces);
	        $patternPiecesLength = array($lastPatternPiecesLength);
	        while( count($patternPieces) ){
				$ptItem = array_shift($patternPieces);
				$pair = explode(":",$ptItem);
				if( count($pair)>1 ){
					$key = $pair[0];
					$val = $pair[1];
					if( strpos($key, "*" ) !== false ){ //persistente, no acepta asignacion
						$key = substr($key,1);
						self::$routeData[$key] = $val;
						$patternPiecesLength[] = --$lastPatternPiecesLength;
					}else{ // si que acepta asignacion
						$uPiece = array_shift($pathPieces);
						$val = !empty($uPiece)?$uPiece:$val;
						self::$routeData[$key] = $val;
					}
				}else{
					$uPiece = array_shift($pathPieces);
					self::$routeData[$ptItem] = !empty($uPiece)?$uPiece:false;
				}
	        }
	        if(in_array($pathPiecesLength,$patternPiecesLength)){
				$routeNotFoundFlag = false;
			}
		}
		if($routeNotFoundFlag){throw new RouterException('No se encontro ninguna de las rutas definidas'); };
    }
}
?>