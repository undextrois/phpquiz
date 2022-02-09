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
 * $Header:      /_rebuild/_logout.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				session cleanup 
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");

$_gn_infL = new _ALTO_Loginfo;
$_gn_ssnL = new _ALTO_Session(__ALTO_SESSION_SUPER__);

$_gn_ssnL->_alto_session_cleanup();
//header("location: ".$rootdir."index.php");
header("Location: index.php");
?>
