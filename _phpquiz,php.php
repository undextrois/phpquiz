<?php
/**
* _members.php
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
//echo $useridPK;

$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_phpquiz.htm"));
	      $_p = new __USERInfoClass__;
	     $_p->_gt_id = $useridPK;
	$_v =$_p->_gtUserInfo();
	$tpl->set_var("_membername",$_v[4]);
	
	
	$_modid = $_GET['modid'];
	$_RS_PHP = "SELECT * FROM tbl_quiz WHERE tbl_quiz.mod_id_FK = '$_modid' ";
	$_V =$db->opendb($_RS_PHP);
$tpl->set_block("hWND","BLOCK","ROW");
	foreach($_V as $_j) {
		$_quiz = $_j['quiz_title'];
		$_id = $_j['quiz_id_PK'];
		$tpl->set_var(array("title" => $_quiz,
							"id" => $_id));
	
						$tpl->parse("ROW","BLOCK",true);						
	}	
	






$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>