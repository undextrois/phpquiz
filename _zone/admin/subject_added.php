<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();

$cat = addSlashes($HTTP_POST_VARS['cat']);
$descr = addSlashes($HTTP_POST_VARS['descr']);
$random = addSlashes($HTTP_POST_VARS['random']);


#Check if another identical category exists
$sqlsub = "SELECT * FROM subjects where cat LIKE '$cat'";
$resultsub = mysql_query($sqlsub, $conn);
$num_sub = mysql_num_rows($resultsub);
if ($num_sub > 0) { echo '<h2>This category already exists. If necessary, edit it below</h2>'; include('../../admin/subject_edit_form.inc.php'); }
else if (empty($cat) || $cat == '' || $cat == ' ') { echo '<h2>Please enter a category name</h2>'; include('../../admin/subject_edit_form.inc.php'); }
else if (empty($descr) || $descr == '' || $descr == ' ') { echo '<h2>Please enter a category description </h2>'; include('../../admin/subject_edit_form.inc.php'); }
else {	
$sql = "INSERT INTO subjects (cat, descr, random) values ('$cat', '$descr', '$random')";
$result = mysql_query($sql, $conn);
if (!$result) {
  echo "<p>There was a database error when executing the script \"$sql\"<br />";
  echo "MySQL error:".mysql_error()."</p>";
  include('../inc/footer.inc.php');
  exit;
}

else { ?>
<h3>This category has been successfully added. Please review the record below and, if necessary, edit it.</h3>
<?php
include('sub_update_view.inc.php');
}
}

 ?>
