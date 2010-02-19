
GETTING STARTED

1) Copy the checkout directory to you webserver

2) create a database named equipment (or modify the config.php to the name of the database you create run the equipment.sql in)

3) using phpmyadmin or mysql command line, run equipment.sql

4) Go to http://www.yourserver.edu/equipment/

5) Login with checkoutguy/password

6) The only student in the test setup has an ID in 1234

7) This student is in the only class in the system called Test Class

ABOUT THE DATABASE

The database relies on primary secondary key relations.  If this is a new concept to you, you may want to wait for some admin tools to be written.  Currently you must manually enter everything including the joining tables.


Primary Tables:

accessorytype - These are smaller items included in kit, but not tracked as
			    individual items.
class - 
kit - The main items
students 
users - This is for people who can log into the system and check things out

Joining Tables:

kit_accessorytype 
kit_class
student_class

Active Tables:

checkedout - This is where checkout records are kept.  These are never deleted. 
			 When equipment in returned, a checkedin date is added.  
			 
ADDING MORE STUDENTS/CLASSES/EQUIPMENT

Adding a student to the students table does not give them access to any kits.  Access to kits are determined by the classes the student is enrolled in.  If the student is enrolled in multiple classes that have access to the same kit, the class with longest checkout hours are used.  The idea is that once the basic structure of your checkout is set up, the only thing that has to be changed each semester are the students and student_class.

The same is true for kits.  Adding a kit doesn't make it available to anyone.  You must add links between kits and classes in the kit_class table.  

The equipment and accessory lists included with phplabman are the current list available to students in Braldey University's Multimedia Program.  There is no reason you have to define you equipment the same way.  We do it this way because we don't track things like which tripod or battery charge a student has.  We do care about which Canon Digital Rebel because we track the average number of hours equipment is checked out before it is damaged, lost, or stolen.  The ability to show how often all our Digital Rebels are checked out as well as how many times the cameras go out each semester helps us justify our requests for new equipment as well as the lab fees and late fees we charge students.

FINES

The default fine system is fairly draconian.  We charge students $5 for every 15 minutes a kit is late PER KIT!  If you checkout a lighting kit and a DV camera and return it an hour late, you'd owe $30.  We give students a 15 minute grace period, but the students who run the checkout have no control over fines.  Fines are automagically assessed and no additional equipment can be checked out until they are paid.


			 

