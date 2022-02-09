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
 * $Header:      /_rebuild/wb_register.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				User registration
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");
$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_register.htm"));
	if ( isset ( $_POST['_register'] ) && $_POST['_register'] == "Y") 	{
		$db = new _ALTO_DB;
		$_wm_status = "_memberOnly";
		$_wm_fname = $_POST['_firstname'];	  
		$_wm_lname = $_POST['_lastname'];
		$_wm_username = $_POST['_username'];
		$_wm_password = $_POST['_password'];
	    $_wm_email = $_POST['_email'];
		$_wm_age = $_POST['_age'];
		$_wm_gender = $_POST['_gender'];
		$_wm_occupation = $_POST['_occupation'];
		$_pLevel = 1;
		$_wm_member_rs ="INSERT INTO tbl_memberlist 
	  					 SET tbl_memberlist._lastname = \"".mysql_escape_string($_wm_lname)."\", 
	                         tbl_memberlist._firstname = \"".mysql_escape_string($_wm_fname)."\",
							 tbl_memberlist._status = '$_wm_status', 
							 tbl_memberlist._age =	 \"".mysql_escape_string($_wm_age )."\", 
							 tbl_memberlist._gender =\"".mysql_escape_string($_wm_gender )."\", 
							 tbl_memberlist._occupation =\"".mysql_escape_string($_wm_occupation)."\", 
							 tbl_memberlist._level = '$_pLevel',
							 tbl_memberlist._aspLevel = '$_pLevel',
							 tbl_memberlist._phpLevel = '$_pLevel',
							 tbl_memberlist._jsLevel = '$_pLevel',
	                         tbl_memberlist._date = NOW()";
 		$db->savedb($_wm_member_rs);
		$_mysql_id = mysql_insert_id();
		$_wm_user_rs =" INSERT INTO tbl_userlist 
	  					 SET tbl_userlist._member_id_FK =  '$_mysql_id',
	                         tbl_userlist._username = \"".mysql_escape_string($_wm_username)."\",
							 tbl_userlist._password = \"".mysql_escape_string($_wm_password)."\", 
							 tbl_userlist._email = \"".mysql_escape_string($_wm_email)."\",
	                         tbl_userlist._date = NOW()";
		$db->savedb($_wm_user_rs);
		$db->closedb();
		header("Location:index.php");
	}	 
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>




							
		 
		  
  

									
	     

