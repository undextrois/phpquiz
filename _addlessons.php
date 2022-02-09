<?PHP
/*********************************************************************************
 * The contents of this file are subject to the Wildchrome Software Paid License 1.1
 * ("License"); You may not use this file except in compliance with the 
 * License. You may obtain a copy of the License at http://www.wildchrome.org/license
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  Webomancer Source Code
 * The Initial Developer of the Original Code is Wildchrome Software, Inc.
 * Portions created by Wildchrome are Copyright (C) Wildchrome Software, Inc.;
 * All Rights Reserved.
 * 
 ********************************************************************************/
/*********************************************************************************
 * $Header:      /_rebuild/_addlessons.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				aDD NEw lesson modules
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");
error_reporting(0);
	$db = new _ALTO_DB;
	$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_addlessons.htm"));
if ( isset ( $_GET['action'] ) && $_GET['action'] == "add") 
{
		$_modidPK =$_GET['modidPK'];

	$_y ="SELECT * FROM tbl_mods WHERE tbl_mods.mod_id_PK = '$_modidPK'";
	$_o = $db->opendb($_y);
	foreach($_o as $_b) {
		$_m =$_b['_mods'];
	}
		$tpl->set_var("LESSON_NAME",$_m);
		$tpl->set_var("modidPK",$_modidPK);
}
	if ( isset ( $_POST['Submit'] ) && $_POST['Submit'] == "Save") 	{
	
	
		$_wm_title = $_POST['_title'];	  
		$_wm_content = $_POST['_content'];
		$_wm_modidPK = $_POST['modidPK'];
		$_wm_level = $_POST['_level'];
	
		$_wm_lessons_rs ="INSERT INTO tbl_lessons
	  					  SET tbl_lessons._title = \"".mysql_escape_string($_wm_title)."\", 
	                          tbl_lessons._content = \"".mysql_escape_string($_wm_content)."\",
							  tbl_lessons._level = \"".mysql_escape_string($_wm_level)."\", 	
							  tbl_lessons.mod_id_FK = '$_wm_modidPK'";
						
 		$db->savedb($_wm_lessons_rs);
	
		$db->closedb();
		header("Location:_modlessons.php?modidPK=$_wm_modidPK");
	}	 
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>




							
		 
		  
  

									
	     

