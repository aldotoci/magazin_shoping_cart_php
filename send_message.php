<?php
// send_message.php


// This snippet is used to send an email to the website owner when a user submits the contact form
// As of right it does not actually send an email, but it will redirect to the contact page with a success or failure message
// This might be used if you actually want to send an email to the website owner
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = test_input($_POST["firstName"]);
    $lastName = test_input($_POST["lastName"]);
    $phoneNumber = test_input($_POST["phoneNumber"]);
    $email = test_input($_POST["email"]);
    $message = test_input($_POST["message"]);

    // Construct email message
    $subject = "New Contact Form Submission";
    $body = "First Name: $firstName\n";
    $body .= "Last Name: $lastName\n";
    $body .= "Phone Number: $phoneNumber\n";
    $body .= "Email: $email\n\n";
    $body .= "Message:\n$message";

    $to = "your@example.com"; 
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        // Email sent successfully
        header("Location: /contact.php?success=true");
        exit();
    } else {
        // Error sending email
        header("Location: /contact.php?success=false");
        exit();
    }
} else {
    // Invalid request method
    header("Location: /contact.php");
    exit();
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
