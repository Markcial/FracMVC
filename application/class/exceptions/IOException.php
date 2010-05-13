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

interface IIOException
{
    /* Protected methods inherited from Exception class */
    public function getMessage();                 // Exception message
    public function getCode();                    // User-defined Exception code
    public function getFile();                    // Source filename
    public function getErrorFolder();			  // Folder base where ioerror happened
    public function getErrorFile();               // File responsible of the ioerror
    public function getLine();                    // Source line
    public function getTrace();                   // An array of the backtrace()
    public function getTraceAsString();           // Formated string of trace

    /* Overrideable methods inherited from Exception class */
    public function __toString();                 // formated string for display
    public function __construct($file, $message = null, $code = 0);
}

abstract class IOException extends Exception implements IIOException {

	protected $message = 'Unknown exception';     // Exception message
    private   $string;                            // Unknown
    protected $code    = 0;                       // User-defined exception code
    protected $file;                              // Source filename of exception
    protected $line;                              // Source line of exception
    private   $trace;                             // Unknown

	protected $errorFolder;                       // Folder of the error
	protected $fileName;                          // Filename of the error
	protected $errorFile;                         // Error file
	protected $fileExists;                        // Boolean that marks if the file exist or not

	function __construct($file, $msg = null, $code = 0){
		$this->fileExists = file_exists($file);
		$this->errorFolder = dirname($file);
		$this->fileName = basename($file);
		$this->errorfile = $file;
		if (!$msg) {
            throw new $this(sprintf("%s thrown caused by file : %s, in folder : %s.",
							get_class($this),
							$this->fileName,
							$this->errorFolder));
        }
		parent::__construct($msg,$code);
	}

	public function getFileExists(){
		return $this->fileExists;
	}

	public function getErrorFolder(){
		return $this->errorFolder;
	}

	public function getErrorFile(){
		return $this->errorFile;
	}

    public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}";
    }
}
?>