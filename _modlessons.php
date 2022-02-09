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
 * $Header:      /_rebuild/_modlessons.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				list view lesson mods
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");



$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_modlessons.htm"));
		$db = new _ALTO_DB;
error_reporting(0);
$_modidPK =$_GET['modidPK'];
		$tpl->set_var("modidPK",$_modidPK);

 $_ptr = new  __USERInfoClass__;
$_k = $_ptr->_gtModInfo($_modidPK);

	$tpl->set_var("LESSON_NAME",$_k[1]);
	$_MODS_RS = "SELECT * FROM tbl_lessons WHERE tbl_lessons.mod_id_FK = '$_modidPK'";
	$_v = $db->opendb($_MODS_RS);
	$_c = count ($_v);
	if($_c > 0 )
	{

	$tpl->set_block("hWND","_BLOCK","ROW");

//	count($_v) ;
		foreach($_v as $_r)	
		{
			$_lessonidPK = $_r['lesson_id_PK'];
			$_modidPK =$_r['mod_id_FK'];
			$_title = $_r['_title'];
			$_content =	$_r['_content'];
$_url ="|&nbsp; <a href=\"_modlessons.php?modidPK=$_modidPK}&lessonidPK=$_lessonidPK&action=delete\" class=\"linkmail\">DELETE&nbsp;</a></span><span class=\"titleblue\">&nbsp;| 
                  <a href=\"_updatelessons.php?modidPK=$_modidPK&lessonidPK=$_lessonidPK&action=update\" 
				  class=\"linkmail\"> 
                  UPDATE LESSON</a>";
			$tpl->set_var("lesson_id_PK",$_lessonidPK);
			$tpl->set_var("lessonidPK",$_lessonidPK);
			$tpl->set_var("_title",$_title);
			$tpl->set_var("_url",$_url);
			$tpl->set_var("modidPK",$_modidPK);
			$tpl->set_var("_mods",$_mods);
			$tpl->parse("ROW","_BLOCK",true);
		}
    }
	else 
	{
		$_m = "EMPTY LESSONS";
		$tpl->set_var("lesson_id_PK","");
				$tpl->set_var("_url","");
			$tpl->set_var("lessonidPK","");
			$tpl->set_var("_title",$_m);
	$tpl->set_var("_mods",$_m );
//	$tpl->parse("ROW",$_m);
	}

/*
	$_admin_rs = "SELECT * FROM tbl_memberlist,tbl_userlist WHERE tbl_memberlist._member_id_PK = tbl_userlist._user_id_PK";

	$_b = $db->opendb($_admin_rs);
		$tpl->set_block("hWND","_BLOCK","ROW");
	foreach($_b as $_j ) 
	{
		$_memberidPK = $_j['_member_id_PK'];
		$_lastname = $_j['_lastname'];
		$_firstname = $_j['_firstname'];
		$tpl->set_var("_lastname",$_lastname);
		$tpl->set_var("_firstname",$_firstname);
		$tpl->set_var("member_id_PK",$_memberidPK); 
	$tpl->parse("ROW","_BLOCK",true);
	}
if (isset($_GET['action'] ) && $_GET['action'] == 'delete' ) {
	$_id =	$_GET['memberidPK'];
	$_PATCH = "DELETE FROM tbl_memberlist
			  WHERE tbl_memberlist._member_id_PK = '$_id'";
  $db->savedb($_PATCH);
	$_C =	"DELETE FROM tbl_userlist WHERE tbl_userlist._member_id_FK = '$_id'";
	$db->savedb($_C);
	header("Location:_cpanel.php?memberidPK=$_id");
}
if (isset($_GET['action'] ) && $_GET['action'] == 'logout' ) {
	header("Location:_admin.php");
}
*/
if ( isset($_GET['action'] ) && $_GET['action'] == 'delete') {
	$_id = $_GET['modidPK'];
	$_lessonidPK = $_GET['lessonidPK'];
	$_DELETE_RS = "DELETE FROM tbl_lessons WHERE lesson_id_PK = '$_lessonidPK'";
	$db->savedb($_DELETE_RS);
	header("Location:_modlessons.php?modidPK=$_modidPK ");
}
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>