<?php

include('template/header.php');
include('template/content.php');
?>


<?php
if (isset($_POST['submit'])) {

    if (!isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirm_password'], $_POST['ext'], $_POST['room_no'])) {
        die("All fields are required.");
    }

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $ext = trim($_POST['ext']);
    $room_no = trim($_POST['room_no']);

    if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        die("Invalid name format.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("The email address '$email' is considered invalid.");
    }

    $passwordError = "";
    $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

    if ($password !== $confirmPassword) {
        $passwordError .= "Passwords are not the same.\n";
    }
    if (!preg_match($password_pattern, $password)) {
        $passwordError .= "Password must have at least 8 characters with at least 1 uppercase, 1 lowercase, 1 number, and 1 special character.\n";
    }

    if (!empty($passwordError)) {
        die(nl2br($passwordError));
    }

    
    $file = fopen("info.txt", "a");
    if (!$file) {
        die("Error opening file.");
    }

    fwrite($file, "$name\n$email\n$password\n$ext\n$room_no\n");
    fclose($file);

    if (isset($_FILES['Image']) && $_FILES['Image']['error'] == 0) {
        
        $targetFile = 'imgs/'. basename($_FILES['Image']['name']);
        if (move_uploaded_file($_FILES['Image']['tmp_name'], $targetFile)) {
            echo "File uploaded successfully.<br>";
        } else {
            echo "Error uploading file.<br>";
        }
    } else {
        echo "No file uploaded.<br>";
    }

    echo "Registration successful.";
}
?>
