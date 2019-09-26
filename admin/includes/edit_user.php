<?php

    if(isset($_GET['u_id']))
    {
        $the_user_id = $_GET['u_id'];
    }

    $query = "SELECT * FROM users WHERE user_id = {$the_user_id}";
    $select_users_by_id = mysqli_query($connection, $query);

    confirm($select_users_by_id);

    while($row = mysqli_fetch_assoc($select_users_by_id))
    {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];
        $user_date = $row['user_date'];
    }

    if(isset($_POST['update_user']))
    {
        $username = $_POST['username'];
        $user_password = $_POST['user_password'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_role = $_POST['user_role'];
        
//        move_uploaded_file($post_image_temp, "../images/{$post_image}");
        
//        if(empty($post_image))
//        {
//            $query = "SELECT * FROM posts WHERE post_id = {$the_post_id}";
//            $select_image = mysqli_query($connection, $query);
//            
//            while($row = mysqli_fetch_array($select_image))
//            {
//                $post_image = $row['post_image'];
//            }
//        }
        
        $query = "UPDATE users SET ";
        $query .= "username = '{$username}', ";
        $query .= "user_password = '{$user_password}', ";
        $query .= "user_firstname ='{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "user_date = now() ";
        $query .= "WHERE user_id = '{$the_user_id}' ";
        
        $update_user = mysqli_query($connection, $query);

        confirm($update_user);
    }

?>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class="form-control" value="<?php echo $user_firstname; ?>" name="user_firstname">
    </div>
    
    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" value="<?php echo $user_lastname; ?>" name="user_lastname">
    </div>
    
    <div class="form-group">
        <select name="user_role" id="">
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
             
            <?php
                if($user_role == 'admin')
                {
                    echo "<option value='subscriber'>subscriber</option>";
                }
                else
                {
                    echo "<option value='admin'>admin</option>";
                }
            ?>
           
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
        <input type="text" class="form-control" value="<?php echo $username; ?>" name="username">
    </div>
    
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" value="<?php echo $user_email; ?>" name="user_email">
    </div>
    
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" value="<?php echo $user_password; ?>" name="user_password">
    </div>
    
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
    </div>
</form>