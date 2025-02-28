<?php
session_start();
include('blogic.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



$userobj=new UserService();
//$dataobj = new Database();

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $ext = trim($_POST['ext']);
    $room_no = trim($_POST['room_no']);



    if (isset($_FILES['Image']) && $_FILES['Image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['Image']['tmp_name']);

        if (!in_array($file_type, $allowed_types)) {
            $errors[] = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        } else {
            $file_extension = pathinfo($_FILES['Image']['name'], PATHINFO_EXTENSION);
            $unique_filename = uniqid() . '.' . $file_extension;
            $image_path = 'imgs/' . $unique_filename;

            
            if (!move_uploaded_file($_FILES['Image']['tmp_name'], $image_path)) {
                $errors[] = "Error uploading file.";
            }
        }
    } else {
        $image_path = "imgs/default.jpg"; 
    }



   // $condition = "id = $id";

    $columns =['name','email','room_no','ext','image_path'];

    $values =[$name,$email,$ext,$room_no,$image_path];

   $userobj->updateUser($id,$columns,$values);


    //$dataobj->UPDATE('user',$columns,$values,$condition);

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
            text-align: center;
        }
        .success {
            color: green;
            font-weight: bold;
            text-align: center;
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
    }

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
        $alluser = $userobj->getAllUser();
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
