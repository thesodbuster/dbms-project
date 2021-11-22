<?php
# Begin the session
session_start();

# Check if the user is logged in, if not then redirect them to login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

# Declare variables as empty strings
$msg = $msg_err = "";
$rec_email = $rec_email_err = "";
$subject = $subject_err = "";
$user_email = $_SESSION["email"];   # Logged in user's email
$headers = 'From: databaseproject24 @ gmail.com'; # Do not alter this

# Do this once the submit button is pressed
if($_SERVER["REQUEST_METHOD"] == "POST"){

    # Throw error if message box is emtpy
    if(empty(trim($_POST["msg"]))){
        $msg_err = "Please enter content for the message";
    } else {
        $msg = trim($_POST["msg"]);
    }

    # Throw error if email field is empty
    if(empty(trim($_POST["rec_email"]))){
        $rec_email_err = "Please enter an email to send to";
    } else {
        $rec_email = trim($_POST["rec_email"]);
    }
	
	# Throw error if subject is empty
    if(empty(trim($_POST["subject"]))){
        $subject_err = "Please enter a subject";
    } else {
        $subject = trim($_POST["subject"]);
    }
	

    # Send the email now that the variables are stored
    #mail($toemail, $subject, $message, $headers); ### REMINDER
    mail($rec_email, $subject, $msg, $headers);
	header("location: welcome.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send a Single Message!</title>
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
                <label>To:</label>
                <input type="text" name="rec_email" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $rec_email; ?>">
                <span class="invalid-feedback"><?php echo $rec_email_err; ?></span>
            </div>
            <div class="form-group">
                <label>Subject:</label>
                <input type="text" name="subject" class="form-control <?php echo (!empty($subject_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $subject; ?>">
                <span class="invalid-feedback"><?php echo $subject_err; ?></span>
            </div>
            <div class="form-group">
                <label>Message:</label>
                <input type="text" name="msg" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $msg; ?>">
                <span class="invalid-feedback"><?php echo $msg_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
        </form>
    </div>
</body>
</html>