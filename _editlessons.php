<?php
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
 * $Header:      /_rebuild/_editlessons.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				edit UI page
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");
	$db = new _ALTO_DB;
	$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_editlessons.htm"));
error_reporting(0);
if ( isset ( $_GET['action'] ) && $_GET['action'] == "edit") 
{
		$_modidPK =$_GET['modidPK'];
		$_lessonidPK = $_GET['lessonidPK'];
	$_y ="SELECT * FROM tbl_mods WHERE tbl_mods.mod_id_PK = '$_modidPK'";
	$_o = $db->opendb($_y);
	foreach($_o as $_b) {
		$_m =$_b['_mods'];
	}
		$tpl->set_var("lessonidPK",$_lessonidPK);
		$tpl->set_var("LESSON_NAME",$_m);
		$tpl->set_var("modidPK",$_modidPK);
$_LL = " SELECT * FROM tbl_lessons WHERE tbl_lessons.lesson_id_PK = '$_lessonidPK'";		
$_llrs = $db->opendb($_LL);
	foreach($_llrs as $_rw ) {
		$_title =$_rw['_title'];
		$_content = $_rw['_content'];
		echo $_content;
		$tpl->set_var(array("_title" => $_title,
							"_content " => $_content));
	}
}
	if ( isset ( $_POST['Submit'] ) && $_POST['Submit'] == "Save") 	{
	
	
		$_wm_title = $_POST['_title'];	  
		$_wm_content = $_POST['_content'];
		$_wm_modidPK = $_POST['modidPK'];

	
		$_wm_lessons_rs ="UPDATE tbl_lessons
	  					 SET tbl_lessons._title = \"".mysql_escape_string($_wm_title)."\", 
	                         tbl_lessons._content = \"".mysql_escape_string($_wm_content)."\",
						 WHERE 	
							 tbl_lessons.mod_id_FK = '$_wm_modidPK'";
						
 		$db->savedb($_wm_lessons_rs);
	
		$db->closedb();
		header("Location:_modlessons.php?modidPK=$_wm_modidPK");
	}	 
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>




							
		 
		  
  

									
	     

