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
$orderID = $orderID_err = "";
$facultyID = $facultyID_err = "";

# When form is submitted perform the following tasks
if($_SERVER["REQUEST_METHOD"] == "POST"){
// Prepare a select statement
    if(empty(trim($_POST["semester"]))){
        $semester_err = "Please enter a semester number";
    } 
	else {
        $semester = trim($_POST["semester"]);
    }

$array = array(" ", " ", " ", " ", " ", " ", " ", " ", " ", " "," ", " ", " ", " ", " ", " ", " ", " ", " ", " ");
$arrayCounter = 0;
	// Perform query
	
	if ($result = mysqli_query($link, "SELECT orderID FROM users.order WHERE semester= ".$semester)) {
		while ($row = mysqli_fetch_row($result)) {
			//printf ("%s\n", $row[0]);
			$array[$arrayCounter] = $row[0];
			$arrayCounter = $arrayCounter + 1;
			}
  // Free result set
  mysqli_free_result($result);
	}

//echo $semester;


}     
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

            </div> 
			<div class ="row1">
			<label for="order1">Order 1:</label><br>
			<input type="text" name="order1" value="<?php echo $array[0];?>">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row2">
			<label for="order2">Order 2:</label><br>
			<input type="text" name="order2" value="<?php echo $array[1];?>">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row3">
			<label for="order3">Order 3:</label><br>
			<input type="text" name="order3" value="<?php echo $array[2];?>">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row4">
			<label for="order4">Order 4:</label><br>
			<input type="text" name="order4" value="<?php echo $array[3];?>">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row5">
			<label for="order5">Order 5:</label><br>
			<input type="text" name="order5" value="<?php echo $array[4];?>">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row6">
			<label for="order6">Order 6:</label><br>
			<input type="text" name="order6" value="<?php echo $array[5];?>">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row7">
			<label for="order7">Order 7:</label><br>
			<input type="text" name="order7" value="<?php echo $array[6];?>">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row8">
			<label for="order8">Order 8:</label><br>
			<input type="text" name="order8" value="<?php echo $array[7];?>">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row9">
			<label for="order9">Order 9:</label><br>
			<input type="text" name="order9" value="<?php echo $array[8];?>">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
			<div class ="row10">
			<label for="order10">Order 10:</label><br>
			<input type="text" name="order10" value="<?php echo $array[9];?>">
			<a href="admin.php" class="btn btn-primary">View Details</a>
			</div>
            <p>Lost? <a href="admin.php">Go back</a>.</p>
        </form>
    </div>    
</body>
</html>