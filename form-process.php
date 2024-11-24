<?php
$Username = $_POST["Username"];
$Password = $_POST["Password"];
$Contact = $_POST["Contact"];
$terms = isset($_POST["terms"]) ? 1 : 0; // Converting checkbox value to integer for storage

// Validating Contact
if (!filter_var($Contact, FILTER_VALIDATE_INT)) {
    die("Contact must be a valid integer.");
}

// Validating terms
if (!$terms) {
    die("Terms must be accepted.");
}

$host = "localhost";
$dbname = "user_logs";
$username = "root";
$password = "";
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO login (username, password, contact, terms) VALUES (?, ?, ?, ?)";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    die("SQL error: " . mysqli_error($conn));
}

// Binding parameters
mysqli_stmt_bind_param($stmt, "ssii", $Username, $Password, $Contact, $terms);

// Execute the statement
if (mysqli_stmt_execute($stmt)) {
    echo "Record saved successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
