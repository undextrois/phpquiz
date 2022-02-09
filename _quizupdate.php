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
 * $Header:      /_rebuild/_quizupdate.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				Edit quiz admin section
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");
error_reporting(0);

$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_quizupdate.htm"));
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
	if(isset($_GET['modidPK'] ) ) 
	{
		$_m = $_GET['modidPK'];
		$_q =$_GET['quizidPK'];
	 	$_rsQz =" SELECT * FROM tbl_quiz WHERE tbl_quiz.quiz_id_PK = '$_q' AND tbl_quiz.mod_id_FK = '$_m'";
		$_Qzd = $db->opendb($_rsQz);
		foreach($_Qzd as $_qrw ) 
		{
			$_level = $_qrw['quiz_level'];
			$_jqtitle =$_qrw['quiz_title'];
			$_jqidPK = $_qrw['quiz_id_PK'];
			$tpl->set_var("quiz_level",$_level);
			$tpl->set_var("quiz_title",$_jqtitle);
			$tpl->set_var("quizidPK",$_jqidPK);
			$tpl->set_var("modidPK",$_m);
		}
		$_rs = "SELECT * FROM tbl_questions 
				WHERE tbl_questions.question_id_FK = '$_q' 
				AND tbl_questions.question_mod_id_FK = '$_m`'  ";
		$_k = $db->opendb($_rs);
		$tpl->set_var("quizidPK",$_q);
		$tpl->set_var("modidPK",$_m);
			$tpl->set_block("hWND","BLOCK","ROW");
		foreach($_k as $_u ) {
			$_qidPK =	$_u['question_id_PK'];
			$_qq =	$_u['questions_questions'];
		$tpl->set_var(array("qidPK" => $_qidPK,
							"question" => $_qq) );
		$tpl->set_var("question_id_PK",$_qidPK);
							$tpl->parse("ROW","BLOCK",true);				
		}
  }
	
	if(isset($_GET['action'] ) && $_GET['action'] == 'delete' ) 
	{
	//	print_r($_GET);
		$_quizidPK =$_GET['quizidPK'];
		$_modidPK =$_GET['modidPK'];
		$_question_id_PK =$_GET['question_id_PK'];
		$_rspa= "SELECT * FROM tbl_possibleanswers WHERE tbl_possibleanswers.pa_id_FK ='$_question_id_PK'";
		$_rspa_r=$db->opendb($_rspa);
		foreach($_rspa_r as $_paRW) 
		{
			$_rw_pa_idPK= $_paRW['pa_id_PK'];
		}
	//	$_delrs_RA ="DELETE FROM tbl_realanswers WHERE tbl_realanswers.ra_id_PK = '$_rw_pa_idPK'";
	//	$db->savedb($_delrs_RA);
		
		$_delrs_PA = "DELETE FROM tbl_possibleanswers WHERE tbl_possibleanswers.pa_id_FK ='$_question_id_PK'";
		$db->savedb($_delrs_PA);
		$_delrs_q ="DELETE FROM tbl_questions WHERE tbl_questions.question_id_PK = '$_question_id_PK'
					AND tbl_questions.question_id_FK = '$_quizidPK'
					AND tbl_questions.question_mod_id_FK = '$_modidPK'";
		$db->savedb($_delrs_q);
		header("Location:_quizupdate.php?quizidPK=$_quizidPK&modidPK=$_modidPK&question_id_PK=$_question_id_PK");		
	}
	if( isset($_POST['action'] ) && $_POST['action']=='update' ) 
	{
//	print_r($_POST);
	//Array ( [quiz_title] => PEEYTSPE8 [Submit] => Update Quiz Title [modidPK] => 1 [quizidPK] => 13 [action] => update ) 
	$_quizidPK =	$_POST['quizidPK'];
	$_modidPK =	$_POST['modidPK'];
	$_quiz_title =	$_POST['quiz_title'];
	$_level = $_POST['quiz_level'];
	$_wQuiz ="UPDATE tbl_quiz 
			  SET tbl_quiz.quiz_title = '$_quiz_title' ,
				  tbl_quiz.quiz_level = '$_level'	
			  WHERE tbl_quiz.quiz_id_PK = '$_quizidPK' 
			  AND tbl_quiz.mod_id_FK = '$_modidPK'";
			  $db->savedb($_wQuiz);
			 //http://localhost/_wb/_quizupdate.php?modidPK=1&quizidPK=13&action=update
//			  http://localhost/_wb/_quizlist.php?modidPK=1&quizidPK=13&action=lessons
			  header("Location:_quizupdate.php?modidPK=$_modidPK&quizidPK=$_quizidPK");
	
	}
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>
	
		

			 
		 
		


