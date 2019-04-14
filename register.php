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
        <div class="register-form col-sm-6">
            <h1 class="text-center">Register Now</h1>

            <form method="post" action="register.php">
                <div class="credentials">
                    <h4>Your Credentials</h4>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" class="form-control" placeholder="Enter your username" type="text" name="username"/>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" class="form-control" placeholder="Enter your email" type="email" name="email" />
                    </div>
                    <div class="form-group">
                        <label for="password_1">Password</label>
                        <input id="password_1" class="form-control" placeholder="Enter a password" type="password" name="password_1"/>
                    </div>
                    <div class="form-group">
                        <label for="password_2">Confirm password</label>
                        <input id="password_2" class="form-control" placeholder="Confirm your password" type="password" name="password_2"/>
                    </div>
                </div>

                <div class="about-you">
                    <h4>About You</h4>
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input id="firstname" class="form-control" placeholder="Enter your First Name" type="text" name="firstname" />
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input id="lastname" class="form-control" placeholder="Enter your Last Name" type="text" name="lastname" />
                    </div>
                    <div class="form-group">
                        <label for="middlename">Middle Name</label>
                        <input id="middlename" class="form-control" placeholder="Enter your Middle Name" type="text" name="middlename" />
                    </div>
                    <div class="form-group">
                        <label for="nickname">Nickname</label>
                        <input id="nickname" class="form-control" placeholder="Enter your Nickname" type="text" name="nickname" />
                    </div>
                </div>

                <div class="location">
                    <h4>Where You At?</h4>
                    <div class="form-group">
                        <label for="address1">Address 1</label>
                        <input id="address1" class="form-control" placeholder="Address 1" type="text" name="address1" />
                    </div>
                    <div class="form-group">
                        <label for="address2">Address 2</label>
                        <input id="address2" class="form-control" placeholder="Address 2" type="text" name="address2" />
                    </div>
                    <div class="address-info">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input id="city" class="form-control" placeholder="City" type="text" name="city" />
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input id="state" class="form-control" placeholder="ST" type="text" name="state" />
                        </div>
                        <div class="form-group">
                            <label for="zipcode">Zip</label>
                            <input id="zipcode" class="form-control" placeholder="Zip" type="text" name="zipcode" />
                        </div>
                    </div>
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