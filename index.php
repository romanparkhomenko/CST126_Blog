<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

require_once ("./assets/includes/sharedHeader.php");

include "./handlers/getUserData.php";
// GET USER DATA
$username = $_SESSION['username'];

?>
<body>
<!-- NAV BAR -->
<?php include_once("./assets/includes/navigation.php"); ?>

<div class="homepage container">
    <div class="row justify-content-center align-items-start">
        <div class="welcome-message col-sm-6">
            <!-- notification message -->
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="error success" >
                    <h4>
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                    </h4>
                </div>
            <?php endif ?>
            <!-- logged in user information -->
            <?php  if (isset($_SESSION['username'])) : ?>
                <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
                <p> <a href="index.php?logout='1'" class="btn btn-danger">logout</a> </p>
            <?php endif ?>
        </div>
        <div class="user-info col-sm-6">
            <details>
                <summary>Your Information</summary>
                <?php getUserData($username); ?>
            </details>
        </div>
    </div>
</div>


</body>
</html>