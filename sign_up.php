<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "user_logs";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Function to validate and sanitize input
    function validateInput($input) {
        return htmlspecialchars(trim($input));
    }

    // Validate and sanitize the input data
    $name = validateInput($_POST["Name"] ?? "");
    $contact = validateInput($_POST["Contact"] ?? "");
    $aadhar = validateInput($_POST["Aadhar"] ?? "");
    $email = validateInput($_POST["email"] ?? "");
    $age = validateInput($_POST["age"] ?? "");
    // Assuming $profile_photo_path is the path to the uploaded file
    $profile_photo_path = validateInput($_POST["profile"] ?? "");

    $father_name = validateInput($_POST["Father_Name"] ?? "");
    $father_no = validateInput($_POST["Father_No"] ?? "");
    $mother_name = validateInput($_POST["Mother_Name"] ?? "");
    $mother_no = validateInput($_POST["Mother_No"] ?? "");

    $emergency_contact = validateInput($_POST["Emergency_Contact"] ?? "");
    $address = validateInput($_POST["address"] ?? "");
    $blood_group = validateInput($_POST["Blood_group"] ?? "");

    // Insert data into emergency table using prepared statements
    $emergency_sql = "INSERT INTO emergency (emergency_no, father_name, father_no, mother_name, mother_no, email, contact, blood_group, age)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($emergency_sql);
    $stmt->bind_param("ssssssssi", $emergency_contact, $father_name, $father_no, $mother_name, $mother_no, $email, $contact, $blood_group, $age);
    
    if ($stmt->execute()) {
        $emergency_id = $stmt->insert_id;

        // Insert data into profile table using prepared statements
        $profile_sql = "INSERT INTO profile (name, photo, aadhar, contact, address, email)
                        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($profile_sql);
        $stmt->bind_param("ssssss", $name, $profile_photo_path, $aadhar, $contact, $address, $email);
        
        if ($stmt->execute()) {
            echo "<script>alert('Account created');</script>";
            header("Location: fs.html");
            exit;
        } else {
            echo "Error: " . $profile_sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $emergency_sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
