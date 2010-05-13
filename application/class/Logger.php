<?php
/**
 * @copyright (C) 2009 Markcial
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

class Logger {

	private static $verbose = false;
	private static $logtodb = false;
	private static $error_format = "{Date=[%s],IP=[%s],Level=[%s],Class=[%s],Message=['%s']}";
	private static $date_format = "d-m-Y h:i:s";

	private static $instance;

	private static $defaults;

	private function __construct(){}
	private function __clone(){}

	public static function getInstance(){
		if(empty(self::$instance)){
			self::$instance = new self;
		}
		return self::$instance;
	}

	function toString(){
		$klss = get_class($this);
		return ";".$klss.";";
	}

	function formatError($err,$severity){
		return sprintf($this->error_format,date($this->date_format),$_SERVER["REMOTE_ADDR"],$severity,$this->toString(),$err);
	}

	public function log($msg){
		$severity = "LOG";
		error_log($this->formatError($msg,$severity)."\n");
		$this->fileLog($msg,$severity);
		if($this->verbose){
			echo $this->formatError($msg,$severity)."\n";
		}
	}

	public function info($msg){
		$severity = "INFO";
		error_log($this->formatError($msg,$severity)."\n");
		$this->fileLog($msg,$severity);
		if($this->verbose){
			echo $this->formatError($msg,$severity)."\n";
		}
	}

	public function debug($msg){
		$severity = "DEBUG";
		error_log($this->formatError($msg,$severity)."\n");
		$this->fileLog($msg,$severity);
		if($this->verbose){
			echo $this->formatError($msg,$severity)."\n";
		}
	}

	public function warn($msg){
		$severity = "WARN";
		error_log($this->formatError($msg,$severity)."\n");
		$this->fileLog($msg,$severity);
		if($this->verbose){
			echo $this->formatError($msg,$severity)."\n";
		}
	}

	public function error($msg){
		$severity = "ERROR";
		error_log($this->formatError($msg,$severity)."\n");
		$this->fileLog($msg,$severity);
		if($this->verbose){
			echo $this->formatError($msg,$severity)."\n";
		}
	}

	public function fatal($msg){
		$severity = "FATAL";
		error_log($this->formatError($msg,$severity)."\n");
		$this->fileLog($msg,$severity);
		if($this->verbose){
			echo $this->formatError($msg,$severity)."\n";
		}
	}

	public function mailLog($msg,$severity){
		error_log($this->formatError($msg,$severity),1,ADMIN_MAIL);
	}

	public function fileLog($msg,$severity){
		error_log($this->formatError($msg,$severity)."\n",3,LOGFILE);
		if( $this->logtodb ){
			$this->dbLog($msg,$severity);
		}
	}

	public function dbLog($msg,$level="LOG"){
		switch ( $level ) {
			case "FATAL":
				$severity = 5;
			break;
			case "ERROR":
				$severity = 4;
			break;
			case "WARN":
				$severity = 3;
			break;
			case "DEBUG":
				$severity = 2;
			break;
			case "INFO":
				$severity = 1;
			break;
			case "LOG":
			default:
				$severity = 0;
			break;
		}
		/*try{
			$db = new dbo();
			$db->table = "tbl_log";
			$db->insert(array("fecha"=>date("Y-m-d H:i:s"),"ip"=>$_SERVER["REMOTE_ADDR"],"severity"=>(int)$severity,"message"=>$msg));
			$db->commit();
		}catch(Exception $e){
			$this->mailLog($e->message,"WARN");
		}*/
	}
}

?>
