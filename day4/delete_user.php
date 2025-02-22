<?php 
session_start();

include('blogic.php');

if(isset($_GET['id'])) {
$id =$_GET['id'];
// $request = $_SERVER["REQUEST_METHOD"];
// print_r($request);


$userser = new UserService('localhost', 'useradd', 'felopater', 'Felo6262#');
$userser->deleteUser($id);

echo'
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
<div class="container mt-5">

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
        </tr>';
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
        echo ' </table> </div>
';
    }else {
        echo "No ID provided.";
    }
?>