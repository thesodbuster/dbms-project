<?php
# Initialize the session start
session_start();

# Check if the user is logged in, if not then redirect them to login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

# Configure SMTP email server
#ini_set("SMTP", "smtp.elasticemail.com");
#ini_set("smtp_port", "2525");

# Testing email functionality 
#$toemail = 'databaseproject24@gmail.com';
#$subject = 'Testing PHP mail';
#$message = 'Someone has successfully logged into the site!';
#$headers = 'From: databaseproject24 @ gmail.com';
#mail($toemail, $subject, $message, $headers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hello, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>. Please select an action</h1>
    <p>      
		<a href="newaccount.php" class="btn btn-primary">Create New Account</a>
		<a href="delaccount.php" class="btn btn-danger">Delete Existing Account</a>
    </p>
	<a href="login.php">Return to main page</a>
</body>
</html>