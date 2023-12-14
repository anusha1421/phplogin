<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>
<body>

<?php
// Establish database connection
$mysqli = new mysqli("localhost", "roots", "anusujay", "usersdb");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Process registration form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $address = $_POST["address"];
    $phone_number = $_POST["phone_number"];

    // Insert user data into the database
    $query = "INSERT INTO users (name, email, password, address, phone_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssss", $name, $email, $password, $address, $phone_number);
    
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>

<!-- Your HTML button goes here -->
<button onclick="goBack()">Go Back</button>

<script>
    function goBack() {
        window.location.href = 'login.html';
    }
</script>

</body>
</html>
