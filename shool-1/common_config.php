<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MVH' ) or die( 'Direct Access to this location is not allowed.' );

/*** CLASS FOR SITE SETUP ***/
require_once $GLOBALS['dr']."classes/setup/setup.php";
$setup=new Setup();

require_once $GLOBALS['dr']."include/functions/design/curve_boxes.php";

/* SESSION ID */
if (ISSET($_SESSION['sid'])) {
	$sid=$_SESSION['sid'];
	$user_id=$_SESSION['user_id'];
	require_once $GLOBALS['dr']."classes/user/user_info.php";
	require_once $GLOBALS['dr']."include/functions/date_time/set_timezone.php";
	$ui=new UserInfo($user_id);
	$workspace_id=$ui->WorkspaceID();
	$teamspace_id=$ui->TeamspaceID();
	//echo $teamspace_id;
	//if (IS_NULL($teamspace_id)) { echo "NULL teamspace"; } else { echo "Not null teamspace"; }
	SetTimezone($ui->Timezone());
	if (IS_NULL($ui->TeamspaceID())) { $teamspace_sql="IS NULL"; $teamspace_id="NULL"; } else { $teamspace_sql="= $teamspace_id"; }
}

/* CREATE AN INSTANCE OF THE WORKSPACE */
if (ISSET($_SESSION['sid']) && IS_NUMERIC($ui->WorkspaceID())) {
	require_once $GLOBALS['dr']."modules/workspace/classes/workspace_user_info.php";
	$wui=new WorkspaceUserInfo($_SESSION['user_id'],$ui->WorkspaceID());
}


/* JPGRAPH SETTINGS */
$jpgraph_font_dir=$dr."include/jpgraph/fonts/";

?>