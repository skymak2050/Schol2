<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MVH' ) or die( 'Direct Access to this location is not allowed.' );

/*
	DATABASE TO USE
*/

//if ($database_type=="postgres") {
//	require_once $dr."classes/db/pgsql.php";
//	$db = new pgsql;//New object
//	$db->Connect($database_hostname,$database_port,$database_name,$database_user,$database_password);
//}
//elseif ($database_type=="mysql") {
	require_once $dr."classes/db/mysql.php";
	$db=new mysql;//New object
	$db->Connect($database_hostname,$database_port,$database_name,$database_user,$database_password);
//}
//else {
	//die("Database not configured");
//}


/*** DATABASE SESSIONS ***/
require_once $GLOBALS['dr']."include/functions/db/session.php";

session_set_save_handler("SessionOpen", "SessionClose", "SessionRead", "SessionWrite", "SessionDestroy", "SessionCleanUp");
session_start();
?>