<?php
function ErrorHandler($errno, $errstr, $errfile, $errline) {
  //echo $errno."<br>";
  echo ErrorDisplay($errno, $errstr, $errfile, $errline);
 /*
  switch ($errno) {
  case E_USER_ERROR:
   echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
   echo "  Fatal error in line $errline of file $errfile";
   echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
   echo "Aborting...<br />\n";
   die();
   exit(1);
   break;
  case E_USER_WARNING:
   echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
   die();
   break;
  case E_USER_NOTICE:
   echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
   die();
   break;
  case E_WARNING:
   //echo "<b>WARNING</b> [$errno] $errstr<br />\n";
   echo ErrorDisplay($errno, $errstr, $errfile, $errline);
   die();
   break;
  case E_NOTICE:
   echo "<b>Fatal Error 2</b> [$errno] $errstr<br />\n";
   die();
   break;
  case E_CORE_WARNING:
   echo "<b>Fatal Error 3</b> [$errno] $errstr<br />\n";
   die();
   break;
  case E_COMPILE_WARNING:
   echo "<b>Fatal Error 4</b> [$errno] $errstr<br />\n";
   die();
   break;
  case E_USER_ERROR:
   echo "<b>Fatal Error 5</b> [$errno] $errstr<br />\n";
   die();
   break;
  case E_ERROR:
   echo "<b>Fatal Error 6</b> [$errno] $errstr<br />\n";
   die();
   break;
  case E_PARSE:
   echo "<b>Fatal Error 7</b> [$errno] $errstr<br />\n";
   die();
   break;
  case E_CORE_ERROR:
   echo "<b>Fatal Error 8</b> [$errno] $errstr<br />\n";
   die();
   break;
  case E_COMPILE_ERROR:
   echo "<b>Fatal Error 9</b> [$errno] $errstr<br />\n";
   die();
   break;
  default:
   echo "Unknown error type: [$errno] $errstr<br />\n";
   die();
   break;
  }
  */
}

function ErrorDisplay($errno, $errstr, $errfile, $errline) {
	$c="<table align='center' border=3 bordercolor=#336699>\n";
		$c.="<tr height='50'>\n";
			$c.="<td colspan='2'><h1>We're sorry, an error has occured</h1></td>\n";
		$c.="</tr>\n";
		$c.="<tr>\n";
			$c.="<td valign='top' colspan='2'>
			This application has hit a possible bug. Your last action has been halted in an effort to fix the problem.<br>
		  The problem is being recorded and reported.
			</td>\n";
		$c.="</tr>\n";
		$c.="<tr height='50'>\n";
			$c.="<td colspan='2'><b>Some debugging information will follow</b></td>\n";
		$c.="</tr>\n";
		$c.="<tr>\n";
			$c.="<td><b>Error Number:</b></td>\n";
			$c.="<td>$errno</td>\n";
		$c.="</tr>\n";
		$c.="<tr>\n";
			$c.="<td><b>Error String:</b></td>\n";
			$c.="<td>$errstr</td>\n";
		$c.="</tr>\n";
		$c.="<tr>\n";
			$c.="<td><b>Error File:</b></td>\n";
			$c.="<td>$errfile</td>\n";
		$c.="</tr>\n";
		$c.="<tr>\n";
			$c.="<td><b>Error Line:</b></td>\n";
			$c.="<td>$errline</td>\n";
		$c.="</tr>\n";
	$c.="</table>\n";
	die($c);
	return $c;
}
?>