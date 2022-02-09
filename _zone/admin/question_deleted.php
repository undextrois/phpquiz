<?php
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php
error_reporting(0);
include('../inc/header_admin.php');
$conn = db_connect();

// Delete Question

$conn = db_connect();

$qid = $HTTP_GET_VARS['qid'];
$rowstart = $HTTP_GET_VARS['rowstart'];
if (!$rowstart) { $rowstart = 0; }
$testsub = $HTTP_POST_VARS['testsub'];

include('hormenu.php');
echo '<hr />'."\n";
$sql = "DELETE FROM questions WHERE ID = '$qid'";
$result = mysql_query($sql, $conn);
if (!$result) {
  echo "<p>There was a database error when executing the script \"$sql\"<br />";
  echo "MySQL error:".mysql_error()."</p>"; }
  
else {
?>

<h3>The question was successfully deleted.</h3>

<?php
}
include('../inc/footer.inc.php');
?>
