<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MVH' ) or die( 'Direct Access to this location is not allowed.' );

function LogoutBar() {
	$setup=$GLOBALS['setup'];
	$s="<table class='plain' cellspacing='0' cellpadding='2'>\n";
		$s.="<tr bgcolor='#99CCFF'>\n";
			$s.="<td><a href='index.php'>Home</a></td>\n";
			if ($setup->AllowSignup()=="y") {
				$s.="<td> | </td>\n";
				$s.="<td><a href='index.php?module=signup'>Signup</a></td>\n";
			}
			$s.="<td> | </td>\n";
			$s.="<td><a href='index.php?module=signup&task=recover_password'>Recover your password</a></td>\n";
			//$s.="<td> | </td>\n";
			//$s.="<td><a href='index.php?module=core&task=show_paragraph&content=about'>About</a></td>\n";
			//$s.="<td> | </td>\n";
			//$s.="<td>Privacy Policy</td>\n";
		$s.="</tr>\n";
	$s.="</table>\n";
	return $s;
}
?>