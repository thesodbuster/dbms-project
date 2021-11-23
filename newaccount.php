<?php
# Include the config file
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

# define variables and initialize with empty values
$name = $password = $confirm_password = $email = "";
$name_err = $password_err = $confirm_password_err = $email_err = "";

# Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
// Validate username
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a name.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["name"]))){
        $name_err = "Name can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            
            // Set parameters
            $param_name = trim($_POST["name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $name_err = "This name is already taken.";
                } else{
                    $name = trim($_POST["name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email";
    } else {
        $email = trim($_POST["email"]);
    }
    
	$newpassword = randName();
    // Check input errors before inserting in database
    if(empty($name_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO user (name, password, email, privilege) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_password, $param_email, $param_privilege);
            
            // Set parameters
            $param_name = $name;
            $param_password = password_hash($newpassword, PASSWORD_DEFAULT); // Creates a password 
            $param_email = $email;
			$param_privilege = 1;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
				# Password update successfully
				echo "New account created successfully";

				# Send an email to the user with their password
				$msg = "Your temporary password for the admin account is: " . $newpassword;
				$subject = "New Admin Account";
				$headers = "From: databaseproject24 @ gmail.com";

            # Send the email message
            mail($email, $subject, $msg, $headers);

                // Redirect to appropriate page
                switch($_SESSION["privilege"])
				{
					case 2 : header("location: superadmin.php");
					break;
					case 1 : header("location: admin.php");
					break;
					case 0 : header("location: welcome.php");
				}
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
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
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create a new admin account for another user.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p><a href="login.php">Return to main page</a>.</p>
        </form>
    </div>    
</body>
</html>