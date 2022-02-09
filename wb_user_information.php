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
 * $Header:      /_rebuild/wb_user_information.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				Edit user information 
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");

$session = new _ALTO_Session(__ALTO_SESSION_USER__); 
//error_reporting(0);
	if($session->_alto_session_auth() == false)
	{
		$session->_alto_session_cleanup();
		header("index.php");
	}
	$username = $session->_alto_session_uget();
	$useridPK = $session->useridFK;
	$db = new _ALTO_DB;
//print_r($_POST);
//echo $useridPK;
 $tpl = new Template(".","keep");
 $tpl->set_file(array("hWND"=>"_html/wb_user_information.htm"));
		 $_p = new __USERInfoClass__;
	     $_p->_gt_id = $useridPK;
	$_v =$_p->_gtUserInfo();

		$tpl->set_var("_firstname",$_v[1]);
		$tpl->set_var("_lastname",$_v[2]);
		$tpl->set_var("_username",$_v[5]);
		$tpl->set_var("_password",$_v[6]);
		$tpl->set_var("_email",$_v[7]);
		$tpl->set_var("_age",$_v[8]);
		$tpl->set_var("_gender",$_v[9]);
		$tpl->set_var("_occupation",$_v[10]);
	$tpl->set_var("_membername",$_v[4]);
	$tpl->set_var("useridPK",$useridPK);
	$tpl->set_var("WBFormAction","wb_user_information.php");

/*Array ( [_firstname] => simpson 
		[_lastname] => bart 
		[_username] => password 
		[_password] => password 
		[_email] => bart@thesimpsons.com 
		[_age] => 25 
		[_gender] => M 
		[_occupation] => Cartoon Character 
		[Submit] => S A V E ) */
		if ( isset($_POST['Submit'] ))  
		{
			$_wb_useridPK = $_POST['useridPK'];
			$_wb_fname = $_POST['_firstname'];
			$_wb_lname = $_POST['_lastname'];
			$_wb_uname =$_POST['_username'];
			$_wb_pword =$_POST['_password'];
			$_wb_email =$_POST['_email'];
			$_wb_age =$_POST['_age'];
			$_wb_gender =$_POST['_gender'];
			$_wb_occupation =$_POST['_occupation'];
			$_SAVE_RS ="UPDATE tbl_memberlist 
						SET tbl_memberlist._lastname ='$_wb_lname',
							tbl_memberlist._firstname ='$_wb_fname',
							tbl_memberlist._age ='$_wb_age',
							tbl_memberlist._gender ='$_wb_gender',
							tbl_memberlist._occupation ='$_wb_occupation'
						WHERE tbl_memberlist._member_id_PK ='$_wb_useridPK' ";	
			//echo $_SAVE_RS;

			$db->savedb($_SAVE_RS);

			$_USRLST_RS = "UPDATE tbl_userlist 
							SET tbl_userlist._username ='$_wb_uname',
							    tbl_userlist._password ='$_wb_pword',
								tbl_userlist._email ='$_wb_email'
							 WHERE tbl_userlist._user_id_PK ='$_wb_useridPK'";
			$db->savedb($_USRLST_RS);				 
			$db->closedb();
			$session->_alto_session_cleanup();

			header("Location: index.php");
		}
	$tpl->parse('hWND', array('hWND'));
	$tpl->p('hWND');
?>	




