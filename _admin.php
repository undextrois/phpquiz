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
 * $Header:      /_rebuild/_admin.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				entry point Cpanel page
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");
$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_admin.htm"));
		$tpl->set_var("_error","");
	$db = new _ALTO_DB;
if ( isset ( $_POST['Submit'] ) && $_POST['Submit'] == "Login") 
{
	$_apassword = $_POST['_password'];
	$_ausername = $_POST['_username'];
	$_admin_rs ="SELECT * FROM tbl_admin WHERE tbl_admin._username = '$_ausername' AND tbl_admin._password = '$_apassword' ";
	$_v = $db->opendb($_admin_rs);
	$_r = count($_v);
	if($_r > 0) 
	{
		header ("Location: _cpanel.php");
	}
	else 
	{
		$_errmsg =  "invalid username and password";
		$tpl->set_var("_error",$_errmsg);
	}
}	
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>


	
	
	


							
		 
		  
  

									
	     

