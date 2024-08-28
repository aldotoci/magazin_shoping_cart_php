<?php
session_start();
include 'db.php';


// Assuming you have a function to fetch details of a specific magazine based on its ID
function getMagazineDetails($magazineId) {
    global $conn;

    $query = "SELECT * FROM magazines WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $magazineId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}



// Get magazine ID from the URL
$magazineId = isset($_GET['magazine_id']) ? $_GET['magazine_id'] : null;

// Redirect if no magazine ID is provided
if (!$magazineId) {
    header("Location: /home.php");
    exit();
}

// Fetch magazine details
$magazineDetails = getMagazineDetails($magazineId);

// Redirect if the magazine ID is invalid or not found
if (!$magazineDetails) {
    header("Location: /home.php");
    exit();
}

function addToCart($magazineId, $magazineName, $quantity, $price) {
    global $conn;

    // Check if the cart session variable exists, initialize if not
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the magazine is already in the cart
    $cartItemKey = array_search($magazineId, array_column($_SESSION['cart'], 'magazine_id'));

    if ($cartItemKey !== false) {
        // Update quantity if the magazine is already in the cart
        $_SESSION['cart'][$cartItemKey]['quantity'] += $quantity;
    } else {
        // Add the magazine to the cart if not already present
        $_SESSION['cart'][] = [
            'magazine_id' => $magazineId,
            'magazine_name' => $magazineName,
            'quantity' => $quantity,
            'price' => $price,
        ];
    }

    // Check if the user is authenticated
    if (!isset($_SESSION['user_id'])) {
        return; // Do not proceed if the user is not authenticated
    }

    // Get user ID from the session
    $userId = $_SESSION['user_id'];

    // Insert or update the order item in the order_items table
    $insertOrderItemQuery = "INSERT INTO order_items (user_id, magazine_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertOrderItemQuery);

    if ($stmt === false) {
        die("Error in preparing statement: " . $conn->error);
    }

    $stmt->bind_param("iiid", $userId, $magazineId, $quantity, $price);

    if ($stmt->execute() === false) {
        die("Error in executing statement: " . $stmt->error);
    }

    $stmt->close();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = $_POST['quantity'];

    // Assuming you have a function to add the magazine to the shopping cart
    addToCart($magazineDetails['id'], $magazineDetails['magazine_name'], $quantity, $magazineDetails['price']);

    // Redirect to the shopping cart or any other page
    header("Location: /checkout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $magazineDetails['magazine_name']; ?></title>
    <link rel="stylesheet" href="./styles/global.css">
</head>
<body>
    <!-- Include common navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Magazine Details -->
    <div>
        <h1><?php echo $magazineDetails['magazine_name']; ?></h1>
        <img width="200" height="400" src="<?php echo $magazineDetails['image_url']; ?>" alt="<?php echo $magazineDetails['magazine_name']; ?>" style="max-width: 100%; height: auto;">
        
        <p>Category: <?php echo $magazineDetails['category']; ?></p>
        <p>Language: <?php echo $magazineDetails['language']; ?></p>
        <p>Quantity: <?php echo $magazineDetails['quantity']; ?></p>
        <p>Price: $<?php echo $magazineDetails['price']; ?></p>

        <!-- Form to order the magazine -->
        <form method="post" action="/magazine.php?magazine_id=<?php echo $magazineDetails['id']; ?>">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" value="1" required>
            <button type="submit">Add to Cart</button>
        </form>
    </div>

    <!-- Footer -->
    <!-- Include your common footer code here -->
</body>
</html>


