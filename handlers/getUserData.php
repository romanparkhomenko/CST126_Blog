<?php
/*
 * CST-126 Blog Project Version 8
 * GetUserData Function
 * Roman Parkhomenko
 * 05/18/2019
 * The purpose of this function is to get the user data
 * to display on the homepage. In addition to printing the data,
 * some of the user properties such as role and username are saved to
 * the session array to be accessible in other modules.
*/

function getUserData($username) {

    // Constants for DB Connection
    DEFINE('DB_USERNAME', 'root');
    DEFINE('DB_PASSWORD', 'root');
    DEFINE('DB_HOST', 'localhost');
    DEFINE('DB_DATABASE', 'blog');

    // Connect To Blog DB
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    // Validate Connection
    if (mysqli_connect_error()) {
        die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
    }

    // Get user info by row.
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        echo '<div class="user-data">';
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<p>ID: '.$row["id"].'</p>';
            $_SESSION['user_id'] = $row["id"];
            echo '<p>Username: '.$row["username"].'</p>';
            $_SESSION['username'] = $row["username"];
            echo '<p>Email: '.$row["email"].'</p>';
            echo '<p>Role: '.$row["role"].'</p>';
            $_SESSION['role'] = $row["role"];
            echo '<p>First Name: '.$row["firstname"].'</p>';
            echo '<p>Last Name: '.$row["lastname"].'</p>';
            echo '<p>Middle Name: '.$row["middlename"].'</p>';
            echo '<p>Nickname: '.$row["nickname"].'</p>';
            echo '<p>Address 1: '.$row["address1"].'</p>';
            echo '<p>Address 2: '.$row["address2"].'</p>';
            echo '<p>City: '.$row["city"].'</p>';
            echo '<p>State: '.$row["state"].'</p>';
            echo '<p>Zip Code: '.$row["zipcode"].'</p>';

        }
        echo "</div>";
    } else {
        echo '<p>Oops! User Data Not Found</p>';
    }

    // Close Connection
    $db -> close();
}