<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MVH' ) or die( 'Direct Access to this location is not allowed.' );

function SessionOpen($save_path,$session_name) {
	SessionCleanUp(); /* REMOVES ALL EXPIRED SESSIONS*/
}

function SessionClose() {
	//SessionCleanUp(); /* REMOVES ALL EXPIRED SESSIONS*/
}

function SessionCleanUp() {
	$sql="DELETE FROM ".$GLOBALS['database_prefix']."core_sessions WHERE session_time < ".(time()-(3600));
	$GLOBALS['db']->query($sql);
}

function SessionRead($session_id) {
	//echo "ok1";
	$db=$GLOBALS['db'];
  $query="SELECT session_data
   				FROM ".$GLOBALS['database_prefix']."core_sessions
   				WHERE session_id='".$session_id."'
   				";
  //echo $query;
  $result = $GLOBALS['db']->query($query);
  if ($GLOBALS['db']->NumRows($result) > 0) {
  	while($row = $GLOBALS['db']->FetchArray($result)) {
  		return $row['session_data'];
  	}
  }
  else {
  	$query="INSERT INTO ".$GLOBALS['database_prefix']."core_sessions (session_id, session_time, session_data)
            VALUES (
            '".$session_id."',
            now(),
            ''
            )";
    $GLOBALS['db']->query($query);
    return "";
  }
}

function SessionWrite($session_id,$session_data) {
	global $db;
	$db=$GLOBALS['db'];
	$session_data=addslashes($session_data);
  $query="UPDATE ".$GLOBALS['database_prefix']."core_sessions
  				SET session_data = '$session_data',
  				session_time = now()
  				WHERE session_id = '".$session_id."'
  				";
  $db->query($query);
  return True;

}


function SessionDestroy($session_id) {
	$query = "DELETE FROM ".$GLOBALS['database_prefix']."core_sessions WHERE session_id = '".$session_id."'";
  $GLOBALS['db']->query($query);
  return True;
}
?>