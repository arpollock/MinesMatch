# CSCI445 Final Project #
## Group: 789 ##
### Team Members: Morgan Cox, Emma May, & Alex Pollock ###


#### Submission Details: ####
* All of the SQL table creation code can be found in `./sql/table_creation` (`./sql/matching` is just a logical reference file). 

* In `database_conn.php` there are two different datbase connections because we had some teammates developing locally and others through XAMPP.


#### How we met the technical requirements: ####
1. Your site must be able to Create, Read, Update, and Delete data: we update create/read/update/delete data with the user's match perferences and matches with other users.

2. All data must be stored in a database accessed through the MySQLi or PDO interface: the `./sql/table_creation` shows how we created our MySQL database and `./databse_conn.php` contains how the site accesses this database. 

3. You should have an access wall that users need to log in to get through.  There are then two main sections to your site:
    1. Outside the Wall:
        1. Log in page: `./login.php`
        2. Users should be able to sign up for an account by providing an email address and creating a password. An email will be sent allowing the user to activate their account: in `./login.php`
        3. An option to reset their password if forgotten.  An email will be sent to the user: in `./login.php` > 'Reset Password' page (`./forgot_password.php`)
    2. Inside the Wall:
        1. Pages that enter, update, select, delete data: this is done both when the user updates their preferences or responds to a potential matching.
        2. Change their password: `./my_profile.php` > 'Edit Settings (`./edit_settings.php`)
        3. Log out: in `./templateHeader.php` > 'Sign Out' option (`./logout.php`)

4. If a user enters the URL for a page inside the wall and they have not logged in yet, they should be redirected to the log in page: the code is at the top of all of these pages (Dashboard, My Profile, Other Profile, Edit Preferences, Edit Settings)

5. If they are inside the wall, but have been inactive for a period of time and try to navigate to a new page, they should be logged out and returned to the log in page: this can be we the cookie is set on the login page.

6. Page is constructed using valid HTML, CSS, JavaScript, and PHP.

7. Pages pass validation and are accessible: we pass validation except in CSS where we are using variables (similar to the Dark Mode assignment), since CSS variables are not supported but they greatly enhance the flexibility of the styling, we used them. 