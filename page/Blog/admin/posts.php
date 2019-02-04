<html>
<head>
    <?php include('../config.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>

    <!--všechny příspěvky z DB -->
    <?php $posts = getAllPosts(); ?>
</head>
<body>
<!-- admin navbar -->
<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

<div class="container content">
    <!-- menu -->
    <?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

    <!-- data z DB-->
    <div class="table-div" style="width: 80%;">
        <!-- notifikační zpráva -->
        <?php include(ROOT_PATH . '/includes/messages.php') ?>

        <?php if (empty($posts)): ?>
            <h1 style="text-align: center; margin-top: 20px;">Žádné příspěvky</h1>
        <?php else: ?>
            <table class="table">
                <thead>
                <th>N</th>
                <th>Autor</th>
                <th>Titulek</th>
                <!--pouze admin muze zverejnit prispevek)-->
                <?php if ($_SESSION['user']['role'] == "Admin"): ?>
                    <th>
                        <small>Zveřejnit</small>
                    </th>
                <?php endif ?>
                <th>
                    <small>Upravit</small>
                </th>
                <th>
                    <small>Odstranit</small>
                </th>
                </thead>
                <tbody>
                <?php foreach ($posts as $key => $post): ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $post['author']; ?></td>
                        <td>
                            <a target="_blank"
                               href="<?php echo BASE_URL . 'single_post.php?post-slug=' . $post['slug'] ?>">
                                <?php echo $post['title']; ?>
                            </a>
                        </td>
                        <!-- pouze admin muze zverejnit prispevek-->
                        <?php if ($_SESSION['user']['role'] == "Admin"): ?>
                            <td>
                                <?php if ($post['published'] == true): ?>
                                    <a class="fa fa-check btn unpublish"
                                       href="posts.php?unpublish=<?php echo $post['id'] ?>">
                                    </a>
                                <?php else: ?>
                                    <a class="fa fa-times btn publish"
                                       href="posts.php?publish=<?php echo $post['id'] ?>">
                                    </a>
                                <?php endif ?>
                            </td>
                        <?php endif ?>

                        <td>
                            <a class="fa fa-pencil btn edit"
                               href="create_post.php?edit-post=<?php echo $post['id'] ?>">
                            </a>
                        </td>
                        <td>
                            <a class="fa fa-trash btn delete"
                               href="create_post.php?delete-post=<?php echo $post['id'] ?>">
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </div>
</div>
<div class="card"><a
    <a href="export.php" style="max-width: 20%;margin-left: 10%;" class="btn btn-primary">Export </a>

</div>
</body>
</html>
