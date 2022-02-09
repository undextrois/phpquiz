<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();

$testsub = $HTTP_POST_VARS['testsub'];
$rowstart = $HTTP_GET_VARS['rowstart'];
$htmle = $HTTP_POST_VARS['htmle'];
$qnu = $HTTP_POST_VARS['qnu'];
$anu = $HTTP_POST_VARS['anu'];
if (!$anu) { $anu = 6; }

include('hormenu.php');

$descr = addSlashes($HTTP_POST_VARS['descr']);
$red = 0;
#Check if new category has been entered
if ($HTTP_POST_VARS['cat']) { $cat = $HTTP_POST_VARS['cat']; 
if ($cat) {
#Check if another identical subject exists
$sqlsq = "SELECT * FROM subjects WHERE cat LIKE '$cat'";
$ressq = mysql_query($sqlsq, $conn);
$nsq = mysql_num_rows($ressq);
echo '<h1> Subject results: '.$nsq.'</h1>';
if ($nsq == 0) 
{
$random = addSlashes($HTTP_POST_VARS['random']);
$sql = "INSERT INTO subjects (cat, descr, random) values ('$cat', '$descr', '$random')";
$result = mysql_query($sql, $conn);
if (!$result) {
  echo "<p>There was a database error when executing the script \"$sql\"<br />";
  echo "MySQL error:".mysql_error()."</p>";
  include('../inc/footer.inc.php');
  exit;
}
}
}
}
else if ($HTTP_POST_VARS['subj'] != 'none') { $cat = addSlashes($HTTP_POST_VARS['subj']); }
for ($i = 1; $i <= $qnu; $i++)
{
$quest = addSlashes($HTTP_POST_VARS['quest_'.$i]);
$bool = $HTTP_POST_VARS['bool_'.$i];
$boolopt = $HTTP_POST_VARS['boolopt_'.$i];
$ans1 = addSlashes($HTTP_POST_VARS['ans1_'.$i]);
$ans2 = addSlashes($HTTP_POST_VARS['ans2_'.$i]);
$ans3 = addSlashes($HTTP_POST_VARS['ans3_'.$i]);
$ans4 = addSlashes($HTTP_POST_VARS['ans4_'.$i]);
$ans5 = addSlashes($HTTP_POST_VARS['ans5_'.$i]);
$ans6 = addSlashes($HTTP_POST_VARS['ans6_'.$i]);
if ($HTTP_POST_VARS['corran_'.$i]) { $corran = $HTTP_POST_VARS['corran_'.$i]; }
else {
unset($corran);
for ($p = 1, $a = 0; $p <= 6; $p++) {
if ($HTTP_POST_VARS['ans'.$p.'_'.$i] != ' ' && !empty($HTTP_POST_VARS['ans'.$p.'_'.$i]) && $HTTP_POST_VARS['ans'.$p.'_'.$i] != 'q#exc' && isset($HTTP_POST_VARS['ans'.$p.'_'.$i]))
{ 
if ($HTTP_POST_VARS['corran'.$p.'_'.$i][3] == $p) { $a++; $corran .= $p; $pa = $p; } else { $corran .= 'm'; }
}
}
}
##if only one answer reset answer code to multiple choice type
if ($a == 1) { $corran = 'ans'.$pa; }

$expl = addSlashes($HTTP_POST_VARS['expl_'.$i]);

##Check the question field is not empty
if ((!$quest) || empty($quest) || $quest == ' ' || $quest == '') { $red++; echo '<h4>Please enter a question</h4>'; include('quiz_reedit_form.inc.php'); }
else {
if ($htmle == 'yes') {
$quest = nl2br(htmlentities($quest));
$cat = nl2br(htmlentities($cat));
$ans1 = nl2br(htmlentities($ans1));
$ans2 = nl2br(htmlentities($ans2));
$ans3 = nl2br(htmlentities($ans3));
$ans4 = nl2br(htmlentities($ans4));
$ans5 = nl2br(htmlentities($ans5));
$ans6 = nl2br(htmlentities($ans6));
$expl = nl2br(htmlentities($expl));
}

#Check if another identical question exists
$sqlnq = "SELECT * FROM questions WHERE question LIKE '$quest'";
$resnq = mysql_query($sqlnq, $conn);
$num_qs = mysql_num_rows($resnq);
if ($num_qs > 0) { $red++; 
echo '<h4>This question has already been entered. Please edit the question below</h4>'; include('quiz_reedit_form.inc.php'); }

##Check at least 3 answer options were given unless it is a boolean question
else if ((!$ans1 || !$ans2 || !$ans3) && ($bool != 'yes') ) { $red++; 
echo '<h4>Please enter at least three answer options</h4>'; include('quiz_reedit_form.inc.php'); }

##Make sure the correct answer matches an available answer option
else if ((($corran == 'ans4') && (empty($ans4) || $ans4 == ' ' || $ans4 == 'q#exc')) || (($corran == 'ans5') && (empty($ans5) || $ans5 == ' ' || $ans5 == 'q#exc')) || (($corran == 'ans6') && (empty($ans6) || $ans6 == ' ' || $ans6 == 'q#exc'))) { $red++; 
echo '<h4>Correct answer option is not available</h4>'; include('quiz_reedit_form.inc.php'); }

else if (($corran == 'none') && ($bool != 'yes')) { $red++;
echo '<h4>Please select a correct answer</h4>'; include('quiz_reedit_form.inc.php'); }

else if ((empty($expl)) || ($expl == ' ')) { $red++;
echo '<h4>Please enter an explanation</h4>'; include('quiz_reedit_form.inc.php'); }
else {	

if ($bool == 'yes') {
$corran = $boolopt;
$sql = "INSERT INTO questions (question, test, ans1, ans2, ans3, ans4, corans, expl) values ('$quest', '$cat', 'true', 'false', 'xb##l', 'xb##l', '$corran', '$expl')";
}

else {
## Multiple Choice question
if ($ans4 == ' ' || empty($ans4)) { $ans4 = 'q#exc'; } // excludes from question
if ($ans5 == ' ' || empty($ans5)) { $ans5 = 'q#exc'; }
if ($ans6 == ' ' || empty($ans6)) { $ans6 = 'q#exc'; }

$sql = "INSERT INTO questions (question, test, ans1, ans2, ans3, ans4, ans5, ans6, corans, expl) values ('$quest', '$cat', '$ans1', '$ans2', '$ans3', '$ans4', '$ans5', '$ans6', '$corran', '$expl')";
}

$result = mysql_query($sql, $conn);
if (!$result) {
  echo "<p>There was a database error when executing the script \"$sql\"<br />";
  echo "MySQL error:".mysql_error()."</p>";
  include('../inc/footer.inc.php');
  exit;
}

else { 
echo '<h4>Question added successfully.</h4>';
include('update_view.inc.php');
}

}
} // end of loop
}

if ($red > 0) { echo '<input type="hidden" name="cat" value="'.$cat.'"><input type="hidden" name="qnu" value="'.$red.'"><input type="hidden" name="anu" value="'.$anu.'">';
echo '</form>'."\n".'<p id="bignav"><a href="javascript:document.quizadd.submit();">Resubmit Corrected Quiz!</a></p>';
}



?>
