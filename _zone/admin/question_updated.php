<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();

$testsub = $HTTP_POST_VARS['testsub'];
$subj = addslashes($HTTP_POST_VARS['subj']);
if (!$testsub) { $testsub = $subj; }
$qid = $HTTP_GET_VARS['qid'];
$rowstart = $HTTP_GET_VARS['rowstart'];
$quest = addslashes($HTTP_POST_VARS['quest']);
$ans1 = addslashes($HTTP_POST_VARS['ans1']);
$ans2 = addslashes($HTTP_POST_VARS['ans2']);
$ans3 = addslashes($HTTP_POST_VARS['ans3']);
$ans4 = addslashes($HTTP_POST_VARS['ans4']);
$ans5 = addslashes($HTTP_POST_VARS['ans5']);
$ans6 = addslashes($HTTP_POST_VARS['ans6']);
if ($HTTP_POST_VARS['corran']) { $corran = $HTTP_POST_VARS['corran']; }
else {
unset($corran);
for ($p = 1, $a = 0; $p <= 6; $p++) {
if ($HTTP_POST_VARS['ans'.$p] != ' ' && !empty($HTTP_POST_VARS['ans'.$p]) && $HTTP_POST_VARS['ans'.$p] != 'q#exc' && isset($HTTP_POST_VARS['ans'.$p]))
{ 
if ($HTTP_POST_VARS['corran'.$p][3] == $p) { $a++; $corran .= $p; $pa = $p; } else { $corran .= 'm'; }
}
}
}
##if only one answer reset answer code to multiple choice type
if ($a == 1) { $corran = 'ans'.$pa; }
$expl = addslashes($HTTP_POST_VARS['expl']);
$htmle = $HTTP_POST_VARS['htmle'];
if ($htmle == 'yes') {
$quest = nl2br(htmlentities($quest));
$subj = nl2br(htmlentities($subj));
$ans1 = nl2br(htmlentities($ans1));
$ans2 = nl2br(htmlentities($ans2));
$ans3 = nl2br(htmlentities($ans3));
$ans4 = nl2br(htmlentities($ans4));
$ans5 = nl2br(htmlentities($ans5));
$ans6 = nl2br(htmlentities($ans6));
$expl = nl2br(htmlentities($expl));
}
if ($ans4 == ' ' || empty($ans4)) { $ans4 = 'q#exc'; }
if ($ans5 == ' ' || empty($ans5)) { $ans5 = 'q#exc'; }
if ($ans6 == ' ' || empty($ans6)) { $ans6 = 'q#exc'; }

$sql = "UPDATE questions SET question = '$quest', test = '$subj', ans1 = '$ans1', ans2 = '$ans2', ans3 = '$ans3', ans4 = '$ans4', ans5 = '$ans5', ans6 = '$ans6', corans = '$corran', expl = '$expl' where ID = '$qid'";
$result = mysql_query($sql, $conn);
if (!$result) {
  echo "<p>There was a database error when executing the script \"$sql\"<br />";
  echo "MySQL error:".mysql_error()."</p>";
  echo '</div>';
 
  exit;
}

else { 
include('hormenu.php');
echo '<hr />'."\n";
echo '<h3>This question has been successfully updated. Please review the record below and, if necessary, edit it.</h3>';
include('update_view.inc.php');
    }


?>
