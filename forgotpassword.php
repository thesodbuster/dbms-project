<?php
# Include config header file
require_once "config.php";

# Function to generate a random 10 character password
function randomPass() {
    $characters = '0123456789qwertyuioplkjhgfdsazxcvbnm';
    $str = '';  # Start with empty string

    # Randomly select 10 characters
    for($i = 0 ; $i < 10 ; $i++) {
        # Generate a random index within strlen of character array
        $ind = rand(0, strlen($characters) - 1);
        
        # Concat character onto string
        $str .= $characters[$ind];
    }

    return $str;
}

# Declare variables
$email = $email_err = $submit_err = $confirm_err = $confirm_email = "";

$success = $show_alert = false;

# Check for form submission
if(isset($_POST['submit'])) {
    # Check if email field is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email and confirm email";
    } 
    else {
        $email = trim($_POST["email"]);
    }

    # Check if confirm email is empty and if both entries match
    if(empty(trim($_POST["confirm_email"]))) {
        $confirm_err = "Please confirm email";
    } 
    else {
        $confirm_email = trim($_POST["confirm_email"]);
        
        if(empty($email_err) && ($email != $confirm_email)) {
            $confirm_err = "Emails do not match";
        }
    }

    // Prepare a select statement
    $checkEmail = "SELECT 1 FROM user WHERE email='$email'";
    $result = mysqli_query($link, $checkEmail);
    
    if ($result && mysqli_num_rows($result) != 1) {
        $submit_err = "No account exists for this email";
        $show_alert = true;
        $success = false;
    }
    else if(empty($email_err) && empty($confirm_err)) {
        
        $tempPass= randomPass();
        $password = password_hash($tempPass, PASSWORD_DEFAULT);
            
        // Prepare an insert statement
        $updatePass = "UPDATE user SET password = '$password' WHERE email = '$email'";
        
        if (mysqli_query($link, $updatePass)) {
            # Send an email to the user with their password
            $msg = "Your password on the book order website has been reset to: " . $tempPass;
            $subject = "Book Website Password Reset";
            $headers = "From: databaseproject24 @ gmail.com";
    
            # Send the email message
            if (mail($email, $subject, $msg, $headers)) {
                $show_alert = true;
                $success = true;
            }
        }
        else {
            $submit_err = "There was an error ressetting your password. Please try again";
            $show_alert = true;
            $success = false;
        }
    }
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
        .title{ padding-top: 20%; padding-bottom: 5% }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2 class="title">Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form autocomplete="off" method="POST"> 
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Email</label>
                <input type="text" name="confirm_email" class="form-control <?php echo (!empty($confirm_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_email; ?>">
                <span class="invalid-feedback"><?php echo $confirm_err; ?></span>
            </div>
            <div class="form-group">
                <input name="submit" type="submit" class="btn btn-primary" value="Submit">
                <br /><br />
                <a href="login.php">< Go back</a>
            </div>
        </form>
        <?php if ($show_alert && $success)
            echo "<div class='alert alert-success alert-dismissible' role='alert'> Temporary password sent to {$email}</div>";
            else if ($show_alert && !$success)
            echo "<div class='alert alert-danger alert-dismissible' role='alert'> {$submit_err} </div>";
        ?>
    </div>    
</body>
</html>