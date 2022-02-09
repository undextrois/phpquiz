<?php

#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

session_start();
require_once('inc/db_config.inc.php');
$conn = db_connect();
include('inc/header.inc.php'); 

if (isset($HTTP_SESSION_VARS['scoreboard'])) {
echo '<p id="hornav"><a href="results.php">View Results Sheet</a></p>';
}
?>
<h2>Welcome to the Test Zone</h2>
<h3>Please select a subject area and the number of questions you wish to answer.</h3>
<ol id="numbered">
<?php
  $sqlsu = "SELECT * FROM subjects ORDER BY ID";
  $ressu = mysql_query($sqlsu, $conn);
  if (mysql_num_rows($ressu)) {
  while ($qry = mysql_fetch_array($ressu)) {
  $cat = stripSlashes($qry['cat']);
$resns = mysql_query("SELECT * FROM questions WHERE test LIKE '$cat'", $conn);
$numcat = mysql_num_rows($resns);
if ($numcat > 0) {  
// Check if scoreboard contains entries in this category and, if so, list results
if (isset($HTTP_SESSION_VARS['scoreboard']) && ($HTTP_SESSION_VARS['scoreboard'][$cat])) {
$totsub = 0;
$correctans = 0;
foreach ($HTTP_SESSION_VARS['scoreboard'][$cat] as $questi)
{
if ($questi == 'c') { $correctans++; }
$totsub++;
}
}
echo "\n".'<form name="teststart'.$qry['ID'].'" action="quiz.php" method="post">';
echo '<li><p id="hornav">';
if ((!$totsub) || ($totsub < $numcat)) {
if ($totsub) { $togo = ($numcat - $totsub); } else { $togo = $numcat; }
echo '<select name="limit">';
if ($togo > 5) { echo '<option value="5" SELECTED>5 questions</option>'; }
for ($j = 1; $j < 12; $j++) {
if ($togo > ($j * 10)) { echo '<option value="'.($j*10).'">'.($j*10).' questions</option>'; }
}
echo '<option value="'.$togo.'">';
if ($togo > 1) {echo ' all '; }
echo $togo;
if ($totsub > 0) { echo ' remaining'; }
echo '</option></select>';
}
if ($totsub >= $numcat) {
echo ' Test completed</p>'; }
else if ($totsub > 0) {
echo '<a href="javascript:document.teststart'.$qry['ID'].'.submit()">Continue Test</a></p>'; }
else {
echo '<a href="javascript:document.teststart'.$qry['ID'].'.submit()">Start Test</a></p>'; }

echo '<strong>'.$cat.'</strong> ';
echo '<em>('.$numcat.' questions)</em>';
echo '<br />';
echo '<input type="hidden" name="testsub" value="'.$cat.'">';
echo stripslashes($qry['descr']);

if ($totsub > 0) {
echo '<h3>Total score: '.$correctans.'/'.$totsub.'</h3>';
$totsub = 0;
$correctans = 0;
}

echo '</li>'."\n".'</form>'."\n";

echo '<hr />';
}
}
}
?>

</ol>
<br />
<?php  include_once('inc/footer.inc.php'); ?>
