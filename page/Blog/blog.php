<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('config.php') ?>
    <?php require_once(ROOT_PATH . '/includes/public_functions.php') ?>
    <?php require_once(ROOT_PATH . '/includes/registration_login.php') ?>
    <?php $posts = getPublishedPosts(); ?>
    <?php require_once(ROOT_PATH . '/includes/head_section.php') ?>
    <link href="../../styles/style.css" rel="stylesheet" type="text/css">
    <?php require_once('includes/head_section.php') ?>
    <title>Blog page</title>
</head>
<body>
<div class="container">
    <!--Navbar-->
     <?php include('includes/navBarBlog.php') ?>
    <!-- banner -->
    <?php include('includes/banner.php') ?>
    <!--Page content-->
    <div>
        <?php foreach ($posts as $post): ?>
            <div class="post" style="margin-left: 0px;">
                <img src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" class="post_image" alt="">
                <!-- Added this if statement... -->
                <?php if (isset($post['topic']['name'])): ?>
                    <a href="<?php echo BASE_URL . 'filtered_posts.php?topic=' . $post['topic']['id'] ?>" class="btn category">
                        <?php echo $post['topic']['name'] ?>
                    </a>
                <?php endif ?>

                <a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">
                    <div class="post_info">
                        <h3><?php echo $post['title'] ?></h3>
                        <div class="info">
                            <span><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></span>
                            <span class="read_more">Read more...</span>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach ?>
    </div>
</div>
</body>
</html>

