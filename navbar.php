<?php
include 'db.php';

?>
<!-- Navbar -->
<nav>
    <ul>
        <li><a href="/home.php">Home</a></li>
        <li><a href="/contact.php">Contact Us</a></li>
        <li><a href="/checkout.php">Check out</a></li>
        <!-- Add Search Bar here -->
        <li>
            <form action="/home.php" method="GET">
                <input type="text" name="search" placeholder="Search magazines...">
                <select id="category" name="category">
                <option name="category" value="">All Categories</option>
                    <?php
                    // Fetch distinct categories from the database
                    $categoriesResult = $conn->query("SELECT DISTINCT category FROM magazines");
                    $categories = $categoriesResult->fetch_all(MYSQLI_ASSOC);

                    foreach ($categories as $category) {
                        // Display each category as an option in the dropdown
                        echo "<option value='{$category['category']}'";
                        echo ($categoryFilter == $category['category']) ? " selected" : "";
                        echo ">{$category['category']}</option>";
                    }
                    ?>
                <input type="submit" value="Search">
            </select>
            </form>
        </li>
        <?php
        if (isset($_SESSION['user_id'])) {
            // Display the username and a link to "Logout"
            echo '<li><button><a style="color: black;" href="/logout.php">Log out</a></button></li>';
        } else {
            // Display "Login" and "Register" links
            echo '<li><button> <a style="color: black;" href="/login.php">Log In</a></button></li>';
            echo '<li><button><a style="color: black;" href="/register.php">Register</a></button></li>';
        }
        ?>
        <!-- <li><button> <a style="color: black;" href="/login.php">Log In</a></button></li>
        <li><button><a style="color: black;" href="/register.php">Register</a></button></li> -->
    </ul>
</nav>