<?php
/*
 * CST-126 Blog Project Version 8
 * Index/Home Page
 * Roman Parkhomenko
 * 05/18/2019
 * The purpose of this page is to display the information for
 * the logged in user, as well as allow them to see recent posts.
 * If a non-authenticated user tries to access this page, they will be
 * redirected to the login screen.
*/

session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

// SHARED HEADER
include ("./handlers/dbConnection.php");
require_once ("./assets/includes/sharedHeader.php");

// GET USER DATA
include "./handlers/getUserData.php";
$username = $_SESSION['username'];

// GET PUBLISHED POSTS
$posts = getPublishedPosts();


?>

<body>

<div class="wrapper">
    <!-- SIDE BAR -->
    <div class="sidebar">
        <?php include_once("./assets/includes/sidebar.php"); ?>
    </div>

    <!-- MAIN CONTENT -->
    <div class="homepage fluid-container">
        <div class="row justify-content-center align-items-start header-row">
            <div class="welcome col-sm-9">
                <h1>Welcome <strong><?php echo $_SESSION['username']; ?></strong></h1>
            </div>
            <div class="user-info col-sm-3">
                <details>
                    <summary>Your Information</summary>
                    <?php getUserData($username); ?>
                </details>
            </div>
        </div>

        <!-- Loop through and display public posts -->
        <div class="row blog-content">
            <h3>Recent Posts:</h3>
            <div class="posts row">
                <?php foreach ($posts as $post): ?>
                    <div class="col-sm-4 post">
                        <a class="post-link" href="/blog/single_post.php?post-slug=<?php echo $post['slug']; ?>">
                            <img src="<?php echo '/blog/assets/images/' . $post['image']; ?>" class="post_image" alt="">
                            <div class="post_info">
                                <h3><?php echo $post['title'] ?></h3>
                                <div class="info">
                                    <p><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></p>
                                    <p class="read_more">Read more...</p>
                                </div>
                            </div>
                        </a>
                        <?php if (isset($post['topic']['name'])): ?>
                            <a href="<?php echo '/blog/filtered_posts.php?topic=' . $post['topic']['id'] ?>" class="category"><?php echo $post['topic']['name'] ?></a>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>

</div>

</body>
</html>