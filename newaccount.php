<?php
# Include the config file
require_once "config.php";

# Function to generate a random 10 character password
function randomPass() {
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

$success = false;
$show_alert = false;

# Processing form data when form is submitted
if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($link, $_POST['name']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $privilege = 1;

    // Prepare a select statement
    $checkEmail = "SELECT 1 FROM user WHERE email='$email'";
    $result = mysqli_query($link, $checkEmail);

    if (mysqli_num_rows($result) == 1) {
        echo "Admin account for {$email} already exists.";
    }

    else {
        $tempPass= randomPass();
        $password = password_hash($tempPass, PASSWORD_DEFAULT);
            
        // Prepare an insert statement
        $createUser = "INSERT INTO user (name, password, email, privilege) VALUES ('$name', '$password', '$email', '$privilege')";
        
        if (mysqli_query($link, $createUser)) {
            # Send an email to the user with their password
            $msg = "Your temporary password for the admin account is: " . $tempPass;
            $subject = "New Admin Account";
            $headers = "From: databaseproject24 @ gmail.com";
 
            # Send the email message
            if (mail($email, $subject, $msg, $headers)) {
                $show_alert = true;
                $success = true;
            }
        }
        else {
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
    <title>Create an Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; margin: auto;}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Create Admin</h2>
        <p>Please fill this form to create a new admin account for another user.</p>
        <form autocomplete="off" method="POST">
            <div class="form-group">
                <label>Name</label>
                <input required type="text" name="name" class="form-control">
            </div>    
            <div class="form-group">
                <label>Email</label>
                <input required type="text" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input name= "submit" type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Clear">
            </div>
            <?php if ($show_alert && $success)
                echo "<div class='alert alert-success alert-dismissible' role='alert'> New admin created and email sent successfully</div>";
                else if ($show_alert && !$success)
                echo "<div class='alert alert-danger alert-dismissible' role='alert'> There was an error creating an admin. Please try again </div>";
            ?>
        </form>
        <a href="createdelete.php">< Go back</a>
    </div>    
</body>
</html>