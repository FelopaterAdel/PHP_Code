<?php  
include_once('blogic.php');

$userser = new UserService('localhost', 'useradd', 'felopater', 'Felo6262#');
?>

<div class="container mt-4">
    <h2>Add User</h2>
    <form action="list_user.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Room No.</label>
            <select name="room_no" required>
    <option value="">Select Room</option> 
    <option value="2005">Room 2005</option>
    <option value="2060">Room 2060</option>
    <option value="2070">Room 2070</option>
    <option value="2090">Room 2090</option>
    <option value="2080">Room 2080</option>
v
</select>
        </div>
        <div class="mb-3">
            <label class="form-label">Ext.</label>
            <input type="text" name="ext" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Profile Picture</label>
            <input type="file" name="Image" class="form-control">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Save</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </form>
</div>