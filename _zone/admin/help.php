<?php 
error_reporting(0);
include('inc/header.inc.php'); 
include('hormenu.php');
?>
<hr />
<h1>MultiWebQuiz 1.5 Help</h1>
<p>MultiWebQuiz 1.5 offers a complete On-Line Quiz Management System.</p>
<p>To use this Web application, your site must be hosted on a server that supports PHP (4.0+) + MySQL.</p>
<p>After following a few basic instructions to set up and configure the MySQL database and then adding password protection to your admin directory, all you need do is enter your questions, answers and explanations into the user-friendly quiz creation form. They can be easily copied and pasted from any Word Processor.</p>
<h3>Unpack the Zip File !</h3>
<p>First unpack the zipped file, ideally to a new folder on your hard drive. This operation will create two new subfolders, inc and admin. The first folder contains HTML code snippets such as the page header and footer dynamically included in the main quiz pages as well as configuration data. The admin folder contains the quiz management pages.</p>
<table id="lst"><tr><th>Main directory</th><th>/inc/</th><th>/img/</th><th>/img/</th></tr>
<tr><td>index.php<br />
marktest.php<br />
multiteststyle.css<br />
quiz.php<br />
results.php<br />
</td>
<td>inc/
db_config.inc.php<br />
header.inc.php<br />
footer.inc.php<br />
header_admin.php<br />
</td>
<td>correct_tick.gif<br />
skipped.gif<br />
wrong_cross.gif<br /></td>
<td>config_make.php<br />
create_tables.php<br />
help.php<br />
hormenu.php<br />
index.php<br />
question_delete.php<br />
question_deleted.php<br />
question_edit_form.inc.php<br />
question_update.php<br />
question_updated.php<br />
questions.php<br />
questnav.inc.php<br />
quiz_add.php<br />
quiz_add_form.inc.php<br />
quiz_added.inc.php<br />
quiz_reedit_form.inc.php<br />
searchform.inc.php<br />
searchq.php<br />
setup.php<br />
sub_update_view.inc.php<br />
subject_add.php<br />
subject_added.php<br />
subject_delete.php<br />
subject_deleted.php<br />
subject_edit_form.php<br />
subject_update.php<br />
subject_updated.php<br />
update_view.inc.php</td></tr>
</table>
<h3>Set Up the Database !</h3>
<p>The quiz management system will not actually create the database, because your server, administered in all likelihood by a remote Web host, may impose restrictions on the number and names of databases.</p>
<p>If you need to set up a new database, here's the correct SQL command:</p>
<p class="dhdbx">CREATE DATABASE quiz;</p>
<p>If necessary, set the database access password as follows:</p>
<p class="dhdbx">GRANT ALL PRIVILEGES ON <em>database_name </em> TO <em>username</em> IDENTIFIED BY <em>password</em>;</p>
<p>It's that simple. <a href="http://www.phpmyadmin.net/" target="_blank">PhpMyAdmin</a> is a good PHP and MySQL administration tool and may be preinstalled on your server. If not, download the latest version and then upload it to a special directory on your Web space. Remember to add password protection to all admin directories. Many Web hosting services will have an online control panel to let you do this effortlessly.</p>
<h3>Configure MultiWebQuiz to work with your database:</h3>
<p>All this data is stored in one small file inc/db_config.inc.php .</p>
<div class="dhdbx">
 <p>function db_connect()<br />
  {<br />
  $result = @mysql_pconnect('<span class="red">host[:port]</span>', '<span class="red">username</span>', '<span class="red">password</span>');<br />
  if (!$result)<br />
  return false;<br />
  if (!@mysql_select_db('<span class="red">database</span>'))<br />
  return false;</p>
 <p>return $result;</p>
 <p>}</p>
</div>
<p><br />
 Do not overwrite the inverted commas. If in doubt, contact your Web Host, who should furnish you with the correct details.</p>
<p><span class="red">host</span>: Type your host name here at the end in inverted commas. Localhost if it is on the same server. If it is on another server, place the port number after a colon at the end.<br />
  <span class="red">username</span>: Type your database user name in inverted commas.<br />
  <span class="red">password</span>: Type your database password here in inverted commas.<br />
  <span class="red">database</span>: Type your database name here in inverted commas..</p>
<h3>Password Protection</h3>
<p>There are no links from the quiz in the main section to the admin zone, but nonethless remember to add password protection to the admin directory. Many Web hosting services will have an online control panel to let you do this effortlessly. If your site is hosted on an Apache server you can edit the .htaccess file.</p>
<h3>Upload The Files to your Server</h3>
<p>Use an FTP program, which may be integrated in your HTML editor, to upload the files to your Website. </p>
<p class="dhdbx">Main admin page URL: http://www.your_website.com/[subdirectory]<span class="red">/admin/index.php</span></p>
<h3>Click Create Tables.</h3>
<p>Navigate to <em>main_quiz_directory<span class="red">/admin/index.php</span></em> and click Create Tables. If this does not work, check your host name, user name, database password and database name. If the database is on a remote server, check the port number with your WebHost. Please note this command will overwrite any tables of the same name.</p>
<p>If you're using phpMyAdmin, you may run these SQL queries:</p>
<div class="dhdbx">
<pre><code>
DROP TABLE IF EXISTS questions;
  CREATE TABLE questions (
  ID int(4) unsigned zerofill NOT NULL auto_increment,
  question text NOT NULL,
  test varchar(31) NOT NULL default '',
  ans1 text NOT NULL,
  ans2 text NOT NULL,
  ans3 text NOT NULL,
  ans4 text NOT NULL,
  ans5 text,
  ans6 text,
  corans varchar(8) NOT NULL default '',
  expl text NOT NULL,
		PRIMARY KEY (ID)
  ) TYPE=MyISAM;

DROP TABLE IF EXISTS subjects;
  CREATE TABLE subjects (
  ID int(4) unsigned zerofill NOT NULL auto_increment,
  cat varchar(31) NOT NULL default '',
  descr text NOT NULL,
  random int(1) default NULL,
  PRIMARY KEY (ID)
		) TYPE=MyISAM;
</code>
</pre>
</div>
<h3>Adding Questions:</h3>
<p>After creating the database, Questions and Subjects tables, just add at least one subject area. You can now add as many questions as you like.</p>
<h3>Special Characters and Line Breaks:</h3>
<p>Tick Use &quot;Special Characters&quot; to convert all special characters such as &amp;, &lt;, &gt;, &egrave; or &eacute; to HTML entities for database storage. This will ensure such characters are viewable in HTML. This option will also convert line breaks to &lt;br /&gt; tags. Otherwise, all data will read as raw HTML so you can use tags within questions, answers and explanations.</p>
<h3> Customising Layout and Formatting:</h3>
<p>MultiWebQuiz uses a stylesheet and some custom classes are essential to the Quiz, in particular <em>p#bignav</em>, <em>span#subnav</em>, <em>table#qst</em> and ol<em>#numbered</em>.<br />
 However, a little basic understanding of stylesheets should let you change much of formatting.<br />
 To add your own custom header, just edit inc/header.inc.php file and use standard HTML under the body tag. Remember the paths of all images you may include in your header are relative to the page and not to the header stored in the <em>/inc/ </em>folder.</p>
<h3>Bugs and Bears</h3>
<p>As the quiz script relies on CSS2 formatting, it will not display correctly in Netscape 4.7. It has, however, been tested on IE 6, Opera 7, Mozilla 1.2 and Netscape 6.0.</p>
<h3>Answer Modes and Answer Exclude Codes</h3>
<p>MultiWebQuiz 1.5 supports three types of questions:</p>
<ol id="numbered">
 <li>Multiple choice with as many as 6 answer options (default), of which only one may be correct.</li>
 <li>Multiple answer with as many as 6 answer options,of which more than one may be correct.<br />
  By Simply leaving the fourth, fifth or sixth answer fields blank in the question edit or update forms, MultiWebQuiz will add a code <em>q#exc</em> to this database field to exclude this option from the test.</li>
 <li>If the Boolean checkbox is ticked [checked], answer option 1 becomes true and 2 false. MultiWebQuiz fills the other answer fields with <em>xb##l</em> and will shuffle only the true and false options.</li>
</ol>
<p>If you see these codes in the question edit form, ignore them unless you wish to change the answer mode.</p>
