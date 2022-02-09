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
 * $Header:      /_rebuild/_updatelessons.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				Edit user lesson information
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");
	$db = new _ALTO_DB;
	$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_updatelessons.htm"));
if ( isset ( $_GET['action'] ) && $_GET['action'] == "update") 
{
		$_modidPK =$_GET['modidPK'];
		$_lessonidPK = $_GET['lessonidPK'];
		
	$_y ="SELECT * FROM tbl_mods WHERE tbl_mods.mod_id_PK = '$_modidPK'";
	$_o = $db->opendb($_y);
	foreach($_o as $_b) {
		$_m =$_b['_mods'];
	}
	 $_lsrs = "SELECT * 
	 		   FROM tbl_lessons 
			   WHERE  tbl_lessons.lesson_id_PK = '$_lessonidPK' 
			   AND tbl_lessons.mod_id_FK = '$_modidPK'";
//				   echo $_lsrs;
				   $_lsres = $db->opendb($_lsrs);
				   foreach($_lsres as $_g) 
				   {
				   		$_gcontent = $_g['_content'];
						$_gtitle = $_g['_title'];
						$_glessonidPK = $_g['lesson_id_PK'];
						$_glevel = $_g['_level'];	
						//echo $_gcontent;
						$tpl->set_var("_level",$_glevel);
						$tpl->set_var("_title",$_gtitle);
						$tpl->set_var("_content",$_gcontent);
						$tpl->set_var("lessonidPK",$_glessonidPK);
						
				   }

		$tpl->set_var("LESSON_NAME",$_m);
		$tpl->set_var("modidPK",$_modidPK);
}
	if ( isset ( $_POST['Submit'] ) && $_POST['Submit'] == "Save") 	{
	
	
		$_wm_title = $_POST['_title'];	  
		$_wm_content = $_POST['_content'];
		$_wm_modidPK = $_POST['modidPK'];
		$_wm_lessonidPK = $_POST['lessonidPK'];
 		$_wm_level = $_POST['_level'];
	
		$_wm_lessons_rs ="UPDATE tbl_lessons
	  					  SET tbl_lessons._title = \"".mysql_escape_string($_wm_title)."\", 
	                         tbl_lessons._content = \"".mysql_escape_string($_wm_content)."\",
							 tbl_lessons.mod_id_FK = '$_wm_modidPK',
							 tbl_lessons._level = '$_wm_level'
								
						  	WHERE tbl_lessons.lesson_id_PK = '$_wm_lessonidPK' 	 ";
						
 		$db->savedb($_wm_lessons_rs);
	
		$db->closedb();
		header("Location:_modlessons.php?modidPK=$_wm_modidPK");
	}	 
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>




							
		 
		  
  

									
	     

