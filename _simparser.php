<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>PHP PARSER</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
	
	function showparser(){
		x=document.forms[0].prstxt.value;
		if(x!=''){
			window.open("_sparser.php?str="+x,"","width=650,height=232,status=yes,toolbar=no,menubar=no");
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
<style type="text/css">
.main {
	FONT-SIZE: 11px; COLOR: #999999; FONT-FAMILY: Arial; TEXT-ALIGN: justify; TEXT-DECORATION: none
}
.button  {
 border-right: #BCC0C5 1px solid;
 border-top: #BCC0C5 1px solid;
 font-size: 11px;
 border-left: #BCC0C5 1px solid;
 border-bottom: #BCC0C5 1px solid;
 color: #5B5B5B;
 font-family: tahoma;
 background-color: #E0DFE3
 }
.mainblue {
	FONT-SIZE: 11px; COLOR: #009ade; FONT-FAMILY: Arial; TEXT-ALIGN: right; TEXT-DECORATION: none
}
.titleblue {
	FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #009ade; FONT-FAMILY: Arial; TEXT-ALIGN: justify; TEXT-DECORATION: none
}
.textbox {
	font-family: Verdana,Arial,Helvetica; 
	font-size: 8pt; 
	font-weight: normal; color: #000000; 
	text-decoration: none;
}
.inputbox {
	background-color: White; 
	border: 1px solid #000000; 
	color: #000000; 
	font-family: Verdana,Arial,Helvetica; 
	font-size: 8pt; 
	text-align: left; 
	scrollbar-face-color: #CCCCCC; 
	scrollbar-shadow-color: #FFFFFF; 
	scrollbar-highlight-color: #FFFFFF; 
	scrollbar-3dlight-color: #FFFFFF; 
	scrollbar-darkshadow-color: #FFFFFF; 
	scrollbar-track-color: #FFFFFF; 
	scrollbar-arrow-color: #000000 
}
</style>
<body>
<form onSubmit="showparser();" method="post">
  <h1>webomancer- interpreter sim - </h1>
  <h1>PHP Interactive Interpreter </h1>
  <p>&nbsp;</p>
  <table width="80%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td width="14%">&nbsp;</td>
    <td width="71%">&nbsp;</td>
    <td width="15%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="prstxt" type="text" size="100" class="txt"></td>
    <td>&nbsp;&nbsp;<input name="SHOW" type="submit" class="button" value=" Parse " ></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
  <table width="75%" border="1" align="center">
    <tr>
      <td width="67%" class="titleblue">INSTRUCTIONS</td>
      <td width="33%">&nbsp;</td>
    </tr>
    <tr>
      <td class="titleblue">Type in your php instructions </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="titleblue">on the input box and hit on the </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="titleblue">PARSE button to evaluate.</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="titleblue">** incorrect phrase will render error </td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p><span class="titleblue">CLICK <a href="_members.php"></a></span><a href="_members.php"  title="Home">HERE</a> 
    <span class="titleblue">TO GO BACK</span></p>
</form>
</body>
</html>
