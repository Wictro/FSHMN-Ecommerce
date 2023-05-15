# An E-commerce Application

This is a simple E-commerce Application as homework for "Biznesi dhe Interneti" at FSHMN.  
  
The frontend is in HTML, CSS, and minimal JavaScript while the backend is in PHP. The data is stored in a MySQL database. Aside from the provided libraries inside of PHP, PHPMailer was used for sending emails.

## Running the application
If you follow the below instructions, the application should run perfectly:

### Setting up the database and server
Set up XAMPP or MAMP on your machine and copy this project in the `htdocs` folder and name it `ecommerce` - that should be enough for the server. Assuming that you started `mysql` from XAMPP, run the `db/schema.sql` in MySQL to create the database structure. If this succeeds, run `db/data.sql` in MySQL to populate the database with some example products and categories. This last one will also create a test user with the following credentials:

- Email: filan@fisteku.com
- Password: ecommerce123

Finally go to `includes/db_connect.php` and change the username and password for logging into your database.

### Setting up PHPMailer
Go to the file `includes/mail_config` and set the correct host, port, username, and password for your SMTP server. In our case, we're using [Mailtrap IO](https://www.mailtrap.io) for testing purposes.
  
With these set, start your server and visit `/ecommerce` in your browser.