<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user is logged in as admin
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
        header('Location: admin_login.php');
        exit();
    }

    include 'db.php'; // Assuming you have a file to establish a database connection

    $magazineId = $_POST['id'];
    $quantity = $_POST['quantity'];
    $action = $_POST['action']; // 'add' or 'remove'

    // Retrieve current quantity of the magazine
    $getQuantityQuery = "SELECT quantity FROM magazines WHERE id = ?";
    $stmt = $conn->prepare($getQuantityQuery);
    $stmt->bind_param("i", $magazineId);
    $stmt->execute();
    $result = $stmt->get_result();
    $currentQuantity = $result->fetch_assoc()['quantity'];

    // Update quantity based on action
    if ($action === 'add') {
        $newQuantity = $currentQuantity + $quantity;
    } elseif ($action === 'remove') {
        $newQuantity = max(0, $currentQuantity - $quantity); // Ensure quantity doesn't go below 0
    }

    // Update quantity in the database
    $updateQuery = "UPDATE magazines SET quantity = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ii", $newQuantity, $magazineId);
    $stmt->execute();

    // Redirect back to the admin dashboard
    header('Location: admin_dashboard.php');
    exit();
} else {
    // Redirect if the request method is not POST
    header('Location: admin_dashboard.php');
    exit();
}
?>
