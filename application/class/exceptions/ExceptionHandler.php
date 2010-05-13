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
final class ExceptionHandler {

	/**
	 * htmlTemplate default template for debugging purposes
	 * @var String
	 */
	private static $htmlTemplate = <<<TEXT
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
 <head>
  <title>%{title}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style type="text/css">
  %{style}
  </style>
 </head>
 %{body}
</html>
TEXT;

	/**
	 * htmlBodyException
	 * @var String Body of the exception thrown as readable html
	 **/
	private static $htmlBodyException = <<<TEXT
 <body>
  <div id="container">
   <h1>Descripción de la excepción</h1>
   <div id="description" class="details">
   %{errDesc}
   </div>
   <h2>Stack Trace</h2>
   <p>
   	<a href="#" class="toggler" onclick="javascript:var s = document.getElementById('stackTrace').style;if(s.display=='none'){s.display='block';this.innerHTML='Ocultar';}else{s.display='none';this.innerHTML = 'Mostrar' };">Mostrar</a>
   </p>
   <div id="stackTrace" class="details" style="display:none">
   %{stackTrace}
   </div>
   <div id="copyright">&copy; 2010 Markcial</div>
  </div>
 </body>
TEXT;

	/**
	 * htmlBodyDump
	 * @var String Body of the var dump thrown as readable html
	 **/
	private static $htmlBodyDump = <<<TEXT
	<body>
	<div id="container">
	<h1>Volcado de variables</h1>
	<p>
   	 <a href="#" class="toggler" onclick="javascript:var s = document.getElementById('varDump').style;if(s.display=='none'){s.display='block';this.innerHTML='Ocultar';}else{s.display='none';this.innerHTML = 'Mostrar' };">Mostrar</a>
    </p>
    <div id="varDump" class="details" style="display:none">
    %{varDump}
    </div>
	<div id="copyright">&copy; 2010 Markcial</div>
	</div>
	</body>
TEXT;

	private static $defaultStyle = <<<TEXT
  html { height:100%; }
  body { background:#CCC;padding:0px;margin:0px;font-family:Verdana;width:100%;min-height:100%;position:relative; }
  #container { padding:10px 20px;padding-bottom:30px;}
  h1,h2{ color:white;background:#666;padding:10px 12px 5px;margin:10px 0px; }
  body div.details { border:2px dotted #AAA;padding:6px 12px;background:#EEE; }
  body div#description { font-weight:bold; color:#8F1116;background:#FFF1AF; }
  body a.toggler { text-decoration:none; color:blue; font-weight:bold;font-size:11px;margin:16px 10px;}
  body div#stackTrace body div#varDump { font-weight:bold; color:#9F0006;background:#FFF04F; }
  body div#copyright { position:absolute; bottom:10px; right:10px; font-size:9px; color:#111; }
TEXT;

	private static $htmlBuffer;

	/**
	 * instance
	 * @var ExceptionHandler the singleton instance of the ExceptionHandler class
	 **/
	private static $instance;

	private function __construct(){}

	public function getInstance(){
		if(empty(self::$instance)){
			self::$instance = new self;
		}
		return self::$instance;
	}

	static public function handleException( Exception $exception ){
		self::$htmlBuffer = preg_replace("/%\{body\}/",self::$htmlBodyException,self::$htmlTemplate);
		self::$htmlBuffer = preg_replace("/%\{style\}/",self::$defaultStyle,self::$htmlBuffer);
		self::$htmlBuffer = preg_replace("/%\{title\}/",sprintf("Capturada excepción de tipo : %s",get_class($exception)),self::$htmlBuffer);
		self::$htmlBuffer = preg_replace("/%\{errDesc\}/",sprintf("Capturada excepción : %s",$exception->getMessage()),self::$htmlBuffer);
		self::$htmlBuffer = preg_replace("/%\{stackTrace\}/",nl2br($exception->getTraceAsString()),self::$htmlBuffer);
		//self::$htmlBuffer = preg_replace("/%\{stackTrace\}/",nl2br(self::parseTrace($exception->getTrace())),self::$htmlBuffer);
		echo self::$htmlBuffer;
		die();
	}

	static private function parseTrace( $trace ){
		$bfr = "";
		$ptr = 0;
		foreach( $trace as $row ){
			$file = $row["file"];
			$line = $row["line"];
			$caller = (!empty($row["class"])?$row["class"].$row["type"]:"").$row["function"];
			$args = implode(",",$row["args"]);
			$bfr .= sprintf("#%s %s(%s): %s(%s)\n",$ptr,$file,$line,$caller,$args);
		}
		return $bfr;
	}

	static private function obj2Html( $obj ){
		$buffer = "";
		foreach( $obj as $key => $val ){
			$buffer .= sprintf('<a href="#" class="toggler %s" onclick="javascript:var s = document.getElementById(\'%s-dump\').style;if(s.display==\'none\'){s.display=\'block\';this.innerHTML=\'^%s\';}else{s.display=\'none\';this.innerHTML = \'>%s\' };">>%s</a>',$key,$key,$key,$key,$key) . "\n";
			$buffer .= sprintf('<div id="%s-dump">%s</div>',$key,is_array($val)?self::obj2Html($val):$val);
		}
		return $buffer;
	}

	static public function varDump( $object ){
		self::$htmlBuffer = preg_replace("/%\{body\}/",self::$htmlBodyDump,self::$htmlTemplate);
		self::$htmlBuffer = preg_replace("/%\{style\}/",self::$defaultStyle,self::$htmlBuffer);
		self::$htmlBuffer = preg_replace("/%\{title\}/","Volcado de var dump",self::$htmlBuffer);
		ob_start();
		echo self::obj2Html($object);
		self::$htmlBuffer = preg_replace("/%\{varDump\}/",ob_get_clean(),self::$htmlBuffer);
		echo self::$htmlBuffer;
		die();
	}

	static public function getDeclaredClasses(){
		self::varDump(get_declared_classes());
	}

	static public function dumpAll(){
		self::varDump($GLOBALS);
	}
}
?>