<?php
// SHARED HEADER
include ("./handlers/dbConnection.php");
require_once ("./assets/includes/sharedHeader.php");

// GET USER DATA
include "./handlers/getUserData.php";
$username = $_SESSION['username'];

// GET POST BY SLUG
if (isset($_GET['post-slug'])) {
    $post = getPost($_GET['post-slug']);
}
$categories = getAllTCategories();

?>

<body>

<div class="wrapper">
    <!-- SIDE BAR -->
    <div class="sidebar">
        <?php include_once("./assets/includes/sidebar.php"); ?>
    </div>

    <!-- MAIN CONTENT -->
    <div class="single-posts fluid-container">
        <div class="row blog-content">

            <div class="post-wrapper col-sm-9">
                <div class="full-post">
                    <?php if ($post['published'] == false): ?>
                        <h2 class="post-title">Sorry... This post has not been published</h2>
                    <?php else: ?>
                        <h2 class="post-title"><?php echo $post['title']; ?></h2>
                        <div class="post-body-div">
                            <?php echo html_entity_decode($post['body']); ?>
                        </div>
                    <?php endif ?>
                </div>
                <!-- // full post div -->
            </div>

            <!-- post sidebar -->
            <div class="post-sidebar col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h2>Categories</h2>
                    </div>
                    <div class="card-content">
                        <?php foreach ($categories as $category): ?>
                            <a href="<?php echo '/blog/filtered_posts.php?topic=' . $category['id'] ?>">
                                <?php echo $category['name']; ?>
                            </a>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


</body>
</html>