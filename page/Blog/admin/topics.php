<html>
<head>
    <?php include('../config.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
    <!-- Get all topics from DB -->
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
            <!-- validation errors for the form -->
            <?php include(ROOT_PATH . '/includes/errors.php') ?>
            <!-- if editing topic, the id is required to identify that topic -->
            <?php if ($isEditingTopic === true): ?>
                <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
            <?php endif ?>
            <input type="text" name="topic_name" value="<?php echo $topic_name; ?>" placeholder="Topic">
            <!-- if editing topic, display the update button instead of create button -->
            <?php if ($isEditingTopic === true): ?>
                <button type="submit" class="btn" name="update_topic">UPDATE</button>
            <?php else: ?>
                <button type="submit" class="btn" name="create_topic">Save Topic</button>
            <?php endif ?>
        </form>
    </div>

    <!-- zobrazeni dat z DB-->
    <div class="table-div">
        <!-- Display notification message -->
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