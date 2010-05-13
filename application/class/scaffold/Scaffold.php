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
require_once 'ScaffoldParser.php';
final class Scaffold {

	private $parser;
	private $modules;

	function __construct($file){
		$this->parser = ScaffoldParser::parse($file);
		$this->modules = $this->parser->tables;
	}

	public function databaseScaffold(){
		$tableSql = "";
		foreach($this->modules as $moduleName => $moduleData){
			$keysSql = $rowSql = array();
			foreach($moduleData as $labelRow => $rowParams ){
				$type = $rowParams["type"];
				$length = key_exists("length",$rowParams)?$rowParams["length"]:false;
				$notNull = key_exists("not_null",$rowParams)?true:false;
				$primaryKey = key_exists("primary_key",$rowParams)?true:false;
				$autoincrement = key_exists("autoincrement",$rowParams)?true:false;
				$unsigned = key_exists("unsigned",$rowParams)?true:false;
				$indexKey = key_exists("index",$rowParams)?true:false;
				$fulltextKey = key_exists("fulltext",$rowParams)?true:false;
				$foreignKey = key_exists("foreign",$rowParams)?$rowParams["foreign"]:false;
				$default = key_exists("default",$rowParams)?$rowParams["default"]:false;
				$additionalFlags = "";
				$additionalFlags .= $unsigned?"UNSIGNED ":"";
				$additionalFlags .= $autoincrement?"AUTO_INCREMENT ":"";
				$additionalFlags .= $notNull?"NOT NULL ":"";
				$additionalFlags .= $default!==false?sprintf("DEFAULT %s ",is_int($default)?$default:sprintf('"%s"',$default)):"";

				$rowSql[] = sprintf( "`%s` %s(%s) %s", $labelRow, $type, $length, $additionalFlags );
				if($primaryKey){
					$keysSql[] = sprintf("PRIMARY KEY (%s)",$labelRow);
				}
				if($indexKey){
					$keysSql[] = sprintf("INDEX(%s)",$labelRow);
				}
				if($fulltextKey){
					$keysSql[] = sprintf("FULLTEXT(%s)",$labelRow);
				}
				if($foreignKey){
					preg_match(ScaffoldParser::$foreignRelationBlock,$foreignKey,$matches);
					$table = $matches["table"];
					$fid = $matches["fid"];
					$label = $matches["label"];
					$actions = explode("&",$matches["actions"]);
					foreach($actions as $action){
						$act[] = sprintf("ON %s",$action);
					};
					$keysSql[] = sprintf("FOREIGN KEY(%s) REFERENCES %s(%s) %s",$labelRow,$table,$fid,implode(" ",$act));
				}
			}
			$rowsSql = array_merge($rowSql,$keysSql);
			var_dump($keysSql);
			var_dump($rowSql);
			$tableSql .= sprintf("CREATE TABLE IF NOT EXISTS `%s` (%s);\n",$moduleName,implode(",",$rowsSql));
		}
		return $tableSql;
	}

	public function formScaffold(){
		$bfr = "";
		foreach($this->modules as $moduleName => $moduleData){
			foreach($moduleData as $labelRow => $rowParams ){
				$type = $rowParams["type"];
				//echo HtmlBuilder::HtmlInputTypeFromSqlType($type)
			}
		}
	}

}
?>