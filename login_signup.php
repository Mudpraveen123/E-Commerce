<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Login form submission
    if (isset($_POST['login'])) {
        $login_username = $_POST['login-username'];
        $login_password = $_POST['login-password'];

        $sql = "SELECT * FROM users WHERE username='$login_username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($login_password, $row['password'])) {
                session_start();
                $_SESSION['username'] = $login_username;
                echo "Login successful";
            } else {
                echo "Invalid password";
            }
        } else {
            echo "No user found";
        }
    }

    // Signup form submission
    if (isset($_POST['signup'])) {
        $signup_username = $_POST['signup-username'];
        $signup_email = $_POST['signup-email'];
        $signup_password = password_hash($_POST['signup-password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES ('$signup_username', '$signup_email', '$signup_password')";

        if ($conn->query($sql) === TRUE) {
            echo "Signup successful";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
