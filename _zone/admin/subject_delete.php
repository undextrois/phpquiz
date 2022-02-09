<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();
$suid = urldecode($HTTP_GET_VARS['suid']);
  $sqlsu = "SELECT * FROM subjects where ID = '$suid'";
  $ressu = mysql_query($sqlsu, $conn);
  while ($qry = mysql_fetch_array($ressu)) {
  $cat = stripSlashes($qry['cat']);
  $sqlns = "SELECT * FROM questions WHERE test LIKE '$cat'";
  $resns = mysql_query($sqlns, $conn);
  $numcat = mysql_num_rows($resns);
  if ($numcat > 0) {
echo '<form name="qview'.$qry['ID'].'" action="questions.php" method="post"><input type="hidden" name="testsub" value="'.$qry['cat'].'"></form>'."\n";
echo '<p class="rtali" id="hornav"><a href="javascript:document.qview'.$qry['ID'].'.submit();">Edit questions in this category</a><a href="subject_update.php?suid='.$qry['ID'].'">Edit Subject</a><a href="index.php">Index</a></p>';
echo '<H3>There are still '.$numcat;
if ($numcat == 1 ) { echo ' question'; } else { echo ' questions'; }
echo ' in the '.$cat.' category.<br />Please delete all questions in this category or transfer them to another subject area.<h3>';
}
else {
echo '<p id="hornav"><a href="subject_ deleted.php?suid='.$qry['ID'].'">Delete Subject</a><a href="subjects.php">View Subjects</a><a href="index.php">Index</a></p>'."\n";
echo '<h3>There are no questions left in the '.$cat.' category. Press <em>delete subject</em> to permanently remove this subject area.</h3>';
}
}
 ?>
