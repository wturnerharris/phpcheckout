This is under an MIT License. Open source.

GETTING STARTED

1) Copy the equipment directory to you webserver

2) create a database named equipment (or modify the config.php to the name of the database you create)

3) using phpmyadmin or mysql command line, run equipment.sql

4) Go to http://www.yourserver.edu/equipment/

5) Login with admin:password or labtech:password

6) The only student in the test setup has an ID in 1234

7) This student is in the only class in the system called Test Class

ABOUT THE DATABASE

Currently working on adding equipment/accessories to the database. Mostly everything else can be added via the admin interface.

ADDING MORE STUDENTS/CLASSES/EQUIPMENT

Once a student is added using the admin-student panel, the student must be assigned to a class, which can be done through the admin-class module.

The same is true for equipment and accessories. I.e. Equipment and accesories must be assigned to a corresponding class. Accessories must then be linked to an equipment bundle.

The equipment and accessory lists included with phplabman are the current list available to students in City College's Multimedia Program.  There is no reason you have to define you equipment the same way.  We do it this way because we don't track things like which tripod or battery charge a student has.  We do care about which Canon Digital Rebel because we track the average number of hours equipment is checked out before it is damaged, lost, or stolen.  The ability to show how often all our Digital Rebels are checked out as well as how many times the cameras go out each semester helps us justify our requests for new equipment as well as the lab fees and late fees we charge students.

FINES

The default fine system is fairly draconian.  We charge students $5 for every 15 minutes a kit is late PER KIT!  If you checkout a lighting kit and a DV camera and return it an hour late, you'd owe $30.  We give students a 15 minute grace period, but the students who run the checkout have no control over fines.  Fines are automagically assessed and no additional equipment can be checked out until they are paid.

STRIKES

Previously phpcheckout was ported from phplabman project. That project used fines as a penalty for late returns. Our policy is that of a three strike system. Both systems remain in place and the variables can be configured in config.php and soon in the general tab of the admin module.