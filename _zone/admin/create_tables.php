<?php
include('../inc/header_admin.php');
$conn = db_connect();

$sqlq = "CREATE TABLE questions (
  ID int(4) unsigned zerofill NOT NULL auto_increment,
  question text NOT NULL,
  test varchar(31) NOT NULL default '',
  ans1 text NOT NULL,
  ans2 text NOT NULL,
  ans3 text NOT NULL,
  ans4 text NOT NULL,
  ans5 text,
  ans6 text,
  corans varchar(8) NOT NULL default '',
  expl text NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM";

$sqlt = "CREATE TABLE subjects (
  ID int(4) unsigned zerofill NOT NULL auto_increment,
  cat varchar(31) NOT NULL default '',
  descr text NOT NULL,
  random int(1) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM";

$resq = mysql_query($sqlq, $conn);
$rest = mysql_query($sqlt, $conn);

if (!$resq) {
  echo "<p>There was a database error when executing the script ".$sqlq."<br />";
  echo "MySQL error:".mysql_error()."</p>";
  }

else if (!$rest) {
  echo "<p>There was a database error when executing the script ".$sqlt."<br />";
  echo "MySQL error:".mysql_error()."</p>";
  }

else { ?>
<h3>The <em>questions</em> and <em>subjects</em> tables have been successfully created.</h3>
<p id="bignav"><a href="index.php">Return to Admin Index</a><a href="subject_add">Add Subject Area</a></p>

<?php
} 


