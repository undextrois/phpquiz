<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();
$suid = urldecode($HTTP_GET_VARS['suid']);

$sql = "SELECT * FROM subjects where ID = '$suid' LIMIT 1";
$result = mysql_query($sql, $conn);
$qry = mysql_fetch_array($result);
echo '<h1>Subject Area: '.$qry['ID'].'</h1>';
echo '<form name="subupdate" action="subject_updated.php?suid='.$qry['ID'].'" method="post">';
echo '<table id="nq"><tr><th width="200">Category name:</th>';
echo '<td><input type="text" name="cat" size="60" value="'.stripslashes($qry['cat']).'" /></td></tr>'."\n";
echo '<tr><th>Description:</th><td><textarea name="descr" cols="60" rows="3">';
echo stripslashes($qry['descr']);
echo '</textarea></td></tr>';
echo '<tr><th width="200">Random mode:</th>';
echo '<td><select name="random">'."\n".'<option value="1">Random question and answer order</option>'."\n".'<option value="2"';
if ($qry['random'] == '2') { echo ' SELECTED'; }
echo '>Random question order with fixed answer order</option>'."\n".'<option value="3"';
if ($qry['random'] == '3') { echo ' SELECTED'; }
echo '>Fixed question order with random answer order</option>'."\n".'<option value="4"';
if ($qry['random'] == '4') { echo ' SELECTED'; }
echo '>Fixed question and answer order</option>'."\n";
echo '</td></tr>'."\n".'</table>'."\n";
echo '<input name="oldcat" type="hidden" value="'.$qry['cat'].'"></form><hr>';
?>
<p id="bignav"><a href="javascript:document.subupdate.submit();">Update Subject!</a><a href="index.php">Return without updating</a></p>

