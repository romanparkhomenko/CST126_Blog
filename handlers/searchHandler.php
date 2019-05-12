<?php

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

// SEARCH MODULE
$output = '';

if(isset($_POST["query"])) {
    $search = mysqli_real_escape_string($db, $_POST["query"]);

    // Use title, slug, and body as search params
    $query = "SELECT * FROM `posts`
              WHERE  title  LIKE '%".$search."%'
              OR slug LIKE '%".$search."%' 
              OR body LIKE '%".$search."%'";
}

$result = mysqli_query($db, $query);
if(mysqli_num_rows($result) > 0) {
    $output .= '
  <div class="table-responsive">
   <table class="table table bordered">
   <tr>
     <th>Title</th>
     <th>Slug</th>
     <th>Body</th>
    </tr>';
    while ($row1 = mysqli_fetch_array($result)) {
        $output .= '
      <tr>
        <td><a href="/blog/single_post.php?post-slug='. $row1["slug"] .'">' . $row1["title"] . '</a></td>
        <td><a href="/blog/single_post.php?post-slug='. $row1["slug"] .'">' . $row1["slug"] . '</a></td>
        <td><a href="/blog/single_post.php?post-slug='. $row1["slug"] .'">' . $row1["body"] . '</a></td>
       </tr>';
    }
    echo $output;
} else {
    echo "<p>No Results</p>";
}

// Close Connection
$db -> close();