<?php error_reporting(0); ?>
<form name="search" action="searchq.php" method="post">
<h3 style="float: left;"><label for="sstr">Search quiz database for: </label></h3>
<p id="hornav"><input type="text" name="sstr" id="sstr" value="<?php echo $sstr; ?>" size="18"/><input type="checkbox" id="pword" name="pword" value="yes" /><label for="pword">partial word match</label><select name="styp"><option value="al">All text fields</option><option value="qo">Questions only</option><option value="ao">Answers Only</option><option value="eo">Explanations only</option></select><select name="testsub"><option value="all">All Subjects</option><?php while ($qrys = mysql_fetch_array($ressch)) { echo '<option>'.$qrys['cat'].'</option>'; } ?></select><a href="javascript:document.search.submit();">Find!</a></p>
</form>