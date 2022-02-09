<?php
/**
* _lessons.php
*		-member only paee
*		-january 2006 (C) 
*		-wildchrome software
*
*/
	require_once ("_config/wc_config.inc.php");
	$session = new _ALTO_Session(__ALTO_SESSION_USER__); 
//error_reporting(0);
	if($session->_alto_session_auth() == false){
		$session->_alto_session_cleanup();
		header("index.php");
	}

$username = $session->_alto_session_uget();
$useridPK = $session->useridFK;
	$tpl = new Template(".","keep");
	$tpl->set_file(array("hWND"=>"_html/_m_php1.htm"));
	      $_p = new __USERInfoClass__;
	     $_p->_gt_id = $useridPK;
	$_v =$_p->_gtUserInfo();
	$tpl->set_var("_membername",$_v[4]);
	$tpl->parse('hWND', array('hWND'));
	$tpl->p('hWND');
?>