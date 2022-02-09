<?php 
error_reporting(0);
if ($red == 1) { echo '<form name="quizadd" action="quiz_added.php" method="post">'; } ?>
<table id="nq"><tr>
<th><label for="htmle">Use special characters</label></th><td><input name="htmle" id="htmle" type="checkbox" value="yes"></td></tr>
<tr><th>New Question:</th><td><textarea name="quest_<?php echo $red; ?>" cols="54" rows="3"><?php echo $quest; ?></textarea></td></tr>
<tr><th><label for="bool_<?php echo $red; ?>">Boolean answer:</label></th><td><input type="checkbox" name="bool_<?php echo $red; ?>" id="bool_<?php echo $red; ?>" value="yes"  />
<label>Correct response:&nbsp;<select name="boolopt_<?php echo $red; ?>"><option value="ans1">True</option><option value="ans2">False</option></select></label><br />
If the <em>boolean</em> option is selected, the other answer fields are ignored and you may proceed to the <em>Explanation</em> field.</em>.
</td></tr>
<?php
for ($h = 1; $h <= $anu; $h++) {
echo '<tr><th><label for="ans'.$h.'_'.$red.'">Answer '.$h.':</label><br/>';
echo '<label for="corran'.$h.'_'.$red.'">Correct&nbsp;</label><input type="checkbox" name="corran'.$h.'_'.$red.'" id="corran'.$h.'_'.$red.'" value="ans'.$h.'"';
if (!eregi("ans", $corran)) { $ct = 'ans'.$corran[($h-1)]; } else { $ct = $corran; }
if ($ct == 'ans'.$h) { echo ' CHECKED'; }
echo ' />';
echo '</th><td><textarea name="ans'.$h.'_'.$red.'" id="ans'.$h.'_'.$red.'" cols="54" rows="2">';
$ansn = '$ans'.$h;
eval("echo $ansn; ");
echo '</textarea></td></tr>';
}
?>
</td></tr>
<tr><th>Explanation:</th><td><textarea name="expl_<?php echo $red; ?>" cols="54" rows="3"><?php echo $expl; ?></textarea></td></tr></table>

