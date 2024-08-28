<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the credentials match the admin credentials
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['admin'] = true;
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $error_message = 'Invalid credentials. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="./styles/admin_login.css">
</head>
<body>
    <h2>Admin Login</h2>
    <?php
    if (isset($error_message)) {
        echo '<p style="color: red;">' . $error_message . '</p>';
    }
    ?>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
