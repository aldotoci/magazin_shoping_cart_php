<!-- admin_add_magazine.php -->

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user is logged in as admin
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
        header('Location: admin_login.php');
        exit();
    }

    include 'db.php'; // Assuming you have a file to establish a database connection

    // Retrieve form data
    $magazineName = $_POST['magazine_name'];
    $category = $_POST['category'];
    $language = $_POST['language'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $imageUrl = $_POST['image_url'];

    // Insert the new magazine into the database
    $insertQuery = "INSERT INTO magazines (magazine_name, category, language, quantity, price, image_url) 
                    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssiis", $magazineName, $category, $language, $quantity, $price, $imageUrl);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the admin dashboard
    header('Location: admin_dashboard.php');
    exit();
} else {
    // Redirect to the dashboard if the request method is not POST
    header('Location: admin_dashboard.php');
    exit();
}
?>
