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
 * $Header:      /_rebuild/index.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				UserLogin Interpreter
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");
function _gn_header() {
  $now = gmdate('D, d M Y H:i:s') . ' GMT';
  header('Expires: ' . $now);
  header('Last-Modified: ' . $now);
  header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0');
  header('Pragma: no-cache');
}

$_gn_infL = new _ALTO_Loginfo;
$_gn_ssnL = new _ALTO_Session(__ALTO_SESSION_SUPER__);
$_error_out = false;

if ((isset($_SERVER['REQUEST_METHOD'])) && ($_SERVER['REQUEST_METHOD']=='POST')) {
  # get referer, if necesary
  # just to check calling script

  $_gn_accept = true;

  if (isset($_POST['_username'])) $_gn_infL->username = trim($_POST['_username']);
  else $_gn_infL->username = '';
  if (isset($_POST['_password'])) $_gn_infL->password = trim($_POST['_password']);
  else $_gn_infL->password = '';

  if (!$_gn_infL->_alto_is_user($_gn_infL->username)) { $_gn_accept = false; }
  if (!$_gn_infL->_alto_is_passwd($_gn_infL->password)) { $_gn_accept = false; }

  $_DB->dbconnect();

  if (($_gn_rs=mysql_query('SELECT * FROM tbl_userlist WHERE tbl_userlist._username="'.mysql_escape_string($_gn_infL->username).'"'))==false) {
     $_DB->closedb();
     die ('query error');
  }
  if (mysql_num_rows($_gn_rs)) {
     $_gn_rw=mysql_fetch_object($_gn_rs);

		$_session_id = stripslashes($_gn_rw->_user_id_PK);

	 if ($_gn_infL->password != $_gn_infL->password)
        $_gn_accept = false;
     mysql_free_result($_gn_rs);
  }
  else {
    $_gn_accept = false;
  }

  $_DB->closedb();

 $m_type = __ALTO_SESSION_USER__;

  if ($_gn_accept) {
     # set-up session here
     $_gn_ssnL->_alto_session_create($_gn_infL->username,$m_type);

	 header("location:_members.php?_id=$_session_id");
  exit;
  }
  else
  {
    $_error_out = true;
  }
}

$hWND = new Template(".","keep");
$hWND->set_file(array("hWND"=>"_html/_index.htm"));
//$hWND->set_var("phpscript",$_SERVER['PHP_SELF']);

if (!$_error_out)
   $hWND->set_var("error_out","");
else
   $hWND->set_var("error_out","<font color=\"#800000\"><strong>WRONG USERNAME/PASSWORD</strong><br>(hint: Check if \"<b>Caps Lock</b>\" is on)</font>");
$hWND->parse("hWND",array("hWND"));
$hWND->finish("hWND");
$hWND->p("hWND");
?>
