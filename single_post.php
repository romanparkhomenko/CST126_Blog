<?php

// SHARED HEADER
include ("./handlers/dbConnection.php");
require_once ("./assets/includes/sharedHeader.php");

// GET USER DATA
include "./handlers/getUserData.php";
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// GET POST BY SLUG
if (isset($_GET['post-slug'])) {
    $post = getPost($_GET['post-slug']);
}

$post_id = $post['id'];
$_SESSION['post_id'] = $post_id;

$categories = getAllTCategories();

// GET USER DATA
include "./handlers/commentsHandler.php";

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

                <div class="comments-section well">
                    <h4><?php echo count($comments) ?> Comment(s)</h4>
                    <!-- comments wrapper -->
                    <div id="comments-wrapper">
                        <?php if (isset($comments)): ?>
                            <!-- Display comments -->
                            <?php foreach ($comments as $comment): ?>
                                <!-- comment -->
                                <div class="comment clearfix">
                                    <div class="comment-details">
                                        <div class="image">
                                            <img src="/blog/assets/images/profile-pic.png" alt="" class="profile-pic">
                                        </div>
                                        <div class="details">
                                            <p class="comment-name"><?php echo getUsernameById($comment['user_id']) ?></p>
                                            <p class="comment-date"><?php echo date("F j, Y ", strtotime($comment["created_at"])); ?></p>
                                        </div>
                                    </div>
                                    <div class="comment-body">
                                        <p><?php echo $comment['body']; ?></p>
                                        <a class="reply-btn" href="#" data-id="<?php echo $comment['id']; ?>">Reply</a>
                                    </div>
                                    <!-- reply form -->
                                    <form action="single_post.php" class="reply_form" id="comment_reply_form_<?php echo $comment['id'] ?>" data-id="<?php echo $comment['id']; ?>">
                                        <textarea class="form-control" name="reply_text" id="reply_text" cols="30" rows="2"></textarea>
                                        <button class="btn btn-primary btn-xs pull-right submit-reply">Submit reply</button>
                                    </form>

                                    <!-- GET ALL REPLIES -->
                                    <?php $replies = getRepliesByCommentId($comment['id']) ?>
                                    <div class="replies_wrapper_<?php echo $comment['id']; ?>">
                                        <?php if (isset($replies)): ?>
                                            <?php foreach ($replies as $reply): ?>
                                                <!-- reply -->
                                                <div class="comment reply clearfix">
                                                    <div class="comment-details">
                                                        <div class="image">
                                                            <img src="/blog/assets/images/profile-pic.png" alt="" class="profile-pic">
                                                        </div>
                                                        <div class="details">
                                                            <p class="comment-name"><?php echo getUsernameById($reply['user_id']) ?></p>
                                                            <p class="comment-date"><?php echo date("F j, Y ", strtotime($reply["created_at"])); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="comment-body">
                                                        <p><?php echo $reply['body']; ?></p>
<!--                                                        <a class="reply-btn" href="#">Reply</a>-->
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <!-- // comment -->
                            <?php endforeach ?>
                        <?php else: ?>
                            <h2>Be the first to comment on this post</h2>
                        <?php endif ?>
                    </div><!-- comments wrapper -->
                    <!-- No Commenting if user not signed in. -->
                    <?php if (isset($user_id)): ?>
                        <form class="clearfix" action="single_post.php" method="post" id="comment_form">
                            <label for="comment_text">Submit a comment below.</label>
                            <textarea placeholder="Enter a comment" name="comment_text" id="comment_text" class="form-control" cols="30" rows="3"></textarea>
                            <button class="btn btn-primary pull-right" id="submit_comment">Submit comment</button>
                        </form>
                    <?php else: ?>
                        <div class="well" style="margin-top: 20px;">
                            <h4 class="text-center"><a href="/blog/login.php">Sign in</a> to post a comment</h4>
                        </div>
                    <?php endif ?>
                </div>
                <!-- End Comments  -->
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

<script>
    $(document).ready(function(){
        // When user clicks on submit comment to add comment under post
        $(document).on('click', '#submit_comment', function(e) {
            e.preventDefault();
            var comment_text = $('#comment_text').val();
            var url = "/blog/handlers/commentsHandler.php";
            // Stop executing if not value is entered
            if (comment_text === "" ) return;
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    comment_text: comment_text,
                    comment_posted: 1
                },
                success: function(data){
                    var response = JSON.stringify(data);
                    console.log(response);
                    if (data === "error") {
                        alert('There was an error adding comment. Please try again');
                    } else {
                        $('#comments-wrapper').prepend(response.comment);
                        $('#comments_count').text(response.comments_count);
                        $('#comment_text').val('');
                    }
                }
            });
        });
        // When user clicks on submit reply to add reply under comment
        $(document).on('click', '.reply-btn', function(e){
            e.preventDefault();
            var comment_id = $(this).data('id');

            $(this).parent().siblings('form#comment_reply_form_' + comment_id).toggle(500);
            $(document).on('click', '.submit-reply', function(e){
                e.preventDefault();
                var reply_textarea = $(this).siblings('textarea');
                var reply_text = $(this).siblings('textarea').val();
                var url = "/blog/single_post.php";
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        comment_id: comment_id,
                        reply_text: reply_text,
                        reply_posted: 1
                    },
                    success: function(data){
                        if (data === "error") {
                            alert('There was an error adding reply. Please try again');
                        } else {
                            $('.replies_wrapper_' + comment_id).append(data);
                            reply_textarea.val('');
                        }
                    }
                });
            });
        });
    });
</script>
</body>
</html>