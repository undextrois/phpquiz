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
 * $Header:      /_rebuild/_deletequizmanager.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				delete quiz record 
 ********************************************************************************/
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
	$db->savedb("DELETE FROM tbl_realanswers WHERE tbl_realanswers.ra_id_FK = '$_pa_id_FK'");
//	$db->savedb("DELETE FROM tbl_possibleanswers WHERE tbl_possibleanswers.pa_id_PK = '$_question_id_PK'");
	$db->savedb("DELETE FROM tbl_questions WHERE question_id_FK='$_quizidPK' AND question_mod_id_FK='$_modidPK'");
	header("Location:_quizmanager.php?quizidPK={quizidPK}&modidPK={modidPK}");
	}
?>