<?php
/*
 * CST-126 Blog Project Version 8
 * Comments Handler
 * Roman Parkhomenko
 * 05/18/2019
 * The purpose of the comments handler is to read and update comment and reply submissions
 * on the post page. It will link the comment to the post and the user who made the comment
 * and display the information dynamically via an AJAX call.
 *
 * For the final project, I added a application/json header and comments class to fix the response which allowed the
 * AJAX for the comments to actually work.
*/

session_start();
// Constants for DB Connection
DEFINE('DB_USERNAME', 'root');
DEFINE('DB_PASSWORD', 'root');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_DATABASE', 'blog');

// Initialize Variables
$errors = array();

// Connect To Blog DB
$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Validate Connection
if (mysqli_connect_error()) {
    die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
}

// Get all comments from database
$comments_query_result = mysqli_query($db, "SELECT * FROM comments WHERE post_id=" . $post_id . " ORDER BY created_at DESC");

$comments = mysqli_fetch_all($comments_query_result, MYSQLI_ASSOC);

// Receives a user id and returns the username of the commenter.
function getUsernameById($id) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    $result = mysqli_query($db, "SELECT username FROM users WHERE id='$id' LIMIT 1");

    return mysqli_fetch_assoc($result)['username'];
}

// Receives a comment id and returns the replies to that comment.
function getRepliesByCommentId($id) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $result = mysqli_query($db, "SELECT * FROM replies WHERE comment_id='$id'");
    $replies = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $replies;
}

// Receives a post id and returns the total number of comments on that post
function getCommentsCountByPostId($post_id) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $result = mysqli_query($db, "SELECT COUNT(*) AS total FROM comments");
    $data = mysqli_fetch_assoc($result);

    return $data['total'];
}

// Comment object to return to ajax call.
class Comment {

    public function __construct($comment, $comments_count) {
        $this->comment = $comment;
        $this->comments_count = $comments_count;
    }
}

// On comment form submission:
if (isset($_POST['comment_posted'])) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    global $user_id, $post_id;

    $user_id = $_SESSION['user_id'];
    $post_id = $_SESSION['post_id'];

    // Get comment from AJAX call.
    $comment_text = $_POST['comment_text'];
    // insert comment into database
    $sql = "INSERT INTO comments (post_id, user_id, body, created_at, updated_at) VALUES ('$post_id', '$user_id', '$comment_text', now(), now())";
    $result = mysqli_query($db, $sql);
    // Query same comment from database to send back to be displayed
    $inserted_id = $db->insert_id;
    $res = mysqli_query($db, "SELECT * FROM comments WHERE id='$inserted_id'");
    $inserted_comment = mysqli_fetch_assoc($res);
    // if insert was successful, get that same comment from the database and return it
    if ($result) {
        $comment = "<div class='comment clearfix'><div class='comment-details'><div class='image'><img src='/blog/assets/images/profile-pic.png' alt='' class='profile-pic'></div><div class='details'><p class='comment-name'>" . getUsernameById($inserted_comment['user_id']) . "</p><p class='comment-date'>" . date('F j, Y ', strtotime($inserted_comment['created_at'])) . "</p></div></div><div class='comment-body'><p>" . $inserted_comment['body'] . "</p><a class='reply-btn' href='#' data-id='" . $inserted_comment['id'] . "'>Reply</a></div><!-- Reply form --><form action='single_post.php' class='reply_form' id='comment_reply_form_" . $inserted_comment['id'] . "' data-id='" . $inserted_comment['id'] . "'><textarea class='form-control' name='reply_text' id='reply_text' cols='30' rows='2'></textarea><button class='btn btn-primary btn-xs pull-right submit-reply'>Submit reply</button></form></div>";

        $comment_info = new Comment($comment, getCommentsCountByPostId($post_id));
        header('Content-type: application/json');
        echo json_encode( $comment_info );
        exit();
    } else {
        echo "error";
        exit();
    }
}
// If the user clicked submit on reply form...
if (isset($_POST['reply_posted'])) {
    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    global $user_id, $post_id;

    $user_id = $_SESSION['user_id'];
    $post_id = $_SESSION['post_id'];

    // grab the reply that was submitted through Ajax call
    $reply_text = $_POST['reply_text'];
    $comment_id = $_POST['comment_id'];
    // insert reply into database
    $sql = "INSERT INTO replies (user_id, comment_id, body, created_at, updated_at) VALUES ('$user_id', '$comment_id', '$reply_text', now(), now())";
    $result = mysqli_query($db, $sql);
    $inserted_id = $db->insert_id;
    $res = mysqli_query($db, "SELECT * FROM replies WHERE id=$inserted_id");
    $inserted_reply = mysqli_fetch_assoc($res);
    // if insert was successful, get that same reply from the database and return it
    if ($result) {
        $reply = "<div class='comment reply clearfix'>
                    <div class='comment-details'>
					    <div class='image'><img src='/blog/assets/images/profile-pic.png' alt='' class='profile-pic'></div>
					    <div class='details'>
	                        <p class='comment-name'>" . getUsernameById($inserted_reply['user_id']) . "</p>
						    <p class='comment-date'>" . date('F j, Y ', strtotime($inserted_reply['created_at'])) . "</p>
                        </div>
					 </div>
					<div class='comment-body'>
					    <p>" . $inserted_reply['body'] . "</p>
                    </div>
				</div>";
        echo $reply;
        exit();
    } else {
        echo "error";
        exit();
    }
}

// Close Connection
$db -> close();