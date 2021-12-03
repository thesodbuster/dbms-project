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

switch($_SESSION["privilege"]) {
	case 2 : $back = "superadmin.php";
	break;
	case 1 : $back = "admin.php";
	break;
	case 0 : $back = "welcome.php";
}

if(isset($_POST['delete'])) {
	$order_id = mysqli_real_escape_string($link, $_POST['delete']);
	$deleteBooks = "DELETE FROM users.book WHERE order_id='$order_id';";
	$deleteOrder = "DELETE FROM users.order WHERE order_id='$order_id';";

	if (mysqli_query($link, $deleteBooks) && mysqli_query($link, $deleteOrder)) {
		$show_alert = true;
        $success = true;
		$successMsg = "Order deleted successfully";
	}
	else {
		$show_alert = true;
        $success = false;
		$errorMsg = "Could not delete order. Please try again later.";
	}
}

if(isset($_POST['edit'])) {
	$_SESSION['order_id'] = mysqli_real_escape_string($link, $_POST['edit']);

	header("location: editorder.php");
}

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
		.button{ width: 100px;}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>View Book Orders</h2>
        <p>Please select a semester to view</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="form-group">
                <label>Semester:</label>
                <select name="semester" class="form-select">
                    <option selected disabled>Select..</option>
					<option value="Summer 21" <?php echo ((isset($_POST['semester']) && $_POST['semester'] === 'Summer 21') 
						|| (isset($_SESSION['semester']) && $_SESSION['semester'] === 'Summer 21')) ? 'selected' : ''; ?>>Summer 21
					</option>
					<option value="Fall 21" <?php echo ((isset($_POST['semester']) && $_POST['semester'] === 'Fall 21') 
						|| (isset($_SESSION['semester']) && $_SESSION['semester'] === 'Fall 21')) ? 'selected' : ''; ?>>Fall 21
					</option>
					<option value="Spring 22" <?php echo ((isset($_POST['semester']) && $_POST['semester'] === 'Spring 22') 
						|| (isset($_SESSION['semester']) && $_SESSION['semester'] === 'Spring 22')) ? 'selected' : ''; ?>>Spring 22
					</option>
                </select>
				<input type="submit" name='submit' class="btn btn-sm btn-primary" value="Submit">
            </div>
        </form>
		<?php if ($show_alert && $success)
			echo "<div class='alert alert-success alert-dismissible' role='alert'> {$successMsg} </div>";
			else if ($show_alert && !$success)
			echo "<div class='alert alert-danger alert-dismissible' role='alert'> {$errorMsg} </div>";
        ?>
		<?php
			if(isset($_POST['submit'])) {

				$_SESSION['semester'] = mysqli_real_escape_string($link, $_POST['semester']);
				$faculty_id = $_SESSION['id'];
				$semester = mysqli_real_escape_string($link, $_POST['semester']);

				if($_SESSION["privilege"] == 0) {
					$getOrders = "SELECT order_id FROM users.order WHERE faculty_id = '$faculty_id' AND semester = '$semester'";
				}
				else {
					$getOrders = "SELECT name, order_id FROM users.user a INNER JOIN users.order b ON a.id = b.faculty_id WHERE semester='$semester'";
				}

				$orders = mysqli_query($link, $getOrders);

				if ($orders) {				
					while($data = mysqli_fetch_array($orders)) {
						$currentOrder = $data['order_id'];
						$getBooks = "SELECT * FROM users.book WHERE order_id = '$currentOrder'";
						$books = mysqli_query($link, $getBooks);
						?>
							<h5><?php echo $data['order_id']; ?></h5>
							<?php if($_SESSION["privilege"] == 1){?> <h5>Ordered By: <?php echo $data['name']; }?></h5>
						<?php
						while($data2 = mysqli_fetch_array($books)) {
						?>
							<tr>
								<b>Title:</b> <?php echo $data2['title']; ?></br>
								<b>Author:</b> <?php echo $data2['authors']; ?></br>
								<b>Publisher:</b> <?php echo $data2['publisher']; ?></br>
								<b>Edition</b> <?php echo $data2['edition']; ?></br>
								<b>ISBN:</b> <?php echo $data2['ISBN']; ?></br></br>
							</tr>
					<?php
						}
						if($_SESSION["privilege"] == 0) {
					?>
						<form method="POST">
							<button type="submit" name='edit' class="btn btn-sm btn-info" value="<?php echo $data['order_id'];?>"> Edit Order </button>
							<button type="submit" name='delete' class="btn btn-sm btn-danger" value="<?php echo $data['order_id'];?>"> Delete Order </button>
							</br>
						</form>
					<?php
						}
					?>
					</br>
					<?php
					}
					if (mysqli_num_rows($orders) == 0) {?>
						<h3> No orders found.</h3>
					<?php
					}
				}
				else { ?>
					<h3> Error trying to retrieve orders. Please try again.</h3>
				<?php
				}
			}
		?>
		<a href="<?php echo $back?>">< Go back</a>
    </div>    
</body>
</html>