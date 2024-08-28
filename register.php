<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password securely
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];

    // Check if the username or email is already taken
    $checkUsernameQuery = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkUsernameQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Username is already taken.";
    } else {
        $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email is already registered.";
        } else {
            // Insert user into the users table
            $insertUserQuery = "INSERT INTO users (username, password, email, first_name, last_name, phone_number) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertUserQuery);
            $stmt->bind_param("ssssss", $username, $password, $email, $first_name, $last_name, $phone_number);
            $stmt->execute();

            // Redirect to the login page after successful registration
            header("Location: /login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="./styles/register.css">
</head>
<body>
    <!-- Navbar -->
    <!-- Include your common navbar code here -->

    <!-- Registration Form -->
    <div>
        <h1>Register</h1>
        
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="post" action="/register.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="phone_number">Phone Number:</label>
            <input type="tel" id="phone_number" name="phone_number" required>

            <button type="submit">Register</button>
        </form>
    </div>

    <!-- Footer -->
    <!-- Include your common footer code here -->
</body>
</html>
