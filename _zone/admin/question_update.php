<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();

$qid = $HTTP_GET_VARS['qid'];
$rowstart = $HTTP_GET_VARS['rowstart'];
$testsub = $HTTP_POST_VARS['testsub'];
$nt = $HTTP_POST_VARS['nt'];
$sql = "SELECT * FROM questions where ID = '$qid'";
$result = mysql_query($sql, $conn);
$qry = mysql_fetch_array($result);
$cor = $qry['corans'];
if ($nt != 'mo') {
echo '<form name="sopt" method="post" action="question_update.php?qid='.$qid.'&rowstart='.$rowstart.'"><input type="hidden" name="nt" value="mo" /><input type="hidden" name="testsub" value="'.$testsub.'" /></form><p id="hornav"><a href="javascript:document.sopt.submit();">Allow multiple answer options</a></p>';
}
echo '<h1>Edit Question '.$qry['ID'].'</h1>';
echo '<form name="qupdate" action="question_updated.php?qid='.$qry['ID'].'&rowstart='.$rowstart.'" method="post">';
echo '<table id="nq"><tr>';
echo '<th><label for="htmle">Use special characters</label></th><td><input name="htmle" id="htmle" type="checkbox" value="yes"></td></tr>';
echo '<tr><th>Question:</th>';
echo '<td><textarea name="quest" cols="60" rows="3">'.stripSlashes($qry['question']).'</textarea></td></tr>'."\n";

echo '<tr><th><label for="bool">Boolean answer:</label></th><td><input type="checkbox" name="bool" id="bool" value="bool"';
if (($qry['ans3'] == 'xb##l') && ($qry['ans4'] == 'xb##l')) { echo 'CHECKED'; }
echo ' />';
echo '<label for="boolopt">Correct response:&nbsp;</label><select name="boolopt"><option value="ans1"';
if (($qry['ans3'] == 'xb##l') && ($cor == 'ans1')) { echo 'SELECTED'; }
echo '>True</option><option value="ans2"'; 
if (($qry['ans3'] == 'xb##l') && ($cor == 'ans2')) { echo 'SELECTED'; }
echo '>False</option></select><br />';
echo 'If the <em>Boolean</em> option is selected, the other answer fields are ignored and you may proceed to the <em>Explanation</em> field.';
echo '</td></tr>';

echo '<tr><th>Subject Area</th>';
$subj = stripSlashes($qry['test']);
echo '<td><select name="subj">';
$sqlsub = "SELECT * FROM subjects";
$ressub = mysql_query($sqlsub, $conn);
while ($qrysub = mysql_fetch_array($ressub)) {
echo '<option value="'.$qrysub['cat'].'"';
if ($subj == $qrysub['cat']) { echo ' SELECTED'; }
echo '>'.$qrysub['cat'].'</option>'; }
echo '</select></td></tr>'."\n";
for ($h = 1; $h <=6; $h++) {
echo '<th>Answer '.$h.':<br />';
$cp1 = '<label for="corran'.$h.'">Correct&nbsp;</label><input type="radio" name="corran" id="corran'.$h.'" value="ans'.$h.'"';
$cp2 = '<label for="corran'.$h.'">Correct&nbsp;</label><input type="checkbox" name="corran'.$h.'" id="corran'.$h.'" value="ans'.$h.'"';
$cp3 = '/>';
if ($nt == 'mo') {
echo $cp2;
if ($cor[3] == $h) { echo ' CHECKED'; }
echo $cp3;
}
else {
if (ereg('ans', $cor)) { echo $cp1;
if ($cor[3] == $h) { echo ' CHECKED'; }
echo $cp3;
}
else
{
echo $cp2;
if ($cor[$h-1] == $h) { echo ' CHECKED'; }
echo $cp3;
}
}
echo '</th><td><textarea name="ans'.$h.'" cols="60" rows="2">'.stripSlashes($qry['ans'.$h]).'</textarea></td></tr>'."\n";
}

echo '</select></td></tr>'."\n";
echo '<tr><th>Explanation:</th><td><textarea name="expl" cols="60" rows="6">'.stripSlashes($qry['expl']).'</textarea></td></tr></table>';
echo '<p id="bignav"><a href="javascript:document.qupdate.submit();">Update Question</a></p>';
echo '<input type="hidden" name="testsub" value="'.$testsub.'"></form><hr>';


?>
