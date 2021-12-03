<?php
error_reporting(E_ALL ^ E_WARNING); 

# Session verification
session_start();
require_once "config.php";

# Check if the user is logged in, if not then redirect them to login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}


$order_id = $_SESSION["order_id"];
$semester = $_SESSION["semester"];

$success = false;
$show_alert = false;

if(isset($_POST['delete'])) {
	$ISBN = mysqli_real_escape_string($link, $_POST['delete']);
	$deleteBook = "DELETE FROM users.book WHERE ISBN='$ISBN';";

	if (mysqli_query($link, $deleteBook)) {
		$show_alert = true;
        $success = true;
		$successMsg = "Book deleted successfully";
	}
	else {
		$show_alert = true;
        $success = false;
		$errorMsg = "Could not delete book. Please try again later.";
	}
}

if(isset($_POST['add'])) {
	$_SESSION["editOrder"] = true;
	header("location: bookorder.php");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Books</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; margin: auto;}
		.title{ width: 500px; padding: 20px; margin: auto;}
		.button{ width: 250px; margin-left: 30px; }
    </style>
</head>
<body>
    <div class="title">
		<h2>Edit Order: <?php echo $order_id; ?></h2>
		<div class="wrapper">
			<?php
				$getBooks = "SELECT * FROM users.book WHERE order_id = '$order_id'";
				$books = mysqli_query($link, $getBooks);

				while($data = mysqli_fetch_array($books)) {
				?>
					<tr>
						<b>Title:</b> <?php echo $data['title']; ?></br>
						<b>Author:</b> <?php echo $data['authors']; ?></br>
						<b>Publisher:</b> <?php echo $data['publisher']; ?></br>
						<b>Edition</b> <?php echo $data['edition']; ?></br>
						<b>ISBN:</b> <?php echo $data['ISBN']; ?></br>
					</tr>
					<form method="POST">
						</br>
						<button type="submit" name='delete' class="btn btn-sm btn-danger" value="<?php echo $data['ISBN'];?>"> Delete Book </button>
						</br></br>
					</form>
				<?php
				}
			?>
			<form method="POST">
				<hr/>
				<button type="submit" name='add' class=" button btn btn-sm btn-primary"> Add Books </button>
				</br></br>
			</form>
			<a href="vieworders.php">< Go back</a>
			<?php if ($show_alert && $success)
                echo "<div class='alert alert-success alert-dismissible' role='alert'> {$successMsg} </div>";
                else if ($show_alert && !$success)
                echo "<div class='alert alert-danger alert-dismissible' role='alert'> {$errorMsg} </div>";
            ?>
		</div>
		<div class="wrapper">
</body>

</html>