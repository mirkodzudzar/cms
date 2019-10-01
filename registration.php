<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php
    if(isset($_POST['submit']))
    {
        $username = $_POST['username']; 
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        
        if(!empty($username) && !empty($user_email) && !empty($user_password))
        {
            $username = mysqli_real_escape_string($connection, $username); 
            $user_email = mysqli_real_escape_string($connection, $user_email); 
            $user_password = mysqli_real_escape_string($connection, $user_password); 

            $query = "SELECT randSalt FROM users";
            $select_randSalt_query = mysqli_query($connection, $query);

            if(!$select_randSalt_query)
            {
                die('QUERY FAILED!' . mysqli_error($connection));
            }

            $row = mysqli_fetch_array($select_randSalt_query);
            $salt = $row['randSalt'];
            
            $user_password = crypt($user_password, $salt);

            $query = "INSERT INTO users (username, user_email, user_password, user_role, user_date) ";
            $query .= "VALUES('{$username}', '{$user_email}', '{$user_password}', 'subscriber', now() )";
            $register_user_query = mysqli_query($connection, $query);
            
            if(!$register_user_query)
            {
                die('QUERY FAILED' . mysqli_error($connection) .' '. mysqli_errno($connection));
            }
            
            $message = "<h6 class='text-center bg-success'>Your registration has been submitted</h6>";
        }
        else
        {
            $message = "<h6 class='text-center bg-danger'>Fields cannot be empty</h6>";
        }
    }

    else
    {
        $message = '';
    }
?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>
    
<!-- Page Content -->
<div class="container">    
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                    <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                           
                            <?php echo $message; ?>
                           
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                            </div>
                             <div class="form-group">
                                <label for="user_email" class="sr-only">Email</label>
                                <input type="email" name="user_email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                             <div class="form-group">
                                <label for="user_password" class="sr-only">Password</label>
                                <input type="password" name="user_password" id="key" class="form-control" placeholder="Password">
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
    <hr>
</div>

<?php include "includes/footer.php";?>
