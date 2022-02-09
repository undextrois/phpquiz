<?php 
## Edit the host path (with optional port), database name and database password in that order.
## The host path is usually localhost, but check with your Webhost or server administrator if another
## database path is required.
## The port number is optional and may be added after after the host path and a colon ( : ).
## Do not delete any quotes!

function db_connect()
{
$result = @mysql_pconnect('localhost', 'root', '');
if (!$result)
return false;
//if (!@mysql_select_db('quiz'))
	if(!mysql_select_db('webomancer'))
return false;
return $result;
}
?>