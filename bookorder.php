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
$title = $title_err = "";
$names = $names_err = "";
$edition = $edition_err = "";
$publisher = $publisher_err = "";
$isbn = $isbn_err = "";

# When form is submitted perform the following tasks
if($_SERVER["REQUEST_METHOD"] == "POST"){
// Prepare a select statement
$sql = "SELECT * FROM books WHERE bookid = ?";
        
# Make sure a book order has not already been made this semester
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_name);
    
    // Set parameters
    $param_name = trim($_SESSION["id"]);
    
    #Check if an order has already been made on this account
    if(mysqli_stmt_execute($stmt)){
        /* store result */
        mysqli_stmt_store_result($stmt);
        
        if(mysqli_stmt_num_rows($stmt) == 1){
            $isbn_err = "This account has already ordered this semester";
        } else{
            $isbn = trim($_POST["isbn"]);
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
    // Close statement
    mysqli_stmt_close($stmt);
}

# Check for empty fields
if(empty(trim($_POST["title"]))){
    $title_err = "Please enter a title";
} else {
    $title = $_POST["title"];
}
if(empty(trim($_POST["names"]))){
    $names_err = "Please enter an author name";
} else {
    $names = $_POST["names"];
}
if(empty(trim($_POST["edition"]))){
    $edition_err = "Please enter an Edition";
} else {
    $edition = $_POST["edition"];
}
if(empty(trim($_POST["publisher"]))){
    $publisher_err = "Please enter a Publisher";
} else {
    $publisher = $_POST["publisher"];
}
if(empty(trim($_POST["isbn"]))){
    $isbn_err = "Please enter an ISBN";
} else {
    $isbn = $_POST["isbn"];
}

# Submit an insertion query for a new book
if(empty($name_err) && empty($password_err) && empty($confirm_password_err)){
        
    // Prepare an insert statement
    $sql = "INSERT INTO books (bookid, title, authors, edition, publisher, isbn) VALUES (?, ?, ?, ?, ?, ?)";
     
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "issssi", $param_bookid, $param_title, $param_authors, $param_edition, $param_publisher, $param_isbn);
        
        // Set parameters
        $param_bookid = $_SESSION["id"];
        $param_title = $title;
        $param_authors = $names;
        $param_edition = $edition;
        $param_publisher = $publisher;
        $param_isbn = $isbn;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            echo "Success! Book Order submitted";
            header("location: welcome.php");
        } else{
            echo "There was an error submitting your order";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}



}


?>



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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                <span class="invalid-feedback"><?php echo $title_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Author names</label>
                <input type="text" name="names" class="form-control <?php echo (!empty($names_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $names; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Edition</label>
                <input type="text" name="edition" class="form-control <?php echo (!empty($edition_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $edition; ?>">
                <span class="invalid-feedback"><?php echo $edition_err; ?></span>
            </div>
            <div class="form-group">
                <label>Publisher</label>
                <input type="text" name="publisher" class="form-control <?php echo (!empty($publisher_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $publisher; ?>">
                <span class="invalid-feedback"><?php echo $publisher_err; ?></span>
            </div>
            <div class="form-group">
                <label>ISBN</label>
                <input type="text" name="isbn" class="form-control <?php echo (!empty($isbn_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $isbn; ?>">
                <span class="invalid-feedback"><?php echo $isbn_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Lost? <a href="welcome.php">Go back</a>.</p>
        </form>
    </div>    
</body>
</html>