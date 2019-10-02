<?php
    if(isset($_POST['create_user']))
    {
        $username = $_POST['username'];
        $user_password = $_POST['user_password'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];    
        $user_role = $_POST['user_role'];
        $user_date = date('d-m-y');
        
        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
        
        $query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_role, user_date) ";
        $query .= "VALUES('{$username}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$user_role}', now())";
        
        $create_user_query = mysqli_query($connection, $query);
        
        //CUSTOM FUNCTION
        confirm($create_user_query);
        
        $the_user_id = mysqli_insert_id($connection);
        
        echo "<p class='bg-success'>User created. <a href='users.php'>See all users</a></p>";
    }
?>   

<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    
    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    
    <div class="form-group">
        <select name="user_role" id="">
            <option value="subscriber">Select Options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
    
<!--
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>
-->
    
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>
    
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
    </div>
</form>