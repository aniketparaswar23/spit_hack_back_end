<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    // Check if both email and password are provided
   
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Database connection parameters
        $servername = "localhost"; 
        $username = "root"; 
        $password_db = ""; 
        $dbname = "signup_db"; 

        // Create connection
        $conn = new mysqli($servername, $username, $password_db, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement to fetch user details based on email and password
        $sql = "SELECT `role`, `name`, `email`, `mobile`, `age`, `location` FROM `users` WHERE `email` = '$email' AND `password` = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // User found, set user details to session
            $row = $result->fetch_assoc();
            $_SESSION['user_details'] = $row;
            echo($_SESSION);
            // Redirect to a dashboard or another page
            header("Location: http://localhost/spit_hack_back_end/Sign_Up/index.html");
            exit();
        } else {
            

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
            <h2>Invalid email or password.</h2>
            <p>Please wait while you are being redirected...</p>
         </div>";
         echo "<script>
            setTimeout(function() {
            window.location.href = 'index.html';
        }, 3000); // Redirect after 3 seconds
        </script>";

        }

        // Close connection
        $conn->close();
    }



?>