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
        echo "<style>
        .alert-box {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            padding: 15px;
            margin: 20px auto;
            width: 50%;
            text-align: center;
            font-family: Arial, sans-serif;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .alert-box h2 {
            margin-top: 0;
        }
    </style>";
    echo "<div class='alert-box'>
        <h2>User with mobile number $mobile already exists</h2>
        <p>Please wait while you are being redirected...</p>
    </div>";
    echo "<script>
        setTimeout(function() {
            window.location.href = 'index.html';
        }, 3000); // Redirect after 3 seconds
    </script>";
    ;
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
        echo "<style>
    .success-alert-box {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 4px;
        padding: 15px;
        margin: 20px auto;
        width: 50%;
        text-align: center;
        font-family: Arial, sans-serif;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .success-alert-box h2 {
        margin-top: 0;
    }
</style>";
echo "<div class='success-alert-box'>
    <h2>New record inserted successfully</h2>
    <p>Please wait while you are being redirected...</p>
</div>";
echo "<script>
    setTimeout(function() {
        window.location.href = 'http://localhost/spit_hack_back_end/Sign_In/index.html';
    }, 3000); // Redirect after 3 seconds
</script>";


    } else {
        echo "<script>alert('Error: " . htmlspecialchars($insert_stmt->error) . "');window.location.href = 'index.html';</script>";
    }

    // Close statement and connection
    $insert_stmt->close();
    $conn->close();
}

// Call the function to insert data
insertFormData($role, $name, $email, $mobile, $age, $password, $confirm_password, $location);
?>
