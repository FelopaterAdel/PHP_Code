<div class="container mt-4">
        <h2>Add User</h2>
        <form  method="POST" enctype="multipart/form-data">
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
                <input type="text" name="room_no" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ext.</label>
                <input type="text" name="ext" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Profile Picture</label>
                <input type="file" name="profile_picture" class="form-control">
            </div>
            <button type="submit"  name="submit"  class="btn btn-primary">Save</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </form>
    </div>