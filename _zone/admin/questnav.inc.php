<?php
error_reporting(0);
if (!$nvi) { $nvi = 1; }
if ($rowstart >= 20) {
echo '<p id="lnav"><form name="prev'.$nvi.'" action="questions.php?rowstart=';
echo $rowstart-20;
echo '" method="post"><input type="hidden" name"testsub" value="'.$testsub.'"></form><a href="javascript:document.prev'.$nvi.'.submit()">&laquo; Previous 20 questions</a></p>';
}


if ($numq > ($rowstart + 20)) {
echo '<p id="hornav"><form name="next'.$nvi.'" action="questions.php?rowstart=';
echo $rowstart+20;
echo '" method="post"><input type="hidden" name="testsub" value="'.$testsub.'"></form><a href="javascript:document.next'.$nvi.'.submit()">Next ';
if ($numq-$rowstart < 40) { echo ($numq-($rowstart+20)); }
else { echo '20'; }
echo ' Questions &raquo;</a></p>';
}
$nvi++;
?>
