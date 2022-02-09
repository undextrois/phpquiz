<?php

#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

session_start();
require_once('inc/db_config.inc.php');
$conn = db_connect();
$title = 'Quiz Zone';

$limit = $HTTP_POST_VARS['limit'];
$testsub = $HTTP_POST_VARS['testsub'];

if ($testsub != 'all'){
$sqldes = "SELECT * FROM subjects WHERE cat LIKE '$testsub' LIMIT 1";
$resdes = mysql_query($sqldes, $conn);
$qr2 = mysql_fetch_array($resdes);
$rand = $qr2['random'];
if ($rand != '3' && $rand != '4') { $rmode = 'ORDER BY RAND()'; } else { $rmode = 'ORDER BY ID'; }
}
$sfq = 'SELECT * FROM questions';
$sfqw = $sfq.' WHERE';

  if (!$limit) { $limit = '5'; }
if (isset($HTTP_SESSION_VARS['answered'])) { $ansd = count($HTTP_SESSION_VARS['answered']); } else { $ansd = 0; }
  if (!$testsub) { $testsub = 'all'; }
  if ($testsub == 'all') {
  if ($ansd == 0) {
$sql = "$sfq $rmode LIMIT $limit";
}
  else {
$exclu = '\''.$HTTP_SESSION_VARS['answered'][0].'\'';
  for ($i = 1; $i < $ansd; $i++) {
$exclu .= ', \''.$HTTP_SESSION_VARS['answered'][$i].'\' ';
}
$sql = "$sfqw ID NOT IN ($exclu) $rmode LIMIT $limit";
}
}
  else {
    if ($ansd == 0) {
$sql = "$sfqw test='$testsub' $rmode LIMIT $limit";
}
  else {
$exclu = '\''.$HTTP_SESSION_VARS['answered'][0].'\'';
  for ($i = 1; $i < $ansd; $i++) {
$exclu .= ', \''.$HTTP_SESSION_VARS['answered'][$i].'\' ';
}
$sql = "$sfqw test='$testsub' AND ID NOT IN ($exclu) $rmode LIMIT $limit";
}
}
$result = mysql_query($sql, $conn);
$tot = mysql_num_rows($result);

include('inc/header.inc.php');
?>
<h1>Your chosen subject is: <?php echo $testsub; ?></h1>
<?php

if (isset($HTTP_SESSION_VARS['scoreboard']) && ($HTTP_SESSION_VARS['scoreboard'][$testsub])) {
$correctans = 0;
$totsub = 0;
foreach ($HTTP_SESSION_VARS['scoreboard'][$testsub] as $questi)
{
if ($questi == 'c') { $correctans++; }
$totsub++;
}

if (($tot == 0) && ($ansd > 0)) { 
echo '<p id="hornav">';
if ($totsub > 1){ echo '<a href="results.php">Results Sheet</a>'; }
echo '<a href="index.php">Select another test</a></p>';
}

if ($totsub > 0) {
echo '<h3>Running score: '.$correctans.'/'.$totsub.'</h3>';
}
}

if ($testsub != 'all'){
echo '<h3>'.$qr2['descr'].'</h3>';
}
if (($tot < $limit) && (!isset($HTTP_SESSION_VARS['answered']))) { echo '<h3">There are only '.$tot.' questions in this category.</h3>'; }
else if  (($tot < $limit) && ($tot > 0) && ($ansd > 0)) { echo '<h3">Only '.$tot.' questions remaining in this category.</h3>'; }
else if (($tot == 0) && ($ansd > 0)) { echo '<h3>There are no more questions in this category.</h3>'."\n"; }
if ($tot > 0) {
?>
<span class="Heading4">Please answer the following <?php $qu = ' question'; if ($tot > 1) { echo $tot.$qu.'s'; } else { echo $qu; }?> and then press the <em>Mark Test</em> button below!</span>
<?php } ?>
<form name="quiz" action="marktest.php" method="post">
<?php
echo '<ol id="numbered" start="'.($totsub + 1).'">';
##Cycle through randomly selected questions
if (mysql_num_rows($result)) {
$qi = 0;
while ($qry = mysql_fetch_array($result)) {
$qi++;

$qu1 = '<li><strong> '.stripSlashes($qry['question']).'</strong>'."\n";
$qu2 = '<table id="qst">';

$t0 = '<tr><th>';
$t1 = '<input name="answ';
$t2b = '" id="';
$t3 = '"></th><td>';
$t3b = '<label for="';
$t3c = '">';
$t3d = '</label>';
$t4 = '</td></tr>'."\n";

$ab = array ('a)', 'b)', 'c)', 'd)', 'e)', 'f)');

$cor = $qry['corans'];
if (!ereg('ans', $cor))
{
$t2 = '" type="checkbox" value="';
$asl = strlen($cor);
switch ($asl) {
case 4: $answers = array('1', '2', '3', '4'); break;
case 5: $answers = array('1', '2', '3', '4', '5'); break;
case 6: $answers = array('1', '2', '3', '4', '5', '6'); break;
default: array('1', '2', '3', '4', '5', '6');
}
for ($p = 0, $cao = 0; $p < $asl; $p++) {
if ($cor[$p] != 'm') { $cao++; }
}
if ($rand != '2' && $rand != '4') {
srand ((double)microtime()*1000000);
shuffle($answers);
}
echo $qu1.'<em>('.$cao.' correct answers)</em>'.$qu2;

for ($f = 0; $f < $asl; $f++) {
$ansn = $qry['ans'.$answers[$f]];
if (($ansn != 'q#exc') && ($ansn != ' ') && ($ansn != '') && (!empty($ansn))) {
echo $t0.$ab[$f].$t1.$answers[$f].'_'.$qi.$t2.$answers[$f].$t2b.'answ'.$answers[$f].'_'.$qi.$t3.$t3b.'answ'.$answers[$f].'_'.$qi.$t3c.$ansn.$t3d.$t4;
}
}
}

else // if multiple choice or Boolean
{
$t2 = '" type="radio" value="';
echo $qu1.$qu2;
##Check if Boolean question
if (($qry['ans4'] == 'xb##l') && ($qry['ans3'] == 'xb##l')) {
$answers = array ('opt1', 'opt2');
srand ((double)microtime()*1000000);
shuffle($answers);
$opt1 = $t0.$t1.$qi.$t2.'ans1'.$t2b.'ans1_'.$qi.$t3.$t3b.'ans1_'.$qi.$t3c.'True'.$t3d.$t4;
$opt2 = $t0.$t1.$qi.$t2.'ans2'.$t2b.'ans2_'.$qi.$t3.$t3b.'ans2_'.$qi.$t3c.'False'.$t3d.$t4;
if ($answers[0] == 'opt1') { echo $opt1; } else { echo $opt2; }
if ($answers[1] == 'opt1') { echo $opt1; } else { echo $opt2; }
}

else
#Multiple choice
{
##Check if only 3 answer options
if (($qry['ans4'] == 'q#exc') || (empty($qry['ans4'])))
{
$answers = array ('ans1', 'ans2', 'ans3');
$nj = 3;
}

##Check if only 4 answer options
else if ((($qry['ans5'] == 'q#exc') || (empty($qry['ans5']))) && (($qry['ans6'] == 'q#exc') || (empty($qry['ans6']))) && (($qry['ans4'] != 'q#exc') || (!empty($qry['ans4']))))
{
$answers = array ('ans1', 'ans2', 'ans3', 'ans4');
$nj = 4;
}

##Check if only 5 answer options
else if ((($qry['ans6'] == 'q#exc') || (empty($qry['ans6']))) && (($qry['ans4'] != 'q#exc') || (!empty($qry['ans4']))))
{
$answers = array ('ans1', 'ans2', 'ans3', 'ans4', 'ans5');
$nj = 5;
}

else {
$answers = array ('ans1', 'ans2', 'ans3', 'ans4', 'ans5', 'ans6');
$nj = 6;
}
srand ((double)microtime()*1000000);
shuffle($answers);
for ($j = 0; $j < $nj; $j++) {
echo $t0.$t3b.$answers[$j].'_'.$qi.$t3c.$ab[$j].$t3d.$t1.$qi.$t2.$answers[$j].$t2b.$answers[$j].'_'.$qi.$t3.$t3b.$answers[$j].'_'.$qi.$t3c;
$answra[$j] = '$qry['.$answers[$j].']';
eval("echo stripSlashes($answra[$j]); ");
echo $t3d.$t4;
}

}
}
echo '</table></li><hr class="dshd">'."\n".'<input type="hidden" name="quest'.$qi.'" value="'.$qry['ID'].'">'."\n";
}
echo '<input type="hidden" name="limit" value="'.$limit.'">';
echo '<input type="hidden" name="testsub" value="'.$testsub.'">';
echo '<input name="totsf" type="hidden" value="'.$totsub.'">';
echo '<p id="bignav"><a href="javascript:document.quiz.submit();">Mark Test Now!</a></p>';
}

?>
</ol>
</form>
<?php  include_once('inc/footer.inc.php'); ?>
