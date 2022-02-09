<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>PHP PARSER</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
	
	function showparser(){
		x=document.forms[0].prstxt.value;
		if(x!=''){
			window.open("parse2.php?str="+x,"","width=650,height=232,status=yes,toolbar=no,menubar=no");
		}
	}


</script>
</head>
<style>
input.bt {
	border: thin #333333 solid;
	background-color: #F4F4F4;
	border:plain;
	background-repeat:
	no-repeat;
	background-position: left center
}
input.txt{
	border: plain;
	background-color: #F4F4F4;
}
</style>

<body>
<form onSubmit="showparser();" method="post">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="14%">&nbsp;</td>
    <td width="71%">&nbsp;</td>
    <td width="15%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="prstxt" type="text" size="100" class="txt"></td>
    <td>&nbsp;&nbsp;<input name="SHOW" type="submit" value=" Parse " class="bt" ></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
