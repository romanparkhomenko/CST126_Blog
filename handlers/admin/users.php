<?php
$pageTitle = "Roman's Blog | Users";

// SHARED HEADER
include ("../dbConnection.php");
require_once ("../../assets/includes/sharedHeader.php");

// GET ADMINS FROM DB
$admins = getAdminUsers();
$roles = ['Admin', 'Author'];

?>

<body>

<div class="wrapper">
    <!-- SIDE BAR -->
    <div class="sidebar">
        <?php include_once("../../assets/includes/sidebar.php"); ?>
    </div>

    <!-- MAIN CONTENT -->
    <div class="users fluid-container">

        <div class="row justify-content-center align-items-start header-row">
            <div class="welcome col-sm-12">
                <h1 class="page-title">Manage Users</h1>
            </div>
        </div>

        <div class="row blog-content">

            <div class="users-form col-sm-3">
                <form method="post" action="users.php">
                    <?php if ($isEditingUser === true): ?>
                        <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                    <?php endif ?>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" class="form-control" placeholder="Enter username" value="<?php echo $username; ?>" type="text" name="username"/>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" class="form-control" placeholder="Enter email" value="<?php echo $email; ?>" name="email"/>
                    </div>
                    <div class="form-group">
                        <label for="password1">Password</label>
                        <input id="password1" class="form-control" placeholder="Enter password" type="password" name="password1"/>
                    </div>
                    <div class="form-group">
                        <label for="password2">Confirm Password</label>
                        <input id="password2" class="form-control" placeholder="Confirm password" type="password" name="password2"/>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" name="role" id="role">
                            <option value="" selected disabled>Assign role</option>
                            <?php foreach ($roles as $key => $role): ?>
                                <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <!-- if editing user, display the update button instead of create button -->
                    <?php if ($isEditingUser === true): ?>
                        <button type="submit" class="btn btn-secondary" name="update_admin">Update</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-primary" name="create_admin">Save User</button>
                    <?php endif ?>

                    <?php include('../errors.php') ?>
                </form>
            </div>

            <!-- Display records from DB-->
            <div class="users-table col-sm-9">
                <!-- Display notification message -->
                <?php include('../messages.php') ?>

                <?php if (empty($admins)): ?>
                    <h3>No Admins In Database</h3>
                <?php else: ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th colspan="2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($admins as $key => $admin): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $admin['username']; ?></td>
                                <td><?php echo $admin['email']; ?></td>
                                <td><?php echo $admin['role']; ?></td>
                                <td>
                                    <a class="fa fa-pencil btn edit" href="users.php?edit-admin=<?php echo $admin['id'] ?>"></a>
                                </td>
                                <td>
                                    <a class="fa fa-trash btn delete" href="users.php?delete-admin=<?php echo $admin['id'] ?>"></a>
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
