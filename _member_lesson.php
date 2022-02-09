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
 * $Header:      /_rebuild/_member_lesson.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  Defines the lesson module listings
 ********************************************************************************/
error_reporting(0);
	require_once ("_config/wc_config.inc.php");
	$session = new _ALTO_Session(__ALTO_SESSION_USER__); 
	if($session->_alto_session_auth() == false)
	{
		$session->_alto_session_cleanup();
		header("index.php");
	}
	$_type = $_GET['type'];
	$username = $session->_alto_session_uget();
	$useridPK = $session->useridFK;
	$tpl = new Template(".","keep");
	$tpl->set_file(array("hWND"=>"_html/wb_rw_mlesson.htm"));
//	$tpl->set_file(array("hWND"=>"_html/_member_lesson.htm"));
	$_p = new __USERInfoClass__;
	$_p->_gt_id = $useridPK;
	$_v =$_p->_gtUserInfo();
	$tpl->set_var("_membername",$_v[4]);
	$db = new _ALTO_DB;


	$_DETECT = "SELECT * FROM tbl_grades WHERE gr_member_id_FK = '$useridPK'";
	$_DRS = $db->opendb($_DETECT);
	$_cdrs = count($_DRS);
	if( $_cdrs > 0 ) 
	{
	  foreach($_DRS as $_bw) 
	  {
	 	$_bw_level = $_bw['gr_level_id_FK'];
	  }
	}	
	else 
	{
	  $_USER = "SELECT * FROM tbl_memberlist WHERE tbl_memberlist._member_id_PK = '$useridPK'";
	  $_qPatch = $db->opendb($_USER);
	  foreach( $_qPatch as $_qpRW ) 
	  {
		$_bw_level = $_qpRW['_level'];
	  }	
	}	
//	SELECT * FROM tbl_lessons
	
	echo $_bw_level;
	$_j = "SELECT * FROM tbl_lessons WHERE mod_id_FK = '$_type' AND _level = '$_bw_level'";
	$_r = $db->opendb($_j);
	
	
	$tpl->set_block("hWND","WCMemberListingBlock","ROW");
	foreach($_r as $_rw ) 
	{
		$_rw_level =$_rw['_level'];
		$_rw_modidFK =$_rw['mod_id_FK'];
		$_rw_lev =$_rw['_level'];
		$_rw_title =$_rw['_title'];
		$_rw_content = $_rw['_content'];
		$_rw_lessonidPK =$_rw['lesson_id_PK'];
//_lesson_id_PK=$_rw_lessonidPK&modidPK=$_rw_modidFK&type=$_rw_modidFK&bw_level=$_bw_level
		$tpl->set_var("_lesson_id_PK",$_rw_lessonidPK);
		$tpl->set_var("modidPK",$_rw_modidFK);
		$tpl->set_var("type",$_type);
		$tpl->set_var("bw_level",$_bw_level);
		$tpl->set_var("_type",$_type);
		$_user_grade = "FAILED";
		$_url_lesson = "<a href =\"wb_usr_lesson.php?_lesson_id_PK=$_rw_lessonidPK&modidPK=$_rw_modidFK&type=$_rw_modidFK&bw_level=$_bw_level\" title=\"$_rw_title\"> $_rw_title </a>";
		$_url_exam = "<a href =\"_phpquiz.php?type=$_type&modid=$_type&level=$_rw_level&lessonidPK=$_rw_lessonidPK&bw_level=$_bw_level\" title=\"Test your skill\"> TAKE THE EXAM </a>";
//	_phpquiz.php?type={_type}&modid={_type}&level={_level}



		$tpl->set_var(array( "LESSON_TITLE" => $_url_lesson,
							"LESSON_LEVEL" => $_rw_lev,
							"LESSON_CONTENT" => $_rw_content,
							"USR_GRADE" => $_user_grade,							
							"URL_EXAM" => $_url_exam,
					
							"_lesson_id_PK" =>$_rw_lessonidPK,
							"modidPK"=> $_rw_modidFK ) );
	$tpl->parse("ROW","WCMemberListingBlock",true);					
	}
	$tpl->set_var("bw_level",$_bw_level	);
	$tpl->parse('hWND', array('hWND'));
	$tpl->p('hWND');
?>