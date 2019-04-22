<?php
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

include "registrationHandler.php";
include 'loginHandler.php';
include 'functions.php';
include 'admin/adminFunctions.php';

// Close Connection
$db -> close();
?>