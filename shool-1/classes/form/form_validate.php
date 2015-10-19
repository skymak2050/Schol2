<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MVH' ) or die( 'Direct Access to this location is not allowed.' );

class FieldValidation {

	function FormName($form_name) {
		$this->form_name=$form_name;
	}

	function OpenTag() {
		echo "<script language='javascript'>\n";
		echo "function ValidateForm(theform) {\n";
	}

	function ValidateFields($arr) {
		//echo "function ValidateFields(theform){\n";
			$vals=explode(",", $arr);
			for ($i=0;$i<count($vals);$i++) {
				echo "if (theform.$vals[$i].value == \"\"){\n";
					echo "alert(\"One or more required fields, indicated by a *, are empty!\");\n";
					//echo "document.theform.getElementById('".$vals[$i]."').className='error_input';\n";
					echo "theform.".$vals[$i].".className='err_input';\n";
					echo "theform.".$vals[$i].".focus();\n";
					echo "return false;\n";
				echo "}\n";
			}
		//echo "}\n";
	}

	function SubmitOnce() {
		//echo "function SubmitOnce(theform) {\n";
			// if IE 4+ or NS 6+
			echo "if (document.all || document.getElementById) {\n";
				// hunt down "submit" and "reset"
				echo "for (i=0;i<theform.length;i++) {\n";
					echo "var tempobj=theform.elements[i];\n";
					echo "if(tempobj.type.toLowerCase()==\"submit\") {\n";
						echo "tempobj.disabled=true;\n";
					echo "}\n";
				echo "}\n";
			echo "}\n";
		//echo "}\n";
	}

	function OnlyInteger($fld) {
		echo "var _x = theform.".$fld.".value;
					if (parseInt(_x) != _x) {
  					alert('Only numbers allowed');
  					theform.".$fld.".focus();
  					theform.".$fld.".select();
  					return false;
  				}";
	}

	function CloseTag() {
		echo "}\n";
		echo "</script>\n";
	}
}
?>