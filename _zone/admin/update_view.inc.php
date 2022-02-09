<?php
error_reporting(0);
##check if a question id has been set,
##else match question record with newly entered question text

if (isset($qid)) {
$sql2 = "SELECT * FROM questions where ID = '$qid'"; }
else {
$sql2 = "SELECT * FROM questions where question = '$quest'"; }

  $result2 = mysql_query($sql2, $conn);
  $qry2 = mysql_fetch_array($result2);
echo '<table id="nq"><tr><th>Question '.$qry2['ID'].':</th><td>'.stripSlashes($qry2['question']).'</td>';
echo '<td><p id="hornav">';
if (!eregi("delete\.php", $HTTP_SERVER_VARS['PHP_SELF'])) { echo '<a href="question_update.php?qid='.$qry2['ID'].'">Edit Question</a><a href="question_delete.php?qid='.$qry2['ID'].'">Delete</a>'; }
else { echo '<form name="delete_q" method="post" action="question_deleted.php?qid='.$qid.'&rowstart="'.$rowstart.'"><input type="hidden" name="testsub" value="<?php echo $testsub; ?>"></form><a href="javascript:document.delete_q.submit()">Confirm deletion</a>'; }
echo '</p></td></tr>';
echo '<tr><th>Subject area: </th><td colspan="2">'.$qry2['test'].'</td></tr>';
##if Boolean question
if (($qry2['ans4'] == 'xb##l') && ($qry2['ans3'] == 'xb##l'))
{
echo '<tr><th>Correct answer: </th><td class="Heading2">';
	switch($qry2[corans]) {
	case ans1: echo 'True'; break;
	case ans2: echo 'False'; break;
}
}
##if multiple choice
else {
echo '<tr><th>Answers:</th><td colspan="2">';
echo '<ol id="numbered">';
for ($h = 1; $h <= 6; $h++) {
$q = $qry2['ans'.$h];
if ($q != 'q#exc' && !empty($q)) {
echo '<li>'.stripSlashes($qry2['ans'.$h]).'</li>'; }
}
echo '</ol>'."\n".'</td></tr>'."\n"; 
echo '<tr><th>Correct answer: </th><td colspan="2">';
if (ereg('ans', $qry2['corans'])) {
	switch($qry2['corans']) {
	case ans1: echo '1)'; break;
	case ans2: echo '2)'; break;
	case ans3: echo '3)'; break;
	case ans4: echo '4)'; break;
	case ans5: echo '5)'; break;
	case ans6: echo '6)'; break;
}
}
else {
$asl = strlen($qry2['corans']);
for ($p = 0, $a = 0; $p < $asl; $p++) {
if ($qry2['corans'][$p] == ($p+1)) { $a++; if ($a == 1) { echo ($p+1).')'; } else { echo ', '.($p+1).')'; } }
}
}

}


echo '<tr><th>Explanation:</th><td colspan="2">'.stripSlashes($qry2['expl']).'</td></tr></table>'."\n".'<hr>'."\n";

?>
