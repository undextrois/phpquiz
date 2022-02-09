<?PHP
/*******************************************************************************
* Software:  WEBOMANCER                                                               *
* Name    :   __USERInfoClass__ Helper class  
* Version :  1.0                                                               *
* Date    :  February 2006                                                         *
* Author  :  Wildchrome Software                                                    *
* License :  Paid License http://www.wildchrome.com/license                                                           *
* Header  :  Get custom user information for WEBOMANCER registered users                                                                           *
* Y                     *
*******************************************************************************/
	class __USERInfoClass__ extends _Altomeyer_dbEx
	{
		var $_rs_userinfo;
		var $_gt_id;
		var $_id;
		var $_rs_mods;
		function _gtModInfo() 
		{
			$_modidPK =$this->_id ;
			$this->_rs_mods = "SELECT * FROM tbl_mods WHERE tbl_mods.mod_id_PK = '$_modidPK'";
			$_r = opendb($this->_rs_mods);
			foreach($_r as $_h) 
			{	
				$_modidPK =$_h['mod_id_PK'];
				$_mods = $_h['_mods'];
			}
			$_vv = $this->_rtval = array($_modidPK,$_mods);
			return $_vv;
		}
		function _gtUserInfo() 
		{
		  $_ci_id = $this->_gt_id;
		  $this->_rs_userinfo = "SELECT * FROM tbl_memberlist WHERE _member_id_PK = '$_ci_id'";
		  $_rs_res = opendb($this->_rs_userinfo);
		  foreach($_rs_res as $_rw )
		  {
			$_cu_memberidPK = $_rw['_member_id_PK'];
			$_cu_ln = $_rw['_lastname'];
			$_cu_fn = $_rw['_firstname'];
		    $_cu_status = $_rw['_status'];
			$_cu_age = $_rw['_age'];
			$_cu_gender = $_rw['_gender'];
			$_cu_occupation = $_rw['_occupation'];
			$_level = $_rw['_level'];
			$_cu = $_cu_ln.",".$_cu_fn;
		  }
		  $this->_rs_member	="SELECT * FROM tbl_userlist WHERE _user_id_PK = '$_ci_id'";
		  $_rs_m = opendb($this->_rs_member);
		  foreach ($_rs_m as $_r) 
		  {
			
		  	$_u_username = $_r['_username'];
			$_u_password = $_r['_password'];
			$_u_email = $_r['_email'];
		  
		  }		  	
			 $_gt_retval = $this->_gt_covalues = array($_cu_memberidPK,$_cu_ln,$_cu_fn,$_cu_status,
			 											$_cu,$_u_username,$_u_password,$_u_email,
														$_cu_age,$_cu_gender,$_cu_occupation,$_level);
			 return $_gt_retval;

		}
		
	}



?>