<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-8">

        <?php
        
        if(isset($_GET['p_id']))
        {
            $the_post_id = escape($_GET['p_id']);
            $the_post_author = escape($_GET['author']);
        }
        
        if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin')
        {
            $query = "SELECT * FROM posts WHERE post_user = '{$the_post_author}' ";
        }
        else
        {
            $query = "SELECT * FROM posts WHERE post_user = '{$the_post_author}' AND post_status = 'published'";
        }

        $select_all_posts_query = mysqli_query($connection, $query);

        if(!$select_all_posts_query)
        {
            die('QUERY FAILED' . mysqli_error($connection));
        }
        
        while($row = mysqli_fetch_assoc($select_all_posts_query))
        {
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];                
            $post_author = $row['post_user'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];

        ?>

        <h1 class="page-header">
        Page Heading
        <small>Secondary Text</small>
        </h1>

        <!-- First Blog Post -->
        <h2>
            <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
        </h2> 
        <p class="lead">
            by <?php echo $post_author; ?>
        </p>
        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
        <hr>
        <a href="post.php?p_id=<?php echo $post_id; ?>">
        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
        </a>
        <hr>
        <p><?php echo $post_content; ?></p>
        <a href="post.php?p_id=<?php echo $post_id; ?>" class="btn btn-primary">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

        <hr>

        <?php

        }

        ?>
    </div>

    <!-- Blog Sidebar Widgets Column -->
    <?php include "includes/sidebar.php"; ?>

</div>
    <!-- /.row -->

<hr>

    <!-- Footer -->
       
<?php include "includes/footer.php"; ?>
        
        
