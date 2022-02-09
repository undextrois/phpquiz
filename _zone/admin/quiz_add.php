<?php
error_reporting(0);
#All code is written by Neil Gardner and is copyright MultiWebVista 2003
#This Quiz System is LinkWare,i.e. you are free to use it for your Website as long as you keep a
#link back to MultiWebVista site at http://www.multiwebvista.com/index.php

include('../inc/header_admin.php');
$conn = db_connect();

$testsub = $HTTP_POST_VARS['testsub'];
$rowstart = $HTTP_GET_VARS['rowstart'];
include('hormenu.php'); ?>
<h1>Create a New Quiz</h1>
<p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">CLICK <a href="../../_cpanel.php">HERE</a> 
  TO GO BACK </font></p>
<?
include('quiz_add_form.inc.php'); ?>


