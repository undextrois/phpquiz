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
 * $Header:      /_rebuild/_phpquiz.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				Shows the individual quiz for a particular user and mods
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");
$session = new _ALTO_Session(__ALTO_SESSION_USER__); 
error_reporting(0);
if($session->_alto_session_auth() == false){
	$session->_alto_session_cleanup();
	header("index.php");
}

$username = $session->_alto_session_uget();
$useridPK = $session->useridFK;
//echo $useridPK;
$db= new _ALTO_DB;
$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_phpquiz.htm"));
	      $_p = new __USERInfoClass__;
	     $_p->_gt_id = $useridPK;
	$_v =$_p->_gtUserInfo();
	$tpl->set_var("_membername",$_v[4]);
	
	$_type = $_GET['type'];	
	$_modid = $_GET['modid'];
	$_level = $_GET['level'];
 $_DETECT_USR = "SELECT * FROM tbl_grades WHERE gr_member_id_FK = '$useridPK'";
	
	$_RS_PHP = "SELECT * FROM tbl_quiz WHERE tbl_quiz.mod_id_FK = '$_modid' ";
	$_V =$db->opendb($_RS_PHP);
	$_gv =count($_V) ;
	
	
	$tpl->set_block("hWND","WCQuizListingBlock","ROW");
if ($_gv > 0 ) 
 {
			
	foreach($_V as $_j) 
	{
		$_quiz = $_j['quiz_title'];
		$_id = $_j['quiz_id_PK'];

		$_url_quiz = "<a href =\"_php_takethequiz.php?modidPK=$_modid&quizidPK=$_id&action=takeit&level=$_level\"> $_quiz</a>";
		$tpl->set_var(array("QUIZ_TITLE" => $_url_quiz,
							"modidPK" =>$_modid,
							"QUIZ_ID" => $_id));
		$_USR_RATING = "FAILED";
		$tpl->set_var("QUIZ_USER_RATING",$_USR_RATING);

		$tpl->set_var("QUIZ_LEVEL",$_level);
		$tpl->parse("ROW","WCQuizListingBlock",true);						
	}	
 }
 else {
		$_ERRMSH = "NO AVAILABLE QUIZ"; 
 		$tpl->set_var("ROW",$_ERRMSH);		
 }
		$tpl->set_var("type",$_type);
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>	






