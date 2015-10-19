<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MVH' ) or die( 'Direct Access to this location is not allowed.' );

function LoginBar($mobile=False) {
	$ui=$GLOBALS['ui'];
	$workspace_id=$ui->WorkspaceID();
	$teamspace_id=$ui->TeamspaceID();
	$s="<table class='plain' width='100%'>\n";
		$s.="<tr>\n";
			$s.="<td><a href='index.php'>Home</a> | ";
			if ($GLOBALS['use_wiki_help']) {
				$s.="<a href='".GetWikiUrlHelp()."' target='new'>Help</a> | ";
			}
			if (!EMPTY($workspace_id) && $mobile==False) {
				$s.="You are logged into: <a href='bin/workspace/unset.php'>".GetColumnValue("name","core_workspace_master","workspace_id",$workspace_id)."</a>";
			}
			if (!EMPTY($teamspace_id)) {
				$s.="<img src='images/nuvola/16x16/actions/forward.png' height='16' width='16'><a href='bin/teamspace/unset.php'>".GetColumnValue("name","core_teamspace_master","teamspace_id",$teamspace_id)."</a>";
			}
			$s.="</td>\n";
			if (!EMPTY($workspace_id)) {
				$s.="<form method='post' action='index.php?dtask=deactivate_workspace'><td><input type='submit' value='Logout Workspace' class='buttonstyle'></td></form>\n";
			}
			if ($mobile==False) {
				$s.="<td align='right'>Welcome, ".$ui->FullName()."</td>\n";
			}
			$s.="<form method='post' action='index.php?dtask=logout'><td><input type='submit' value='Logout' class='buttonstyle'></td></form>\n";
		$s.="</tr>\n";
	$s.="</table>\n";
	return $s;
}

function GetWikiUrlHelp() {
	$v=$GLOBALS['wiki_url'];
	$v.="doku.php?id=";
	$v.="lams";
	if (ISSET($_GET['module'])) {
		$v.=":".$_GET['module'];
	}
	if (ISSET($_GET['task']) && $_GET['task'] != "home" && !EMPTY($_GET['task'])) {
		$v.=":".$_GET['task'];
	}
	return $v;
}
?>