<?php
$role = $_POST['role'];
$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$age = $_POST['age'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$location = $_POST['location'];
// Function to insert form data into the database
function insertFormData($role, $name, $email, $mobile, $age, $password, $confirm_password, $location) {
    // Database connection parameters
    $servername = "localhost"; // Change this to your database server
    $db_username = "root"; // Change this to your database username
    $db_password = ""; // Change this to your database password
    $dbname = "signup_db"; // Change this to your database name

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if user with same mobile number already exists
    $check_query = "SELECT * FROM users WHERE mobile = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $mobile);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    if ($result->num_rows > 0) {
        echo "User with mobile number $mobile already exists";
        $check_stmt->close();
        $conn->close();
        return;
    }
    $check_stmt->close();

    // Prepare SQL statement
    $insert_query = "INSERT INTO users (role, name, email, mobile, age, password, location) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    // Bind parameters
    $insert_stmt->bind_param("sssssss", $role, $name, $email, $mobile, $age, $password, $location);

    // Execute statement
    if ($insert_stmt->execute() === TRUE) {
        echo "New record inserted successfully";
    } else {
        echo "Error: " . $insert_stmt->error;
    }

    // Close statement and connection
    $insert_stmt->close();
    $conn->close();
}

// Call the function to insert data
insertFormData($role, $name, $email, $mobile, $age, $password, $confirm_password, $location);
?>
