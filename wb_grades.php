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
 * $Header:      /_rebuild/_m_account.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				User edit admin side
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");
$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/wb_grades.htm"));
		$tpl->set_var("_error","");
	$db = new _ALTO_DB;
error_reporting(0);
//$_memberidPK =  $_GET['memberidPK'];
//print_r($_GET);

	$_gTbl = "SELECT * FROM tbl_grades";
	$_gRS = $db->opendb($_gTbl);
	$_cR = count ($_gRS );
	
	
	if ( $_cR > 0 )
	{
		$tpl->set_block("hWND","WBGradeListingBlock","ROW");


		foreach ($_gRS as $_gRW ) 
		{
			 $_gr_id_PK	= $_gRW['gr_id_PK'];
		  $_gr_mod_id_FK = $_gRW['gr_mod_id_FK'];
		 $_gr_quiz_id_FK = $_gRW['gr_quiz_id_FK'];
		  $_gr_member_id_FK = $_gRW['gr_member_id_FK'];
		 $_gr_level_id_FK = $_gRW['gr_level_id_FK'];
		 $_gr_rating = $_gRW['gr_rating'];
		$_gr_remarks = $_gRW['gr_remarks'];
		 $_gr_date = $_gRW['gr_date'];
		  $_gr_name =$_gRW['gr_name'];
		  $_gr_quiz_name = $_gRW['gr_quiz_name'];
	
		 $tpl->set_var("gr_level",$_gr_level_id_FK);
		  $tpl->set_var("gr_id_PK",$_gr_id_PK);
		  $tpl->set_var("gr_name",$_gr_name);
		  $tpl->set_var("gr_date",$_gr_date);
		  $tpl->set_var("gr_rating",$_gr_rating);
		  $tpl->set_var("quiz_title",$_gr_quiz_name);
		  $tpl->parse("ROW","WBGradeListingBlock",true);
		}
	}
	else 
	{
	 $_m = "Grade Table Empty";
	  $tpl->set_var("quiz_title",$_m );
  $tpl->set_var("gr_id_PK","");
		  $tpl->set_var("gr_name","");
		  $tpl->set_var("gr_date","");
		  $tpl->set_var("gr_rating","");
// $tpl->parse("ROW","WBGradeListingBlock",true);
//	 $tpl->parse("ROW",$_m);
	}
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');

						
if ( isset ( $_GET['action'] ) && $_GET['action'] == "delete") 
{
	$_gr_id_PK = $_GET['gr_id_PK'];
	$_RS = "DELETE FROM tbl_grades WHERE gr_id_PK='$_gr_id_PK'";
		$db->savedb($_RS);		  
header("Location:wb_grades.php?gr_id_PK=$_gr_id_PK");


}	

?>




							
		 
		  
  	
	
	


									
	     

