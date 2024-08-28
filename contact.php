<?php
// contact.php
session_start();
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
// $categoryFilter = mysqli_real_escape_string($conn, $categoryFilter);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" type="text/css" href="/styles/global.css">
    <link rel="stylesheet" type="text/css" href="/styles/contact.css">
    <link rel="stylesheet" href="./styles/index.css">

</head>
<body>
    <!-- Include common navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Contact Form -->
    <div class="contact-container">
        <h2>Contact Us</h2>
        <form action="/send_message.php" method="post">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required>

            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required>

            <label for="phoneNumber">Phone Number:</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <button type="submit">Submit</button>
        </form>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
