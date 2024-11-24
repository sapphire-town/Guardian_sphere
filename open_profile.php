<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $servername = "localhost";
    $database = "user_logs";
    $username = "root";
    $password = "";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        // Check if Email is received from the login page
        if(isset($_POST['email'])) {
            $EMAIL = $_POST['email'];

            // Prepare SQL query
            $sql = "SELECT * FROM emergency e 
                    JOIN profile p ON e.email = p.email
                    WHERE e.email = ?";

            // Prepare statement
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $conn->error);
            }

            // Bind parameters
            $stmt->bind_param("s", $EMAIL);

            // Execute statement
            $stmt->execute();

            // Get result
            $result = $stmt->get_result();

            // Check if the query executed successfully
            if ($result) {
                // Get the number of rows returned
                $num = $result->num_rows;
                echo "<br>";

                // Display user profile if data is found
                if ($num > 0) {
                    $row = $result->fetch_assoc();
                    // Debugging output
                    
                  
                    // Include the HTML template
                    include 'template_profile.html';
                } else {
                    echo "User not found";
                }
            } else {
                echo "Error executing the query: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        } else {
            echo "Email not received from the login page";
        }
    }

    // Close connection
    $conn->close();
} else {
    echo "Form is not submitted.";
}
?>
