<?php 
session_start();
include('blogic.php');
include('template/header.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];

$userobj=new UserService();
  $user =$userobj->getUserById($id);
  var_dump($user);
 $name =array_column($user,'name');
 $email =array_column($user,'email');
 $ext =array_column($user,'ext');
 $room_no =array_column($user,'room_no');

      // print( $name[0]);
    echo '
    <div class="container mt-4">
        <h2>Update User '. $name[0] . '</h2>

        <form action="updated.php?id=' . $id . '" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Name</label>
               <input type="text" name="name" class="form-control" value='. $name[0] . '>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value =' . $email[0] .'>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Room No.</label>
                <select name="room_no"  required>
                    <option value="'. $room_no[0] .'">Room '. $room_no[0] .'</option> 
                    <option value="2005">Room 2005</option>
                    <option value="2060">Room 2060</option>
                    <option value="2070">Room 2070</option>
                    <option value="2090">Room 2090</option>
                    <option value="2080">Room 2080</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Ext.</label>
                <input type="text" name="ext" value="' . $ext[0] .'" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Profile Picture</label>
                <input type="file" name="Image" class="form-control">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </form>
    </div>';

    
}


?>
