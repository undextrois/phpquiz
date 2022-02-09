<?php
error_reporting(0);
	echo '<form name="testupdate" action="question_added.php" " method="post">';
 echo '<table width="96%" border="0" cellspacing="0" cellpadding="4"><tr><th>New Question: </th>';
	echo '<td><textarea name="quest" cols="54" rows="3">'.$quest.'</textarea></td></tr>';
	echo '<tr><th>Correct answer:</th><td>';
	echo '<th>Subject Area</th>';
echo '<td><select name="subj">';
$sqlsub = "SELECT * FROM subjects";
$ressub = mysql_query($sqlsub, $conn);
while ($qrysub = mysql_fetch_array($ressub)) {
echo '<option value="'.$qrysub['cat'].'"';
if ($subj == $qrysub['cat']) { echo ' SELECTED'; }
echo '>'.$qrysub['cat'].'</option>'; }
echo '</select></td></tr>';
  echo '<tr><th>Answer 1:</th><td><textarea name="ans1" cols="54" rows="2">'.$ans1.'</textarea></td></tr>';
	echo '<tr><th>Answer 2:</th><td><textarea name="ans2" cols="54" rows="2">'.$ans2.'</textarea></td></tr>';
	echo '<tr><th>Answer 3:</th><td><textarea name="ans3" cols="54" rows="2">'.$ans3.'</textarea></td></tr>';
	echo '<tr><th>Answer 4:</th><td><textarea name="ans4" cols="54" rows="2">'.$ans4.'</textarea></td></tr>';
	echo '<tr><th>Correct answer:</th><td><select name="corran">';
	echo '<option value="none" ';
	if ($corran == 'none' || !$corran ) { echo 'SELECTED'; }
	echo '>Please select an answer</option>';
	echo '<option value="ans1" ';
	if ($corran == ans1) { echo 'SELECTED'; }
	echo '>Answer 1</option>';
	echo '<option value="ans2" ';
	if ($corran == ans2) { echo 'SELECTED'; }
	echo '>Answer 2</option>';
	echo '<option value="ans3" ';
	if ($corran == ans3) { echo 'SELECTED'; }
	echo '>Answer 3</option>';
	echo '<option value="ans4"';
	if ($corran == ans4) { echo ' SELECTED'; }
	echo '>Answer 4</option><select></td></tr>';
	echo '<tr><th>Explanation:</th><td><textarea name="expl" cols="54" rows="3">'.$expl.'</td></tr></table>';
	echo '<input name="post" type="hidden" value="Submit"></form>';
 echo '<p id="bignav"><a href="javascript:document.testupdate.submit();">Update Question!</a><a href="questions.php">Return without updating</a></p>';
?>
