<?php
# Include the config file
require_once "config.php";

# define variables and initialize with empty values
$name =  "";
$name_err =  "";

# Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
// Validate username
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a name.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["name"]))){
        $name_err = "Name can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id, privilege FROM user WHERE name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            
            // Set parameters
            $param_name = trim($_POST["name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
				
				
				mysqli_stmt_bind_result($stmt, $id, $privilege);
				if(mysqli_stmt_fetch($stmt)){
					if(mysqli_stmt_num_rows($stmt) < 1){
						$name_err = "This account does not exist";
					} 
					else if($privilege == 2){
						$name_err = "Superadmin accounts cannot be deleted";
					}
					else{
						$name = trim($_POST["name"]);
					}
				}
				else{
					$name_err = "This account does not exist";
				}
				
				
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
	if(empty($name_err))
	{
			// Prepare an delete statement
			$sql = "DELETE FROM user WHERE name = ?";
			 
			if($stmt = mysqli_prepare($link, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_name);
				
				// Set parameters
				$param_name = $name;
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					// Redirect to appropriate page
					header("location: login.php");
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
    <title>Delete Account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; margin: auto;}
    </style>
</head>
<body>
    <div class="wrapper">
        <p>Please fill this form to delete an existing account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>    
			<div class="form-group">
                <input type="submit" class="btn btn-danger" value="Delete">
                <input type="reset" class="btn btn-secondary ml-2" value="Clear">
            </div>
            <a href="createdelete.php">< Go back</a>
        </form>
    </div>    
</body>
</html>