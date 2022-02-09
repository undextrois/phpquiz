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
 * $Header:      /_rebuild/_showmods.php , v 1.0 2006 february AM:PM Exp $ 
 * Author:		 WChrome Web Component Division			
 * Description:  
 				show modules UI
 ********************************************************************************/
require_once ("_config/wc_config.inc.php");
$tpl = new Template(".","keep");
$tpl->set_file(array("hWND"=>"_html/_showmods.htm"));
		$db = new _ALTO_DB;

	if( isset($_GET['action'] ) && $_GET['action'] == 'view') {

	$_modidPK = $_GET['modidPK'];
	$_RS = "SELECT * FROM tbl_mods WHERE mod_id_PK = '$_modidPK'";
	$_n = $db->opendb($_RS);
		foreach($_n as $_r) {
			$_modname = $_r['_mods'];
			$_modidPK =	$_r['mod_id_PK'];
		$tpl->set_var("_modname",$_modname);
		$tpl->set_var("modidPK",$_modidPK);
		}
	}
	if ( isset ( $_POST['Submit'] ) && $_POST['Submit'] == "Save") 	{
	
		$_modidPK = $_POST['modidPK'];
		$_modname = $_POST['_modname'];	  
			$_MOD_RS = "UPDATE tbl_mods SET tbl_mods._mods = '$_modname' WHERE tbl_mods.mod_id_PK = '$_modidPK'";
			$db->savedb($_MOD_RS);
	
	
		header("Location:_mods.php");
	}	 
$tpl->parse('hWND', array('hWND'));
$tpl->p('hWND');
?>




							
		 
		  
  

									
	     

