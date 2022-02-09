<?php error_reporting(0); ?>
<form name="quizadd" action="quiz_added.php<?php if (isset($rowstart)) { echo '?rowstart='.$rowstart; } ?>" method="post">
<input type="hidden" name="testsub" value="<?php echo $testsub; ?>" />
<table id="nq"><tr>
<?php 
$tty = $HTTP_POST_VARS['tty'];
$testsub = $HTTP_POST_VARS['testsub'];
if ($tty == 'new') { ?>
<tr><th>New Subject Name:</th>
<td><input name="cat" type="text" size="31" />&nbsp;(Leave empty if you wish to choose an existing subject area)</td></tr>
<?php
}

echo '<tr><th>';
if ($tty == 'new') { echo 'Existing subject:'; } else { echo 'Subject area:'; }
echo '</th><td>';
echo '<select name="subj">';
echo '<option value="none">';
if ($tty == 'new') { echo 'Or choose an existing subject area'; } else { echo 'Please select a subject area'; }
echo '</option>';

$sqlsub = "SELECT * FROM subjects";
$ressub = mysql_query($sqlsub, $conn);
while ($qrysub = mysql_fetch_array($ressub)) {
echo '<option value="'.$qrysub['cat'].'"';
if ($qrysub['cat'] == $testsub) { echo ' SELECTED'; }
echo '>'.$qrysub['cat'].'</option>';
}
echo '<select></td></tr>';

if ($tty == 'new') { ?>
<tr><th>Description:</th><td><textarea name="descr" cols="54" rows="3"></textarea></td></tr>
<tr><th>Sort mode:</th>
<td>
<select name="random">
<option value="1">Random question and answer order</option>
<option value="2">Random question order with fixed answer order</option>
<option value="3">Fixed question order with random answer order</option>
<option value="4">Fixed question and answer order</option>
</select>
</td></tr>
<?php }
?>
<th><label for="htmle">Use special characters</label></th><td><input name="htmle" id="htmle" type="checkbox" value="yes"></td></tr>
<?

$qnu = $HTTP_POST_VARS['qnu'];
if (!$qnu) { $anu = 10; }
$anu = $HTTP_POST_VARS['anu'];
if (!$anu) { $anu = 6; }

$xtype = $HTTP_POST_VARS['xtype'];

for ($j = 1; $j <= $qnu; $j++) {

echo '<tr><th>New Question No. '.$j.':</th><td><textarea name="quest_'.$j.'" cols="54" rows="3">'.$quest.'</textarea></td></tr>';
if ($xtype == 'all' || $xtype == 'bonly') {
echo '<tr><th>Boolean answer:</th><td>';
if ($xtype != 'bonly') { echo '<input type="checkbox" name="bool_'.$j.'" value="yes" />'; }
echo '<label for="boolopt_'.$j.'">Correct response:&nbsp;</label><select name="boolopt_'.$j.'"><option value="ans1">True</option><option value="ans2">False</option></select>';
if ($xtype != 'bonly') { echo '<br />'."\n".'If the <em>Boolean</em> option is selected, the other answer fields are ignored and you may proceed to the <em>Explanation</em> field.'; }
echo '</td></tr>';
}

if ($xtype != 'bonly') {
for ($h = 1; $h <= $anu; $h++) {
$ansn = '$ans'.$h.'_'.$j;
echo '<tr><th>Answer '.$h.':<br />';
if ($xtype == 'maex') {
echo '<label for="corran'.$h.'_'.$j.'">Correct&nbsp;</label><input type="radio" name="corran_'.$j.'" id="corran'.$h.'_'.$j.'" value="ans'.$h.'" />';
}
else
{
echo '<label for="corran'.$h.'_'.$j.'">Correct&nbsp;</label><input type="checkbox" name="corran'.$h.'_'.$j.'" id="corran'.$h.'_'.$j.'" value="ans'.$h.'" />';
}
echo '</th><td><textarea name="ans'.$h.'_'.$j.'" cols="54" rows="2">'.eval("echo $ansn;").'</textarea></td></tr>';
}
}
echo '<tr><th>Explanation:</th><td><textarea name="expl_'.$j.'" cols="54" rows="3">'.$expl.'</textarea></td></tr>';
echo '<tr><td colspan="2"><hr /></td></tr>';

} ?>

</table>
<?php echo '<input type="hidden" name="qnu" value="'.$qnu.'"><input type="hidden" name="anu" value="'.$anu.'">'; ?>
</form>
<p id="bignav"><a href="javascript:document.quizadd.submit();">Add this quiz!</a></p>
