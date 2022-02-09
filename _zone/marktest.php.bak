<?php

#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

session_start();
require_once('inc/db_config.inc.php');
$conn = db_connect();
include('inc/header.inc.php');

$testsub = $HTTP_POST_VARS['testsub'];
$limit = $HTTP_POST_VARS['limit'];
$qes = 0;
$anw = 0;
$testtot = 0;
$tot = 0;
$skip = 0;
$qi = 0;

##Calculate total questions answered before marking test
$totsf = $HTTP_POST_VARS['totsf'];

$mark = '<ol id="numbered" start="'.($totsf+1).'">';
while ($qes < $limit) {
$qes++;
$anw++;
$ansy = 'answ'.$anw;
$ansy1 = 'answ1_'.$anw;
$ansy2 = 'answ2_'.$anw;
$ansy3 = 'answ3_'.$anw;
$ansy4 = 'answ4_'.$anw;
$ansy5 = 'answ5_'.$anw;
$ansy6 = 'answ6_'.$anw;
$qesy = 'quest'.$qes;
$answx = $HTTP_POST_VARS[$ansy];
$ansx[1] = $HTTP_POST_VARS[$ansy1];
$ansx[2] = $HTTP_POST_VARS[$ansy2];
$ansx[3] = $HTTP_POST_VARS[$ansy3];
$ansx[4] = $HTTP_POST_VARS[$ansy4];
$ansx[5] = $HTTP_POST_VARS[$ansy5];
$ansx[6] = $HTTP_POST_VARS[$ansy6];
$questx = $HTTP_POST_VARS[$qesy];
$sql = "select * from questions where ID = '$questx'";
if (!isset($questx)) { break; }
$result = mysql_query($sql, $conn);
while ($qry = mysql_fetch_array($result)) {
$qi++;
$cor = $qry['corans'];

##Check if multiple answer or multiple choice
if ((!ereg('ans', $cor)) && (!empty($cor)))
{ $type = 'ma'; } else { $type = 'mq'; }

##If multiple answer parse answer code
if ($type == 'ma') {
$answx = '';
$asl = strlen($cor);
for ($k = 1, $suc = 0, $noa = 0, $mi = 0; $k <= $asl; $k++) {
if ($ansx[$k] == $k) { $answx .= $k; } else { $answx .= 'm'; $mi++; };
if ($ansx[$k] == $cor[($k-1)] && $ansx[$k] == $k) { $suc++; }
if (isset($ansx[$k])) { $noa++; }
}
for ($p = 0, $cao = 0; $p < $asl; $p++) {
if ($cor[$p] != 'm') { $cao++; }
}
if ($mi == $asl) { $answx = ''; }
}


$mark .= '<li><strong>'.stripSlashes($qry['question']).'</strong><br />';
##Check if answered questions session variable has been set and add question to it


unset($ansz);
unset($taken);
$mark .= '<table id="nq">';

if ($type == 'mq') {
$ansz = $qry[$answx];
}

else {
for ($k = 1; $k <= 6; $k++) {
if ($ansx[$k] == $k) { $wrx = 'ans'.$k; $ansz .= $qry[$wrx].'<br />'; }
}
for ($p = 0, $w = 0; $p < $asl; $p++) {
if ($answx[$p] == intval($p+1)) { $crx = 'ans'.($p+1); $w++; if ($w > 1) { $crans .= '<br />'; } $crans .= $qry[$crx]; }
}

}

##verify answers and assign scoreboard session variables
if ($answx == $cor) {
$resz = 'Correct!';
$taken = 'y';
$tot++;
$sym = 'correct_tick.gif';
if ($type == 'mq') {
$ansz = stripSlashes($qry[$answx]); }
else {
$crans = '';
for ($p = 0, $w = 0; $p < $asl; $p++) {
if ($answx[$p] == intval($p+1)) { $crx = 'ans'.($p+1); $w++; if ($w > 1) { $crans .= '<br />'; } $crans .= $qry[$crx]; }
}
$ansz = stripSlashes($crans);
}
$testtot++;
$HTTP_SESSION_VARS['scoreboard'][$testsub][$questx] = 'c';
$expla = '';
}

else if (empty($answx) || $answx == '' || $answx == ' ') {
$resz = 'Skipped';
$taken = '';
$sym = 'skipped.gif';
$skip++;
$expla = '';
}
else
{
$resz = 'Incorrect!';
$taken = 'y';
$tot++;
$sym = 'wrong_cross.gif';
$expla = '<blockquote>'.stripSlashes($qry['expl']).'</blockquote>';
$HTTP_SESSION_VARS['scoreboard'][$testsub][$questx] = $answx;
}
if ($taken == 'y') {
$ai = count($HTTP_SESSION_VARS['answered']);
if ($ai > 0) { $HTTP_SESSION_VARS['answered'][$ai] = $qry['ID']; }
else { $HTTP_SESSION_VARS['answered'][0] = $qry['ID']; }

$mark .= '<tr><th>You answered:</th><td><em>'.$ansz.'</em></td></tr>';
}
}

$mark .= "\n".'<tr><th>'.$resz.'</th><td><img src="img/'.$sym.'" width="21" height="21">';

if ($type == 'ma' && $taken == 'y') {
$req = ' required answer options correct';
if ($noa <= $cao) { $mark .= $suc.' of '.$cao.$req; }
if ($noa > $cao) { $mark .= $suc.' of '.$cao.$req.' <em>('.($noa-$cao).' too many selected)</em>'; }
}


$mark .= '</td></tr></table>';
$mark .= $expla;
$mark .= '</li>'."\n".'<hr />'."\n";
}

$mark .= '</ol>';

##Recalculate total questions answered so far
if (isset($HTTP_SESSION_VARS['scoreboard'][$testsub])) {
$correctans = 0;
$totsub = 0;
foreach ($HTTP_SESSION_VARS['scoreboard'][$testsub] as $questi)
{
if ($questi == 'c') { $correctans++; }
$totsub++;
}
}
##Check total number of questions in category
$sqlns = "SELECT * FROM questions WHERE test LIKE '$testsub'";
$resns = mysql_query($sqlns, $conn);
$numcat = mysql_num_rows($resns);

$ctest = '<a href="javascript:document.retake.submit();">Continue <em>'.$testsub.'</em> test</a>';
$rssh = '<a href="results.php">Results Sheet</a>';

echo '<p class="rtali" id="hornav">';
if ($totsub < $numcat){ echo $ctest; } else { echo $rssh; }
echo '<a href="index.php">Select another test</a></p>';
if ($testsub == 'all') {$subject = 'All Subjects'; }
else { $subject = $testsub; }
echo '<h1>'.$subject.' Test</h1>';
echo '<table id="nq">';
if ($skip >= $tot) {
echo '<tr><td colspan="2">You did <em>not</em> answer any questions at all !</td></tr>'; }
if ($numcat > $testtot && $tot > 0) {
echo '<tr><th>Subtotal:</th><td>'.$testtot.' / '.$tot.' or '.round(($testtot / $tot) * 100).'% '; }
if ($skip > 0 && $skip < $tot ) {
echo '<br />However, you skipped '.$skip.' question';
if ($skip != 1) { echo 's'; }
}
if ($totsub > 0) {
$tsc = $correctans.' / '.$totsub;
$pcsc = round(($correctans/$totsub)*100).'%';
$rs0 = '<tr><th>';
$rs2 = '</th><td>';
$rs3 = '</td></tr>';
$ttn = 'Subject total:</th><td>'.$numcat;
if (($totsub > $limit) && ($totsub < $numcat)) {
echo $rs0.'Running score:'.$rs2.$tsc.' or '.$pcsc.' '.$rs3;
}
echo $rs0.$ttn.$rs3;
}
else if ($totsub == $numcat) {
echo $rs0.'Total score:'.$rs2.$tsc.' or '.$pcsc.$rs3;
}
else { echo $rs0.$ttn.$rs3; }

echo '</td></tr></table>';
?>
<h3>Please review your test results</h3>
<?php
##Print marked test
echo $mark;
?>
<form name="retake" action="quiz.php" method="post">
<input type="hidden" name="limit" value="<?php echo $limit; ?>">
<input type="hidden" name="testsub" value="<?php echo $testsub; ?>">
</form>

<?php  include_once('inc/footer.inc.php'); ?>
