<?php
if (isset($_POST['submit'])) {

    // Check if all required fields exist
    $required_fields = ['name', 'email', 'password', 'confirm_password', 'ext', 'room_no'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field])) {
            die("All fields are required.");
        }
    }

    // Get & sanitize input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $ext = trim($_POST['ext']);
    $room_no = trim($_POST['room_no']);

    // Name validation
    if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        die("Invalid name format.");
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Password validation
    $passwordError = "";
    $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

    if ($password !== $confirmPassword) {
        $passwordError .= "Passwords do not match.\n";
    }
    if (!preg_match($password_pattern, $password)) {
        $passwordError .= "Password must be at least 8 characters with at least 1 uppercase, 1 lowercase, 1 number, and 1 special character.\n";
    }
    if (!empty($passwordError)) {
        die(nl2br($passwordError));
    }

    // Secure password hashing
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Save user info securely (consider a database instead of a file)
    $file = fopen("info.txt", "a");
    if (!$file) {
        die("Error opening file.");
    }
    fwrite($file, "$name\n$email\n$hashed_password\n$ext\n$room_no\n");
    fclose($file);

    // Handle file upload securely
    if (isset($_FILES['Image']) && $_FILES['Image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['Image']['tmp_name']);

        if (!in_array($file_type, $allowed_types)) {
            die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
        }

        $targetFile = 'imgs/' . basename($_FILES['Image']['name']);
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

// Display information in a table
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            font-size: 18px;
        }
        table, th, td {
            border: 3px solid black;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Review</h2>

    <h4 class="text-center">Please Review Your Information:</h4>

    <table class="table table-striped">
         <tr>
           <th>User</th>
            <th>Address</th>
          <th>Skills</th>
          <th>Department</th>
          <th>Actions</th>
        </tr>
        <tr>
            <td><?= isset($first_name) ? htmlspecialchars($first_name) : 'N/A'; ?> 
                <?= isset($last_name) ? htmlspecialchars($last_name) : ''; ?>
            </td>
            <td><?= isset($address) ? htmlspecialchars($address) : 'N/A'; ?></td>
           <td><?= isset($skills) ? htmlspecialchars(implode(" - ", $skills)) : 'N/A'; ?></td>
          <td>OpenSource</td>
          <td>
              <a href="#">Update</a> | <a href="#">Delete</a>
          </td>
        </tr>
    </table>
</div>

</body>
</html>
