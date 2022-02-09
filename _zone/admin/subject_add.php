<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();
 ?>
<p id="hornav"><a href="index.php">Admin Index</a>
<a href="questions.php">View All Questions</a>

<form name="subjadd" action="subject_added.php" method="post">
<table width="96%" border="0" cellspacing="0" cellpadding="4"><tr><th width="200">Category Name:</th>
<td><input name="cat" type="text" size="31"></td></tr>
<tr><th>Description:</th><td><textarea name="descr" cols="54" rows="3"></textarea></td></tr>
<tr><th>Sort mode:</th>
<td>
<select name="random">
<option value="1">Random question and answer order</option>
<option value="2">Random question order with fixed answer order</option>
<option value="3">Fixed question order with random answer order</option>
<option value="4">Fixed question and answer order</option>
</select>
</td></tr>
<tr><th></th><td><p id="bignav"><a href="javascript:document.subjadd.submit();">Add 
          this Subject Area!</a><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          CLICK <a href="../../_cpanel.php">HERE</a> TO GO BACK </font></p></td></tr></table>
</form>

