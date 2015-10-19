<?php
/* SET THE ERROR MESSAGES TO MAX */
error_reporting(E_ALL);

//ini_set("error_reporting",1);

/* THIS ENSURES WE ARE ABLE TO CONTROL OUR INCLUDE FILES */
define( '_VALID_MVH', 1 );

/* SET THE TIMEZONE */
date_default_timezone_set('UTC');

/* set the error reporting level for this script */
//error_reporting(E_USER_ERROR | E_USER_WARNING | E_USER_NOTICE);

require_once "include/functions/errors/error_handler.php";

/* set to the user defined error handler */
set_error_handler("ErrorHandler");

/* START OUTPUT BUFFERING AND SEND HEADERS */
ob_start();

/* DISABLE CACHING */
header("Pragma: no-cache");

/* CHECK FOR AN INSTALLATION FILE */
if (!file_exists("site_config.php")) { header("Location:install/"); }
if (file_exists("install/")) { die ("Please remove the install directory before continuing"); }

/**** WE SPLIT UP THE CONFIGURATION FILE HERE SO THAT WE CAN POST THE USERNAME AND PASSWORD FROM ANYWHERE ****/

/* GENERAL CONFIG */
require_once "config.php";

/* DATABASE CONFIGURATION */

require_once "db_config.php";

/* THIS ALLOWS POSTING TO THE INDEX PAGE TO BE PICKED UP AND PROCESSED BEFORE WE DO CONFIG STUFF */
if (ISSET($_GET['dtask'])) {
	/**** LOGOUT ****/
	if ($_GET['dtask']=="logout" && ISSET($_SESSION['user_id'])) {
		require_once $dr."classes/login/logout.php";
		$logout=new Logout;
		$logout->SetCredentials($_SESSION['user_id']);
		$result=$logout->ExecuteLogout();
		if (!$result) { echo Alert("2"); }
	}
	/**** REMOVE LOGIN COOKIE ****/
	elseif ($_GET['dtask']=="remove_remember_me" && ISSET($_COOKIE['mvh_username'])) {
		setcookie("mvh_username",False);
	}
	/**** ACTIVATE WORKSPACE ****/
	elseif ($_GET['dtask']=="activate_workspace" && ISSET($_SESSION['user_id']) && ISSET($_GET['workspace_id'])) {
		require_once $dr."modules/workspace/classes/activate_workspace.php";
		$aw=new ActivateWorkspace;
		$aw->SetCredentials($_SESSION['user_id'],$_GET['workspace_id']);
		$result=$aw->Activate();
		if (!$result) { echo Alert("3",$aw->ShowErrors()); }
	}
	/**** DEACTIVATE WORKSPACE ****/
	elseif ($_GET['dtask']=="deactivate_workspace" && ISSET($_SESSION['user_id'])) {
		require_once $dr."modules/workspace/classes/activate_workspace.php";
		$aw=new ActivateWorkspace;
		$result=$aw->Deactivate($_SESSION['user_id']);
		if (!$result) { echo Alert("3",$aw->ShowErrors()); }
	}
	/**** ACTIVATE TEAMSPACE ****/
	elseif ($_GET['dtask']=="activate_teamspace" && ISSET($_SESSION['user_id']) && ISSET($_GET['teamspace_id'])) {
		require_once $dr."modules/teamspace/classes/activate_teamspace.php";
		$at=new ActivateTeamspace;
		$at->SetCredentials($_SESSION['user_id'],$_GET['teamspace_id']);
		$result=$at->Activate();
		if (!$result) { echo Alert("3",$at->ShowErrors()); }
	}
	/**** DEACTIVATE TEAMSPACE ****/
	elseif ($_GET['dtask']=="deactivate_teamspace" && ISSET($_SESSION['user_id'])) {
		require_once $dr."modules/teamspace/classes/activate_teamspace.php";
		$at=new ActivateTeamspace;
		$result=$at->Deactivate($_SESSION['user_id']);
		if (!$result) { echo Alert("3",$at->ShowErrors()); }
	}
}
/**** LOGIN MUST ALWAYS COME LAST ****/
if (ISSET($_POST['username']) && ISSET($_POST['password'])) {
	//echo "logging in now";
	if (ISSET($_POST['remember_me'])) { $remember_me="y"; } else { $remember_me="n"; }
	require_once $dr."modules/core/classes/login.php";
	$login=new Login;
	$setparameter_result=$login->SetParameters($_POST['username'],$_POST['password'],$remember_me);
	if ($setparameter_result) {
		$result=$login->Verify();
		if (!$result) { echo Alert("2"); }
	}
}

/* OTHER CLASSES AND COMMON INCLUDES */
require_once "common_config.php";

/********* CONTENT ALL GETS CALLED HERE ***********/
$head=new HTMLHead;
$head->IncludeFile("css");

/* CALL THE BODY AND FOOT FIRST */
$html_body=Body();
$html_foot=HTMLFoot();

/* SINCE THIS HANDLES DYNAMIC INCLUDES WE CALL IT LAST */
$html_head=$head->DrawHead();

echo $html_head;
echo $html_body;
echo $html_foot;

/********* CONTENT ALL GETS CALLED HERE ***********/

/* THIS IS THE BODY FUNCTION */
function Body() {
	$dr=$GLOBALS['dr'];
	$wb=$GLOBALS['wb'];
	GLOBAL $mi; /* PUT THE MODULE ID IN THE GLOBAL CONTEXT */
	$c="<table align='center' width='780' cellpadding='0' cellspacing='0' border='0' class='plain'>\n";

		$c.="<tr>\n";
			$c.="<td width='20' bgcolor='#3399CC'><img src='".$wb."images/curves/top_left.gif' width='20' height='42'></td>\n";
			//$c.="<td width='740' bgcolor='#66CC33'><a href='index.php'></a></td>\n";
			$c.="<td width='740' bgcolor='#66CC33'><a href='index.php'>".$GLOBALS['site_logo']."</a></td>\n";
			$c.="<td width='20' bgcolor='#3399CC'><img src='".$wb."images/curves/top_right.gif' width='20' height='42'></td>\n";
		$c.="</tr>\n";
		$c.="<tr>\n";
			$c.="<td bgcolor='#99CCFF' colspan='3'>\n";
			if (ISSET($_SESSION['user_id'])) {
				require_once $dr."include/functions/design/login_bar.php";
				$c.=LoginBar();
			}
			else {
				require_once $dr."include/functions/design/logout_bar.php";
				$c.=LogoutBar();
			}
			$c.="</td>\n";
		$c.="</tr>\n";
		/* NOT LOGGED IN AND NO MODULE IN QUERYSTRING */
		if (!ISSET($_SESSION['user_id']) && !ISSET($_GET['module'])) {
			require_once($dr."modules/core/functions/forms/login_form.php");
			$c.="<tr bgcolor='#ffffff' align='center'>\n";
				$c.="<td colspan='3'>\n";
				if (ISSET($_COOKIE['mvh_username'])) {
					$c.=LoginFormCookie();
				}
				else {
					$c.=LoginForm();
				}
				$c.="</td>\n";
			$c.="</tr>\n";
		}
		/* LOGGED IN & NO MODULE IN QUERYSTRING & NO MODULE SELECTED*/
		elseif (ISSET($_SESSION['user_id']) && !ISSET($_GET['module']) && ISSET($GLOBALS['ui']) && ISSET($GLOBALS['wui'])) {
			/* PROCESS THE ACTIVATION AND DEACTIVATION OF MODULES IN THE WORKSPACE HERE AS WE NEED UI TO BE SET */
			if (ISSET($_GET['wtask']) && $_GET['wtask']=="install_workspace_user_module") {
				require_once $dr."modules/workspace/classes/add_remove_user_workspace_module.php";
				$aruwm=new AddRemoveUserWorkspaceModule;
				$aruwm->SetParameters($_GET['module_id']);
				$result=$aruwm->AddRemove();
				//if (!$result) { echo Alert("3",$at->ShowErrors()); }
			}
			/* ACTIVATE THE TEAMSPACE MODULES */
			if (ISSET($_GET['wtask']) && $_GET['wtask']=="install_teamspace_user_module") {
				require_once $dr."modules/teamspace/classes/add_remove_user_teamspace_module.php";
				$arutm=new AddRemoveUserTeamspaceModule;
				$arutm->SetParameters($_GET['module_id']);
				$result=$arutm->AddRemove();
				//if (!$result) { echo Alert("3",$at->ShowErrors()); }
			}
			/* INCLUDE THE MAIN FILES FOR THE WORKSPACE */
			require_once($dr."modules/workspace/functions/browse/non_enterprise_workspace_modules.php");
			require_once($dr."include/functions/design/teamspace_slider.php");
			require_once($dr."include/functions/teamspace/user_teamspaces.php"); /* TODO: CHANGE THIS TO THE WORKSPACE FOLDER */
			//require_once($dr."modules/teamspace/functions/browse/user_available_modules.php");
			require_once($dr."modules/teamspace/classes/user_available_modules.php"); //

			$c.="<tr>\n";
				$c.="<td colspan='3'>\n";
				$c.="<table cellspacing='0'>\n";
					$c.="<tr>\n";
						if (IS_NUMERIC($GLOBALS['teamspace_id'])) {
							$c.="<td width='150' valign='top'>".UserAvailableModules()."</td>\n";
						}
						else {
							$obj_uam=new UserAvailableModules;
							if ($obj_uam->CountUserAvailableModules() > 0) {
								$c.="<td width='150' valign='top'>".TeamspaceSliderItems()."</td>\n";
							}
						}
						$c.="<td width='630'>".CurveBox(NonEnterpriseModules($GLOBALS['ui']->WorkspaceID(),$_SESSION['user_id'],$GLOBALS['wui']->RoleID(),True))."</td>\n";
						$c.="<td width='150' valign='top'>".UserTeamspaces()."</td>\n";
					$c.="</tr>\n";
				$c.="</table>\n";
				$c.="</td>\n";
			$c.="</tr>\n";
		}
		/* LOGGED IN, NO MODULE, NO WORKSPACE*/
		elseif (ISSET($_SESSION['user_id']) && !ISSET($_GET['module']) && EMPTY($workspace_id)) {
			require_once $dr."modules/workspace/functions/browse/select_workspace.php";
			require_once $dr."modules/workspace/functions/misc/menu.php";
			$c.="<tr>\n";
				$c.="<td colspan='3'>\n";
				$c.="<table cellspacing='0' class='plain_border'>\n";
					$c.="<tr>\n";
						$c.="<td>".SelectWorkspace()."</td>\n";
						if ($GLOBALS['ui']->GetInfo("default_role") != "y") {
							$c.="<td width='150' valign='top'>".Menu()."</td>\n";
						}
					$c.="</tr>\n";
				$c.="</table>\n";
				$c.="</td>\n";
			$c.="</tr>\n";
			//$c.=CurveBox(SelectWorkspace());
		}
		/* WITH A MODULE */
		elseif (ISSET($_GET['module']) && file_exists($dr."modules/".$_GET['module'].".php")) {

			$module_id=GetColumnValue("module_id","core_module_master","name",$_GET['module']);
			require_once $dr."modules/".$_GET['module'].".php";
			require_once $dr."classes/modules/module_id.php";
			$mi=new ModuleID();
			$module_result=$mi->Info($module_id);
			$anonymous_access=$mi->GetInfo("anonymous_access");

			$c.="<tr>\n";
				$c.="<td colspan='3'>";
				/* CHECK FOR ERRORS OR ACCESS DENIED */
				if ($module_result && $mi->CheckACL()) {
					$c.=LoadModule($module_id,$anonymous_access);
				}
				else {
					$c.=CurveBox("Access to module denied");
				}
				$c.="</td>\n";
			$c.="</tr>\n";
		}
		$c.="<tr>\n";
			$c.="<td width='20' bgcolor='#3399CC'><img src='".$wb."images/curves/white_bottom_left.gif' width='20' height='20'></td>\n";
			$c.="<td width='780' bgcolor='#ffffff' align='center'>".$GLOBALS['copyright_notice']."</td>\n";
			$c.="<td width='20' bgcolor='#3399CC'><img src='".$wb."images/curves/white_bottom_right.gif' width='20' height='20'></td>\n";
		$c.="</tr>\n";

	$c.="</table>\n";
	return $c;
}

/* HTML FOOTER FUNCTION */
function HTMLFoot() {
	$c="</body>\n";
	$c.="</html>\n";
	return $c;
}
?>