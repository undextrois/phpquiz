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
 * $Header:      /_rebuild/_quiz_edit_question.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  edit quiz questions
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");
error_reporting(0);

$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_quiz_edit_question.htm"));
		$db = new _ALTO_DB;
//Array ( [quizidPK] => 13 [modidPK] => 1 [question_id_PK] => 36 [action] => edit ) 
	//SELECT * FROM tbl_questions WHERE tbl_questions.question_id_PK ='$_question_id_PK'
//print_r($_GET);
	if(isset($_GET['modidPK'] ) ) 
	{
		$_question_id_PK = $_GET['question_id_PK'];
		$_quizidPK = $_GET['quizidPK'];
		$_modidPK = $_GET['modidPK'];

		$_c = $db->opendb("SELECT * FROM tbl_questions WHERE tbl_questions.question_id_PK = '$_question_id_PK'");
		foreach($_c as $_y )
		{
			$_qq = $_y['questions_questions'];
		}
	$_aqs =	"SELECT tbl_possibleanswers.pa_id_PK,
		       tbl_possibleanswers.pa_id_FK, 
		       tbl_possibleanswers.pa_A, 
		       tbl_possibleanswers.pa_B, 
		       tbl_possibleanswers.pa_C, 
		       tbl_possibleanswers.pa_D, 
		       tbl_possibleanswers.pa_real_answer
			FROM 
			   tbl_possibleanswers 
			WHERE tbl_possibleanswers.pa_id_FK = '$_question_id_PK'";
			$_vrs = $db->opendb($_aqs);
//			$tpl->set_block("hWND","BLOCK","ROW");
			foreach ($_vrs as $_zx) 
			{
				$_pa_id_PK =$_zx['pa_id_PK'];  
				$_pa_id_FK = $_zx['pa_id_FK'];  
				$_paA = $_zx['pa_A'];  
				$_paB =$_zx['pa_B'];  
				$_paC = $_zx['pa_C'];  
				$_paD = $_zx['pa_D'];  
				$_ra_realanswer = $_zx['pa_real_answer'];  
			$tpl->set_var("questions_questions",$_qq);
			$tpl->set_var("pa_id_PK",$_pa_id_PK);
			$tpl->set_var("pa_id_FK",$_pa_id_FK);
			$tpl->set_var("A",$_paA);
			$tpl->set_var("B",$_paB );
			$tpl->set_var("C",$_paC);
			$tpl->set_var("D",$_paD);
			$tpl->set_var("ra_realanswer",$_ra_realanswer);
		//	$tpl->set_var("questions_questions",$_qq);
		//	$tpl->parse("ROW","BLOCK",true);
			}
			$tpl->set_var("question_id_PK",$_question_id_PK);
			$tpl->set_var("quizidPK",$_quizidPK );
			$tpl->set_var("modidPK",$_modidPK);
  }
	if(isset($_POST['action'] ) && $_POST['action'] == 'update_question') 
	{
/*		print_r($_POST);
	Array ( [questions_questions] => Q 
			[A] => A 
			[B] => B 
			[C] => C 
			[D] => D 
			[ra_realanswer] => D 
			[Submit] => Update Quiz Question 
			[pa_id_PK] => 36 
			[pa_id_FK] => 36 
			[question_id_PK] => 36 
			[quizidPK] => 13 
			[modidPK] => 1 
			[action] => update_question ) 
*/	
	$_ra_realanswer	= $_POST['ra_realanswer']; 
    $_pa_id_PK =$_POST['pa_id_PK'];  
	$_pa_id_FK =$_POST['pa_id_FK'];  
	$_quizidPK =$_POST['quizidPK'];  
	$_modidPK =$_POST['modidPK'];  
	$_question_id_PK =$_POST['question_id_PK'];  
	$_questions_questions =$_POST['questions_questions'];  

	$_K = "UPDATE `tbl_questions` 
		   SET `questions_questions` = '$_questions_questions' 
		   WHERE `question_id_PK` ='$_question_id_PK' ";
		   $db->savedb($_K);
	
	$_A =$_POST['A'];  
	$_B=$_POST['B'];
	$_C = $_POST['C'];
	$_D = $_POST['D']; 
			$db->savedb("UPDATE tbl_possibleanswers 
						 SET pa_A = '$_A',
  							 pa_B ='$_B',
							 pa_C = '$_C',
 							 pa_D = '$_D',
							pa_real_answer = '$_ra_realanswer'
						WHERE tbl_possibleanswers.pa_id_FK = '$_question_id_PK'");			
		

	header("Location:_quizupdate.php?modidPK=$_modidPK&quizidPK=$_quizidPK");

	}
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>	
	
		









