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
 * $Header:      /_rebuild/_cpanel.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  Administration page for webmaster
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");

/*
$session = new _ALTO_Session(__ALTO_SESSION_USER__); 
//error_reporting(0);
if($session->_alto_session_auth() == false){
	$session->_alto_session_cleanup();
	header("index.php");
}

$username = $session->_alto_session_uget();
$useridPK = $session->useridFK;
//echo $useridPK;*/

$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_cpanel.htm"));
		$db = new _ALTO_DB;
error_reporting(0);
/*
	      $_p = new __USERInfoClass__;
	     $_p->_gt_id = $useridPK;
	$_v =$_p->_gtUserInfo();
	$tpl->set_var("_membername",$_v[4]);
	*/
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
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>