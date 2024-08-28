<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user from the users table based on the entered username
    $getUserQuery = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($getUserQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the entered password against the hashed password in the database
        if (password_verify($password, $user['password'])) {
            // Set user_id in the session to indicate successful authentication
            $_SESSION['user_id'] = $user['id'];

            // Redirect to the home page or any other authenticated page
            header("Location: /home.php");
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "Invalid username";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./styles/login.css">
</head>
<body>
    <!-- Navbar -->
    <!-- Include your common navbar code here -->

    <!-- Login Form -->
    <div>
        <h1>Login</h1>
        
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="post" action="/login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>

    <!-- Footer -->
    <!-- Include your common footer code here -->
</body>
</html>


