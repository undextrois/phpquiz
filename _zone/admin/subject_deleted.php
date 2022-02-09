<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();
$suid = urldecode($HTTP_GET_VARS['suid']);
  $sqlsu = "SELECT * FROM subjects WHERE ID = '$suid'";
  $ressu = mysql_query($sqlsu, $conn);
  while ($qry = mysql_fetch_array($ressu)) {
  $cat = stripslashes($qry['cat']);
  $sqlns = "SELECT * FROM questions WHERE test LIKE '$cat'";
  $resns = mysql_query($sqlns, $conn);
  $numcat = mysql_num_rows($resns);
  if ($numcat == 0) {
$sqldel = "DELETE FROM subjects WHERE ID = '$suid'";
$resdel = mysql_query($sqldel, $conn);

echo '<p id="hornav"><a href="subjects.php">View Subjects</a><a href="index.php">Index</a><a href="questions.php">Review Questions</a></p>';

if (!$resdel) {
echo '<H3>Could not execute the MySQL delete operation.</h3>';
echo '<p>MySQL error:'.mysql_error().'</p>';
}
else {
echo '<H3>The '.$cat.' category has been deleted from the database.</h3>';
include('sub_update_view.inc.php');
}
}
else {
echo '<p id="hornav"><a href="subjects.php">View Subjects</a><a href="index.php">Index</a><a href="questions.php">Review Questions</a></p>';
echo '<H3>The '.$cat.' category cannot be deleted because it still contains some questions.</h3>';
include('sub_update_view.inc.php');
}
}
?>
