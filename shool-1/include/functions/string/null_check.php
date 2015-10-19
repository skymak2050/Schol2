<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MVH' ) or die( 'Direct Access to this location is not allowed.' );

function NullCheck($v) {
	if (IS_NULL($v) || EMPTY($v)) {
		return "NULL";
	}
	else {
		return $v;
	}
}
?>