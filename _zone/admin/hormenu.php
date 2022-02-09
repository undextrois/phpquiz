<?PHP error_reporting(0); ?>
<form name="viewq" method="post" action="questions.php?rowstart=<?php echo $rowstart; ?>">
<?php if (isset($testsub)) { echo '<input type="hidden" name="testsub" value="'.$testsub.'">';} ?>
</form>
<p class="rtali" id="hornav">
<a href="javascript:document.viewq.submit();">Review Questions</a>
<a href="subject_add.php">New Subject</a>
<a href="index.php">Admin Index</a>
</p>
<p id="hornav"><form name="addq" method="post" action="quiz_add.php<?php if (isset($rowstart)) { echo '?rowstart='.$rowstart; }  ?>"><?php if (isset($testsub)) { echo '<input type="hidden" name="testsub" value="'.$testsub.'">';} ?>
<a href="javascript:document.addq.submit();">Add to Quiz</a><select name="qnu"><option value="1" SELECTED>1 new question</option><option value="2">2 new questions</option><option value="5">5 new questions</option><option value="10">10 new questions</option></select> and <select name="anu"><option value="3">max. 3 answer options</option><option value="4" SELECTED>max. 4 answer options</option><option value="5">max. 5 answer options</option><option value="6">max. 6 answer options</option></select> | <select name="xtype" id="xtype" ><option value="all">Allow all question types</option><option value="maex" SELECTED>Multiple choice only</option><option value="maex">Exclude multiple answer option</option><option value="bonly">True/false only</option></select></form></p>
