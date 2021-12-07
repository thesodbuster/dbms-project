<?php
# Database credentials for connecting to MySQL
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');

#### IMPORTANT ####
# YOUR MYSQL PASSWORD HERE
define('DB_PASSWORD', 'Blake414?');
define('DB_NAME', 'users');

# Attempt to connect to the database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

# Check the connection
if ($link === false) {
    die("ERROR: Cannot connect to DB. " . mysqli_connect_error());
}
?>