<?php
$pageTitle = "Roman's Blog | Posts";

// SHARED HEADER
include ("../dbConnection.php");
require_once ("../../assets/includes/sharedHeader.php");

// GET CATEGORIES FROM DB
$posts = getAllPosts();

?>

<body>

<div class="wrapper">
    <!-- SIDE BAR -->
    <div class="sidebar">
        <?php include_once("../../assets/includes/sidebar.php"); ?>
    </div>

    <!-- MAIN CONTENT -->
    <div class="posts fluid-container">

        <div class="row justify-content-center align-items-start header-row">
            <div class="welcome col-sm-12">
                <h1 class="page-title">Manage Posts</h1>
            </div>
        </div>

        <div class="row blog-content">

            <!-- Display records from DB-->
            <div class="posts-table col-sm-12">
                <!-- Display notification message -->
                <?php include('../messages.php') ?>

                <?php if (empty($posts)): ?>
                    <h3>No Posts In Database</h3>
                <?php else: ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Views</th>
                            <?php if ($_SESSION['user']['role'] == "Admin"): ?>
                                <th><small>Publish</small></th>
                            <?php endif ?>
                            <th><small>Edit</small></th>
                            <th><small>Delete</small></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($posts as $key => $post): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $post['author']; ?></td>
                                <td>
                                    <a target="_blank" href="<?php echo '/blog/single_post.php?post-slug=' . $post['slug'] ?>">
                                        <?php echo $post['title']; ?>
                                    </a>
                                </td>
                                <td><?php echo $post['views']; ?></td>

                                <!-- Only Admin can publish/unpublish post -->
                                <?php if ($_SESSION['user']['role'] == "Admin" ): ?>
                                    <td>
                                        <?php if ($post['published'] == true): ?>
                                            <a class="fa fa-check btn unpublish"
                                               href="posts.php?unpublish=<?php echo $post['id'] ?>">
                                            </a>
                                        <?php else: ?>
                                            <a class="fa fa-times btn publish"
                                               href="posts.php?publish=<?php echo $post['id'] ?>">
                                            </a>
                                        <?php endif ?>
                                    </td>
                                <?php endif ?>

                                <td>
                                    <a class="fa fa-pencil btn edit"
                                       href="create_post.php?edit-post=<?php echo $post['id'] ?>">
                                    </a>
                                </td>
                                <td>
                                    <a  class="fa fa-trash btn delete"
                                        href="create_post.php?delete-post=<?php echo $post['id'] ?>">
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                <?php endif ?>
            </div>

        </div>
    </div>
</div>

</body>
</html>
