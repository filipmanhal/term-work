<head>
    <?php include('config.php'); ?>
    <?php include('includes/public_functions.php'); ?>
    <?php include('includes/head_section.php'); ?>
    <?php
    // příspěvky pod kategorií
    if (isset($_GET['topic'])) {
        $topic_id = $_GET['topic'];
        $posts = getPublishedPostsByTopic($topic_id);
    }
    ?>
</head>
<body>
<header>
    <!-- Navbar -->
    <?php include(ROOT_PATH . '/includes/navbar.php'); ?>
</header>
<div class="container">
    <!-- content -->
    <div class="content">
        <h2 class="content-title">
            Příspěvky v <u><?php echo getTopicNameById($topic_id); ?></u>
        </h2>
        <hr>
        <?php foreach ($posts as $post): ?>
            <div class="post" style="margin-left: 0;">
                <img src="<?php echo BASE_URL . 'static/images_blog/' . $post['image']; ?>" class="post_image" alt="">
                <a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">
                    <div class="post_info">
                        <h3><?php echo $post['title'] ?></h3>
                        <div class="info">
                            <span><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></span>
                            <span class="read_more">Zobrazit příspěvek</span>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach ?>
    </div>
</div>