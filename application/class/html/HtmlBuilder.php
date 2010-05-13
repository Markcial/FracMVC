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

class HtmlBuilder {


	function form($content,$action,$method="get",$name=false,$params=false){
		if(!empty($params)){
			foreach($params as $name => $param){
				$prms[] = sprintf('%s="%s"',$name,$param);
			}
		}
		return sprintf('<form action="%s" method="%s"%s>%s</form>',$action,$method,implode(" ",$prms),$content);
	}

	function input($type,$value,$params=false){
		if(!empty($params)){
			foreach($params as $name => $param){
				$prms[] = sprintf('%s="%s"',$name,$param);
			}
		}
		return sprintf('<input type="%s" class="%s" value="%s"%s />',$type,$type,$value,implode(" ",$prms));
	}

	function HtmlInputTypeFromSqlType($type){
		if(preg_match("/(bigint|int|varchar|date|time)/i",$type)){ return "text"; };
		//if(preg_match("/tinyint/")){ return type}
	}
}
?>