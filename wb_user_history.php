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
 * $Header:      /_rebuild/wb_user_history.php, v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 			 quiz history listings 
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");
$session = new _ALTO_Session(__ALTO_SESSION_USER__); 
error_reporting(0);
	if($session->_alto_session_auth() == false)
	{
		$session->_alto_session_cleanup();
		header("index.php");
	}
	$username = $session->_alto_session_uget();
	$useridPK = $session->useridFK;
//print_r($_POST);
	  $db  = new _ALTO_DB;	
	 $tpl = new Template(".","keep");
 $tpl->set_file(array("hWND"=>"_html/wb_user_history.htm"));
		 $_p = new __USERInfoClass__;
	     $_p->_gt_id = $useridPK;
	$_v =$_p->_gtUserInfo();
	$tpl->set_var("_membername",$_v[4]);
	$tpl->set_var("useridPK",$useridPK);
	$_gr_member_id_FK = $_GET['gr_member_id_FK'];
	
		$_grTBL = "SELECT * FROM tbl_grades WHERE gr_member_id_FK='$_gr_member_id_FK'";
		$_grRS =$db->opendb($_grTBL);
		$_nRs = count($_grRS);
//echo $_nRs;
	//	if( $_nRS > 0 ) 
	//	{
		$tpl->set_block("hWND","WCGradeListingBlock","ROW");
			foreach( $_grRS as $_grRW ) 
			{
				echo $_gr_id_PK;
				$_gr_id_PK = $_grRW['gr_id_PK'];
				$_gr_mod_id_FK = $_grRW['gr_mod_id_FK'];
				$_gr_quiz_id_FK = $_grRW['gr_quiz_id_FK'];
				$_gr_member_id_FK = $_grRW['gr_member_id_FK'];
				$_gr_level_id_FK = $_grRW['gr_level_id_FK'];
				$_gr_rating = $_grRW['gr_rating'];
				$_gr_remarks = $_grRW['gr_remarks'];
				$_gr_date = $_grRW['gr_date'];
				$_gr_name = $_grRW['gr_name'];
				$tpl->set_var("gr_id_PK",$_gr_id_PK);
				$tpl->set_var("gr_mod_id_FK",$_gr_mod_id_FK);
				$tpl->set_var(array("gr_quiz_id_FK" => $_gr_quiz_id_FK,
								"gr_member_id_FK" => $_gr_member_id_FK,
								"gr_level_id_FK" =>$_gr_level_id_FK,
								"gr_rating" => $_gr_rating,
								"gr_remarks" => $_gr_remarks,
								"gr_date" => $_gr_date,
								"gr_name" => $_gr_name )) ;
				$tpl->parse("ROW","WCGradeListingBlock",true);
			 }
//		}
	//	else 
	//	{
//			$_errmsg = "<font face=\"Courier New, Courier, mono\"> QUIZ LOGS EMPTY </font> ";
//			$_errmsg = "<a font class =\"titleblue\"> NO EXAM TAKEN </font>";
		//	$tpl->set_var("ROW",$_errmsg);	
		//}
	 
	$tpl->parse('hWND', array('hWND'));
	$tpl->p('hWND');
?>

		
		
	


