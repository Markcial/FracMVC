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

class Mysql implements IDatabaseLayer {

	protected $config = array();          // server connection params
	protected $pdo;                       // database object;

	function __construct($config){
		$this->config = $config;
		$this->connect();
	}

	public function connect($config=array()){
		if(!empty($config)){ $this->config = $config; };
		$this->pdo = new PDO(sprintf('mysql:host=%s;dbname=%s',$this->config['host'],$this->config['db']), $this->config['user'], $this->config['password']);
	}

	public function prepare($sql){
		return $this->pdo->prepare($sql);
	}

	public function query($sql){
		$sth = $this->pdo->prepare($sql);
		$sth->execute();
		return $sth;
	}
	
	public function execute(){
		
	}
	
	public function fetchOne(){
		
	}
	
	public function fetchMany($from,$to){
		
	}
	
	public function fetchAll(){
		
	}
	
	public function explain($sql){
		
	}
	
	public function getError(){
		
	}
	
	public function showDatabases(){
		
	}
	
	public function showTables(){
		
	}
	
	public function describeTable($table){
		
	}

	public function __wakeup(){
		$this->connect();
	}

	public function __sleep(){
		return $this->config;
	}
}

?>