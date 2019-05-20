<?php

/*
 * CST-126 Blog Project Version 8
 * DB Connections
 * Roman Parkhomenko
 * 05/18/2019
 * This file sets global connection variables, starts the user session, and contains the functions
 * to be used throughout the application.
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

include "registrationHandler.php";
include 'loginHandler.php';
include 'functions.php';
include 'admin/adminFunctions.php';

// Close Connection
$db -> close();
?>