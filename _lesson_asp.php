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
$_type = $_GET['type'];
$username = $session->_alto_session_uget();
$useridPK = $session->useridFK;
	$tpl = new Template(".","keep");
	$tpl->set_file(array("hWND"=>"_html/_m_asp1.htm"));
	      $_p = new __USERInfoClass__;
	     $_p->_gt_id = $useridPK;
	$_v =$_p->_gtUserInfo();
	$tpl->set_var("_membername",$_v[4]);
	$_j = "SELECT * FROM tbl_lessons WHERE mod_id_FK = '$_type'";
	$_r = $db->opendb($_j);
	foreach($_r as $_rw ) 
	{
//lesson_id_PK mod_id_FK _level _title _content 
		$_rw_level =$_rw['_level'];
		$_rw_modidFK =$_rw['mod_id_FK'];
		$_rw_lev =$_rw['_level'];
		$_rw_title =$_rw['_title'];
		$_rw_content = $_rw['_content'];
		$_rw_lessonidPK =$_rw['lesson_id_PK'];
		$tpl->set_var(array( "_title" => $_rw_title,
							"_level" => $_rw_lev,
							"_content" => $_rw_content,
							"_lesson_id_PK" =>$_rw_lessonidPK,
							"modidPK"=> $_rw_modidPK ) );
							
		
	}




	$tpl->parse('hWND', array('hWND'));
	$tpl->p('hWND');
?>