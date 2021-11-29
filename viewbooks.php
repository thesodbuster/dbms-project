<?php
# Session verification
session_start();
require_once "config.php";

# Check if the user is logged in, if not then redirect them to login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}



echo "we want to look at the books for orderID: ";

$value = $_SESSION["orderID"];
echo $value;

echo "  which was ordered by professorID: ";

$profID = $_SESSION["facultyID"];
echo $profID;

?>
