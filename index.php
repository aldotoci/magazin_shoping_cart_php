<?php
// index.php

session_start();
include 'db.php';

// Fetch the first category from the database
$firstCategoryResult = $conn->query("SELECT DISTINCT category FROM magazines LIMIT 1");
$firstCategory = $firstCategoryResult->fetch_assoc()['category'];

// Fetch featured magazines from the first category
$featuredMagazinesResult = $conn->query("SELECT * FROM magazines WHERE category = '$firstCategory' LIMIT 3");
$featuredMagazines = $featuredMagazinesResult->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magazine Shop</title>
    <link rel="stylesheet" type="text/css" href="./styles/home.css">

</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>Welcome to the Magazine Shop</h1>
        <p>Explore a wide variety of magazines and enjoy reading!</p>
    </header>

    <!-- Call to Action Section -->
    <section class="cta-section">
        <h2>Find Your Favorite Magazines</h2>
        <p>Discover the latest publications across various categories.</p>
        <a href="/home.php">Explore Magazines</a>
    </section>

    <!-- Featured Magazines Section -->
    <section class="featured-section">
        <h2>Featured Magazines in <?php echo $firstCategory; ?></h2>
        <?php
        if (!empty($featuredMagazines)) {
            foreach ($featuredMagazines as $magazine) {
                echo "<div class='featured-magazine'>";
                echo "<img src='{$magazine['image_url']}' alt='{$magazine['magazine_name']}'>";
                echo "<h3>{$magazine['magazine_name']}</h3>";
                echo "<p>Category: {$magazine['category']}</p>";
                echo "<a href='/magazine/{$magazine['id']}'>View Details</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No featured magazines available in this category.</p>";
        }
        ?>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Magazine Shop. All rights reserved.</p>
    </footer>
</body>
</html>
