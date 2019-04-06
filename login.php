<?php
$pageTitle = "Roman's Blog | Login";
require_once ("./assets/includes/sharedHeader.php");
include "./handlers/dbConnection.php";
?>


<body class="login-page">

<!-- NAV BAR -->
<?php include_once("./assets/includes/navigation.php"); ?>

<div class="login container">
    <div class="row justify-content-center align-items-center">
        <div class="login-content col-sm-6">
            <h1 class="text-center">Login</h1>
            <p class="text-center">It's great to see you again!</p>
            <img src="./assets/images/rocket.svg" alt="rocket">
        </div>
        <div class="login-form col-sm-6">
            <form method="post" action="login.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" class="form-control" placeholder="Enter your username" type="text" name="username"/>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" class="form-control" placeholder="Enter your password" type="password" name="password"/>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="login_user">Login</button>
                </div>
                <p>Not a member yet? <a href="./register.php">Sign Up</a></p>
                <?php include('handlers/errors.php'); ?>
            </form>
        </div>
    </div>
</div>

</body>
</html>