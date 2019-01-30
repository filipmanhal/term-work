<html>
<head>
    <?php include('../config.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
    <!-- vrací všechny příspěvky -->
    <?php $topics = getAllTopics(); ?>
    <title>Admin | vytvoreni prispevku</title>
</head>
<body>
<!-- admin navbar -->
<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

<div class="container content">
    <!--menu -->
    <?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

    <!-- formulář pro vytvoření a edit příspěvku -->
    <div class="action create-post-div">
        <h1 class="page-title">Příspěvek do blogu</h1>
        <form method="post" enctype="multipart/form-data" action="<?php echo BASE_URL . 'admin/create_post.php'; ?>">
            <!-- chyby ve validaci formulare -->
            <?php include(ROOT_PATH . '/includes/errors.php') ?>

            <!-- id příspěvku pro editaci -->
            <?php if ($isEditingPost === true): ?>
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <?php endif ?>

            <input type="text" name="title" value="<?php echo $title; ?>" placeholder="Titulek">
            <label style="float: left; margin: 5px auto 5px;">Úvodní obrázek</label>
            <input type="file" name="featured_image">
            <textarea name="body" id="body" cols="30" rows="10"><?php echo $body; ?>
            </textarea>
            <select name="topic_id">
                <option value="" selected disabled>Kategorie</option>
                <?php foreach ($topics as $topic): ?>
                    <option value="<?php echo $topic['id']; ?>">
                        <?php echo $topic['name']; ?>
                    </option>
                <?php endforeach ?>
            </select>

            <!-- zobrazeni možnosti zverejneni pouze pro Admina -->
            <?php if ($_SESSION['user']['role'] == "Admin"): ?>
                <?php if ($published == true): ?>
                    <label for="publish">
                        Zveřejnit
                        <input type="checkbox" value="1" name="publish" checked="checked">&nbsp;
                    </label>
                <?php else: ?>
                    <label for="publish">
                        Zveřejnit
                        <input type="checkbox" value="1" name="publish">&nbsp;
                    </label>
                <?php endif ?>
            <?php endif ?>

            <!-- Zobrazeni Upravit místo Uložit -->
            <?php if ($isEditingPost === true): ?>
                <button type="submit" class="btn" name="update_post">Upravit</button>
            <?php else: ?>
                <button type="submit" class="btn" name="create_post">Uložit</button>
            <?php endif ?>

        </form>
    </div>
</div>
</body>
</html>

<script>
    CKEDITOR.replace('body');
</script>
