<?php
/**
 *
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

final class Core {
	private static $classpath = array();
	/**
	 * @name $instance
	 * @desc Instancia privada
	 * @var Config
	 * @internal
	 * @static
	 */
	private static $instance;
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
		if( empty(self::$instance) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function dispatch(){
		Router::addRoute(Routes::$basic);
		Router::init();
	}
	
	/**
	 * @name getClassPath
	 * @return array
	 */
	static public function getClassPath(){
		return self::$classpath;
	}
	/**
	 * @name setClassPath
	 * @param array $folders
	 * @desc define las carpetas a las que buscar donde cargar clases
	 */
	static public function setClassPath($folders){
		foreach($folders as $folder){
			self::addFolderToClassPath($folder);
		}
	}
	/**
	 * @name addFolderToClassPath
	 * @desc Añade carpeta a la ruta de classpath
	 */
	static public function addFolderToClassPath($folder){
		if(!file_exists($folder)){
			throw new FileNotFoundException($folder);
		}
		self::$classpath[] = $folder;
	}

    /**
     * @name dispatch
     * @desc Carga controlador y llama a la acción
     */
    public function render(){
    	$controller = Config::loadCurrentController();
		$action = Router::getAction();
		ob_start();
		if(in_array($action,get_class_methods(get_class($controller)))){
			call_user_func_array(array($controller,$action),Router::getParams());
		}
		$htmlBuffer = ob_get_clean();
		Router::headers(array('Content-Type','text/html;encoding=utf-8;'));
		die($htmlBuffer);
    }
}
 ?>