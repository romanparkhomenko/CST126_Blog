<?php

// Constants for DB Connection
DEFINE('DB_USERNAME', 'root');
DEFINE('DB_PASSWORD', 'root');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_DATABASE', 'blog');

// Validate Connection
if (mysqli_connect_error()) {
    die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
}

// Get All Published Posts.
function getPublishedPosts() {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $sql = "SELECT * FROM `posts` WHERE published=true";
    $result = mysqli_query($db, $sql);

    // Get all published posts from DB
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $final_posts = array();
    foreach ($posts as $post) {
        $post['topic'] = getPostCategory($post['id']);
        array_push($final_posts, $post);
    }

    // Close Connection
    $db -> close();


    return $final_posts;
}

// Get Post Category from Post ID
function getPostCategory($post_id) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $sql = "SELECT * FROM categories WHERE id=
			(SELECT topic_id FROM post_category WHERE post_id=$post_id) LIMIT 1";

    $result = mysqli_query($db, $sql);
    $category = mysqli_fetch_assoc($result);

    return $category;
}

// Filter posts by Category
function getPublishedPostsByCategory($topic_id) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $sql = "SELECT * FROM posts ps 
			WHERE ps.id IN 
			(SELECT pt.post_id FROM post_category pt 
				WHERE pt.topic_id=$topic_id GROUP BY pt.post_id 
				HAVING COUNT(1) = 1)";
    $result = mysqli_query($db, $sql);

    // Get all posts by category
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $final_posts = array();

    foreach ($posts as $post) {
        $post['topic'] = getPostCategory($post['id']);
        array_push($final_posts, $post);
    }

    return $final_posts;
}

// Get Category by ID Number
function getCategoryNameById($id) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $sql = "SELECT name FROM categories WHERE id=$id";
    $result = mysqli_query($db, $sql);
    $category = mysqli_fetch_assoc($result);

    return $category['name'];
}

// Get Single Post
function getPost($slug){
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    // Get single post slug
    $post_slug = $_GET['post-slug'];
    $sql = "SELECT * FROM posts WHERE slug='$post_slug' AND published=true";
    $result = mysqli_query($db, $sql);

    // Get post result
    $post = mysqli_fetch_assoc($result);
    if ($post) {
        // Get the category for post
        $post['topic'] = getPostCategory($post['id']);
    }
    return $post;
}

// Get all categories
function getAllTCategories() {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $sql = "SELECT * FROM categories";

    $result = mysqli_query($db, $sql);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $categories;
}
