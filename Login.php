<?php
// login.php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "HotelBooking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Prevent SQL injection
    $input_username = stripslashes($input_username);
    $input_password = stripslashes($input_password);
    $input_username = mysqli_real_escape_string($conn, $input_username);
    $input_password = mysqli_real_escape_string($conn, $input_password);

    $sql = "SELECT * FROM Users WHERE username='$input_username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($input_password, $row['password'])) {
            $_SESSION['username'] = $input_username;
            header("Location: dashboard.php"); // Redirect to dashboard
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found.";
    }
}

$conn->close();
?>
