<?php
session_start();
require_once('inc/db_config.inc.php');
$conn = db_connect();

include('inc/header.inc.php');
?>
<h1><p id="hornav"><a href="index.php">Try another test</a></p>Results Sheet</h1>
<?php

$sqs = "SELECT * FROM subjects ORDER BY ID";
$rss = mysql_query($sqs, $conn);
if (mysql_num_rows($rss)) {
while ($qrs = mysql_fetch_array($rss)) {
$cat = $qrs['cat'];
$correctans = 0;
$totsub = 0;
// Check if scoreboard contains entries in this category and, if so, list results
if (count($HTTP_SESSION_VARS['scoreboard'][$cat]) > 0) {
$mark .= '<ol id="numbered">';
while (list($key, $questi) = each(($HTTP_SESSION_VARS['scoreboard'][$cat]))) {
$totsub++;
$sql = "select * from questions where ID = '$key'";
$res = mysql_query($sql, $conn);
while ($qry = mysql_fetch_array($res)) {
$mark .= '<li class="numbered"><strong>'.stripSlashes($qry['question']).'</strong><br />';
$cor = $qry['corans'];

unset($ansz);
$mark .= '<table id="nq">';
if ($questi != 'f') {
$mark .= '<tr><th>You answered:</th><td><em>';
}
##Check if multiple answer or multiple choice
if ((!ereg('ans', $cor)) && (!empty($cor)))
{ $type = 'ma'; } else { $type = 'mq'; }

if ($questi == 'c') {
$correctans++;

##verify answers and assign scoreboard session variables
$resz = 'Correct!';
$sym = 'correct_tick.gif';
if ($type == 'mq') {
$ansz = stripslashes($qry[$cor]); }
else {
$crans = '';
for ($p = 0, $w = 0; $p < $asl; $p++) {
if ($cor[$p] == intval($p+1)) { $crx = 'ans'.($p+1); $w++; if ($w > 1) { $crans .= '<br />'; } $crans .= $qry[$crx]; }
}
$ansz = stripslashes($crans);
}
$expla = '';
	}
	else if ($questi == 'f') {
	$resz = 'Skipped.';
	$sym = 'wrong_cross.gif';
	$expla = '';
	$skip++;
	}
	else
	{
	$resz = 'Incorrect!';
	$sym = 'wrong_cross.gif';
	if ($type == 'mq') {
	$ansz = $qry[$questi]; }
	else {
for ($p = 0, $cao = 0; $p < $asl; $p++) {
if ($cor[$p] != 'm') { $cao++; }
}


	$asl = strlen($questi);
	for ($m = 0, $n = 0; $m < $asl; $m++) {
	if ($questi[$m] == ($m+1)) { $wrnx = 'ans'.($m+1);
	if ($n == 0) { $wrans = $qry[$wrnx]; } else { $wrans .= '<br />'.$qry[$wrnx]; } $n++;
	}
	}
	$ansz = stripslashes($wrans);
	}
	$expla = '<blockquote>'.stripSlashes($qry['expl']).'</blockquote>';
	 }
 }
if ($questi != 'f') { $mark .= $ansz.'</em></td></tr>'; }
$mark .= "\n".'<tr><th>'.$resz.'</th><td><img src="img/'.$sym.'" width="21" height="21">';
$mark .= '</td></tr></table>';
$mark .= $expla;

$mark .= '</li>'."\n".'<hr />'."\n";
  }
  $mark .= '</ol>';
$pce = round((($correctans / $totsub) * 100));
if ($totsub > 0) {
echo '<p><span class="heading2">'.$cat.'</span><br />';
echo $qry['descr'].'<br />';
echo '<span class="heading2">Score: '.$correctans.'/'.$totsub.' or '.$pce.'%</span></p>';
echo $mark;
echo '<hr />'."\n";
$mark = '';
}
}
}
}

include_once('inc/footer.inc.php');

?>
