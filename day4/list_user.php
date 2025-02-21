<?php
include_once('blogic.php');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$userser = new UserService('localhost', 'useradd', 'felopater', 'Felo6262#');
$errors = [];
$name = $email = $room_no = $ext = $image = '';

if (isset($_POST['submit'])) {
    $required_fields = ['name', 'email', 'password', 'confirm_password', 'ext', 'room_no'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = "All fields are required.";
            break;
        }
    }

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $ext = trim($_POST['ext']);
    $room_no = trim($_POST['room_no']);

    if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        $errors[] = "Invalid name format. Only letters and spaces are allowed.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    if (!preg_match($password_pattern, $password)) {
        $errors[] = "Password must be at least 8 characters with at least 1 uppercase, 1 lowercase, 1 number, and 1 special character.";
    }

    if (isset($_FILES['Image']) && $_FILES['Image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['Image']['tmp_name']);

        if (!in_array($file_type, $allowed_types)) {
            $errors[] = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        } else {
            $file_extension = pathinfo($_FILES['Image']['name'], PATHINFO_EXTENSION);
            $unique_filename = uniqid() . '.' . $file_extension;
            $image_path = 'imgs/' . $unique_filename;

            if (!is_dir('imgs')) {
                mkdir('imgs', 0755, true);
            }

            if (!move_uploaded_file($_FILES['Image']['tmp_name'], $image_path)) {
                $errors[] = "Error uploading file.";
            }
        }
    } else {
        $errors[] = "No file uploaded.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $adduser = $userser->insertUser($name, $email, $hashed_password, $ext, $room_no, $image_path);

        if ($adduser) {
            echo "Registration successful.";
        } else {
            $errors[] = "Error registering user.";
        }
    }
}
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
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container mt-5">
<?php
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='error'>$error</div>";
        }
    }else {
    ?>
    <h2 class="text-center">Review</h2>
    <h4 class="text-center">Please Review Your Information:</h4>
  
    <table class="table table-striped">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Room No</th>
            <th>Ext</th>
            <th>Profile Picture</th>
            <th>Actions</th>
        </tr>
        <?php
        $alluser = $userser->getAllUser();
        if ($alluser === false) {
            echo "<tr><td colspan='6' class='error'>Error fetching users. Please try again later.</td></tr>";
        } else {
            foreach ($alluser as $user) {
                echo '
                <tr>
                    <td>' . htmlspecialchars($user['name']) . '</td>
                    <td>' . htmlspecialchars($user['email']) . '</td>
                    <td>' . htmlspecialchars($user['room_no']) . '</td>
                    <td>' . htmlspecialchars($user['ext']) . '</td>
                    <td><img src="'. htmlspecialchars($user['image_path']) . '" width="100" height="100"></td>
                    <td>
                        <a href="update_user.php?id=' . htmlspecialchars($user['id']) . '">Update</a> |
                        <a href="delete_user.php?id=' . htmlspecialchars($user['id']) . '">Delete</a>
                    </td>
                </tr>';
            }
        }
        ?>
    </table>
</div>
</body>
</html>

<?php }?>