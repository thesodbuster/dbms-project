<?php
# Session verification
session_start();
require_once "config.php";

# Check if the user is logged in, if not then redirect them to login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

# Initialize the form variables
$semester = $semester_err = "";



        
# Check for empty fields




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Book Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; margin: auto;}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>View Book Orders</h2>
        <p>Please enter a semester number below</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Semester</label>
                <input type="text" name="semester" class="form-control <?php echo (!empty($semester_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $semester; ?>">
                <span class="invalid-feedback"><?php echo $semester_err; ?></span>
				<input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div> 
			<div class ="row1">
			<label for="order1">Order 1:</label><br>
			<input type="text" name="order1" value="">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row2">
			<label for="order2">Order 2:</label><br>
			<input type="text" name="order2" value="">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row3">
			<label for="order3">Order 3:</label><br>
			<input type="text" name="order3" value="">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row4">
			<label for="order4">Order 4:</label><br>
			<input type="text" name="order4" value="">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row5">
			<label for="order5">Order 5:</label><br>
			<input type="text" name="order5" value="">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row6">
			<label for="order6">Order 6:</label><br>
			<input type="text" name="order6" value="">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row7">
			<label for="order7">Order 7:</label><br>
			<input type="text" name="order7" value="">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row8">
			<label for="order8">Order 8:</label><br>
			<input type="text" name="order8" value="">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row9">
			<label for="order9">Order 9:</label><br>
			<input type="text" name="order9" value="">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row10">
			<label for="order10">Order 10:</label><br>
			<input type="text" name="order10" value="">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
            <p>Lost? <a href="welcome.php">Go back</a>.</p>
        </form>
    </div>    
</body>
</html>