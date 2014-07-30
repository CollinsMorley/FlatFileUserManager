FlatFileUserManager
===================

PHP with OOP User Account class using a flat file for storage

===================

A single class written in PHP that handles user login and account creation.  The username, a clean (lowercase) version of the username, and a hashed password are stored in a text file.

The class also includes a simple error handler making it much easier to customize the output of errors to the user.  It's also worth noting, that while the sample uses sessions, the class is designed such that the login only returns a boolean value which can be used in a condition to track the login howeve the user likes, or one could modify the class to handle any sessions internally very easily.

This class has been tested for speed with up to 10,000 users.
