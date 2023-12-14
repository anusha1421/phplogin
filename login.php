<?php
// Establish database connection
$mysqli = new mysqli("localhost", "roots", "anusujay", "usersdb");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Process login form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Retrieve user data from the database
    $query = "SELECT id, name, email, password FROM users WHERE email = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $email, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            echo "Login successful! Welcome, $name!";
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found. Please register.";
    }

    $stmt->close();
}

$mysqli->close();
?>
