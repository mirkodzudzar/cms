<?php include "includes/header.php"; ?>

<?php
if(isset($_SESSION['user_role']))
{
    if($_SESSION['user_role'] == 'admin')
    {
        header("Location: admin/profile.php");
    }
    else
    {
?>
   
<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome,
                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>
                    
                    <?php
                    if(isset($_SESSION['username']))
                    {
                        $username = escape($_SESSION['username']);

                        $query = "SELECT * FROM users WHERE username = '{$username}'";
                        $select_user_profile = mysqli_query($connection, $query);

                        confirm($select_user_profile);

                        while($row = mysqli_fetch_array($select_user_profile))
                        {
                            $user_id = $row['user_id'];
                            $username = $row['username'];
                            $user_firstname = $row['user_firstname'];
                            $user_lastname = $row['user_lastname'];
                            $user_email = $row['user_email'];
                            $user_image = $row['user_image'];
                            $user_password = $row['user_password'];
                        }
                    }

                    if(isset($_POST['update_profile']))
                    {
                        $username = escape($_POST['username']);
                        $user_password = escape($_POST['user_password']);
                        $user_firstname = escape($_POST['user_firstname']);
                        $user_lastname = escape($_POST['user_lastname']);
                        $user_email = escape($_POST['user_email']);

                        if(!empty($user_password))
                        {
                            $query_password = "SELECT user_password FROM users WHERE username = '{$username}'";
                            $get_user_query = mysqli_query($connection, $query_password);

                            confirm($get_user_query);

                            $row = mysqli_fetch_array($get_user_query);

                            $db_user_password = $row['user_password'];

                            if($db_user_password != $user_password)
                            {
                                $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
                            } 

                            $query = "UPDATE users SET ";
                            $query .= "username = '{$username}', ";
                            $query .= "user_password = '{$hashed_password}', ";
                            $query .= "user_firstname ='{$user_firstname}', ";
                            $query .= "user_lastname = '{$user_lastname}', ";
                            $query .= "user_email = '{$user_email}', ";
                            $query .= "user_date = now() ";
                            $query .= "WHERE username = '{$username}' ";

                            $update_user = mysqli_query($connection, $query);

                            confirm($update_user);

                            echo "<p class='bg-success'>User updated.</p>";
                        }
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
                            <label for="username">Username</label>
                            <input type="text" class="form-control" value="<?php echo $username; ?>" name="username">
                        </div>

                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input type="email" class="form-control" value="<?php echo $user_email; ?>" name="user_email">
                        </div>

                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input type="password" autocomplete="off" class="form-control" name="user_password">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="update_profile" value="Update Profile">
                        </div>
                    </form>
                    
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php include "includes/footer.php"; ?>
   
<?php
    }
}
?>