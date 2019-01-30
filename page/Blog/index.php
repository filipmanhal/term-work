<head>
    <?php include('config.php'); ?>
    <?php require_once('../Blog/includes/public_functions.php') ?>
    <?php require_once('../Blog/includes/registration_login.php') ?>

    <!--všechny příspěvky z DB  -->
    <?php $posts = getPublishedPosts(); ?>

    <?php require_once(ROOT_PATH . '/includes/head_section.php') ?>
    <title>Manhist | Blog </title>
</head>
<body>
<header>
    <!-- navbar -->
    <?php include(ROOT_PATH . '/includes/navbar.php') ?>
</header>

<div class="container">
    <!-- login a registrace-->
    <?php include(ROOT_PATH . '/includes/banner.php') ?>

    <!--obsah uvodni stranky blogu-->
    <div class="content">
        <h2 class="content-title">Příspěvky</h2>
        <hr>
        <!--zobrazeni vsech prispevku-->
        <?php foreach ($posts as $post): ?>
            <div class="post" style="margin-left: 20px;">
                <img src="<?php echo BASE_URL . '/static/images_blog/' . $post['image']; ?>" class="post_image" alt="">
                <?php if (isset($post['topic']['name'])): ?>
                    <a
                            href="<?php echo BASE_URL . 'filtered_posts.php?topic=' . $post['topic']['id'] ?>"
                            class="btn category">
                        <?php echo $post['topic']['name'] ?>
                    </a>
                <?php endif ?>

                <a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">
                    <div class="post_info">
                        <h3><?php echo $post['title'] ?></h3>
                        <div class="info">
                            <span><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></span>
                            <span class="read_more">Zobrazit článek</span>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach ?>
    </div>
</div>
</body>