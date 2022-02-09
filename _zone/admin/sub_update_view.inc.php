<?php
error_reporting(0);
echo '<h1>Subject Review</h1><p class="rtali"><em>Questions are sorted in 20s</em></p>'."\n".'<hr /><br />';
echo '<table id="nq">';
  $sqlsu = "SELECT * FROM subjects ORDER BY ID";
  $ressu = mysql_query($sqlsu, $conn);
  $snu = 1;
  if (mysql_num_rows($ressu)) {
  while ($qry = mysql_fetch_array($ressu)) {
		$cat = stripSlashes($qry['cat']);
		echo '<tr><th>Subject '.$snu.':</th><td>';
echo '<strong>'.$cat.'. </strong></td>';
echo '<td><p id="hornav"><a href="javascript:document.qview'.$qry['ID'].'.submit();">Edit questions</a><a href="subject_update.php?suid='.$qry['ID'].'">Edit Subject</a><a href="subject_delete.php?suid='.$qry['ID'].'">Delete</a></p></td></tr>';
echo "\n".'<tr><th>Description:</th><td colspan="2">'.stripSlashes($qry['descr']).'</td></tr>';
$sqlns = "SELECT * FROM questions WHERE test LIKE '$cat'";
$resns = mysql_query($sqlns, $conn);
$numcat = mysql_num_rows($resns);
echo "\n".'<tr><th>Number of questions:</th><td colspan="2">'.$numcat.'</td></tr>';
echo "\n".'<tr><th>Random mode:</th><td colspan="2">';
$dff = 'Random question and answer order';
switch ($qry['random']) {
case '1': echo $dff;
break;
case '2': echo 'Random question order with fixed answer order';
break;
case '3': echo 'Fixed question order with random answer order';
break;
case '4': echo 'Fixed question answer order';
break;
default: echo $dff;
}
echo '</td></tr>';
echo "\n".'<tr><td colspan="3"><hr /></td></tr>'."\n";
echo '<form name="qview'.$qry['ID'].'" action="questions.php" method="post"><input type="hidden" name="testsub" value="'.$qry[cat].'"></form>'."\n";
$snu++;
}
echo '</table>';
}
echo '</ol>'."\n";

?>
