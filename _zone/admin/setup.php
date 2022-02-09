<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();

?>
<p id="hornav"><a href="index.php">Back to Admin Index</a><a href="help.php">Help</a></p>
<h2>Configure Database</h2>
<form name="confdb" action="config_make.php" method="post">
<p id="hornav"><a href="javascript:document.confdb.submit()" title="Overwrite the Database Configuration File!">Send Data</a></p>
<table id="nq">
<?php

$rrf = file("../inc/db_config.inc.php");
for ($j = 0; $j < count($rrf); $j++) {
$fstr .= $rrf[$j]."\n";
}

preg_match("/(mysql_pconnect\(')([^']+)(')/i",$fstr, $mtces);

echo '<tr><th><label for="host">Host name: </label></th><td><input type="text"  size="31" value="'.$mtces[2].'" name="host" id="host" /></td></tr>';

echo "\n";
preg_match("/(mysql_pconnect\(')([^']+)('),\s*(')([^']+)(')/i",$fstr, $mtces);

echo '<tr><th><label for="username">User name: </label></th><td><input type="text"  size="31" value="'.$mtces[5].'" name="username" id="username" /></td></tr>';

echo "\n";
preg_match("/(mysql_pconnect\(')([^']+)('),\s*(')([^']+)('),\s*(')([^']+)(')/i",$fstr, $mtces);

echo '<tr><th><label for="password">Password: </label></th><td><input type="password"  size="31" value="'.$mtces[8].'" name="password" id="password" /></td></tr>';

preg_match("/(mysql_select_db\(')([^']+)(')/i",$fstr, $mtces);

echo '<tr><th><label for="dbname">Database name: </label></th><td><input type="text"  size="31" value="'.$mtces[2].'" name="dbname" id="dbname" /></td></tr>';


?>
</table>
</form>
<?php
$sqlqch = "SELECT * FROM questions";
$resqch = mysql_query($sqlqch, $conn);
$sqlsch = "SELECT * FROM subjects";
$ressch = mysql_query($sqlsch, $conn);
if (empty($ressch) || empty($resqch)){ 
?>
<p id="hornav"><a href="create_tables.php">Create Tables</a></p>
<?php
}

 ?>