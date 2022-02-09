<?PHP
/*******************
*	Session pkg 1.0
*	copyright blackwolf 2004 (C)
*`` Blackbell Technologies 		
*   Blackbell Technologies is a division of Wildchrome software 2005 (C)
*
*
*
*******/


define ('__ALTO_SESSION_USER__',1);
define ('__ALTO_SESSION_SUPER__',2);
define ('__ALTO_SESSION_ADMIN__',3);

define ('MULTI_SESSION_ENABLE',1);

#############################################################################
#
# ukpa_session
#
# ssn_idPK int
# ssn_user char 16
# ssn_ipaddr int
# ssn_key char 32
# ssn_login timestamp
# ssn_time int
#/
#############################################################################

class _UKPA_SessionClass
{
  var $ssn_idPK;
  var $ssn_user;
  var $ssn_ipaddr;
  var $ssn_key;
  var $ssn_login;
  var $ssn_time;

  var $logidPK;
  var $useridFK;
  var $entityidFK;

  var $isadmin;

}

class _ALTO_Session extends _UKPA_SessionClass
{

  function _ALTO_Session($m_stype)
  {
    session_cache_limiter("private, must-revalidate");
    session_cache_expire(90);   // 15
    session_start();
  }

  function _alto_session_cleanup()
  {

    if (session_is_registered($GLOBALS['_alto_config']['session']['user_id']))
        session_unregister($GLOBALS['_alto_config']['session']['user_id']);

    if (session_is_registered($GLOBALS['_alto_config']['session']['user_mgk']))
        session_unregister($GLOBALS['_alto_config']['session']['user_mgk']);

    @session_destroy();
  }

  function _alto_session_create($m_id,$m_type)
  {

    session_register($GLOBALS['_alto_config']['session']['user_id']);
    session_register($GLOBALS['_alto_config']['session']['user_mgk']);

    $_loDB = new _ALTO_DB;
    $_loDB->dbconnect();

    if (($_loRS=mysql_query("SELECT * FROM tbl_sessions
                             WHERE ssn_user=\"".mysql_escape_string($m_id)."\""))==false)
    {
       print __LINE__ . ": ".mysql_error();
       mysql_close ($_acon);
    exit;
    }

    if (mysql_num_rows($_loRS))
    {
       @mysql_query("DELETE FROM tbl_sessions
                     WHERE ssn_user=\"".mysql_escape_string($m_id)."\"");
       mysql_free_result($_loRS);
    }

    srand((double)microtime()*1000000);
    $_mkey = uniqid(rand(),1);
    $_mkey = md5($m_id . $_mkey);

    if (mysql_query("INSERT INTO tbl_sessions SET
                     ssn_user = \"".mysql_escape_string($m_id)."\",
                     ssn_key  = \"".mysql_escape_string($_mkey)."\",
                     ssn_ipaddr  = ". ip2long($_SERVER['REMOTE_ADDR']). ",
                     ssn_time = NOW()")==false)
    {
        print __LINE__ . ": ".mysql_error();
        mysql_close($_acon);
    exit;
    }

   /*
    if (mysql_query("INSERT INTO users SET
                     lastlog=NOW() WHERE user=\"".mysql_escape_string($_fm1_in)."\"")==false)
    {
       print __LINE__ . ": ".mysql_error();
       mysql_close($_acon);
    exit;
    }
    */

    $_loDB->closedb();

    $_SESSION[$GLOBALS['_alto_config']['session']['user_id']] = "$m_id";
    $_SESSION[$GLOBALS['_alto_config']['session']['user_mgk']] = $_mkey;
  }

  function _alto_session_auth()
  {
    if (session_is_registered($GLOBALS['_alto_config']['session']['user_id']) &&
       session_is_registered($GLOBALS['_alto_config']['session']['user_mgk']))
    {

       $this->ssn_user = $_SESSION[$GLOBALS['_alto_config']['session']['user_id']];
       $this->ssn_key = $_SESSION[$GLOBALS['_alto_config']['session']['user_mgk']];

       $_loDB = new _ALTO_DB;
       $_loDB->dbconnect();

       if (($_loRS=mysql_query("SELECT * FROM tbl_sessions
                                WHERE ssn_user=\"".mysql_escape_string($this->ssn_user)."\"
                                AND ssn_key=\"".mysql_escape_string($this->ssn_key)."\""))==false)
       {
          print __LINE__ . ": ".mysql_error();
          $_loDB->closedb();
       exit;
       }
       if (!mysql_num_rows($_loRS)) {

          @mysql_query("DELETE FROM tbl_sessions
                        WHERE ssn_user=\"".mysql_escape_string($this->ssn_user)."\"");
          mysql_free_result($_loRS);
          $this->_alto_session_cleanup();
          $_loDB->closedb();
       return false;
       }

       if (mysql_query("UPDATE tbl_sessions SET ssn_time=NOW() WHERE
                        ssn_user=\"".mysql_escape_string($this->ssn_user)."\"
                        AND ssn_ipaddr=".ip2long($_SERVER['REMOTE_ADDR']))==false)
       {
          print __LINE__. ": ".mysql_error();
          mysql_close ($_acon);
       exit;
       }

       if (($_loRS=mysql_query("SELECT l.logidPK,
	   								   l.useridFK,
									   u.entityidFK,
									   u.admin 
	   							FROM loginfo AS l, 
									 userlist AS u 
								WHERE l.username=\"$this->ssn_user\" 
								AND u.useridPK=l.useridFK"))==false)
       
	   if (($_loRS=mysql_query("SELECT l.*,
									   u.*
								FROM tbl_userlist AS l, 
								 	tbl_memberlist AS u 
								WHERE l._username=\"$this->ssn_user\" 
								AND u._member_id_PK=l._member_id_FK"))==false)
	   
	   {
	   
          print __LINE__. ": ".mysql_error();
          mysql_close ($_acon);
       exit;
       }

       if ($_loRW = mysql_fetch_array($_loRS))
       {
          $this->logidPK = $_loRW['_user_id_PK'];
          $this->ssn_idPK = $this->logidPK;
          $this->useridFK = $_loRW['_member_id_FK'];
     //    $this->entityidFK = $_loRW['entityidFK'];
        //  $this->isadmin = ($_loRW['admin'] == "Y" ? true : false);
       mysql_free_result($_loRS);
       }
       else
       {
          $this->_alto_session_cleanup();
          return false;
       }

       $_loDB->closedb();

       $_SESSION[$GLOBALS['_alto_config']['session']['user_id']] = $this->ssn_user;
       $_SESSION[$GLOBALS['_alto_config']['session']['user_mgk']] = $this->ssn_key;

       return true;
    }
  return false;
  }

  function _alto_session_uget()
  {
    return $this->ssn_user;
  }

  function _alto_session_lget()
  {
    return $this->logidPK;
  }

  function _alto_session_iget()
  {
    return $this->useridFK;
  }

  function _alto_session_eget()
  {
    return $this->entityidFK;
  }

  function _alto_session_rget()
  {
    return $this->isadmin;
  }
}


class _ALTO_Loginfo {
  var $logidPK;
  var $useridPK;
  var $username;
  var $password;

  function _alto_is_user($m_user) {
    $m_lng = strlen($m_user);

    if (($m_lng <= $GLOBALS['_alto_config']['auth-user']['mx'])
       && ($m_lng >= $GLOBALS['_alto_config']['auth-user']['mn'])) {
       if (preg_match("#^\w(\w|\_|\.|\-)+$#si",$m_user,$m_m)==false) return false;
    return true;
    }
  return false;
  }

  function _alto_is_passwd($m_pass) {
    $m_lng = strlen($m_pass);
    if (($m_lng <= $GLOBALS['_alto_config']['auth-pass']['mx'])
       && ($m_lng >= $GLOBALS['_alto_config']['auth-pass']['mn'])) {
    return true;
    }
  return false;
  }

  function _alto_auth($m_user,$m_pass) {
    global $_DB;
  }
}

?>
