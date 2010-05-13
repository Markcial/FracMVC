<?php
/**
 * Copyright (C) 2009 Markcial
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
 */
class contentController extends Controller {

	var $name = "content";

	function afterLoad(){
		//echo "after load";
	}

	function beforeLoad(){
		//echo "before load";

	}

	function __construct(){
		parent::__construct();
	}

	public function fileLoad(){
		if(empty($_POST))return;
		var_dump($_FILES);
		echo 'File Upload';
	}

	public function formFileLoad(){
		$view = new Smarty;
		$view->template_dir = TPL;
		$view->compile_dir = APPROOT."externals/smarty/templates_c";
		$view->assign('tpl','formulario.tpl');
		$view->display('base.tpl');
	}

	public function index(){
		$arg_max = 0;
		$view = new Smarty;
		$view->template_dir = TPL;
		$view->compile_dir = APPROOT."externals/smarty/templates_c";
		$view->display('sticker.demo.tpl');
	}
	
	public function index2(){
		$view = new Smarty;
		$view->template_dir = TPL;
		$view->compile_dir = APPROOT."externals/smarty/templates_c";
		$view->assign('tpl','syntax.highlighter.tpl');
		$view->display('base.tpl');
	}

	public function lista(){
		$lista = array(1,2,3,4,5,6,7,8,9);
		var_dump($_SERVER);
		echo "mod_rewrite : ".(!empty($_SERVER["REDIRECT_URL"])?"supported":"not supported");
		foreach( $lista as $a ){
			print $a."\n";
		}
	}

	public function jquery(){
		$this->data->assign("tpl","jquery.tpl" );
		$this->view->output($this->tpl,$this->data);
	}

	public function gmap(){
		$this->data->assign("tpl","gmap.tpl" );
		$this->view->output($this->tpl,$this->data);
	}

	public function cssOff(){
		$this->data->assign("css","css.off.css" );
		$this->data->assign("tpl","cssOff.tpl" );
		$this->view->output($this->tpl,$this->data);
	}
}
?>
