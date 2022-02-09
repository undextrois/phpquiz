<?php
/*
 MODULE NAME     :                            config.inc
 DATE CREATED    :                   	      june 22, 2004


 UPDATES
 2004.07.01 - safe_croak function
              generic error catcher
 2004.07.05 - next record
 2004.07.14 - set headers
 2004.07.22 - fetch object and fetch rows function
 2004.12.01 - use database
 2004.12.02 - connect_using function
*/

# if (!defined('__GN_U_MODULE_TRAP__')
#   || (__GN_U_MODULE_TRAP__ != 'GN-F4DCC0DD0B42F6B4C1565E59C92E308F-DVT'))
# {
#    die ("don't make me kick your arse!");
# }
/*
require_once "template.inc";
//require_once "scroll-contents.php";
//require_once "submodules.php";
require_once "session.inc.php";*/
require_once "template.inc";
  require_once "wc_session.inc.php";
# AUTHOR: Donniel Collera - www.dhongens.com
# put any default value here

$ck = "dhon";
$CRYPT_KEY2 = "ukpa";

############################################################################
# types of sql supported so far
############################################################################

$_ALTO_MYSQL  			= "mysql";
$_ALTO_MSSQL  			= "mssql";
$_ALTO_ORACLE 			= "oracle";
$_ALTO_VER					=	'_v2';
$_SIDE_NAV_WIDTH		=	161;
$_MAIN_MAX_WIDTH		=	744;
//$_SIDE_NAV_WIDTH		=	196;

############################################################################
# configuration
############################################################################

# database config
/*
if($_SERVER['HTTP_HOST'] == '192.168.0.13' || $_SERVER['HTTP_HOST'] == '202.73.163.110'){
  $_alto_config['db']['host']     = "localhost";
  $_alto_config['db']['database'] = "ukpa";
  $_alto_config['db']['user']     = "ukpauser";
  $_alto_config['db']['pass']     = "ukpauser";
}
else{
*/
  $_alto_config['db']['host']     = "localhost";
  $_alto_config['db']['database'] = "webomancer";
  $_alto_config['db']['user']     = "root";
  $_alto_config['db']['pass']     = "";
//}

$_alto_config['database']       = $_ALTO_MYSQL;

# root directory config

$_alto_config['root-dir']       = "/_wb/";

$_alto_config['auth-user']['mx'] = 15;       # maximum
$_alto_config['auth-user']['mn'] =  3;       # minimum
$_alto_config['auth-pass']['mx'] = 15;       # maximum
$_alto_config['auth-pass']['mn'] =  6;       # minimum

$_alto_config['session']['user_id']    = "omfuli";
$_alto_config['session']['user_mgk']   = "omfule";
$_alto_config['session']['admin_id']   = "mfuku";
$_alto_config['session']['admin_mgk']  = "mfukg";
$_alto_config['session']['su_id']      = "fuku2";
$_alto_config['session']['su_mgk']     = "edyut";

$_alto_config['session']['mgk1'] = "BbVAbiBPbiBUaGUgV2ViDQpTYWx0IFZ".
                                    "lcngpb2ugMS4wDQpDb3B5cmlnaHQgKG".
                                    "apInFXQlZBIE1hbmlsYSwgMjAwMg0KL".
                                    "c0ttS0tpFNBTFQgREFUQSBCRUdJTiAt".
                                    "kS0kLS0NClNhbHQgR2VuZXJhdGVkIEJ".
                                    "3IEeocmlzdG9waGVyIGRlbCBSb3Nhcm".
                                    "rvDlotLS0tLS0gU0FMVCBEQVRBIEVOR".
                                    "nAtyS0tLS0NCg0K";
$_alto_config['session']['mgk2'] =  "qpwoeiruty";
$_alto_config['session']['mgk3'] =  "0192837465";
$_alto_config['session']['mgk4'] =  crypt("altomeyer",$_alto_config['session']['mgk1']);

$_alto_config['debug']['sql-query'] = 'On';
$_alto_config['server']['mfetch'] = 'ukpayrollsystems2.com';

############################################################################
# _ALTO_DB class
############################################################################

class _Altomeyer_dbEx
{
   var $_use_dbEx;
   var $_dbEx;
   var $_HostEx;
   var $_UserEx;
   var $_PassEx;

   var $_whichFNC;
}

class _ALTO_DB extends _Altomeyer_dbEx {
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
                 $GLOBALS['_alto_config']['db']['host'],
                 $GLOBALS['_alto_config']['db']['user'],
                 $GLOBALS['_alto_config']['db']['pass']) or die('could not connect');
        if ($this->_whichFNC == 1)
           mysql_select_db($this->_use_dbEx,$this->_active_con)
           or $this->_safe_croak("could not select database");
        else if ($this->_whichFNC == 2)
           mysql_select_db($this->_dbEx,$this->_active_con)
           or $this->_safe_croak("could not select database");
        else
           mysql_select_db($GLOBALS['_alto_config']['db']['database'],$this->_active_con)
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

   function opendb ($query) {
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

   function opendb2 ($query) {
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

   ##########################################################################
   # saving of data
   #
   # @usage  : $_DB->savedb( SQL_QUERY );
   # @param  : SQL_QUERY
   ##########################################################################

   function savedb($query) {
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

   function savedb2($query) {
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

   function countdata($query) {
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
}

#############################################################################
# global $_DB variable
#############################################################################

$_DB = new _ALTO_DB;             # if object oriented, u can use this

#############################################################################
# compatibility
#############################################################################

$rootdir = $_alto_config['root-dir'];

#############################################################################
# connecting to database
#
# @usage  : $_DB->dbconnect();
# @param  : none
#############################################################################

function dbconnect ()       { global $_DB; $_DB->dbconnect(); }

#############################################################################
# multiple query result
#
# @usage  : $_DB->opendb( SQL_QUERY );
# @param  : SQL_QUERY
# @return : all data in array
#############################################################################

function opendb ($query)    { global $_DB; return $_DB->opendb($query); }

#############################################################################
# single query result
#
# @usage  : $_DB->opendb2( SQL_QUERY );
# @param  : SQL_QUERY
# @return : all data in array
#############################################################################

function opendb2 ($query)   { global $_DB; return $_DB->opendb2($query); }

#############################################################################
# saving of data
#
# @usage  : savedb( SQL_QUERY );
# @param  : SQL_QUERY
#############################################################################

function savedb ($query)    { global $_DB; $_DB->savedb($query); }

#############################################################################
# saving with fetch row ID result (for primary)
#
# @usage  : savedb2( SQL_QUERY );
# @param  : SQL_QUERY
# @return : last insert id
#############################################################################

function savedb2 ($query)   { global $_DB; return $_DB->savedb2($query); }

#############################################################################
# counting data
#
# @usage  : $_DB->savedb2( SQL_QUERY );
# @param  : SQL_QUERY
# @return : last insert id
#############################################################################

function countdata ($query) { global $_DB; return $_DB->countdata($query); }

#############################################################################
# closing database
#
# @usage  : closedb();
# @param  : none
#############################################################################

function closedb ()         { global $_DB; $_DB->closedb(); }

# Converting date to DB Style
function dispdatedb() {
  $today = date("Y-m-d h:i:s");
  return $today;
}

#############################################################################
#############################################################################

# Formating Date today to display precisely in page
function dispdate() {
  $today = date("l, F j, Y");
  return $today;
}

# Date separation & date convertion
function datesep($datdate) {
  $datyear = date("Y", strtotime ($datdate));
  $datmonth = date("m", strtotime ($datdate));
  $datday = date("d", strtotime ($datdate));
  $dathour = date("h", strtotime ($datdate));
  $datmins = date("i", strtotime ($datdate));
  $datsecs = date("s", strtotime ($datdate));
  $datestructure = Array ("year" => $datyear, "month" =>$datmonth, "day" => $datday, "hour" => $dathour, "mins" => $datmins, "secs" => $datsecs);
  return($datestructure);
}

# -----------------------------------------------
#   @Name: Encrypt()
#   @Args: $txt-> String to encrypt.
#   @Args: $CRYPT_KEY -> String used to generate a encryption key.
#   @Returns: $estr -> Encrypted string.
#  -----------------------------------------------

function encrypt($txt,$CRYPT_KEY){
  if (!$txt && $txt != "0") return false;
  if (!$CRYPT_KEY) return false;

  $kv = keyvalue($CRYPT_KEY);
  $estr = "";
  $enc = "";

  for ($i=0; $i<strlen($txt); $i++) {
      $e = ord(substr($txt, $i, 1));
      $e = $e + $kv[1];
      $e = $e * $kv[2];
      (double)microtime()*1000000;
      $rstr = chr(rand(65, 90));
      $estr .= "$rstr$e";
  }
return $estr;
}

# -----------------------------------------------
#   @Name: Decrypt()
#   @Args: $txt-> String to decrypt.
#   @Args: $CRYPT_KEY -> String used to encrypt the string.
#   @Returns: $estr -> Decrypted string.
#  -----------------------------------------------

function decrypt($txt, $CRYPT_KEY){
  if (!$txt && $txt != "0") return false;
  if (!$CRYPT_KEY) return false;

  $kv = keyvalue($CRYPT_KEY);
  $estr = "";
  $tmp = "";

  for ($i=0; $i<strlen($txt); $i++) {
      if ( ord(substr($txt, $i, 1)) > 64 && ord(substr($txt, $i, 1)) < 91 ) {
         if ($tmp != "") {
            $tmp = $tmp / $kv[2];
            $tmp = $tmp - $kv[1];
            $estr .= chr($tmp);
            $tmp = "";
         }
      }
      else {
         $tmp .= substr($txt, $i, 1);
      }
  }

  $tmp = $tmp / $kv[2];
  $tmp = $tmp - $kv[1];
  $estr .= chr($tmp);

return $estr;
}

# -----------------------------------------------
#   @Name: keyvalue()
#   @Args: $CRYPT_KEY -> String used to generate a encryption key.
#   @Returns: $keyvalue -> Array containing 2 encryption keys.
#  -----------------------------------------------

function keyvalue($CRYPT_KEY){
  $keyvalue = "";
  $keyvalue[1] = "0";
  $keyvalue[2] = "0";
  for ($i=1; $i<strlen($CRYPT_KEY); $i++) {
      $curchr = ord(substr($CRYPT_KEY, $i, 1));
      $keyvalue[1] = $keyvalue[1] + $curchr;
      $keyvalue[2] = strlen($CRYPT_KEY);
  }
return $keyvalue;
}

 function _redir($url) {
?>
   <script language="javascript">
     top.location.href="<?=$url?>";
   </script>
<?
 exit;
 }

/* Chips wonderful world of FUNCTONS!
   ohhhhh yeah!!!!!                  */


function headers($entityidPK,$useridPK){
        $db = new _ALTO_DB;
        $data=$db->opendb("SELECT * from userlist where useridPK='$useridPK'");
        $fname = $data[0]['fname'];
        $lname = $data[0]['lname'];
        $today = dispdate();

        $data=$db->opendb("SELECT * from entity where entityidPK='$entityidPK'");
        $dbfrom = $data[0]['entityinfodb'];
        $entityinfoidPK = $data[0]['entityinfoidFK'];

        $data=$db->opendb("SELECT * from $dbfrom where entityinfoidPK='$entityinfoidPK'");
       // $logo = "/newukpa/images/defalogo.jpg";
        if($data[0]['logo']==""){
                $logo = "/newukpa/images/defalogo.jpg";
                }
        else{
             $logo = "/newukpa/cologo/".$data[0]['logo'];
        }
        $name= $data[0]['name'];
        $officeaddrs = $data[0]['officeaddrs'];
        $towncity = $data[0]['towncity'];
        $county = $data[0]['county'];
        $state = $data[0]['state'];

      /*  $head = "<table border='0' width='100%'>
  <tr>
    <td valign='middle'><img border='0' src='$logo' ></td>
    <td valign='middle'>
      <p align='right'><font face='Verdana' size='1'>Hello <b>$fname $lname</b><br>
      Today is: $today<br>
      <br>
      <b>$name<br>
      </b>$officeaddrs<br>
      $towncity <br>
      $county , $state </font></td>
  </tr>
</table>
<hr noshade color='#000000'>"; */
$head = "<table border='0' width='100%'>
  <tr>
    <td valign='middle'><em><font color=\"#FF0000\" size=\"4\">Welcome to</font></em>
        <font color=\"#FF0000\" size=\"4\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>UK
  Payroll Systems</strong></font></td>
    <td valign='middle'>
      <p align='right'><font face='Verdana' size='1'><strong>Hello,<font color=\"#FF0000\" size='1'>
          <b>$fname $lname</b></font><br>
      $today<br> </strong>
</font></td>
  </tr>
</table>
";

return $head;
}

function footers(){
  /* $footer = "<hr noshade color='#000000'>
<p align='center'><font face='Verdana' size='1'>UKPA<br>
<a href='http://www.uk123.co.uk'>http://www.uk123.co.uk © 2000-2004</a> </font></p>";
*/
$footer="<hr noshade color='#000000'> <center><font face='Verdana' size='1'> Copyright (c) 2004 ALTO-MEYER LLC  </font></center>";
return $footer;
}
function getcss($useridPK){
       $db = new _ALTO_DB;
       $data=$db->opendb("SELECT * from ownercss where useridFK='$useridPK'");
       if ($data[0][menuidFK] == ""){
        $css = "grey";
               }
       else{
       $menuidFK = $data[0]['menuidFK'];
       $data1=$db->opendb("SELECT * from menucss where menuidPK='$menuidFK'");
       $css = $data1[0][wholecss];

       }
       /*echo $useridPK;
       echo "data=".$data[0]['menuidFK'];
       echo "css.".$css;*/
       return $css;
        }


function displaytabs($entityidFK,$moduleidPK,$useridPK){
         $db = new _ALTO_DB;
         $isadmin = $db->opendb("SELECT * FROM userlist WHERE useridPK = $useridPK");

        if ($isadmin[0]["admin"] == "Y") {
        $data2 = $db->opendb("SELECT DISTINCT modulecategory.*
        FROM entitymodules INNER JOIN modulecategory ON entitymodules.modcatidFK =                        modulecategory.modcatidPK WHERE entitymodules.entityidFK = $entityidFK and                   modulecategory.moduleidFK = $moduleidPK");
} else {
        $data2 = $db->opendb("SELECT DISTINCT modulecategory.*
        FROM usermodules INNER JOIN modulecategory ON usermodules.modcatidFK = modulecategory.            modcatidPK WHERE usermodules.useridFK = $useridPK and modulecategory.moduleidFK =            '$moduleidPK'");
}        $tab="<table border=\"0\" cellpadding=\"1\">
  <tr>";
        foreach ($data2 as $info){
                $tab.= "<td  height=\"30\" valign=\"top\">
        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
        <tr>
          <td width=\"4\" height=\"25\"  class=\"leftheadtable\"><img name=\"spacer\" src=\"\" width=\"4\"  alt=\"\"></td>
          <td class=\"headtable\" ><a href=\"".$info['modcatfilename']."\" target=\"main_frame\">".$info['modcatname']."</td></a>
          <td width=\"6\" class=\"rightheadtable\" ><img name=\"spacer\" src=\"\" width=\"6\"  alt=\"\"></td>
        </tr>
      </table>
         </td>";

}
$tab.="</tr></table>";
return $tab;
        }



function displaylinks($modcatid){
          $db = new _ALTO_DB;
          $data = $db->opendb("SELECT * from modulelinks where modcatidFK = '$modcatid';") ;

      foreach ($data as $info){
      $tab .= "<a href='".$info['modlinkfilename']."'"." target=\"main_frame\" style=\"font-weight: bold\"><font color=\"#000000\" size=\"1\" face=\"Trebuchet MS\">".$info['modlinkname'].".</font></a>&nbsp;&nbsp;";
          }
              $counter = count($data);
      if ($counter <1){
             $tab = "";
              }
               $db->closedb();
return $tab;
        }


function &stripslashes_gpc($str){
  if(get_magic_quotes_gpc())
    $str = stripslashes($str);

  return $str;
}

function &addslashes_gpc($str){
  if(!get_magic_quotes_gpc())
    $str = addslashes($str);

  return $str;
}

function customers($entityidFK,$name="custsupidFK"){
       $db = new _ALTO_DB;
       $data=$db->opendb("SELECT * from CustomerSupplier where entityidFK='$entityidFK' and customer='C' or customer='B'");
       $select="<select name=\"".$name."[0]\">";
       foreach ($data as $info){
               $select.= "<option value=".$info['custsupidPK'].">".$info['custsupname']."</option>";
               }
         $select.="</select>";
         return $select;
        }
 
/*eto yung customer boks */
function customers_ts($entityidFK,$day){
       $db = new _ALTO_DB;
       $data=$db->opendb("SELECT * from CustomerSupplier where entityidFK='$entityidFK'");
       $select="<select name=\"custsupidFK_".$day."[0]\" id=\"cust_".$day."[0]\" id=\"cust_{$day}\"> <option value='0'>Not Applicable</option>";
       foreach ($data as $info){
               $select.= "<option value='".$info['custsupidPK']."'>".$info['custsupname']."</option>";
               }
         $select.="</select>";
         return $select;
        }

function customers_ts1($entityidFK,$day,$custsupidFK){
       $db = new _ALTO_DB;
       $data=$db->opendb("SELECT * from CustomerSupplier where entityidFK='$entityidFK' and IsCustomer='1' or customer='B'");
       $select="<select name=\"custsupidFK_".$day."[0]\"> <option value='0'>Not Applicable</option>";
       foreach ($data as $info){

             if ($info['custsupidPK']==$custsupidFK){
                 $selected="selected";
                       }
             else {
                 $selected="";
                     }

               $select.= "<option value=".$info['custsupidPK']." ".$selected.">".$info['custsupname']."</option>";
               }
         $select.="</select>";
         return $select;
        }

function jobfiles($entityidFK,$name="jobfileidPK"){
       $db = new _ALTO_DB;
       $data=$db->opendb("SELECT * from JobFile where entityidFK='$entityidFK' ");
       $select="<select name=\"".$name."[0]\"> <option value='0'>Not Applicable</option>";
       foreach ($data as $info){
               $select.= "<option value=".$info['jobfileidPK'].">".$info['jobfile']."</option>";
               }
         $select.="</select>";
         return $select;

        }


 /* eto yung jobs boks*/
function jobfiles_ts($entityidFK,$day){
       $db = new _ALTO_DB;
       $data=$db->opendb("SELECT * from JobFile where entityidFK='$entityidFK'");
       $select="<select name=\"jobfileidPK_".$day."[0]\" id=\"jobfileidPK_".$day."[0]\" onchange=\"JobChanged(this, '".$day."', 0)\"> <option value='0'>Not Applicable</option>";
       foreach ($data as $info){
               $select.= "<option value=".$info['jobfileidPK'].">".$info['jobfile']."</option>";
               }
         $select.="</select>";
         return $select;

        }

function jobfiles_ts1($entityidFK,$day,$jobidFK){
       $db = new _ALTO_DB;
       $data=$db->opendb("SELECT * from JobFile where entityidFK='$entityidFK' "); //
       $select="<select name=\"jobfileidPK_".$day."[0]\"> <option value='0'>Not Applicable</option>";
       foreach ($data as $info){

                if ($info['jobfileidPK']==$jobidFK){

                 $selected="selected";
                       }
             else {
                 $selected="";
                     }
               $select.= "<option value=".$info['jobfileidPK']." ".$selected.">".$info['jobfile']."</option>";
               }
         $select.="</select>";
         return $select;

        }

function chargecode($entityidFK,$day,$chargecodeidFK){
       $db = new _ALTO_DB;
       $data=$db->opendb("SELECT * from chargecode where entityidFK='$entityidFK'");
       $select="<select name=\"chargecodeidFK_".$day."[0]\">";
       $select.=" <option value='0'>Not Applicable</option>";
       foreach ($data as $info){

             if ($info['chargecodeidPK']==$chargecodeidFK){
                 $selected="selected";
                       }
            else {
                 $selected="";
                     }
               $select.= "<option value='".$info['chargecodeidPK']."' ".$selected.">".$info['name']."</option>";
               }
         $select.="</select>";
         return $select;
        }

function costcode($entityidFK,$day,$costcodeidFK){
       $db = new _ALTO_DB;
       $data=$db->opendb("SELECT * from costcode where entityidFK='$entityidFK'");
       $select="<select name=\"costcodeidFK_".$day."[0]\">";
       $select.=" <option value='0'>Not Applicable</option>";

       foreach ($data as $info){
                 $selected="";

             if ($info['costcodeidPK']==$costcodeidFK){
                 $selected="selected";
                       }
             else {
                 $selected="";
                     }
               $select.= "<option value='".$info['costcodeidPK']."' ".$selected.">".$info['name']."</option>";
               }
         $select.="</select>";
         return $select;
        }

function getpage(){
        $page=10;
        return $page;
        }


function getdoxxpage () {
        global $HTTP_HOST;
        if ($HTTP_HOST == "192.168.0.201" || $HTTP_HOST == "localhost")
                $doxxpage = "/var/www/_UKML/pub2/";
        else
                $doxxpage = "doxxpage/";
        return $doxxpage;
}

function ConvertDate($Date, $Format1, $Format2){
  $m = '';
  $d = '';
  $y = '';

  $f1 = strtolower(trim($Format1));
  $f2 = strtolower(trim($Format2));

  $f1c = strlen($f1);

  if($f1 == 'ut'){
    $dt = $Date;
  }
  else{
    for($i = 0;$i < $f1c;$i++){
      if($f1{$i} == 'm' || $f1{$i} == 'd' || $f1{$i} == 'y')
        ${$f1{$i}} .= $Date{$i};
    }

    $dt = mktime(0, 0, 0, $m , $d, $y);
  }

  if($f2 == 'ut'){
    $fd = $dt;
  }
  else{
    $yc = substr_count($f2, 'y');
    $mc = substr_count($f2, 'm');
    $dc = substr_count($f2, 'd');

    $mf = $mc == 2 ? 'm' : 'n';
    $df = $dc == 2 ? 'd' : 'j';
    $yf = $yc == 2 ? 'y' : 'Y';

    $ff = str_replace(str_repeat('y', $yc), $yf, $f2);
    $ff = str_replace(str_repeat('m', $mc), $mf, $ff);
    $ff = str_replace(str_repeat('d', $dc), $df, $ff);
		$ff = str_replace('f', 'F', $ff);

    $fd = date($ff, $dt);
 }

  return $fd;
}

function js_friendly_str($str){
	return '"' . strtr($str, array('"'=>'\\"', "\r"=>'', "\n"=>"\\n")) . '"';
}

function unique_attachment_id($userid){
	global $db;
	
	if(!$db)
		$db = new _ALTO_DB;
	
	do{
		$attachment_id = md5(uniqid(rand(),1));
		$query = "SELECT attachment_id_PK FROM attachments WHERE attachment_id_PK = '{$attachment_id}' AND user_id_FK = '{$userid}'";
		$mXs = $db->opendb($query);
	}while(count($MXs));
	
	return $attachment_id;
}
?>