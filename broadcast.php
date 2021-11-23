<?php
# Start the session on this page and require config.php credentials
session_start();
require_once "config.php";

## database connection is stored in $link ##

# Check if the user is logged in, if not then redirect them to login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

# Set form variables to empty char
$date = $message = "";
$date_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    # Configure SMTP email server
    ini_set("SMTP", "smtp.elasticemail.com");
    ini_set("smtp_port", "2525");


    # Testing email functionality 
    $toemail = 'databaseproject24@gmail.com';
    $subject = 'Book order due date';
    $headers = 'From: databaseproject24 @ gmail.com';

    $sql = "SELECT email FROM user";

    $result = mysqli_query($link, $sql);

    # Populate $date with post submission
    if(empty(trim($_POST["date"]))){
        $date_err = "Please enter a date";
    } else {
        $date = trim($_POST["date"]);
    }

    while($row = mysqli_fetch_row($result)){
        $toemail = $row[0];
        $message = "This is an announcement to professors to have their book orders completed by " . $date;
        $message .= "\n\nClick the link to access our sign in page: http://localhost/dbms-project/dbms-project/login.php";

        mail($toemail, $subject, $message, $headers);
    }
	// Redirect to appropriate page
    switch($_SESSION["privilege"])
	{
		case 2 : header("location: superadmin.php");
		break;
		case 1 : header("location: admin.php");
		break;
		case 0 : header("location: welcome.php");
	}
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Broadcast a Message!</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper{ width: 450px; padding: 20px; margin: auto;}
    </style>
</head>
<body>
<div class="wrapper">
        <h2>Broadcast Book Order Due Date to Professors</h2>
        <p>Announcement to all Professors</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Date</label>
                <input type="text" name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                <span class="invalid-feedback"><?php echo $date_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
        </form>
    </div>
</body>
</html>