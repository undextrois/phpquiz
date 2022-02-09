<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();

$rowstart = $HTTP_GET_VARS['rowstart'];
if (!isset($rowstart) || empty($rowstart)) { $rowstart = 0; }
$testsub = $HTTP_POST_VARS['testsub'];
if (!$testsub) { $testsub = 'all'; }
include('hormenu.php');
echo '<h1>Question Review</h1>';
if ($testsub == 'all') {
$sql = "SELECT * FROM questions ORDER BY ID LIMIT $rowstart, 20";
$sqlns = "SELECT * FROM questions";
$tsub = '';
}
else {
$sql = "SELECT * FROM questions WHERE test LIKE '$testsub' ORDER BY ID LIMIT $rowstart, 20";
$sqlns = "SELECT * FROM questions WHERE test LIKE '$testsub'";
$tsub = ' in <em>'.$testsub.'</em>';
		}
$resns = mysql_query($sqlns, $conn);
$numq = mysql_num_rows($resns);
  $result = mysql_query($sql, $conn);
  if (mysql_num_rows($result)) {
echo '<h3>Total number of questions'.$tsub.': '.$numq.'</h3>'."\n".'<hr />';
include('questnav.inc.php');
  while ($qry = mysql_fetch_array($result)) {
$qid = $qry['ID'];
echo '<form name="delete'.$qry['ID'].'" method="post" action="question_delete.php?qid='.$qid.'&rowstart='.$rowstart.'"><input type="hidden" name="testsub" value="'.$testsub.'"></form>';
echo '<form name="edit'.$qry['ID'].'" method="post" action="question_update.php?qid='.$qid.'&rowstart='.$rowstart.'"><input type="hidden" name="testsub" value="'.$testsub.'"></form>';
echo '<table id="nq"><tr><th>Question '.$qid.':</th>';
echo '<td>'.stripSlashes($qry['question']).'</td>';
echo '<td><p id="hornav"><a href="javascript:document.edit'.$qid.'.submit()">Edit</a><a href="javascript:document.delete'.$qid.'.submit()">Delete</a></p></td>';
echo '</td></tr>';
echo '<tr><th>Subject area: </th><td colspan="2">'.$qry['test'].'</td></tr>';
echo '<tr><th>Answers:</th><td colspan="2">';
echo '<ol id="numbered">';
for ($h = 1; $h <= 6; $h++) { // Cycle through answer options
$q = $qry['ans'.$h];
if ($q != 'xb##l' && $q != 'q#exc' && !empty($q)) {
echo '<li>'.stripSlashes($q).'</li>';
}
}
echo '</ol></td></tr>'."\n";
echo '<tr><th>Correct answer: </th><td colspan="2">';

#check if boolean
if ($qry['ans4'] == 'xb##l') {
	switch($qry['corans']) {
	case ans1: echo 'True'; break;
	case ans2: echo 'False'; break;
}
}
else if (ereg('ans', $qry['corans'])) {
	switch($qry['corans']) {
	case ans1: echo '1)'; break;
	case ans2: echo '2)'; break;
	case ans3: echo '3)'; break;
	case ans4: echo '4)'; break;
	case ans5: echo '5)'; break;
	case ans6: echo '6)'; break;
}
}
else {
$asl = strlen($qry['corans']);
for ($p = 0, $a = 0; $p < $asl; $p++) {
if ($qry['corans'][$p] == ($p+1)) { $a++; if ($a == 1) { echo ($p+1).')'; } else { echo ', '.($p+1).')'; } }
}


}
echo '<tr><th>Explanation:</th><td colspan="2">';
echo stripSlashes($qry['expl']);
echo '</td></tr></table><hr>'."\n";
}
}

include('questnav.inc.php');


?>
