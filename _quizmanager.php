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
 * $Header:      /_rebuild/_quizmanager.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  Engine Core Controller for Quiz Real time quiz generation 
 
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");
error_reporting(0);

$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_quizmanager.htm"));
		$db = new _ALTO_DB;
/*
CREATE TABLE `tbl_questions` (
  `question_id_PK` smallint(12) NOT NULL auto_increment,
  `question_id_FK` smallint(12) NOT NULL default '0',
  `question_mod_id_FK` smallint(12) NOT NULL default '0',
  `questions_questions` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`question_id_PK`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

*/
		

if(isset($_GET['modidPK'] ) ) {
		$_m = $_GET['modidPK'];
		$_q =$_GET['quizidPK'];
	//	echo $_m.$_q;
 $_rs = "SELECT * FROM tbl_questions 
WHERE tbl_questions.question_id_FK = '$_q' 
AND tbl_questions.question_mod_id_FK = '$_m`'  ";
		//$tpl->set_var()		
$_k = $db->opendb($_rs);
		$tpl->set_var("quizidPK",$_q);
		$tpl->set_var("modidPK",$_m);
			$tpl->set_block("hWND","BLOCK","ROW");
		foreach($_k as $_u ) {
		$_qidPK =	$_u['question_id_PK'];
		$_qq =	$_u['questions_questions'];

		$tpl->set_var(array("qidPK" => $_qidPK,
							"question" => $_qq) );
			
						$tpl->parse("ROW","BLOCK",true);				
		}
  }
	
	if(isset($_GET['action'] ) && $_GET['action'] == 'delete' ) {
		$_quizidPK =$_GET['quizidPK'];
		$_modidPK =$_GET['modidPK'];
		
	$_F ="SELECT * FROM tbl_questions WHERE question_id_FK='$_quizidPK' AND question_mod_id_FK='$_modidPK'"; 
	$_ff = $db->opendb($_F);
	foreach($_ff as $_gg) {
		$_question_id_PK = $_gg['question_id_PK'];
	}
	$_cv = $db->opendb("SELECT * FROM tbl_possibleanswers  WHERE tbl_possibleanswers.pa_id_PK = '$_question_id_PK'");
	foreach($_cv as $_cb ) {
		$_pa_id_FK =$_cb['pa_id_FK'];
	}
//	$db->savedb("DELETE FROM tbl_realanswers WHERE tbl_realanswers.ra_id_FK = '$_pa_id_FK'");
	$db->savedb("DELETE FROM tbl_possibleanswers WHERE tbl_possibleanswers.pa_id_PK = '$_question_id_PK'");
	$db->savedb("DELETE FROM tbl_questions WHERE question_id_FK='$_quizidPK' AND question_mod_id_FK='$_modidPK'");
	header("Location:_quizmanager.php?modidPK=$_modidPK&quizidPK=$_quizidPK");
	}

		if ( isset($_POST['action'] ) && $_POST['action'] == 'Y') {

				$_modidPK = $_POST['modidPK'];
				$_quizidPK = $_POST['quizidPK'];
				$_ansA = $_POST['_answerA'];
				$_ansB = $_POST['_answerB'];
				$_ansC = $_POST['_answerC'];
				$_ansD = $_POST['_answerD'];	
				$_correct_answer = $_POST['pa_real_answer'];
				$_question = $_POST['_question'];
/*
				$_hCAnswer = $_POST['correct'];
				if($_hCAnswer == 'Answer A') {
					$_rAnswer = "A";
				}
				else if($_hCAnswer == 'Answer B' ) {
					$_rAnswer = "B";
				}
				else if($_hCAnswer == 'Answer C' ) {
					$_rAnswer = "C";
				}
				else if($_hCAnswer == 'Answer D') {
					$_rAnswer = "D";
				}
*/
		$_PATCH ="SELECT * FROM tbl_quiz WHERE tbl_quiz.quiz_id_PK = '$_quizidPK'";
		$_HJK =$db->opendb($_PATCH);
		foreach($_HJK as $_n ) {
			$_kkk = $_n['quiz_id_PK'];
		}
		 $_rsQuestion = "INSERT INTO tbl_questions 
						SET tbl_questions.question_id_FK = '$_kkk',
							tbl_questions.questions_questions = '$_question',
							tbl_questions.question_mod_id_FK = '$_modidPK'";
							$db->savedb($_rsQuestion);								
							$_rsQuestion_id = mysql_insert_id();
							$_rsPA = "INSERT INTO tbl_possibleanswers
									  SET tbl_possibleanswers.pa_id_FK ='$_rsQuestion_id',
									  	  tbl_possibleanswers.pa_A = '$_ansA',
										  tbl_possibleanswers.pa_B = '$_ansB',
										  tbl_possibleanswers.pa_C = '$_ansC',
										  tbl_possibleanswers.pa_D = '$_ansD',
										  tbl_possibleanswers.pa_quiz_id_FK ='$_kkk',
										  tbl_possibleanswers.pa_real_answer ='$_correct_answer' ";
							$db->savedb($_rsPA);
/*							$_pa_id=mysql_insert_id();

							$_realrs = "INSERT INTO tbl_realanswers
										SET tbl_realanswers.ra_id_FK = '$_pa_id',
											tbl_realanswers.ra_realanswer = '$_rAnswer'";
							$db->savedb($_realrs);
							*/
						 
								header("Location:_quizmanager.php?modidPK=$_modidPK&quizidPK=$_quizidPK");
	}




	//$tpl->set_block("hWND","_BLOCK","ROW");

//	count($_v) ;
	/*
		foreach($_v as $_r)	
		{
			$_lessonidPK = $_r['lesson_id_PK'];
			$_modidPK =$_r['mod_id_FK'];
			$_title = $_r['_title'];
			$_content =	$_r['_content'];
			$tpl->set_var("lesson_id_PK",$_lessonidPK);
			$tpl->set_var("lessonidPK",$_lessonidPK);
			$tpl->set_var("_title",$_title);
			$tpl->set_var("modidPK",$_modidPK);
			$tpl->set_var("_mods",$_mods);
			$tpl->parse("ROW","_BLOCK",true);
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

if ( isset($_GET['action'] ) && $_GET['action'] == 'delete') {
	$_id = $_GET['modidPK'];
	$_lessonidPK = $_GET['lessonidPK'];
	$_DELETE_RS = "DELETE FROM tbl_lessons WHERE lesson_id_PK = '$_lessonidPK'";
	$db->savedb($_DELETE_RS);
	header("Location:_mods.php");
}*/
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>