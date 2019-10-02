<?php
    //Does not working on chrome, ie and safari. Opera and firefox are functioning.
    function users_online()
    {   
        if(isset($_GET['onlineusers']))
        {
            global $connection;
            
            if(!$connection)
            {
                session_start();
                
                include("../includes/db.php");
                
                $session = session_id();
                $time = time();
                $time_out_in_seconds = 30;
                $time_out = $time - $time_out_in_seconds;

                $query = "SELECT * FROM users_online WHERE session = '{$session}'";
                $send_query = mysqli_query($connection, $query);

                if(!$send_query)
                {
                    die("QUERY FALIED" . mysqli_error($connection));
                }

                $count = mysqli_num_rows($send_query);

                if($count == null)
                {
                    mysqli_query($connection, "INSERT INTO users_online (session, time) VALUES ('{$session}', '{$time}')");
                }
                else
                {
                    mysqli_query($connection, "UPDATE users_online SET time = '{$time}' WHERE session = '{$session}'");
                }

                $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '{$time_out}'");
                echo $count_user = mysqli_num_rows($users_online_query);
            }
        }//get request isset()
    }

    users_online();

    function confirm($result)
    {
        global $connection;
        
        if(!$result)
        {
            die("QUERY FAILED" . mysqli_error($connection));
        }
    }

    function insert_categories()
    {
        global $connection;
        
        if(isset($_POST['submit']))
        {
            $cat_title = $_POST['cat_title'];

            if($cat_title == "" || empty($cat_title))
            {
                echo "This field should not be empty";
            }
            else
            {
                $query = "INSERT INTO categories(cat_title)";
                $query .=  "VALUES ('{$cat_title}') ";

                $create_category_query = mysqli_query($connection, $query);

                if(!$create_category_query)
                {
                    die("QUERY FAILED" . mysqli_error($connection));
                }
                
                echo "Category created";
            }
        }
    }

    function findAllCategories()
    {
        global $connection;
        
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_categories))
        {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";                     
        echo "<td><a href='categories.php?delete={$cat_id}'>DELETE</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>EDIT</a></td>";
        echo "<tr>";

        }
    }

    function deleteCategories()
    {
        global $connection;
        
        if(isset($_GET['delete']))
        {
            if(isset($_SESSION['user_role']))
            {
                if($_SESSION['user_role'] == 'admin')
                {
                    $the_cat_id = mysqli_real_escape_string($connection, $_GET['delete']);
                    $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
                    $delete_query = mysqli_query($connection, $query);
                    header("Location: categories.php");
                }
            }
        }
    }

?>