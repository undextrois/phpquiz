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
$tpl->set_file(array("hWND"=>"_html/_m_account.htm"));
		$tpl->set_var("_error","");
	$db = new _ALTO_DB;
error_reporting(0);
$_memberidPK =  $_GET['memberidPK'];
//print_r($_GET);

$_m_rs = "SELECT * FROM tbl_memberlist,
						tbl_userlist

		  WHERE tbl_memberlist._member_id_PK = '$_memberidPK'
		  AND tbl_userlist._member_id_FK = tbl_memberlist._member_id_PK";


	$_GR =" SELECT * FROM tbl_grades WHERE gr_member_id_FK = '$_memberidPK' ";
	$_res =	$db->opendb($_GR);
	$_cres = count ($_res) ;
	if ($_cres > 0 )
	{
		foreach($_res as $_rw)
		{
			$_gr_level_id_FK = $_rw['gr_level_id_FK'];
		}
	}
	else
	{
		$_gr_level_id_FK  = 0;
	}

$_h = $db->opendb($_m_rs);

foreach($_h as $_p )
{
	$_lastname =$_p['_lastname'];
	$_firstname =$_p['_firstname'];
	$_age = $_p['_age'];
	$_gender = $_p['_gender'];
	$_occupation = $_p['_occupation'];
	$_email = $_p['_email'];
	$_username = $_p['_username'];
	$_password = $_p['_password'];
	$_level = $_p['_level'];
	//cho $_lastname;

	$tpl->set_var("memberidPK",$_memberidPK);
	$tpl->set_var("_lastname",$_lastname);
	$tpl->set_var("_level",$_level );

	$tpl->set_var(array(
						"_firstname" => $_firstname,
						"_age" => $_age,
						"_gender" => $_gender,
						"_occupation" => $_occupation,
						"_email" => $_email,
						"_username" => $_username,
						"_password" => $_password ) );
}
if ( isset ( $_POST['Submit'] ) && $_POST['Submit'] == "Save") {
	$_a_password = $_POST['_password'];
	$_a_username = $_POST['_username'];
	$_memberidPK = $_POST['memberidPK'];
	$_a_gender = $_POST['_gender'];
	$_a_lastname = $_POST['_lastname'];
	$_a_firstname = $_POST['_firstname'];
	$_a_occupation = $_POST['_occupation'];
	$_a_email = $_POST['_email'];
	$_level = $_POST['_level'];
	$_A_UPDATE = "UPDATE tbl_memberlist , tbl_userlist
				  SET
				  tbl_memberlist._lastname = '$_a_lastname',
				  tbl_memberlist._firstname = '$_a_firstname',
				  tbl_memberlist._gender = '$_a_gender',
				  tbl_memberlist._occupation = '$_a_occupation',
				  tbl_memberlist._level = '$_level',
				  tbl_userlist._email = '$_a_email',
				  tbl_userlist._username = '$_a_username',
				  tbl_userlist._password = '$_a_password'
				  WHERE
				  		tbl_memberlist._member_id_PK = '$_memberidPK'
				  AND
				  		tbl_userlist._member_id_FK = tbl_memberlist._member_id_PK";
		$db->savedb($_A_UPDATE);

 $_grade = "UPDATE tbl_grades SET gr_level_id_FK = '$_level' WHERE gr_member_id_FK ='$_memberidPK'";
$db->savedb($_grade);
header("Location:_cpanel.php");


}
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>















