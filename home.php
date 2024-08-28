<?php
session_start();
include 'db.php';

if (isset($_GET['search'])) {
    $searchQuery = '%' . $_GET['search'] . '%';
    $searchQuery = mysqli_real_escape_string($conn, $searchQuery);
    $categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
    $categoryFilter = mysqli_real_escape_string($conn, $categoryFilter);

    $searchMagazinesQuery = "SELECT * FROM magazines WHERE magazine_name LIKE ? AND category LIKE ?";
    $stmt = $conn->prepare($searchMagazinesQuery);

    if ($stmt === false) {
        die("Error in preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ss", $searchQuery, $categoryFilter);

    if ($stmt->execute() === false) {
        die("Error in executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $magazines = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
} else {
    // Fetch all magazines if no search query
    $categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
    $categoryFilter = mysqli_real_escape_string($conn, $categoryFilter);

    if (!empty($categoryFilter)) {
        // Filter by category if a category is selected
        $result = $conn->query("SELECT * FROM magazines WHERE category = '$categoryFilter'");
    } else {
        // Fetch all magazines if no category is selected
        $result = $conn->query("SELECT * FROM magazines");
    }

    $magazines = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magazine Shop</title>
    <link rel="stylesheet" href="./styles/global.css">
    <link rel="stylesheet" href="./styles/index.css">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php' ?>

    <!-- Magazine Listings -->
    <div>
        <h1>Magazine Listings</h1>
        <div class="magazinesContainer">
            <?php foreach ($magazines as $magazine): ?>
                <div class="magazineContainer">
                    <div class="imgContainer">
                        <img width="200" height="500" src="<?php echo $magazine['image_url']; ?>" alt="<?php echo $magazine['magazine_name']; ?>" style="max-width: 100%; height: auto;">
                    </div>
                    <h3><?php echo $magazine['magazine_name']; ?></h3>
                    <p>Category: <?php echo $magazine['category']; ?></p>
                    <p>Language: <?php echo $magazine['language']; ?></p>
                    <p>Quantity: <?php echo $magazine['quantity']; ?></p>
                    <p>Price: $<?php echo $magazine['price']; ?></p>
                    <a href="/magazine.php?magazine_id=<?php echo $magazine['id']; ?>">View Details</a>
                </div>            
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div>
            <span>1</span> <!-- Add more page numbers as needed -->
        </div>
    </div>
</body>
</html>


<!-- CREATE TABLE magazines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    magazine_name VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL,
    language VARCHAR(50) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL
); -->

<!-- CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255), -- Use a secure hash function like bcrypt in a real application
    email VARCHAR(100) UNIQUE,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    phone_number VARCHAR(20),
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); -->

<!-- CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    total_price DECIMAL(10, 2),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    magazine_name VARCHAR(255),
    quantity INT,
    price DECIMAL(10, 2)
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    user_id INT, -- Added user_id column
    magazine_id INT,
    quantity INT,
    price DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (user_id) REFERENCES users(id), -- Assuming a users table for user information
    FOREIGN KEY (magazine_id) REFERENCES magazines(id)
); 






-->