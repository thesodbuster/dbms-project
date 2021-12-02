<?php
# Include the config file
require_once "config.php";

# define variables and initialize with empty values
$email = $email_err = $submit_err = "";

$success = $show_alert = false;

# Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
// Validate useremail
    if(empty(trim($_POST["email"]))) {
        $email_err = "Please enter a email.";
    } 
    else{
        // Prepare a select statement
        $sql = "SELECT id, privilege FROM user WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);
				
				
				mysqli_stmt_bind_result($stmt, $id, $privilege);
				if(mysqli_stmt_fetch($stmt)) {
					if(mysqli_stmt_num_rows($stmt) < 1) {
						$email_err = "This account does not exist";
					} 
					else if($privilege == 2) {
						$email_err = "Super Admin accounts cannot be deleted";
					}
					else {
						$email = trim($_POST["email"]);
					}
				}
				else{
					$email_err = "This account does not exist";
				}
				
				
            } else{
                $submit_err = "Oops! Something went wrong. Please try again later.";
                $show_alert = true;
                $success = false;
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
	if(empty($email_err))
	{
			// Prepare an delete statement
			$sql = "DELETE FROM user WHERE email = ?";
			 
			if($stmt = mysqli_prepare($link, $sql)) {
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_email);
				
				// Set parameters
				$param_email = $email;
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)) {
					$show_alert = true;
                    $success = true;
				} else{
					$submit_err = "Oops! Something went wrong. Please try again later.";
                    $show_alert = true;
                    $success = false;
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
    <title>Delete Account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; margin: auto;}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Delete Account</h2>
        <p>Enter the email of the account you want to delete</p>
        <form autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>    
			<div class="form-group">
                <input type="submit" class="btn btn-danger" value="Delete">
                <input type="reset" class="btn btn-secondary ml-2" value="Clear">
            </div>
            <a href="createdelete.php">< Go back</a>
        </form>
        <?php if ($show_alert && $success)
            echo "<div class='alert alert-success alert-dismissible' role='alert'> Account successfully deleted </div>";
            else if ($show_alert && !$success)
            echo "<div class='alert alert-danger alert-dismissible' role='alert'> {$submit_err} </div>";
        ?>
    </div>    
</body>
</html>