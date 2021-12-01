<?php
// Session verification
session_start();
require_once "config.php";

//Check if the user is logged in, if not then redirect them to login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$submit_message = "";
$alert_type = "";
$hideAlert = true;

// When form is submitted perform the following tasks
if(isset($_POST['submitOrder'])) {

    $faculty_id = $_SESSION['id'];
    $semester = mysqli_real_escape_string($link, $_POST['semester']);
    $course_id = mysqli_real_escape_string($link, $_POST['course_id']);
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $authors = mysqli_real_escape_string($link, $_POST['authors']);
    $edition = mysqli_real_escape_string($link, $_POST['edition']);
    $publisher = mysqli_real_escape_string($link, $_POST['publisher']);
    $ISBN = mysqli_real_escape_string($link, $_POST['ISBN']);
    
    
    // Submit insertion query for new book
    $insertBook = "INSERT INTO book(ISBN, order_id, title, authors, edition, publisher) VALUES('$ISBN', '$course_id', '$title', '$authors', '$edition', '$publisher')";
    
    //mysqli_query($link, $upsertOrder);
    if(mysqli_query($link, $insertBook)) {
        $submit_message = "Book order added successfully";
        $alert_type = "alert alert-success alert-dismissible";
        $hideAlert = false;

    }

    else {
        $submit_message = "There was an error submitting your order. Please try again";
        $alert_type = "alert alert-danger alert-dismissible";
        $hideAlert = false;
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
                <select name="semester" class="form-select" value="<?php echo $semester; ?>">
                    <option value="0">Fall 21</option>
                    <option value="1">Spring 22</option>
                </select>
            </div>
            <div class="form-group">
                <label>Course ID</label>
                <input required type="text" name="course_id" class="form-control">
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
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Lost? <a href="welcome.php">Go back</a>.</p>
            <div class="<?php echo $alert_type ?>" role="alert">
                <?php echo $submit_message ?>
            </div>
        </form>
    </div>    
</body>
</html>