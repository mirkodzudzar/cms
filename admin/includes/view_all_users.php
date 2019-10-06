<?php include("delete_modal.php"); ?>
  
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <th>Id</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Date</th>
            <th>Admin</th>
            <th>Subscriber</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>
            <?php
                $query = "SELECT * FROM users";
                $select_users = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_users))
                {
                    $user_id = $row['user_id'];
                    $username = $row['username'];
                    $user_firstname = $row['user_firstname'];
                    $user_lastname = $row['user_lastname'];
                    $user_email = $row['user_email'];
                    $user_image = $row['user_image'];
                    $user_role = $row['user_role'];
                    $user_date = $row['user_date'];

                    echo "<tr>";
                    echo "<td>{$user_id}</td>";
                    echo "<td>{$username}</td>";
                    echo "<td>{$user_firstname}</td>";
                    echo "<td>{$user_lastname}</td>";
                    echo "<td>{$user_email}</td>";
                    echo "<td>{$user_role}</td>";
                    echo "<td>{$user_date}</td>";
                    
                    if($user_role != 'admin')
                    {
                        echo "<td><a href='users.php?change_to_admin={$user_id}' class='btn btn-primary'>ADMIN</a></td>";
                        echo "<td></td>";
                    }
                    else
                    {
                        echo "<td></td>";
                        echo "<td><a href='users.php?change_to_sub={$user_id}' class='btn btn-primary'>SUBSCRIBER</a></td>";
                    }
                    
                    echo "<td><a href='users.php?source=edit_user&u_id={$user_id}' class='btn btn-success'>EDIT</a></td>";
                    echo "<td><a rel='{$user_id}' href='javascript:void(0)' class='btn btn-danger delete_link'>DELETE</a></td>";
                    echo "</tr>";

                }
            ?>

        </tbody>
    </table>
</div>

<?php
if(isset($_GET['change_to_admin']))
{
    if(isset($_SESSION['user_role']))
    {
        if($_SESSION['user_role'] == 'admin')
        {
            $the_user_id = escape($_GET['change_to_admin']);

            $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $the_user_id";
            $admin_query = mysqli_query($connection, $query);

            confirm($admin_query);

            header("Location: users.php");
        }
    }
}

if(isset($_GET['change_to_sub']))
{
    if(isset($_SESSION['user_role']))
    {
        if($_SESSION['user_role'] == 'admin')
        {
            $the_user_id = escape($_GET['change_to_sub']);

            $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $the_user_id";
            $subscriber_query = mysqli_query($connection, $query);

            confirm($subscriber_query);

            header("Location: users.php");
        }
    }
}

if(isset($_GET['delete']))
{
    if(isset($_SESSION['user_role']))
    {
        if($_SESSION['user_role'] == 'admin')
        {
            $the_user_id = escape($_GET['delete']);

            $query = "DELETE FROM users WHERE user_id = {$the_user_id}";
            $delete_query = mysqli_query($connection, $query);

            confirm($delete_query);

            header("Location: users.php");

        }
    }
}
?>

<script>
    $(document).ready(function(){
        $(".delete_link").on('click', function(){
            var id = $(this).attr("rel");
            var delete_url = "users.php?delete="+ id +" ";
            $(".modal_delete_link").attr("href", delete_url);
            $("#myModal").modal('show');
        });
    });
</script>
