<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to admin,
                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>

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

                                $the_comment_post_id = escape($_GET['p_id']);

                                $query = "SELECT * FROM comments WHERE comment_post_id =".mysqli_real_escape_string($connection, $the_comment_post_id)." ";
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
                                    echo "<td><a href='post_comments.php?approve={$comment_id}&p_id=".$the_comment_post_id."'>APPROVE</a></td>";
                                    echo "<td><a href='post_comments.php?unapprove={$comment_id}&p_id=".$the_comment_post_id."'>UNAPPROVE</a></td>";
                                    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?');\" href='post_comments.php?delete={$comment_id}&p_id=".$the_comment_post_id."'>DELETE</a></td>";
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

                                header("Location: post_comments.php?p_id={$the_comment_post_id}");
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

                                header("Location: post_comments.php?p_id={$the_comment_post_id}");
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

                                header("Location: post_comments.php?p_id={$the_comment_post_id}");
                            }
                        }
                    }

                ?>
                    
                 </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php include "includes/admin_footer.php"; ?>