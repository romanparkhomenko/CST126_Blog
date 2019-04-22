<?php
// SHARED HEADER
include ("./handlers/dbConnection.php");
require_once ("./assets/includes/sharedHeader.php");

$username = $_SESSION['username'];

// GET POSTS IN CATEGORY
if (isset($_GET['topic'])) {
    $topic_id = $_GET['topic'];
    $posts = getPublishedPostsByCategory($topic_id);
}

?>

<body>

<div class="wrapper">
    <!-- SIDE BAR -->
    <div class="sidebar">
        <?php include_once("./assets/includes/sidebar.php"); ?>
    </div>

    <!-- MAIN CONTENT -->
    <div class="filtered-posts fluid-container">
        <div class="row blog-content">
            <h3 class="content-title">Articles on <strong><?php echo getCategoryNameById($topic_id); ?></strong></h3>
            <hr>
            <div class="posts row">
                <?php foreach ($posts as $post): ?>
                    <div class="col-sm-4 post">
                        <a class="post-link" href="/blog/single_post.php?post-slug=<?php echo $post['slug']; ?>">
                            <img src="<?php echo './assets/images/' . $post['image']; ?>" class="post_image" alt="">
                            <div class="post_info">
                                <h3><?php echo $post['title'] ?></h3>
                                <div class="info">
                                    <p><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></p>
                                    <p class="read_more">Read more...</p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

    </div>

</div>

</body>
</html>