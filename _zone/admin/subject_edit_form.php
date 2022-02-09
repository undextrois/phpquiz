<?php
error_reporting(0);
echo '<form name="subupdate" action="subject_updated.php" method="post">';
echo '<table width="96%" border="0" cellspacing="0" cellpadding="4"><tr><th width="200">Category Name:</th>';
echo '<td><textarea name="cat" cols="60" rows="3">'.$cat.'</textarea></td></tr>';
echo '<th>Description:</th><td><textarea name="descr" cols="60" rows="3">'.$descr.'</textarea></td></tr></table>';
echo '<input name="post" type="hidden" value="Submit"></form><hr>';
?>
