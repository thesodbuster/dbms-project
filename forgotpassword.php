<?php
# Include config header file
require_once "config.php";

# Function to generate a random 10 character password


# Declare variables
$email = $email_err = $confirm_email_err = $confirm_email = "";

# Check for form submission
if($_SERVER["REQUEST_METHOD"] == "POST"){
    # Check if email field is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email and confirm email";
    } else {
        $email = trim($_POST["email"]);
    }

    # Check if confirm email is empty and if both entries match
    if(empty(trim($_POST["confirm_email"]))){
        $confirm_email_err = "Please confirm email";
    } else {
        $confirm_email = trim($_POST["confirm_email"]);
        if(empty($email_err) && ($email != $confirm_email)){
            $confirm_email_err = "Emails do not match";
        }
    }

    # Now generate a random string as a temporary password
    $newpassword = 
}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; margin: auto;}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Email</label>
                <input type="password" name="confirm_email" class="form-control <?php echo (!empty($confirm_email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_email; ?>">
                <span class="invalid-feedback"><?php echo $confirm_email_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="login.php">Never mind</a>
            </div>
        </form>
    </div>    
</body>
</html>