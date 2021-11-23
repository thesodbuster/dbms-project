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
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>. Welcome to the admin site.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
		<a href="createdelete.php" class="btn btn-info">Create/Delete Accounts</a>
        <a href="broadcast.php" class="btn btn-primary">Broadcast an Email</a>
        <a href="singlemail.php" class="btn btn-secondary">Individual Email</a>
    </p>
</body>
</html>