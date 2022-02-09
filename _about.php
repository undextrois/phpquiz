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
 * $Header:      /_rebuild/_about.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 		handle to About Page
 ********************************************************************************/

require_once ("_config/wc_config.inc.php");
/*
$db = new _ALTO_DB;
$session = new _ALTO_Session(__ALTO_SESSION_USER__); 

if($session->_alto_session_auth() == false){
	$session->_alto_session_cleanup();
	_redir("index.php");
}

$username = $session->_alto_session_uget();
$useridPK = $session->useridFK;
$mccidses = $session->mccidses;
$entityidFK = $session->entityidFK;
*/
$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_about.htm"));

$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>