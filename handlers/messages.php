<?php
/*
 * CST-126 Blog Project Version 8
 * Messages
 * Roman Parkhomenko
 * 05/18/2019
 * This message block will display any error messages added to the session information
*/
?>

<?php if (isset($_SESSION['message'])) : ?>
    <div class="message" >
        <p>
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            ?>
        </p>
    </div>
<?php endif ?>