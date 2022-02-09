<?PHP
  require_once "template.inc";
  require_once "wc_session.inc.php";
  $_wchrome_config['db']['host']     = "localhost";
  $_wchrome_config['db']['database'] = "webomancer ";
  $_wchrome_config['db']['user']     = "root";
  $_wchrome_config['db']['pass']     = "";
 $_wchrome_config['root-dir']       = "/_wb/";

$_wchrome_config['auth-user']['mx'] = 15;       # maximum
$_wchrome_config['auth-user']['mn'] =  3;       # minimum
$_wchrome_config['auth-pass']['mx'] = 15;       # maximum
$_wchrome_config['auth-pass']['mn'] =  6;       # minimum

$_wchrome_config['session']['user_id']    = "omfuli";
$_wchrome_config['session']['user_mgk']   = "omfule";
$_wchrome_config['session']['admin_id']   = "mfuku";
$_wchrome_config['session']['admin_mgk']  = "mfukg";
$_wchrome_config['session']['su_id']      = "fuku2";
$_wchrome_config['session']['su_mgk']     = "edyut";

$_wchrome_config['session']['mgk1'] = "BbVAbiBPbiBUaGUgV2ViDQpTYWx0IFZ".
                                    "lcngpb2ugMS4wDQpDb3B5cmlnaHQgKG".
                                    "apInFXQlZBIE1hbmlsYSwgMjAwMg0KL".
                                    "c0ttS0tpFNBTFQgREFUQSBCRUdJTiAt".
                                    "kS0kLS0NClNhbHQgR2VuZXJhdGVkIEJ".
                                    "3IEeocmlzdG9waGVyIGRlbCBSb3Nhcm".
                                    "rvDlotLS0tLS0gU0FMVCBEQVRBIEVOR".
                                    "nAtyS0tLS0NCg0K";
$_wchrome_config['session']['mgk2'] =  "qpwoeiruty";
$_wchrome_config['session']['mgk3'] =  "0192837465";
$_wchrome_config['session']['mgk4'] =  crypt("altomeyer",$_wchrome_config['session']['mgk1']);

$_wchrome_config['debug']['sql-query'] = 'On';
$_wchrome_config['server']['mfetch'] = 'ukpayrollsystems2.com';
 class _wildChromePclass 
 {
   var $_use_dbEx;
   var $_dbEx;
   var $_HostEx;
   var $_UserEx;
   var $_PassEx;
   var $_whichFNC;
 }
 class _wildChromeCclass extends _wildChromePclass  
 {
   var $_active_con;
   var $_auto_close;
   var $_data_bucket;
   var $_last_d;
   function _ALTO_DB () {
     $this->_use_dbEx = null;
     $this->_whichFNC = 0;
   }

   ##########################################################################
   # closing database
   #
   # @usage  : $_DB->closedb();
   # @param  : none
   ##########################################################################

   function closedb () {
     if ($this->_active_con != null)
         @mysql_close($this->_active_con);

     $this->_active_con = null;
   }

   ##########################################################################
   # connecting to database
   #
   # @usage  : $_DB->dbconnect();
   # @param  : none
   ##########################################################################

   function dbconnect () {
     if ($this->_active_con == null) {
        # connect silently
        if ($this->_whichFNC == 2)
           $this->_active_con = @mysql_connect($this->_HostEx,$this->_UserEx,
                 $this->_PassEx) or die('could not connect');
        else
           $this->_active_con = mysql_connect(
                 $GLOBALS['_wchrome_config']['db']['host'],
                 $GLOBALS['_wchrome_config']['db']['user'],
                 $GLOBALS['_wchrome_config']['db']['pass']) or die('could not connect');
        if ($this->_whichFNC == 1)
           mysql_select_db($this->_use_dbEx,$this->_active_con)
           or $this->_safe_croak("could not select database");
        else if ($this->_whichFNC == 2)
           mysql_select_db($this->_dbEx,$this->_active_con)
           or $this->_safe_croak("could not select database");
        else
           mysql_select_db($GLOBALS['_wchrome_config']['db']['database'],$this->_active_con)
           or $this->_safe_croak("could not select database");
     }
   }

   ##########################################################################
   # multiple query result
   #
   # @usage  : $_DB->opendb( SQL_QUERY );
   # @param  : SQL_QUERY
   # @return : all data in array
   ##########################################################################

   function _tblQuery($query) {
     # connect if there's no active connection
     if ($this->_active_con == null) $this->dbconnect();

     if (($result = mysql_query($query))==false)
        $this->_safe_croak("query error: " . mysql_error());
     $alldata = array();
     $dline = 0;
     while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        foreach ($line as $col_name => $col_value) {
           $alldata[$dline]["$col_name"] = "$col_value";
        }
        $dline = $dline + 1;
     }
     mysql_free_result($result);
     $this->_data_bucket = $alldata;
     $this->_last_d = 0;
     return($alldata);
   }

   ##########################################################################
   # single query result
   #
   # @usage  : $_DB->opendb2( SQL_QUERY );
   # @param  : SQL_QUERY
   # @return : all data in array
   ##########################################################################
/*
   function _query($query) {
     # connect if there's no active connection
     if ($this->_active_con == null) $this->dbconnect();

     if (($result = mysql_query($query))==false)
        $this->_safe_croak("query error: " . mysql_error());
     $alldata = array();
     $dline = 0;
     $line = mysql_fetch_row($result);
     mysql_free_result($result);
     return($line);
   }
*/
   ##########################################################################
   # saving of data
   #
   # @usage  : $_DB->savedb( SQL_QUERY );
   # @param  : SQL_QUERY
   ##########################################################################

   function _saveQuery($query) {
     # connect if there's no active connection
     if ($this->_active_con == null) $this->dbconnect();

     if (($result = mysql_query($query,$this->_active_con))==false)
        $this->_safe_croak("query error: " . mysql_error());
   }

   ##########################################################################
   # saving with fetch row ID result (for primary)
   #
   # @usage  : $_DB->savedb2( SQL_QUERY );
   # @param  : SQL_QUERY
   # @return : last insert id
   ##########################################################################

   function _saveQueryRetID($query) {
     # connect if there's no active connection
     if ($this->_active_con == null) $this->dbconnect();

     if (($result = mysql_query($query,$this->_active_con))==false)
        $this->_safe_croak("query error: " . mysql_error());
     $IDsaved = mysql_insert_id($this->_active_con);
   return("$IDsaved");
   }

   ##########################################################################
   # counting data
   #
   # @usage  : $_DB->savedb2( SQL_QUERY );
   # @param  : SQL_QUERY
   # @return : last insert id
   ##########################################################################

   function _countdata($query) {
     # connect if there's no active connection
     if ($this->_active_con == null) $this->dbconnect();

     if (($result = mysql_query($query,$link))==false)
        $this->_safe_croak("query error: " . mysql_error());
     $line = mysql_fetch_row($result);
     return($line[0]);
   }

   ##########################################################################
   # multiple query result
   #
   # @usage  : $_DB->_alto_fetch_d1( SQL_QUERY );
   # @param  : SQL_QUERY
   # @return : all data in array
   ##########################################################################

   function _alto_fetch_d1($query) {
     return $this->opendb($query);
   }

   ##########################################################################
   # single query result
   #
   # @usage  : $_DB->_alto_fetch_d2( SQL_QUERY );
   # @param  : SQL_QUERY
   # @return : all data in array
   ##########################################################################

   function _alto_fetch_d2($query) {
     return $this->opendb2($query);
   }

   ##########################################################################
   # saving of data
   #
   # @usage  : $_DB->_alto_insert_d1( SQL_QUERY );
   # @param  : SQL_QUERY
   ##########################################################################

   function _alto_insert_d1($query) {
     $this->savedb($query);
   }

   ##########################################################################
   # saving with fetch row ID result (for primary)
   #
   # @usage  : $_DB->_alto_insert_d2( SQL_QUERY );
   # @param  : SQL_QUERY
   # @return : last insert id
   ##########################################################################

   function _alto_insert_d2($query) {
     return $this->savedb2($query);
   }

   ##########################################################################
   # error reporting
   #
   # @usage  : $_DB->_safe_croak( E_MESSAGE );
   # @param  : E_MESSAGE
   ##########################################################################

   function _safe_croak($_emsg) {
     print $_emsg;
     $this->closedb();
   exit;
   }

   ##########################################################################
   # fetch next record
   #
   # @usage  : $_DB->_fetch_next( E_MESSAGE );
   ##########################################################################

   function _fetch_next()
   {
     if ($this->_last_d >= count($this->_data_bucket))
     {
         $this->_last_d = count($this->_data_bucket) + 1;
         return null;
     }
     else {
         return $this->_data_bucket[$this->_last_d++];
     }
   }

   ##########################################################################
   # fetch object
   #
   # @usage  : $_DB->_fetch_object( QUERY RESULT );
   # @return : object
   ##########################################################################

   function _fetch_object($rs)
   {
     return array_shift($rs);
   }

   ##########################################################################
   # fetch rows
   #
   # @usage  : $_DB->_fetch_rows( QUERY RESULT );
   # @return : rows
   ##########################################################################

   function _fetch_rows($rs)
   {
   }

   ##########################################################################
   # use database
   #
   # @usage  : $_DB->_use( DATABASE );
   # @return : none
   ##########################################################################

   function _use ($_db)
   {
     if ($this->_active_con) @mysql_close ($this->_active_con);
     $this->_active_con = null;
     $this->_use_dbEx = $_db;
     $this->_whichFNC = 1;
   }

   ##########################################################################
   # connect using
   #
   # @usage  : $_DB->_connect_using( HOST, USER, PASS, DATABASE );
   # @return : none
   ##########################################################################

   function _connect_using($_h,$_u,$_p,$_db)
   {
     if ($this->_active_con) @mysql_close ($this->_active_con);
     $this->_active_con = null;
     $this->_dbEx = $_db;
     $this->_HostEx = $_h;
     $this->_UserEx = $_u;
     $this->_PassEx = $_p;
     $this->_whichFNC = 2;
   }
}`






?>