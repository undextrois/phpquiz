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
 * $Header:      /_rebuild/_quizlist.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				list view quiz mods
 ********************************************************************************/

require_once ("_config/wc_config.inc.php");

/*
$session = new _ALTO_Session(__ALTO_SESSION_USER__); 
error_reporting(0);
if($session->_alto_session_auth() == false){
	$session->_alto_session_cleanup();
	header("index.php");
}

$username = $session->_alto_session_uget();
$useridPK = $session->useridFK;
//echo $useridPK;*/
error_reporting(0);
$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_quizlist.htm"));
		$db = new _ALTO_DB;
//print_r($_GET);
	if(isset($_GET['modidPK']) ) 
	{
		$_modidPK = $_GET['modidPK'];
		$_quizidPK =$_GET['quizidPK'];
		$tpl->set_var("modidPK",$_modidPK);
		$tpl->set_var("quizidPK",$_quizidPK);
	}
	$_QRS ="SELECT * FROM tbl_quiz 
			WHERE tbl_quiz.mod_id_FK = '$_modidPK'";
	$_ii =	$db->opendb($_QRS);
	$tpl->set_block("hWND","_BLOCK","ROW");
	$_fc = count($_ii);
if($_fc > 0 ) 
{
	foreach($_ii as $_r)	
	{
	 $_quizidPK = $_r['quiz_id_PK'];
	 $_quiztitle =$_r['quiz_title'];
	 $tpl->set_var("quizidPK",$_quizidPK);
	 $tpl->set_var("_title",	$_quiztitle);		
     $tpl->parse("ROW","_BLOCK",true);	
    }
}
else 
{
		$_m = "EMPTY QUIZ ";
//		$tpl->set_var("lesson_id_PK","");
//				$tpl->set_var("_url","");
		 $tpl->set_var("quizidPK","");
	 $tpl->set_var("_title",$_m);
$tpl->parse("ROW","_BLOCK",true);
//	$tpl->set_var("_mods",$_m );
}	
	if( isset($_GET['action']) && $_GET['action'] == 'delete' ) 
	{
		//print_r($_GET);//Array ( [modidPK] => 1 [quizidPK] => 9 [action] => delete ) 
		$_modidPK	= $_GET['modidPK'];
		$_quizidPK = $_GET['quizidPK'];
		$_qRS="SELECT tbl_questions.question_id_PK
		       FROM tbl_questions
		       WHERE tbl_questions.question_id_FK = '$_quizidPK'
		       AND tbl_questions.question_mod_id_FK = '$_modidPK'";
			   $_rsO = $db->opendb($_qRS);
				foreach($_rSO as $_rso_rw ) {
					$_rw_q_idPK= $_rso_rw['question_id_PK'];
				}	
		$_paRS ="SELECT * 
				 FROM tbl_possibleanswers
				 WHERE tbl_possibleanswers.pa_id_FK = '$_rw_q_idPK'";
				$_paO = $db->opendb($_paRS);
				foreach($_paO as $_rw ) {
					$_rw_pa_idPK=$_rw['pa_id_PK'];
				}
		//delete section goes here
			$_delrs_RA ="DELETE FROM tbl_realanswers WHERE tbl_realanswers.ra_id_PK = '$_rw_pa_id_PK'";
				$db->savedb($_delrs_RA);
			$_delrs_PA = "DELETE FROM tbl_possibleanswers WHERE tbl_possibleanswers.pa_id_FK ='$_rw_q_idPK'";
				$db->savedb($_delrs_PA);
			$_delrs_Q = "DELETE FROM tbl_questions WHERE tbl_questions.question_id_FK = '$_quizidPK'
					     AND tbl_questions.question_mod_id_Fk = '$_modidPK'";
				$db->savedb($_delrs_Q);
			$_delrs_Qz = "DELETE FROM tbl_quiz WHERE tbl_quiz.quiz_id_PK = '$_quizidPK'
	      				  AND tbl_quiz.mod_id_FK ='$_modidPK' ";	   
				$db->savedb($_delrs_Qz);
			header("Location:_quizlist.php?modidPK=$_modidPK&quizidPK=$_quizidPK");
			

	}
					
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>	

	


