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
 * $Header:      /_rebuild/_genqresults.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				_results generator 
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
	$tpl->set_file(array("hWND"=>"_html/_genqresults.htm"));
	      $_p = new __USERInfoClass__;
	     $_p->_gt_id = $useridPK;
	$_v =$_p->_gtUserInfo();
 $_bee = $_v[4];
echo "<font class =\"mainblue\"><b>".$_bee."</b></font>";
print_r($_POST);
//Array ( [1] => A [2] => A [Submit] => View Results [modidPK] => 2 [quizidPK] => 5 [memberidPK] => 7 ) 
//steps 1 query tbl_questions , 
//		2 query tbl_realanswers

	
	
	
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>




