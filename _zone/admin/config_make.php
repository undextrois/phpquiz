<?php
error_reporting(0);
$host = $HTTP_POST_VARS['host'];
$username = $HTTP_POST_VARS['username'];
$password = $HTTP_POST_VARS['password'];
$dbname = $HTTP_POST_VARS['dbname'];

$outt = '<?php ';
$outt .= "\n".'## Edit the host path (with optional port), database name and database password in that order.';
$outt .= "\n".'## The host path is usually localhost, but check with your Webhost or server administrator if another';
$outt .= "\n".'## database path is required.';
$outt .= "\n".'## The port number is optional and may be added after after the host path and a colon ( : ).';
$outt .= "\n".'## Do not delete any quotes!'."\n";

$outt .= "\n".'function db_connect()';
$outt .= "\n".'{';
$outt .= "\n".'$result = @mysql_pconnect(\''.$host.'\', \''.$username.'\', \''.$password.'\');';
$outt .= "\n".'if (!$result)';
$outt .= "\n".'return false;';
$outt .= "\n".'if (!@mysql_select_db(\''.$dbname.'\'))';
$outt .= "\n".'return false;';
$outt .= "\n".'return $result;';
$outt .= "\n".'}';
$outt .= "\n".'?>';

$outfile = '../inc/db_config.inc.php';

$fp = fopen($outfile, 'w');
fwrite($fp, $outt);
fclose($fp);

header('location:index.php');
?>
