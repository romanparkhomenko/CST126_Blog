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

// Initialize Admin Variables
$admin_id = 0;
$isEditingUser = false;
$username = "";
$role = "";
$email = "";

/////////////////// ADMIN CRUD OPERATIONS

// Create New Admin
if (isset($_POST['create_admin'])) {
    createAdmin($_POST);
}
// Edit Admin
if (isset($_GET['edit-admin'])) {
    $isEditingUser = true;
    $admin_id = $_GET['edit-admin'];
    editAdmin($admin_id);
}
// Update Admin
if (isset($_POST['update_admin'])) {
    updateAdmin($_POST);
}
// Delete Admin
if (isset($_GET['delete-admin'])) {
    $admin_id = $_GET['delete-admin'];
    deleteAdmin($admin_id);
}

/// Get admins from DB
function getAdminUsers(){
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $sql = "SELECT * FROM users WHERE role IS NOT NULL";
    $result = mysqli_query($db, $sql);

    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $users;
}

function esc($value){
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    // Remove whitespace.
    $val = mysqli_real_escape_string($db, trim($value));

    return $val;
}

function makeSlug($string){
    $string = strtolower($string);
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    return $slug;
}

/// Create Admin
function createAdmin($request_values) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    global $errors, $role, $username, $email;
    $username = esc($request_values['username']);
    $email = esc($request_values['email']);
    $password1 = esc($request_values['password1']);
    $password2 = esc($request_values['password2']);

    if(isset($request_values['role'])){
        $role = esc($request_values['role']);
    }
    // form validation: ensure that the form is correctly filled
    if (empty($username)) { array_push($errors, "Missing Username."); }
    if (empty($email)) { array_push($errors, "Missing Email."); }
    if (empty($role)) { array_push($errors, "Role is required.");}
    if (empty($password1)) { array_push($errors, "Password required."); }
    if ($password1 != $password2) { array_push($errors, "The two passwords do not match"); }

    // Ensure that no user is registered twice.
    // the email and usernames should be unique
    $user_check_query = "SELECT * FROM users WHERE username='$username' 
							OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }
    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password1);//encrypt the password before saving in the database
        $query = "INSERT INTO `users` (`username`, `email`, `role`, `password`, `firstname`, `lastname`, `middlename`, `nickname`, `address1`, `address2`, `city`, `state`, `zipcode`) 
  			  VALUES('$username', '$email', '$role', '$password', '$username', '$email', null, null, null, null, null, null, null)";

        mysqli_query($db, $query);

        $_SESSION['message'] = "Admin user created successfully";
        header('location: users.php');
        exit(0);
    }
}

// Edit Admin
function editAdmin($admin_id) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    global $username, $role, $isEditingUser, $admin_id, $email;

    $sql = "SELECT * FROM users WHERE id=$admin_id LIMIT 1";
    $result = mysqli_query($db, $sql);
    $admin = mysqli_fetch_assoc($result);

    // set form values ($username and $email) on the form to be updated
    $username = $admin['username'];
    $email = $admin['email'];
}

// Update Admin
function updateAdmin($request_values) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    global $errors, $role, $username, $isEditingUser, $admin_id, $email;
    // get id of the admin to be updated
    $admin_id = $request_values['admin_id'];
    // set edit state to false
    $isEditingUser = false;


    $username = esc($request_values['username']);
    $email = esc($request_values['email']);
    $password1 = esc($request_values['password1']);
    $password2 = esc($request_values['password2']);

    if ($password1 != $password2) { array_push($errors, "Password confirmation is incorrect."); }

    if(isset($request_values['role'])){
        $role = $request_values['role'];
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        //encrypt the password (security purposes)
        $password = md5($password1);

        $query = "UPDATE users SET username='$username', email='$email', role='$role', password='$password' WHERE id=$admin_id";
        mysqli_query($db, $query);

        $_SESSION['message'] = "Admin user updated successfully";
        header('location: users.php');
        exit(0);
    }
}
// Delete Admin
function deleteAdmin($admin_id) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $sql = "DELETE FROM users WHERE id=$admin_id";

    if (mysqli_query($db, $sql)) {
        $_SESSION['message'] = "User successfully deleted";
        header("location: users.php");
        exit(0);
    }
}


// Initialize Category Variables
$topic_id = 0;
$isEditingTopic = false;
$topic_name = "";

// CRUD OPS FOR CATEGORIES
if (isset($_POST['create_topic'])) { createTopic($_POST); }
// Edit Topic
if (isset($_GET['edit-topic'])) {
    $isEditingTopic = true;
    $topic_id = $_GET['edit-topic'];
    editTopic($topic_id);
}
// Update Topic
if (isset($_POST['update_topic'])) {
    updateTopic($_POST);
}
// Delete Topic
if (isset($_GET['delete-topic'])) {
    $topic_id = $_GET['delete-topic'];
    deleteTopic($topic_id);
}


// GET ALL CATEGORIES
function getAllCategories() {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $sql = "SELECT * FROM categories";
    $result = mysqli_query($db, $sql);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $categories;
}

// CREATE NEW CATEGORY
function createTopic($request_values) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    global $errors, $topic_name;
    $topic_name = esc($request_values['topic_name']);
    // Create Slug
    $topic_slug = makeSlug($topic_name);
    // Validate Form Input
    if (empty($topic_name)) {
        array_push($errors, "Topic name required");
    }
    // Check duplicate categories
    $topic_check_query = "SELECT * FROM categories WHERE slug='$topic_slug' LIMIT 1";
    $result = mysqli_query($db, $topic_check_query);
    if (mysqli_num_rows($result) > 0) {
        array_push($errors, "Topic already exists");
    }
    // Create category
    if (count($errors) == 0) {
        $query = "INSERT INTO categories (name, slug) 
				  VALUES('$topic_name', '$topic_slug')";

        mysqli_query($db, $query);
        $_SESSION['message'] = "Category created successfully";
        header('location: categories.php');
        exit(0);
    }
}

// EDIT CATEGORY
function editTopic($topic_id) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    global $topic_name, $isEditingTopic, $topic_id;
    $sql = "SELECT * FROM categories WHERE id=$topic_id LIMIT 1";

    $result = mysqli_query($db, $sql);
    $topic = mysqli_fetch_assoc($result);
    // set form values ($topic_name) on the form to be updated
    $topic_name = $topic['name'];
}

// UPDATE CATEGORY
function updateTopic($request_values) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    global $errors, $topic_name, $topic_id;
    $topic_name = esc($request_values['topic_name']);
    $topic_id = esc($request_values['topic_id']);
    // Create Slug
    $topic_slug = makeSlug($topic_name);
    // validate form
    if (empty($topic_name)) {
        array_push($errors, "Topic name required");
    }

    // Register Category
    if (count($errors) == 0) {
        $query = "UPDATE categories SET name='$topic_name', slug='$topic_slug' WHERE id=$topic_id";
        mysqli_query($db, $query);

        $_SESSION['message'] = "Category updated successfully";
        header('location: categories.php');
        exit(0);
    }
}

// DELETE CATEGORY
function deleteTopic($topic_id) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $sql = "DELETE FROM categories WHERE id=$topic_id";
    if (mysqli_query($db, $sql)) {
        $_SESSION['message'] = "Category successfully deleted";
        header("location: categories.php");
        exit(0);
    }
}

// Initialize Post Variables
$post_id = 0;
$isEditingPost = false;
$published = 0;
$title = "";
$post_slug = "";
$body = "";
$featured_image = "";
$post_topic = "";

// GET ALL POSTS FROM DB
function getAllPosts() {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $sql = "SELECT * FROM `posts`";
    $result = mysqli_query($db, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $final_posts = array();
    foreach ($posts as $post) {
        $post['author'] = getPostAuthorById($post['user_id']);
        array_push($final_posts, $post);
    }
    return $final_posts;
}

// Get the Author of Post
function getPostAuthorById($user_id) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $sql = "SELECT username FROM users WHERE id=$user_id";
    $result = mysqli_query($db, $sql);

    if ($result) {
        // return username
        return mysqli_fetch_assoc($result)['username'];
    } else {
        return null;
    }
}

/////////////////////////////////// POST CRUD OPERATIONS

// CREATE POST
if (isset($_POST['create_post'])) {
    createPost($_POST);
}
// EDIT POST
if (isset($_GET['edit-post'])) {
    $isEditingPost = true;
    $post_id = $_GET['edit-post'];
    editPost($post_id);
}
// UPDATE POST
if (isset($_POST['update_post'])) {
    updatePost($_POST);
}
// DELETE POST
if (isset($_GET['delete-post'])) {
    $post_id = $_GET['delete-post'];
    deletePost($post_id);
}

// Create Post Function
function createPost($request_values) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    global $errors, $title, $featured_image, $topic_id, $body, $published;

    $title = esc($request_values['title']);
    $body = htmlentities(esc($request_values['body']));
    if (isset($request_values['topic_id'])) {
        $topic_id = esc($request_values['topic_id']);
    }
    if (isset($request_values['publish'])) {
        $published = esc($request_values['publish']);
    }

    $post_slug = makeSlug($title);
    // Validate Post
    if (empty($title)) { array_push($errors, "Post title is required"); }
    if (empty($body)) { array_push($errors, "Post body is required"); }
    if (empty($topic_id)) { array_push($errors, "Post topic is required"); }
    // Get Image
    $featured_image = $_FILES['featured_image']['name'];
    if (empty($featured_image)) { array_push($errors, "Featured image is required"); }
    // image file directory
    $target = "../../assets/images/" . basename($featured_image);
    if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
        array_push($errors, "Failed to upload image. Please check file settings for your server");
    }
    // Ensure that no post is saved twice.
    $post_check_query = "SELECT * FROM posts WHERE slug='$post_slug' LIMIT 1";
    $result = mysqli_query($db, $post_check_query);

    if (mysqli_num_rows($result) > 0) { // if post exists
        array_push($errors, "A post already exists with that title.");
    }
    // create post if there are no errors in the form
    if (count($errors) == 0) {
        $query = "INSERT INTO posts (user_id, title, slug, image, body, published, created_at, updated_at) VALUES(1, '$title', '$post_slug', '$featured_image', '$body', 1, now(), now())";
        if(mysqli_query($db, $query)){ // if post created successfully
            $inserted_post_id = mysqli_insert_id($db);
            // create relationship between post and topic
            $sql = "INSERT INTO post_topic (post_id, topic_id) VALUES('$inserted_post_id', '$topic_id')";
            mysqli_query($db, $sql);

            $_SESSION['message'] = "Post created successfully";
            header('location: posts.php');
            exit(0);
        }
    }
}

// Edit Post Function
function editPost($role_id) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    global $title, $post_slug, $body, $published, $isEditingPost, $post_id;
    $sql = "SELECT * FROM posts WHERE id='$role_id' LIMIT 1";
    $result = mysqli_query($db, $sql);
    $post = mysqli_fetch_assoc($result);
    // set form values on the form to be updated
    $title = $post['title'];
    $body = $post['body'];
    $published = $post['published'];
}

// Update Post Function
function updatePost($request_values) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    global $errors, $post_id, $title, $featured_image, $topic_id, $body, $published;

    $title = esc($request_values['title']);
    $body = esc($request_values['body']);
    $post_id = esc($request_values['post_id']);
    if (isset($request_values['topic_id'])) {
        $topic_id = esc($request_values['topic_id']);
    }
    // create slug: if title is "The Storm Is Over", return "the-storm-is-over" as slug
    $post_slug = makeSlug($title);

    if (empty($title)) { array_push($errors, "Post title is required"); }
    if (empty($body)) { array_push($errors, "Post body is required"); }
    // if new featured image has been provided
    if (isset($_POST['featured_image'])) {
        // Get image name
        $featured_image = $_FILES['featured_image']['name'];
        // image file directory
        $target = "../../assets/images/" . basename($featured_image);
        if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
            array_push($errors, "Failed to upload image. Please check file settings for your server");
        }
    }

    // register topic if there are no errors in the form
    if (count($errors) == 0) {
        $query = "UPDATE posts SET title='$title', slug='$post_slug', views=0, image='$featured_image', body='$body', published=1, updated_at=now() WHERE id='$post_id'";
        // attach topic to post on post_topic table
        if(mysqli_query($db, $query)){ // if post created successfully
            if (isset($topic_id)) {
                $inserted_post_id = mysqli_insert_id($db);
                // create relationship between post and topic
                $sql = "INSERT INTO post_topic (post_id, topic_id) VALUES('$inserted_post_id', '$topic_id')";
                mysqli_query($db, $sql);
                $_SESSION['message'] = "Post created successfully";
                header('location: posts.php');
                exit(0);
            }
        }
        $_SESSION['message'] = "Post updated successfully";
        header('location: posts.php');
        exit(0);
    }
}

// Delete Post Function
function deletePost($post_id) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $sql = "DELETE FROM posts WHERE id='$post_id'";
    if (mysqli_query($db, $sql)) {
        $_SESSION['message'] = "Post successfully deleted";
        header("location: posts.php");
        exit(0);
    }
}
