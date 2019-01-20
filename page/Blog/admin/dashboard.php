<html>
<head>
    <?php include('../config.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
    <title>Admin | Dashboard</title>
</head>
<body>
<div class="header">
    <div class="logo">
        <a href="<?php echo BASE_URL . 'admin/dashboard.php' ?>">
            <h1>Blog | správa</h1>
        </a>
    </div>
    <?php if (isset($_SESSION['user'])): ?>
        <div class="user-info">
            <span><?php echo $_SESSION['user']['username'] ?></span> &nbsp; &nbsp;
            <a href="<?php echo BASE_URL . 'logout.php'; ?>" class="logout-btn">logout</a>
        </div>
    <?php endif ?>
</div>
<div class="container dashboard">
    <div class="stats">
        <a href="create_post.php">
            <span>Vytvořit příspěvek</span>
        </a>
        <a href="posts.php">
            <span>Spravovat příspěvky</span>
        </a>
        <a href="users.php" class="first">
            <span>Spravovat uživatele</span>
        </a>
        <a href="topics.php">
            <span>Spravovat kategorie</span>
        </a>
    </div>
</div>
</body>
</html>
