<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();

$qid = $HTTP_GET_VARS['qid'];
$rowstart = $HTTP_GET_VARS['rowstart'];
if (!$rowstart) { $rowstart = 0; }
$testsub = $HTTP_POST_VARS['testsub'];
include('hormenu.php');
?>
<hr />
<form name="back" method="post" action="questions.php?rowstart="<?php echo $rowstart; ?>"><input type="hidden" name="testsub" value="<?php echo $testsub; ?>"></form>
<h3>Are you sure you wish to delete this question?</h3>
<?php include('update_view.inc.php');
 ?>
