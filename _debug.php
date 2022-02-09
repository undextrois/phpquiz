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
 * $Header:      /_rebuild/_debug.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 			 real time quiz controller 
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");
$session = new _ALTO_Session(__ALTO_SESSION_USER__); 
//error_reporting(0);
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
 $tpl->set_file(array("hWND"=>"_html/_debug.htm"));
		 $_p = new __USERInfoClass__;
	     $_p->_gt_id = $useridPK;
	$_v =$_p->_gtUserInfo();
	$tpl->set_var("_membername",$_v[4]);
	$tpl->set_var("useridPK",$useridPK);
	if ( isset($_POST['Submit'] ) && $_POST['Submit'] == 'View Results' )
	{
	  $_DB->dbconnect();

        $_level_id = $_POST['level_id'];
	  $_pa_id_PK = $_POST['pa_id_PK'];
	  $_pa_quiz_id_FK = $_POST['quizidPK'];
	$_WB_Tbl_rs = "SELECT * FROM tbl_realanswers 
					   WHERE tbl_realanswers.ra_id_PK = '$_pa_id_PK'";
		$_Tbl_Pa_rs = "SELECT * FROM tbl_possibleanswers WHERE pa_quiz_id_FK='$_pa_quiz_id_FK'";
		$_rs_result = mysql_query($_Tbl_Pa_rs);
		$_nTotalq = mysql_num_rows($_rs_result);
		$_nScoreq = 0;
		$_qCtr = 0;
		while ( $_rw = mysql_fetch_array( $_rs_result ) )
		{
		  $_qCtr++;
		  $_cAns = $_rw['pa_real_answer'];
		  $_hgtAns = "ans_".$_qCtr;
		  $_gtAns = $_POST[$_hgtAns];
		  if ( $_cAns == $_gtAns )
		  {
			$_nScoreq++;
//			echo 'correct'.'<br>';
		  }
		else 
		 {
//			echo 'wrong'.'<br>';
		 }
		}		 	
	
	$_wb_msg = "You scored $_nScoreq out of $_nTotalq Questions";
	$tpl->set_var("WB_REMARKS",$_wb_msg);
	}
	$_wb_rating = array("Congratulations! You got every question right! Rating 100% PASSED ",
						"Not the best score, ! Rating FAILED",
						"Well done! You certainly know your stuff! Rating 75% PASSED",
						"Too bad - but there were a few that caught you out!  Rating FAILED");
						
	if ( $_nScoreq == $_nTotalq ) 
	{
//		$_wb_rating = "Congratulations! You got every question right! Rating 100% ";
	  $_Tbl_uInsertRating = "PASSED";
		 $_upgradeLevel = $_level_id;
		
		 $_wb_remarks = $_wb_rating[0];
	  $tpl->set_var("WB_RATING",$_wb_rating[0]);
	}
	elseif ($_nScoreq / $_nTotalq < 0.34) 
	{
	 $_upgradeLevel = 1;
	  $_Tbl_uInsertRating = "FAILED";
	  $_wb_remarks = $_wb_rating[1];
	  $tpl->set_var("WB_RATING",$_wb_rating[1]);
	}
	elseif ($_nScoreq / $_nTotalq > 0.67) 
	{
	  $_Tbl_uInsertRating = "FAILED";
	  $_upgradeLevel = 1;
	  $_wb_remarks = $_wb_rating[2];	
	  $tpl->set_var("WB_RATING",$_wb_rating[2]);
	}

		$_mod_id_PK = $_POST['modidPK'];
		$_quiz_id_PK = $_POST['quizidPK'];
		$_member_id_PK =$_POST['memberidPK'];
		$_level = $_POST['level'];
		$_wb_name = $_POST['member_name'];
		$_quiz_title = $_POST['quiz_title'];
//		echo $_upgradeLevel;	
	$_wb_mrs ="UPDATE tbl_memberlist SET _level = '$_upgradeLevel' WHERE _member_id_PK ='$_member_id_PK'";
		$db->savedb($_wb_mrs);

		$_tbl_grade = "INSERT INTO tbl_grades
					   SET gr_mod_id_FK ='$_mod_id_PK',
						   gr_quiz_id_FK = '$_quiz_id_PK', 
						   gr_member_id_FK = '$_member_id_PK',
						   gr_level_id_FK = '$_upgradeLevel',
						   gr_rating	= '$_Tbl_uInsertRating',
						   gr_remarks = '$_wb_remarks',
							gr_name = '$_wb_name',
							gr_quiz_name ='$_quiz_title',
						   gr_date =NOW()";	
		$db->savedb($_tbl_grade);
		
			$db->closedb();
	$tpl->set_var("gr_member_id_FK",$_member_id_PK);
	$tpl->parse('hWND', array('hWND'));
	$tpl->p('hWND');

?>