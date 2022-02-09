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
 * $Header:      /_rebuild/_php_takethequiz.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 			 		realtime quiz handler
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
//echo $useridPK;
$db= new _ALTO_DB;
$tpl = new Template(".","keep");
	$tpl->set_file(array("hWND"=>"_html/_takethequiz.htm"));
	      $_p = new __USERInfoClass__;
	     $_p->_gt_id = $useridPK;
	$_v =$_p->_gtUserInfo();
 $_bee = $_v[4];
echo "<font class =\"mainblue\"><b>".$_bee."</b></font>";

//	print_r($_GET);
	$_modidPK= $_GET['modidPK'];
	$_quizidPK = $_GET['quizidPK'];
	$_level = $_GET['level'];
	
//	bartArray ( [modidPK] => 2 [quizidPK] => 5 [action] => takeit [level] => 1 ) 
	$tpl->set_var(array('modidPK' =>$_modidPK,
						'quizidPK' =>$_quizidPK,
						'useridPK' => $useridPK) );
	$tpl->set_var("level",$_level);
						
	
	$_cccc = "SELECT * FROM tbl_mods WHERE tbl_mods.mod_id_PK = '$_modidPK'";
	$_cee = $db->opendb($_cccc);
	foreach($_cee as $_jo9) {
		$_subject = $_jo9['_mods'];
		$tpl->set_var("_subject",$_subject);
	}
	$_RS_PHP = "SELECT * FROM tbl_quiz WHERE tbl_quiz.mod_id_FK = '$_modidPK' ";
	$_V =$db->opendb($_RS_PHP);

	foreach($_V as $_j) {
		$_quiz = $_j['quiz_title'];
		$_id = $_j['quiz_id_PK'];
		$_level_id = $_j['quiz_level'];
		}	
	$_QRS = "SELECT * FROM tbl_questions 
			 WHERE tbl_questions.question_id_FK = '	$_quizidPK' 
			 AND tbl_questions.question_mod_id_FK = '$_modidPK'";
	$_i =  $db->opendb($_QRS);
$_b = count($_i);
//echo $_b;
$_ctr = 1;
	$tpl->set_block("hWND","BLOCK","ROW");
	foreach($_i as $_jj) 
	{
			$_questions_questions = $_jj['questions_questions'];
			$_question_id_PK = $_jj['question_id_PK']; 
			$_QRT = "SELECT * FROM tbl_possibleanswers WHERE tbl_possibleanswers.pa_id_FK = '$_question_id_PK'";
			$_ol =  $db->opendb($_QRT);

			foreach($_ol as $_om) 
			{
			 $_pa_id_PK = $_om['pa_id_PK'];
			 $_pa_id_FK = $_om['pa_id_FK'];
			 $_pa_A  = $_om['pa_A'];
			 $_pa_B  = $_om['pa_B'];
			 $_pa_C  = $_om['pa_C'];
			 $_pa_D  = $_om['pa_D'];
			   if ( $_ctr > 1 )
			   {
				 $_rbn = "$_ctr";
			   }
			   else 
			   {
				 $_rbn = "$_ctr";
			   }
		
			$_hiddenFld = "<input type=\"hidden\" name=\"quest.$_rbn\" value=\"$_question_id_PK\">";
			$_ss = $_hiddenFld."$_rbn.) ".$_questions_questions." <br><br> 
						A.)"."<input type=\"radio\" name=\"ans_$_rbn\" value=\"$_pa_A\">".$_pa_A."<br>
						B.)"."<input type=\"radio\" name=\"ans_$_rbn\" value=\"$_pa_B\">".$_pa_B."&nbsp;&nbsp;&nbsp;
				   <br> "."
				   		C.)"."<input type=\"radio\" name=\"ans_$_rbn\" value=\"$_pa_C\">".$_pa_C."<br>"."
						D.)"."<input type=\"radio\" name=\"ans_$_rbn\" value=\"$_pa_D\">".$_pa_D."<br><br>";
				$tpl->set_var("quiz_title",$_quiz);							
				$tpl->set_var("level_id",$_level_id);
				$tpl->set_var('pa_id_PK',$_pa_id_PK);
				$tpl->set_var(array("_quiz" => $_ss ));
				$tpl->set_var("question_id_PK",$_question_id_PK);
				$tpl->set_var("_limit",$_b);
			 $_ctr++;

			}
		//	$tpl->set_var("question_id_PK",$_question_id_PK);
			$tpl->set_var("member_name",$_bee); 
			$tpl->parse("ROW","BLOCK",true);	
	}		
	
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>




