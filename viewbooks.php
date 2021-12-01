<?php
# Session verification
session_start();
require_once "config.php";

# Check if the user is logged in, if not then redirect them to login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}



//echo "we want to look at the books for orderID: ";

$value = $_SESSION["orderID"];
//echo $value;

//echo "  which was ordered by professorID: ";

$profID = $_SESSION["facultyID"];
//echo $profID;

#I literally have no idea how to instantiate an array in php any other way. This is seriously an ungabunga cave man language.
#array size of 50
$array = array_fill(0,50, " ");

$arrayCounter = 0;
#going to perform a query		↓↓↓ BOOK 1  ↓↓↓						↓↓↓  BOOK 2 ↓↓↓
#array will look like this (ISBN, Title, Authors, Edition, Publisher, ISBN, Title, .....)
#attributes of book 1 start on index 0, book 2 on 5, book 3 on 10, on and on and on until book 10

	// Perform query
	
	if ($result = mysqli_query($link, "SELECT ISBN, title, authors, edition, publisher FROM user.books WHERE orderID LIKE '$value'")) {
		while ($row = mysqli_fetch_row($result)) {
			//printf ("%s\n", $row[0]);
			$array[$arrayCounter] = $row[0];
			$arrayCounter = $arrayCounter + 1;
			$array[$arrayCounter] = $row[1];
			$arrayCounter = $arrayCounter + 1;
			$array[$arrayCounter] = $row[2];
			$arrayCounter = $arrayCounter + 1;
			$array[$arrayCounter] = $row[3];
			$arrayCounter = $arrayCounter + 1;
			$array[$arrayCounter] = $row[4];
			//echo $row[1];
			$arrayCounter = $arrayCounter + 1;
			}
  // Free result set
  mysqli_free_result($result);
	}





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Books</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="wrapper">
        <h2>Currently viewing order:  <?php echo $value; ?></h2>
        <p>The full order is shown below</p>
    </div>
	<div>
		<table width = "1000px" border = "1px">
		<tr>
		<td> ISBN</td>
		<td> Title</td>
		<td> Authors</td>
		<td> Edition</td>	
		<td> Publisher</td>
		</tr>
		<tr>
		<td> <?php echo $array[0]; ?></td>
		<td> <?php echo $array[1]; ?></td>
		<td> <?php echo $array[2]; ?></td>
		<td> <?php echo $array[3]; ?></td>	
		<td> <?php echo $array[4]; ?></td>
		</tr>
		<tr>
		<td> <?php echo $array[5]; ?></td>
		<td> <?php echo $array[6]; ?></td>
		<td> <?php echo $array[7]; ?></td>
		<td> <?php echo $array[8]; ?></td>	
		<td> <?php echo $array[9]; ?></td>
		</tr>
		<tr>
		<td> <?php echo $array[10]; ?></td>
		<td> <?php echo $array[11]; ?></td>
		<td> <?php echo $array[12]; ?></td>
		<td> <?php echo $array[13]; ?></td>	
		<td> <?php echo $array[14]; ?></td>
		</tr>
		<tr>
		<td> <?php echo $array[15]; ?></td>
		<td> <?php echo $array[16]; ?></td>
		<td> <?php echo $array[17]; ?></td>
		<td> <?php echo $array[18]; ?></td>	
		<td> <?php echo $array[19]; ?></td>
		</tr>
		<tr>
		<td> <?php echo $array[20]; ?></td>
		<td> <?php echo $array[21]; ?></td>
		<td> <?php echo $array[22]; ?></td>
		<td> <?php echo $array[23]; ?></td>	
		<td> <?php echo $array[24]; ?></td>
		</tr>
		<tr>
		<td> <?php echo $array[25]; ?></td>
		<td> <?php echo $array[26]; ?></td>
		<td> <?php echo $array[27]; ?></td>
		<td> <?php echo $array[28]; ?></td>	
		<td> <?php echo $array[29]; ?></td>
		</tr>
		<tr>
		<td> <?php echo $array[30]; ?></td>
		<td> <?php echo $array[31]; ?></td>
		<td> <?php echo $array[32]; ?></td>
		<td> <?php echo $array[33]; ?></td>	
		<td> <?php echo $array[34]; ?></td>
		</tr>

		<tr>
		<td> <?php echo $array[35]; ?></td>
		<td> <?php echo $array[36]; ?></td>
		<td> <?php echo $array[37]; ?></td>
		<td> <?php echo $array[38]; ?></td>	
		<td> <?php echo $array[39]; ?></td>
		</tr>
		<tr>
		<td> <?php echo $array[40]; ?></td>
		<td> <?php echo $array[41]; ?></td>
		<td> <?php echo $array[42]; ?></td>
		<td> <?php echo $array[43]; ?></td>	
		<td> <?php echo $array[44]; ?></td>
		</tr>
		<tr>
		<td> <?php echo $array[45]; ?></td>
		<td> <?php echo $array[46]; ?></td>
		<td> <?php echo $array[47]; ?></td>
		<td> <?php echo $array[48]; ?></td>	
		<td> <?php echo $array[49]; ?></td>
		</tr>
	</div>
	<div>
	<p>Previous Page: <a href="vieworders.php">Click Here</a>.</p>
	</div>
</body>

</html>