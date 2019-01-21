<html>
<head>
    <?php include('../config.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
    <!-- vsechny kategorie z DB -->
    <?php $topics = getAllTopics(); ?>
    <title>Admin | kategorie</title>
</head>
<body>
<!-- admin navbar -->
<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
<div class="container content">
    <!--menu -->
    <?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

    <!-- formular-->
    <div class="action">
        <h1 class="page-title">Vytvořit/upravit kategorii</h1>
        <form method="post" action="<?php echo BASE_URL . 'admin/topics.php'; ?>">
            <!-- error při validaci formuláře -->
            <?php include(ROOT_PATH . '/includes/errors.php') ?>
            <!-- id kategorie při editaci -->
            <?php if ($isEditingTopic === true): ?>
                <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
            <?php endif ?>
            <input type="text" name="topic_name" value="<?php echo $topic_name; ?>" placeholder="Kategorie">
            <!-- editace (zobrazení update nebo create btn)-->
            <?php if ($isEditingTopic === true): ?>
                <button type="submit" class="btn" name="update_topic">UPDATE</button>
            <?php else: ?>
                <button type="submit" class="btn" name="create_topic">Uložit kategorii</button>
            <?php endif ?>
        </form>
    </div>

    <!-- zobrazeni dat z DB-->
    <div class="table-div">
        <!-- notifikační zpráva -->
        <?php include(ROOT_PATH . '/includes/messages.php') ?>
        <?php if (empty($topics)): ?>
            <h1>Žádná kategorie</h1>
        <?php else: ?>
            <table class="table">
                <thead>
                <th>N</th>
                <th>Název kategorie</th>
                <th colspan="2">Action</th>
                </thead>
                <tbody>
                <?php foreach ($topics as $key => $topic): ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $topic['name']; ?></td>
                        <td>
                            <a class="fa fa-pencil btn edit"
                               href="topics.php?edit-topic=<?php echo $topic['id'] ?>">
                            </a>
                        </td>
                        <td>
                            <a class="fa fa-trash btn delete"
                               href="topics.php?delete-topic=<?php echo $topic['id'] ?>">
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </div>
</div>
</body>
</html>