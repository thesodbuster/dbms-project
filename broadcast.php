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
$date = $msg = "";
$date_err = $msg_err = "";


$sql = "SELECT email FROM user";

$result = mysqli_query($link, $sql);


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Broadcast a Message!</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper{ width: 360px; padding: 20px; margin: auto;}
    </style>
</head>
<body>
<div class="wrapper">
        <h2>Sign Up</h2>
        <p>Announcement to all Professors</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                <span class="invalid-feedback"><?php echo $date_err; ?></span>
            </div>
            <div class="form-group">
                <label>Message</label>
                <input type="text" name="msg" class="form-control <?php echo (!empty($msgl_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $msg; ?>">
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