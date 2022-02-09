<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();

$suid = urldecode($HTTP_GET_VARS['suid']);
$cat = addslashes($HTTP_POST_VARS['cat']);
$testsub = $cat;
$descr = htmlentities(addslashes($HTTP_POST_VARS['descr']));
$random = $HTTP_POST_VARS['random'];
$oldcat = addSlashes($HTTP_POST_VARS['oldcat']);

##Update subject record
$sql = "UPDATE subjects SET cat = '$cat', descr = '$descr', random = '$random' where ID = '$suid' LIMIT 1";
$result = mysql_query($sql, $conn);

##Update test subject field of all questions with the old subject name
$sql2 = "UPDATE questions SET test = '$cat' WHERE test = '$oldcat'";
$res2 = mysql_query($sql2, $conn);

if ((!$result) || (!$res2)){
  echo "<p>There was a database error when executing the script \"$sql\"<br />";
  echo "MySQL error:".mysql_error()."</p>";
}

else { 
include('hormenu.php');
echo '<h3>This category has been successfully updated. Please review the record below and, if necessary, edit it.</h3>';
include('sub_update_view.inc.php');
    }

?>
