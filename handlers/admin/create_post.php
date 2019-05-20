<?php

/*
 * CST-126 Blog Project Version 8
 * Create Post Module
 * Roman Parkhomenko
 * 05/18/2019
 * This page allows a user to create a new post by utilizing the WYSIWIG Editor from CKEDITOR in addition to
 * uploading a thumbnail image for the post.
*/

$pageTitle = "Roman's Blog | Create Post";

// SHARED HEADER
include ("../dbConnection.php");
require_once ("../../assets/includes/sharedHeader.php");

// GET CATEGORIES FROM DB
$categories = getAllCategories();

?>

<body>

<div class="wrapper">
    <!-- SIDE BAR -->
    <div class="sidebar">
        <?php include_once("../../assets/includes/sidebar.php"); ?>
    </div>

    <!-- MAIN CONTENT -->
    <div class="create-post fluid-container">
        <div class="row justify-content-center align-items-start header-row">
            <div class="welcome col-sm-12">
                <h1 class="page-title">Create Post</h1>
            </div>

            <?php include('../messages.php') ?>

        </div>

        <div class="row blog-content">
            <div class="col-sm-12">

                <form method="post" enctype="multipart/form-data" action="create_post.php">
                    <?php if ($isEditingPost === true): ?>
                        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                    <?php endif ?>

                    <div class="form-group">
                        <label for="title">Post Title</label>
                        <input id="title" class="form-control" placeholder="Title" value="<?php echo $title; ?>" type="text" name="title"/>
                    </div>

                    <div class="form-group">
                        <label for="featured_image">Featured Image</label>
                        <input id="featured_image" class="form-control" placeholder="Featured Image" type="file" name="featured_image"/>
                    </div>

                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea name="body" id="body" cols="30" rows="10"><?php echo $body; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="topic_id">Category</label>
                        <select id="topic_id" name="topic_id" class="form-control">
                            <option value="" selected disabled>Choose topic</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>">
                                    <?php echo $category['name']; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <!-- Checkbox if post is published -->
<!--                    --><?php //if ($published == true): ?>
<!--                        <div class="form-group">-->
<!--                            <label for="publish">Publish (Check Box to Publish Post)</label>-->
<!--                            <input id="publish" type="checkbox" name="publish" checked class="form-control">-->
<!--                        </div>-->
<!--                    --><?php //else: ?>
<!--                        <div class="form-group">-->
<!--                            <label for="publish">Publish (Check Box to Publish Post)</label>-->
<!--                            <input id="publish" type="checkbox" name="publish" class="form-control">-->
<!--                        </div>-->
<!--                    --><?php //endif ?>

                    <!-- if editing post, display the update button instead of create button -->
                    <?php if ($isEditingPost === true): ?>
                        <button type="submit" class="btn btn-primary" name="update_post">UPDATE</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-primary" name="create_post">Save Post</button>
                    <?php endif ?>

                    <?php include('../errors.php') ?>
                </form>
            </div>

        </div>
    </div>
</div>

</body>
<script>
    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

</html>
