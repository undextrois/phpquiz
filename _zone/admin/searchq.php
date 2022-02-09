<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();

include('hormenu.php');

$sstr = $HTTP_POST_VARS['sstr'];
$styp = $HTTP_POST_VARS['styp'];
$testsub = $HTTP_POST_VARS['testsub'];
$pword = $HTTP_POST_VARS['pword'];

if ($pword == 'yes') { $fstr = 'LIKE (\'%'.$sstr.'%\')'; } else  { $fstr = 'REGEXP \'[[:<:]]'.$sstr.'[[:>:]]\''; }

echo '<h3>Search results for <em>'.$sstr.'</em>:</h3>';
$sqlsch = "SELECT * FROM subjects";
$ressch = mysql_query($sqlsch, $conn);
echo '<hr />'."\n";
include('searchform.inc.php');
echo '<hr />'."\n";

if ((empty($sstr)) && ($sstr == ' ')) 
{ echo '<p>Please enter a search string!</p>'; }

else if (($sstr == 'the') || ($sstr == 'and') || ($sstr == 'what') || ($sstr == 'which') || ($sstr == 'with') || ($sstr == 'who') || ($sstr == 'from') || ($sstr == 'for') || ($sstr == 'where') || ($sstr == 'why')) 
{ echo '<p>The entered string is either a very common word </p>'; }

else if (strlen($sstr) < 2) 
{ echo '<p>Single character searches are inadmissable. (<em>With partial character searches enter at least 4 characters</em>).</p>'; }

else if (($pword == 'yes') && (strlen($sstr) < 4))
{ echo '<p>Please enter at least 4 characters with partial character searches (<em>With whole searches enter at least 2 characters.</em>).</p>'; }

else {
$s1 = 'SELECT * FROM questions WHERE';
if (($testsub == 'all') || (!testsub)) { $tte = ''; }
else { $tte = "test = '".$testsub."' AND"; }

$sqd = "$s1 $tte (question $fstr OR ans1 $fstr OR ans2 $fstr OR ans3 $fstr OR ans4 $fstr OR ans5 $fstr OR ans6 $fstr OR expl $fstr)";
switch ($styp) {
case 'al':
$sql = $sqd;
break;
case 'qo':
$sql = "$s1 $tte question $fstr";
break;
case 'ao':
$sql = "$s1 $tte (ans1 $fstr OR ans2 $fstr OR ans3 $fstr OR ans4 $fstr OR ans5 $fstr OR ans6 $fstr)";
break;
case 'eo':
$sql = "$s1 $tte expl $fstr";
break;
default: $sqd;
}
$result = mysql_query($sql, $conn);

if ($result  && mysql_num_rows($result)) {
while ($qry = mysql_fetch_array($result)) {
 
echo '<table id="nq"><tr><th>Question '.$qry['ID'].':</th><td>'.stripSlashes($qry['question']).'</td>';
echo '<td><p id="hornav"><a href="question_update.php?qid='.$qry['ID'].'">Edit Question</a><a href="question_delete.php?qid='.$qry['ID'].'">Delete</a></p></td></tr>';
echo '<tr><th>Subject area: </th><td colspan="2">'.$qry['test'].'</td></tr>';
##if Boolean question
if (($qry['ans4'] == 'xb##l') && ($qry['ans3'] == 'xb##l'))
{
echo '<tr><th>Correct answer: </th><td class="Heading2">';
	switch($qry[corans]) {
	case ans1: echo 'True'; break;
	case ans2: echo 'False'; break;
}
}
##if multiple choice
else {
echo '<tr><th>Answers:</th><td colspan="2">';
echo '<ol id="numbered">';
for ($h = 1; $h <= 6; $h++) {
$q = $qry['ans'.$h];
if ($q != 'q#exc' && !empty($q)) {
echo '<li>'.stripSlashes($qry['ans'.$h]).'</li>'; }
}
echo '</ol>'."\n".'</td></tr>'."\n"; 
echo '<tr><th>Correct answer: </th><td colspan="2">';
	switch($qry['corans']) {
	case ans1: echo '1)'; break;
	case ans2: echo '2)'; break;
	case ans3: echo '3)'; break;
	case ans4: echo '4)'; break;
	case ans5: echo '5)'; break;
	case ans6: echo '6)'; break;
}
}
echo '<tr><th>Explanation:</th><td colspan="2">'.stripSlashes($qry['expl']).'</td></tr></table>'."\n".'<hr>'."\n";

}
}
else {
echo '<p>No matching records were found for '.$sstr;

if ($pword == 'yes') { echo ' <em>(including partial word matches}</em>'; } else { echo ' <em>(whole word search only}</em>'; }

echo '</p>';
}

} //end of search


 ?>
