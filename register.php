<?php
$pageTitle = "Roman's Blog | Registration";
require_once ("./assets/includes/sharedHeader.php");
include "./handlers/dbConnection.php";
?>


<body class="register-page">

<!-- NAV BAR -->
<?php include_once("./assets/includes/navigation.php"); ?>

<div class="register container">
    <div class="row justify-content-center align-items-center">
        <div class="register-content col-sm-6">
            <h1 class="text-center">Register Now</h1>
            <p class="text-center">Take off with Acme. Whether it's random blog posts or memes, we've got it all for you. Get started free today!</p>
            <img src="./assets/images/rocket.svg" alt="rocket">
        </div>
        <div class="register-form col-sm-6">
            <form method="post" action="register.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" class="form-control" placeholder="Enter your username" type="text" name="username" value="<?php echo $username; ?>"/>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" class="form-control" placeholder="Enter your email" type="email" name="email" value="<?php echo $email; ?>"/>
                </div>
                <div class="form-group">
                    <label for="password_1">Password</label>
                    <input id="password_1" class="form-control" placeholder="Enter a password" type="password" name="password_1"/>
                </div>
                <div class="form-group">
                    <label for="password_2">Confirm password</label>
                    <input id="password_2" class="form-control" placeholder="Confirm your password" type="password" name="password_2"/>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="register_user">Register Now</button>
                </div>
                <p>Already a member? <a href="./login.php">Sign in</a></p>
                <?php include('handlers/errors.php'); ?>
            </form>
        </div>
    </div>
</div>


</body>
</html>