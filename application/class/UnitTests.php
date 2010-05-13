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
final class UnitTests {

	private static $bin = "C:/wamp/bin/php/php5.3.0/phpunit";

	private static $command = "%s --verbose %s";

	private function __construct(){}
	private function __clone(){}

	public function runTest($which){
		$cmd = sprintf(self::$command,self::$bin,escapeshellarg(TESTS.sprintf('/%s.uphp',$which)));
		echo $which;
		echo '<pre>';
		echo passthru($cmd);
		echo '</pre>';
	}

}
?>