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
class ImportException extends IOException {

	function __construct($file, $msg = null, $code = 0){
		if(file_exists($file)){
			$this->errorFolder = dirname($file);
			$this->fileName = basename($file);
			$this->errorFile = $file;
		}

		parent::__construct($file, sprintf("%s : Could not import class : %s, inside file : %s in folder : %s.",
								get_class($this),
								$this->fileName,
								$this->fileName,
								$this->errorFolder),$code);
	}
}
?>
