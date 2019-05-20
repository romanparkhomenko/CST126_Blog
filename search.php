<?php

/*
 * CST-126 Blog Project Version 8
 * Search Module
 * Roman Parkhomenko
 * 05/18/2019
 * The search module presents the user with an input field. Once the user starts typing,
 * a query will be made with each key stroke, presenting the user a live response via Ajax.
*/

$pageTitle = "Search Module";
require_once ("./assets/includes/sharedHeader.php");
include "./handlers/dbConnection.php";
$username = $_SESSION['username'];

?>

<body>

<div class="wrapper">
    <!-- SIDE BAR -->
    <div class="sidebar">
        <?php include_once("./assets/includes/sidebar.php"); ?>
    </div>

    <!-- MAIN CONTENT -->
    <div class="search-page fluid-container">
        <div class="row justify-content-center align-items-start header-row">
            <div class="welcome col-sm-12">
                <h1 class="page-title">Search Blog Posts</h1>
            </div>
        </div>

        <div class="row blog-content">
            <div class="search-blog col-sm-6">
                <label for="search">Search</label>
                <input id="search" class="form-control" placeholder="Search any term" type="text" name="search"/>
            </div>
            <div class="search-results col-sm-9">
                <h3>Results:</h3>
                <div id="result"></div>
            </div>
        </div>

    </div>

</div>
<script>
    $(document).ready(function(){
        load_data();
        function load_data(query) {
            $.ajax({
                url:"/blog/handlers/searchHandler.php",
                method:"POST",
                data:{query:query},
                success:function(data) {
                    $('#result').html(data);
                }
            });
        }
        $('input#search').keyup(function() {
            var search = $(this).val();
            if(search !== "") {
                load_data(search);
            }
            else {
                load_data();
            }
        });
    });
</script>
</body>
</html>