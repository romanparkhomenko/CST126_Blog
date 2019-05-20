<?php
/*
 * CST-126 Blog Project Version 8
 * Errors Array
 * Roman Parkhomenko
 * 05/18/2019
 * This array is used to store error and form validation messages
 * that are displayed during form submission.
*/
?>
<?php  if (count($errors) > 0) : ?>
    <div class="error">
        <?php foreach ($errors as $error) : ?>
            <p><?php echo $error ?></p>
        <?php endforeach ?>
    </div>
<?php  endif ?>