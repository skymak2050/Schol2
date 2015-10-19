<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MVH' ) or die( 'Direct Access to this location is not allowed.' );

class HTMLHead {

	public function IncludeFile($v) {
		$this->$v=True;
	}

	function DrawHead() {
		$wb=$GLOBALS['wb'];
		$c="<html>\n";
		$c.="<head>\n";
		$c.="<title>".$GLOBALS['site_title']."</title>\n";
		if (ISSET($this->css)) {
			$c.="<link rel='stylesheet' href='".$wb."/css/css.css' type='text/css'>\n";
		}
		if (ISSET($this->jscalendar)) {
			$c.="<style type='text/css'>@import url(".$wb."include/jscalendar/calendar-win2k-1.css);</style>\n";
			$c.="<script type='text/javascript' src='".$wb."include/jscalendar/calendar.js'></script>\n";
			$c.="<script type='text/javascript' src='".$wb."include/jscalendar/lang/calendar-en.js'></script>\n";
			$c.="<script type='text/javascript' src='".$wb."include/jscalendar/calendar-setup.js'></script>\n";
		}
		$c.="</head>\n";
		$c.="<body>\n";
		return $c;
	}

	function DrawBody($content,$icon="images/home/signup_icon.gif") {
		$wb=$GLOBALS['wb'];
		$c="<table align='center' width='780' cellpadding='0' cellspacing='0' border='0' class='plain'>\n";

			/* HEAD */
			$c.="<tr>\n";
				$c.="<td width='20' bgcolor='#3399CC'><img src='".$wb."images/curves/top_left.gif' width='20' height='42'></td>\n";
				$c.="<td width='740' bgcolor='#66CC33'><a href='index.php'>".$GLOBALS['site_logo']."</a></td>\n";
				$c.="<td width='20' bgcolor='#3399CC'><img src='".$wb."images/curves/top_right.gif' width='20' height='42'></td>\n";
			$c.="</tr>\n";

			/* DIVIDER BAR */
			$c.="<tr>\n";
				$c.="<td colspan='3'><br></td>\n";
			$c.="<tr>\n";

			/* CONTENT */

			$c.="<tr>\n";
				$c.="<td colspan='3'>\n";
				$c.="<table class='plain'>\n";
					$c.="<tr class='modulehead'>\n";
						$c.="<td>Greetings from MyVirtualHut.com,<br></td>\n";
					$c.="</tr>\n";
					$c.="<tr>\n";
						$c.="<td>".$content."</td>\n";
						$c.="<td width='128'><img src='".$GLOBALS['wb'].$icon."'></td>\n";
					$c.="</tr>\n";
					$c.="<tr>\n";
						$c.="<td>MyVirtualHut.com is an online community management tool for residential complexes and community groups offering affordable online community tools</td>\n";
					$c.="</tr>\n";
					$c.="<tr class='modulehead'>\n";
						$c.="<td>Sincerely, <br><br>MyVirtualHut.com</td>\n";
					$c.="</tr>\n";
				$c.="</table>\n";
				$c.="</td>\n";
			$c.="</tr>\n";

			/* DIVIDER BAR */
			$c.="<tr>\n";
				$c.="<td colspan='3'><br></td>\n";
			$c.="<tr>\n";

			/* FOOT */
			$c.="<tr>\n";
				$c.="<td width='20' bgcolor='#3399CC'><img src='".$wb."images/curves/white_bottom_left.gif' width='20' height='20'></td>\n";
				$c.="<td width='780' bgcolor='#ffffff' align='center'>&copy;2004-".Date("Y")." MyVirtualHut</td>\n";
				$c.="<td width='20' bgcolor='#3399CC'><img src='".$wb."images/curves/white_bottom_right.gif' width='20' height='20'></td>\n";
			$c.="</tr>\n";

		$c.="</table>\n";

		return $c;
	}

	function DrawFoot() {
		$c="</body>\n";
		$c.="</html>\n";
		return $c;
	}
}
?>