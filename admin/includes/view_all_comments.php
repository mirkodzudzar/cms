<?php include"includes/delete_modal.php"; ?>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </thead>
        <tbody>
            <?php
                $query = "SELECT * FROM comments";
                $select_comments = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_comments))
                {
                    $comment_id = $row['comment_id'];
                    $comment_post_id = $row['comment_post_id'];
                    $comment_author = $row['comment_author'];
                    $comment_content = $row['comment_content'];
                    $comment_email = $row['comment_email'];
                    $comment_status = $row['comment_status'];
                    $comment_date = $row['comment_date'];

                    echo "<tr>";
                    echo "<td>{$comment_id}</td>";
                    echo "<td>{$comment_author}</td>";
                    echo "<td>{$comment_content}</td>";

    //                $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
    //                $select_categories_id = mysqli_query($connection, $query);
    //                
    //                while($row = mysqli_fetch_assoc($select_categories_id))
    //                {
    //                    $cat_id = $row['cat_id'];
    //                    $cat_title = $row['cat_title'];
    //                    
    //                    echo "<td>{$cat_title}</td>";
    //                }

                    echo "<td>{$comment_email}</td>";
                    echo "<td>{$comment_status}</td>";

                    $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
                    $select_post_id_query = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($select_post_id_query))
                    {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];

                        echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
                    }

                    echo "<td>{$comment_date}</td>";
                    
                    if($comment_status != 'approved')
                    {
                        echo "<td><a href='comments.php?approve={$comment_id}' class='btn btn-primary'>APPROVE</a></td>";
                        echo "<td></td>";
                    }
                    else
                    {
                        echo "<td></td>";
                        echo "<td><a href='comments.php?unapprove={$comment_id}' class='btn btn-primary'>UNAPPROVE</a></td>";    
                    }
                    
                    echo "<td><a rel='{$comment_id}' href='javascript:void(0)' class='btn btn-danger delete_link'>DELETE</a></td>";
                    echo "</tr>";

                }
            ?>

        </tbody>
    </table>
</div>

<?php

    if(isset($_GET['approve']))
    {
        if(isset($_SESSION['user_role']))
        {
            if($_SESSION['user_role'] == 'admin')
            {
                $the_comment_id = escape($_GET['approve']);

                $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$the_comment_id}";
                $approve_comment_query = mysqli_query($connection, $query);

                header("Location: comments.php");
            }
        }
    }

    if(isset($_GET['unapprove']))
    {
        if(isset($_SESSION['user_role']))
        {
            if($_SESSION['user_role'] == 'admin')
            {
                $the_comment_id = escape($_GET['unapprove']);

                $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$the_comment_id}";
                $unapprove_comment_query = mysqli_query($connection, $query);

                header("Location: comments.php");
            }
        }
    }

    if(isset($_GET['delete']))
    {
        if(isset($_SESSION['user_role']))
        {
            if($_SESSION['user_role'] == 'admin')
            {
                $the_comment_id = escape($_GET['delete']);

                $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
                $delete_query = mysqli_query($connection, $query);

                header("Location: comments.php");
            }
        }
    }
?>

<script>
    $(document).ready(function(){
        $(".delete_link").on('click', function(){
            var id = $(this).attr("rel");
            var delete_url = "comments.php?delete="+ id +" ";
            $(".modal_delete_link").attr("href", delete_url);
            $("#myModal").modal('show');
        });
    });
</script>