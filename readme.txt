~WEBOMANCER 1.0
 Latest Stable release
 build 1.0 March 2006

USER MANUAL
Student
       The design is highly intuitive the only rules
       are :
	
	1.You cannot get into the next lesson f you dont pass the
	  exam 
        
	2.You can take as many exam as you like provided that you have passed the
	  pre requisite exam.

	3.TestZone pre-exam for novice programmers

	4.PHP Simulator
		Testing area for php parser
	example inputs:
		echo "hello world";	


Administrator

	The control panel provides

	1.User Management
	
        2.Quiz Engine 
	
	3.History profiles for Quiz Results

	4.TesTZone Management

Developer

turn error_reporting on or off if you happen to see
a debug statements such as NOTICE . WARNING.

	Contains 13 Database Tables

tbl_admin - for administrator only

tbl_grades - storage of grades that has been taken by an individual user

tbl_lessons - storage of lessons

tbl_memberlist - list of registered user

tbl_mods - list of mods , 3 modules for version 1.0
	   ASP,PHP,JSCRIPT
tbl_possibleanswers - list of all quiz answers and correct answers

tbl_quiz - list of quiz c

tbl_session - for security session management

tbl_userlist - listings of user for login 	


Quick Notes:
	 a newly registered user LEVEL_FLAG = 1
	 this will change if the user pas all the pre requisite exam
	 user is not capable of viewing lesson if he fail to pas the pre requisite 
         exam



Regards,
The WEBOMANCER Team
webomancer@webomancer.com

Wildchrome Software	 


Files:
	   _version1.zip (533k)    
	   webomancer.sql (65k)   

