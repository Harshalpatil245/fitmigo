<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Basic input sanitization
    $name    = htmlspecialchars(trim($_POST["name"] ?? ''));
    $email   = htmlspecialchars(trim($_POST["email"] ?? ''));
    $phone   = htmlspecialchars(trim($_POST["phone"] ?? ''));
    $message = htmlspecialchars(trim($_POST["message"] ?? ''));

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        echo "Please fill in all required fields.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Mail setup
    $to      = "contact@fitmigo.com"; // change this to your email
    $subject = "New Contact Form Submission from $name";
    $body    = "Name: $name\nEmail: $email\nPhone: $phone\nMessage:\n$message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "success";
    } else {
        echo "Failed to send email. Try again later.";
    }
} else {
    // Method not allowed
    header("HTTP/1.1 405 Method Not Allowed");
    echo "Method Not Allowed";
}
?>
