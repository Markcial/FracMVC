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

final class ScaffoldParser {


	public static $commentBlock = "@\/\*[\s\S]*?\*\/|\/\/.*|#.*@";
	//private static $preCompilerConds = "/@processor\[([^\]]+)\];/";
	public static $tableBlock = "/(?<tabla>Table\(\"(?P<nombre>[^\)]+)\"\)\[(?P<filas>[^\]]+)\];)/";
	public static $rowBlock = "/\"(?P<nombre>\w+)\"\s?\=\>\s?(?P<params>[^,\n]+)/";
	public static $paramBlock = "/(?P<key>type|length|primary_key|foreign|default|not_null|index|fulltext|unsigned|autoincrement|visible|label)\:?(?P<value>[^|]+)?/";
	public static $foreignRelationBlock = "/(?P<table>\w+)\.(?P<fid>\w+)\((?P<label>\w+)\)\{(?P<actions>[^}]+)\}/";

	private static $scaffoldData;

	private static $instance;

	private $file;
	private $tables;

	private function __construct(){}
	private function __clone(){}

	private function parseRows($rowsData){
		preg_match_all(self::$rowBlock,$rowsData,$matches);
		for($i=0;$i<count($matches["nombre"]);$i++){
			$nombre = $matches["nombre"][$i];
			$parameters = $matches["params"][$i];
			if(preg_match(self::$paramBlock,$parameters)){
				preg_match_all(self::$paramBlock,$parameters,$pmatches);
				for($j = 0;$j<count($pmatches["key"]);$j++){
					$params[$pmatches["key"][$j]] = trim($pmatches["value"][$j]);
				}
			}
			$rows[$nombre] = !empty($params)?$params:"";
			unset($params);
		}
		return $rows;
	}

	public static function getInstance(){
		if(empty(self::$instance)){
			$class = new self;
		}
		return self::$instance;
	}

	public function parse($scaffoldFile){
		if(!file_exists($scaffoldFile)){
			throw new FileNotFoundException($scaffoldFile);
		}
		$bfr = file_get_contents($scaffoldFile);
		$bfr = preg_replace(self::$commentBlock,"",$bfr);
		//preg_match_all(self::$preCompilerConds,$bfr,$matches);
		//var_dump($matches);
		//$this->
		preg_match_all(self::$tableBlock,$bfr,$matches);
		for($i=0;$i<count($matches["nombre"]);$i++){
			$nombre = $matches["nombre"][$i];
			$filas = $matches["filas"][$i];
			$rows = self::parseRows($filas);
			self::getInstance()->tables[$nombre] = $rows;
		}
		return self::getInstance();
	}
}
?>