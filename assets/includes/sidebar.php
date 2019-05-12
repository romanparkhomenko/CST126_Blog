
<nav id="sidebar">
    <a class="sidebar-brand" href="/blog"><img id="nav-logo" src="/blog/assets/images/acme-logo-white.svg" alt="acme-logo"></a>

    <div class="sidebar-links">
        <a href="/blog">Home</a>
        <a href="/blog/handlers/admin/users.php">Manage Users</a>
        <a href="/blog/handlers/admin/categories.php">Manage Categories</a>
        <a href="/blog/handlers/admin/posts.php">Manage Posts</a>
        <a href="/blog/handlers/admin/users.php">Add Users</a>
        <a href="/blog/handlers/admin/create_post.php">Add Posts</a>
        <a href="/blog/search.php">Search</a>
        <!-- Change Nav link based on if logged in or not. -->
        <?php
        if(isset( $_SESSION["username"]) ) {
            echo '<a class="btn btn-danger" href="/blog/index.php?logout=1">Logout</a>';
        } else { ?>
            <a class="nav-item nav-link" href="/blog/register.php">Register</a>
            <a class="nav-item nav-link" href="/blog/login.php">Login</a>
            <?php
        }
        ?>
    </div>
</nav>