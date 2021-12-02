<?php
# Include the config file
require_once "config.php";

# define variables and initialize with empty values
$name = $password = $confirm_password = $email = "";
$name_err = $password_err = $confirm_password_err = $email_err = "";
$success = $show_alert = false;

# Processing form data when form is submitted
if(isset($_POST['submit'])){
// Validate username
    if(empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } 
    else if(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["name"]))) {
        $name_err = "Name can only contain letters, numbers, and underscores.";
    } 
    else {
        $checkEmail = "SELECT 1 FROM user WHERE email='$email'";
        $result = mysqli_query($link, $checkEmail);

        if (mysqli_num_rows($result) == 1) {
            $email_err = "Account for this email address already exists.";
        }
        else{
            $name = trim($_POST["name"]);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";     
    } 
    else if(strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } 
    else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    } 
    else {
        $confirm_password = trim($_POST["confirm_password"]);
        
        if(empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email";
    }
    else {
        $email = trim($_POST["email"]);
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {
        $privilege = 0;
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);

        // Prepare an insert statement
        $createUser = "INSERT INTO user (name, password, email, privilege) VALUES ('$name', '$hashedPass', '$email', '$privilege')";
         
        if (mysqli_query($link, $createUser)) {
            $show_alert = true;
            $success = true;
        }
        else {
            $show_alert = true;
            $success = false;
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; margin: auto;}
        .title{ padding-top: 20%; padding-bottom:10%}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2 class="title">Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form autocomplete="off" method="POST">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <input name= "submit" type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Clear">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
        <?php if ($show_alert && $success)
            echo "<div class='alert alert-success alert-dismissible' role='alert'> New account created successfully</div>";
            else if ($show_alert && !$success)
            echo "<div class='alert alert-danger alert-dismissible' role='alert'> There was an error creating an account. Please try again </div>";
        ?>
    </div>    
</body>
</html>