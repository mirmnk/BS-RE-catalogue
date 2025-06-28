<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2005 Miroslav Monkevic (m@vektorius.lt)
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is 
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license 
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Word wrapping function
 *
 * @author	Miroslav Monkevic <m@vektorius.lt>
 */

class user_vvrecatalog {
	function wrap($content, $conf) {
		$length = ($conf['max'])?$conf['max']:20;
		$strBr = ($conf['brstr'])?trim($conf['brstr']):' ';	
		$bolCut = ($conf['cut'])?intval($conf['cut']):1;			
        return wordwrap($content, $length, $strBr, $bolCut);
	}
}

?>