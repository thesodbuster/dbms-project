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
$test = "variable has been passed";
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
	
	if ($result = mysqli_query($link, "SELECT orderID, facultyID FROM user.order WHERE semester= ".$semester)) {
		while ($row = mysqli_fetch_row($result)) {
			//printf ("%s\n", $row[0]);
			$array[$arrayCounter] = $row[0];
			$arrayCounter = $arrayCounter + 1;
			$array[$arrayCounter] = $row[1];
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
			<?php
        if(array_key_exists('button1', $_POST)) {
            button1();
        }
        function button1() {
			$_SESSION["orderID"] = $_POST["order1"];
			$_SESSION["facultyID"] = $_POST["faculty1"];
			//echo $_POST["order1"];
			//echo $_POST["faculty1"];
            header("location: viewbooks.php");
        }
    ?>
			<div class ="row1">
			<label for="order1">Order 1:</label><br>
			<input type="text" name="order1" value="<?php echo $array[0];?>">
			<input type="hidden" name="faculty1" value="<?php echo $array[1];?>">
			<input type="submit" name="button1" class="button" value="View Details">			
			</div>
			<?php
        if(array_key_exists('button2', $_POST)) {
            button2();
        }
        function button2() {
			$_SESSION["orderID"] = $_POST["order2"];
			$_SESSION["facultyID"] = $_POST["faculty2"];
			//echo $_POST["order1"];
			//echo $_POST["faculty2"];
            header("location: viewbooks.php");
        }
    ?>			
			
			<div class ="row2">
			<label for="order2">Order 2:</label><br>
			<input type="text" name="order2" value="<?php echo $array[2];?>">
			<input type="hidden" name="faculty2" value="<?php echo $array[3];?>">
			<input type="submit" name="button2" class="button" value="View Details">			
			</div>
						<?php
        if(array_key_exists('button3', $_POST)) {
            button3();
        }
        function button3() {
			$_SESSION["orderID"] = $_POST["order3"];
			$_SESSION["facultyID"] = $_POST["faculty3"];
			//echo $_POST["order1"];
			//echo $_POST["faculty3"];
            header("location: viewbooks.php");
        }
    ?>	
			
			<div class ="row3">
			<label for="order3">Order 3:</label><br>
			<input type="text" name="order3" value="<?php echo $array[4];?>">
			<input type="hidden" name="faculty3" value="<?php echo $array[5];?>">
			<input type="submit" name="button3" class="button" value="View Details">
			</div>
			
									<?php
        if(array_key_exists('button4', $_POST)) {
            button4();
        }
        function button4() {
			$_SESSION["orderID"] = $_POST["order4"];
			$_SESSION["facultyID"] = $_POST["faculty4"];
			//echo $_POST["order1"];
			//echo $_POST["faculty4"];
            header("location: viewbooks.php");
        }
    ?>	
			
			<div class ="row4">
			<label for="order4">Order 4:</label><br>
			<input type="text" name="order4" value="<?php echo $array[6];?>">
			<input type="hidden" name="faculty4" value="<?php echo $array[7];?>">
			<input type="submit" name="button4" class="button" value="View Details">
			</div>
			
											<?php
        if(array_key_exists('button5', $_POST)) {
            button5();
        }
        function button5() {
			$_SESSION["orderID"] = $_POST["order5"];
			$_SESSION["facultyID"] = $_POST["faculty5"];
			//echo $_POST["order1"];
			//echo $_POST["faculty5"];
            header("location: viewbooks.php");
        }
    ?>		
			
			<div class ="row5">
			<label for="order5">Order 5:</label><br>
			<input type="text" name="order5" value="<?php echo $array[8];?>">
			<input type="hidden" name="faculty5" value="<?php echo $array[9];?>">
			<input type="submit" name="button5" class="button" value="View Details">
			</div>
								<?php
        if(array_key_exists('button6', $_POST)) {
            button6();
        }
        function button6() {
			$_SESSION["orderID"] = $_POST["order6"];
			$_SESSION["facultyID"] = $_POST["faculty6"];
			//echo $_POST["order1"];
			//echo $_POST["faculty6"];
            header("location: viewbooks.php");
        }
    ?>
			<div class ="row6">
			<label for="order6">Order 6:</label><br>
			<input type="text" name="order6" value="<?php echo $array[10];?>">
			<input type="hidden" name="faculty6" value="<?php echo $array[11];?>">
			<input type="submit" name="button6" class="button" value="View Details">
			</div>
											<?php
        if(array_key_exists('button7', $_POST)) {
            button7();
        }
        function button7() {
			$_SESSION["orderID"] = $_POST["order7"];
			$_SESSION["facultyID"] = $_POST["faculty7"];
			//echo $_POST["order1"];
			//echo $_POST["faculty7"];
            header("location: viewbooks.php");
        }
    ?>
			
			<div class ="row7">
			<label for="order7">Order 7:</label><br>
			<input type="text" name="order7" value="<?php echo $array[12];?>">
			<input type="hidden" name="faculty7" value="<?php echo $array[13];?>">
			<input type="submit" name="button7" class="button" value="View Details">
			</div>
			
														<?php
        if(array_key_exists('button8', $_POST)) {
            button8();
        }
        function button8() {
			$_SESSION["orderID"] = $_POST["order8"];
			$_SESSION["facultyID"] = $_POST["faculty8"];
			//echo $_POST["order1"];
			//echo $_POST["faculty8"];
            header("location: viewbooks.php");
        }
    ?>
	
			<div class ="row8">
			<label for="order8">Order 8:</label><br>
			<input type="text" name="order8" value="<?php echo $array[14];?>">
			<input type="hidden" name="faculty8" value="<?php echo $array[15];?>">
			<input type="submit" name="button8" class="button" value="View Details">
			</div>
			
				<?php
        if(array_key_exists('button9', $_POST)) {
            button9();
        }
        function button9() {
			$_SESSION["orderID"] = $_POST["order9"];
			$_SESSION["facultyID"] = $_POST["faculty9"];
			//echo $_POST["order1"];
			//echo $_POST["faculty9"];
            header("location: viewbooks.php");
        }
    ?>
			<div class ="row9">
			<label for="order9">Order 9:</label><br>
			<input type="text" name="order9" value="<?php echo $array[16];?>">
			<input type="hidden" name="faculty9" value="<?php echo $array[17];?>">
			<input type="submit" name="button9" class="button" value="View Details">
			</div>
				<?php
        if(array_key_exists('button10', $_POST)) {
            button10();
        }
        function button10() {
			$_SESSION["orderID"] = $_POST["order10"];
			$_SESSION["facultyID"] = $_POST["faculty10"];
			//echo $_POST["order1"];
			//echo $_POST["faculty10"];
            header("location: viewbooks.php");
        }
    ?>			
			
			<div class ="row10">
			<label for="order10">Order 10:</label><br>
			<input type="text" name="order10" value="<?php echo $array[18];?>">
			<input type="hidden" name="faculty10" value="<?php echo $array[19];?>">
			<input type="submit" name="button10" class="button" value="View Details">
			</div>
            <p>Lost? <a href="admin.php">Go back</a>.</p>
        </form>
    </div>    
</body>
</html>