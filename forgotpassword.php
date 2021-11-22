<?php
# Include config header file
require_once "config.php";

# Function to generate a random 10 character password
function randName() {
    $characters = '0123456789qwertyuioplkjhgfdsazxcvbnm';
    $str = '';  # Start with empty string

    # Randomly select 10 characters
    for($i = 0 ; $i < 10 ; $i++){
        # Generate a random index within strlen of character array
        $ind = rand(0, strlen($characters) - 1);
        
        # Concat character onto string
        $str .= $characters[$ind];
    }

    return $str;
}

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
    $newpassword = randName();

    # Execute an update query to change the password to the randomly generated one
    $sql = "UPDATE user SET password = ? WHERE email = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "ss", $param_new_password, $param_email);

        # Set parameters
        $param_new_password = password_hash($newpassword, PASSWORD_DEFAULT);
        $param_email = $email;

        # Attempt to execute the statement
        if(mysqli_stmt_execute($stmt)){
            # Password update successfully
            echo "Password updated successfully";

            # Send an email to the user with their password
            $msg = "Your password on the book order website has been reset to: " . $newpassword;
            $subject = "Book Website Password Reset";
            $headers = "From: databaseproject24 @ gmail.com";

            # Send the email message
            mail($email, $subject, $msg, $headers);

            # Now redirect to the login page
            header("location: login.php");
        } else {
            echo "Something went wrong creating a temporary password";
        }
        mysqli_stmt_close($stmt);
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
                <input type="text" name="confirm_email" class="form-control <?php echo (!empty($confirm_email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_email; ?>">
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