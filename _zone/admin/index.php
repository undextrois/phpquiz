<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();

$sqlqch = "SELECT * FROM questions";
$resqch = mysql_query($sqlqch, $conn);
$sqlsch = "SELECT * FROM subjects";
$ressch = mysql_query($sqlsch, $conn);
?>

<?php
if (empty($ressch) || empty($resqch)){ 
echo '<h3>The database has not been configured and/or the questions and subjects tables have not been created.</br />Click on the set-up button configure the database and to create the tables:</h3>';
} 
$sqlnum = "SELECT * FROM questions";
$resnum = mysql_query($sqlnum, $conn);
$numq = mysql_num_rows($resnum);
echo '<h3>Total number of Questions: '.$numq.'</h3>';
?>
<hr />
<p id="hornav"><form action="quiz_add.php" name="quizadd" method="post"><a href="javascript:document.quizadd.submit()">Create new Quiz</a> with <select name="qnu"><option value="1">1 question</option><option value="5">5 questions</option><option value="10" SELECTED>10 questions</option><option value="20">20 questions</option></select> and <select name="anu"><option value="3">max. 3 answer options</option><option value="4" SELECTED>max. 4 answer options</option><option value="5">max. 5 answer options</option><option value="6">max. 6 answer options</option></select> | <select name="xtype" id="xtype" ><option value="all">Allow all question types</option><option value="maex" SELECTED>Multiple choice only</option><option value="maex">Exclude multiple answer option</option><option value="bonly">True/false only</option></select><input type="hidden" name="tty" value="new" /></form></p>
<hr />
<p id="hornav"><a href="questions.php">Review All Questions</a><a href="subject_add.php">Add 
  New Subject</a></p>
<p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">CLICK <a href="../../_cpanel.php">HERE</a> 
  TO GO BACK </font></p>
<h3>General Quiz Maintenance</h3>
<hr />
<?php include('searchform.inc.php'); ?>
<hr />

<?php
include('sub_update_view.inc.php');
//include('../inc/admin_footer.inc.php')
 ?>
