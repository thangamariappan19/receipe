Step 1: Download and install XAMPP on your computer

Step 2: Start the modules and test your server

To install XAMPP and WordPress properly, you’ll need to run two modules:

    Apache
    MySQL

    And now you should be able to test that your local server is working by going to http://localhost/ in your web browser of choice

Step 3: Add the WordPress files by clonig from github

clone from this following github repository
"https://github.com/thangamariappan19/receipe.git"
Inside Recipe repository find "wordpress" folder and copy that,
Then, in Windows, navigate to the folder where you installed XAMPP. For me, that’s C://xampp. It should be something similar for you. Then, in that folder, find the htdocs subfolder: paste "wordpress".

Step 4: Create a database for WordPress

Next, you need to create a MySQL database for your WordPress install. To do that, launch PHPMyAdmin from your XAMPP control panel:
Then click on Databases at the top:
And enter a name for your database as "receipe" and click Create. Then import database from cloned repository DB folder find receipe.sql.Using this file import in phpmyadmin

Step 5:Thats it Go to browser and check this link http://localhost/wordpress
