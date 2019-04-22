<?php
$pageTitle = "Roman's Blog | Categories";

// SHARED HEADER
include ("../dbConnection.php");
require_once ("../../assets/includes/sharedHeader.php");

// GET CATEGORIES FROM DB
$categories = getAllCategories();

?>

<body>

<div class="wrapper">
    <!-- SIDE BAR -->
    <div class="sidebar">
        <?php include_once("../../assets/includes/sidebar.php"); ?>
    </div>

    <!-- MAIN CONTENT -->
    <div class="categories fluid-container">
        <div class="row justify-content-center align-items-start header-row">
            <div class="welcome col-sm-12">
                <h1 class="page-title">Manage Categories</h1>
            </div>
        </div>

        <div class="row blog-content">

            <div class="categories-form col-sm-3">
                <form method="post" action="categories.php">
                    <?php if ($isEditingTopic === true): ?>
                        <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
                    <?php endif ?>

                    <div class="form-group">
                        <label for="topic_name">Category Name</label>
                        <input id="topic_name" class="form-control" placeholder="Enter Category Name" value="<?php echo $topic_name; ?>" type="text" name="topic_name"/>
                    </div>

                    <!-- if editing user, display the update button instead of create button -->
                    <?php if ($isEditingTopic === true): ?>
                        <button type="submit" class="btn btn-secondary" name="update_topic">Update</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-primary" name="create_topic">Save Category</button>
                    <?php endif ?>

                    <?php include('../errors.php') ?>
                </form>
            </div>

            <!-- Display records from DB-->
            <div class="users-table col-sm-9">
                <!-- Display notification message -->
                <?php include('../messages.php') ?>

                <?php if (empty($categories)): ?>
                    <h3>No Categories In Database</h3>
                <?php else: ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th colspan="2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($categories as $key => $category): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $category['name']; ?></td>
                                <td>
                                    <a class="fa fa-pencil btn edit" href="categories.php?edit-topic=<?php echo $category['id'] ?>"></a>
                                </td>
                                <td>
                                    <a class="fa fa-trash btn delete" href="categories.php?delete-topic=<?php echo $category['id'] ?>"></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                <?php endif ?>
            </div>

        </div>
    </div>
</div>

</body>
</html>
