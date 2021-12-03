<?php
error_reporting(E_ALL ^ E_WARNING); 
// Session verification
session_start();
require_once "config.php";

//Check if the user is logged in, if not then redirect them to login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if (isset($_SESSION["semester"]) && isset($_SESSION["order_id"])) {
    $back = "editorder.php";
}
else {
    $back = "welcome.php";
}

$success = false;
$show_alert = false;

// When form is submitted perform the following tasks
if(isset($_POST['submitOrder'])) {

    $faculty_id = $_SESSION['id'];
    $semester = mysqli_real_escape_string($link, $_POST['semester']);
    $order_id = mysqli_real_escape_string($link, $_POST['course_id']);
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $authors = mysqli_real_escape_string($link, $_POST['authors']);
    $edition = mysqli_real_escape_string($link, $_POST['edition']);
    $publisher = mysqli_real_escape_string($link, $_POST['publisher']);
    $ISBN = mysqli_real_escape_string($link, $_POST['ISBN']);
    
    // Submit insertion query for new order if one doesn't already exist
    $insertOrder = "INSERT IGNORE INTO users.order(order_id, faculty_id, semester) VALUES('$order_id', '$faculty_id', '$semester')";
    // Submit insertion query for new book
    $insertBook = "INSERT INTO book(ISBN, order_id, title, authors, edition, publisher) VALUES('$ISBN', '$order_id', '$title', '$authors', '$edition', '$publisher')";
    
    if(mysqli_query($link, $insertOrder) && mysqli_query($link, $insertBook)) {
        $show_alert = true;
        $success = true;

    }
    else {
        $show_alert = true;
        $success = false;
    }
}?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Order Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; margin: auto;}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Book Order</h2>
        <p>Please fill this form to submit a book order</p>
        <form autocomplete="off" method="POST">
            <div class="form-group">
                <label>Semester:</label>
                <select name="semester" class="form-select">
                    <option selected disabled>Select..</option>
                    <option value="Fall 21" <?php echo ((isset($_POST['semester']) && $_POST['semester'] === 'Fall 21') 
                    || isset($_SESSION['semester']) && $_SESSION['semester'] === 'Fall 21') 
                    ? 'selected' : ''; ?>
                    <?php echo (isset($_SESSION['semester']) && $_SESSION['semester'] !== 'Fall 21') ? 'disabled' : ''; ?>
                >Fall 21
                </option>
                    <option value="Spring 22" 
                        <?php echo ((isset($_POST['semester']) && $_POST['semester'] === 'Spring 22') 
                        || isset($_SESSION['semester']) && $_SESSION['semester'] === 'Spring 22') 
                        ? 'selected' : ''; ?>
                        <?php echo (isset($_SESSION['semester']) && $_SESSION['semester'] !== 'Spring 22') ? 'disabled' : ''; ?>
                        >Spring 22
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label>Course ID</label>
                <input required type="text" name="course_id" class="form-control" 
                    value="<?php 
                        if (isset($_POST['course_id'])) echo $_POST['course_id']; 
                        else if (isset($_SESSION['order_id'])) echo $_SESSION['order_id']; 
                    ?>"
                />
            </div>  
            <div class="form-group">
                <label>Title</label>
                <input required type="text" name="title" class="form-control">
            </div>    
            <div class="form-group">
                <label>Author Names</label>
                <input required type="text" name="authors" class="form-control">
            </div>
            <div class="form-group">
                <label>Edition</label>
                <input required type="text" name="edition" class="form-control">
            </div>
            <div class="form-group">
                <label>Publisher</label>
                <input required type="text" name="publisher" class="form-control">
            </div>
            <div class="form-group">
                <label>ISBN</label>
                <input required type="text" name="ISBN" class="form-control">
            </div>
            <div class="form-group">
                <input name= "submitOrder" type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Clear">
            </div>
            <a href="<?php echo $back?>">< Go back</a>
            <?php if ($show_alert && $success)
                echo "<div class='alert alert-success alert-dismissible' role='alert'> Book order added successfully </div>";
                else if ($show_alert && !$success)
                echo "<div class='alert alert-danger alert-dismissible' role='alert'> There was an error submitting your order. Please try again </div>";
            ?>
        </form>
    </div>    
</body>
</html>