<html>
<head>
    <?php include('../config.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
    <?php
    //
    $admins = getAdminUsers();
    $roles = ['Admin', 'Author'];
    ?>
    <?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
    <title>Admin | </title>
</head>
<body>
<!-- admin navbar -->
<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
<div class="container content">
    <!--menu -->
    <?php include(ROOT_PATH . '/admin/includes/menu.php') ?>
    <!-- formular pro vytvoreni nebo upravu uzivatele -->
    <div class="action">
        <h1 class="page-title"></h1>

        <form method="post" action="<?php echo BASE_URL . 'admin/users.php'; ?>">

            <!-- overeni validace dat ve formulari -->
            <?php include(ROOT_PATH . '/includes/errors.php') ?>

            <!-- if editing user, the id is required to identify that user -->
            <?php if ($isEditingUser === true): ?>
                <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
            <?php endif ?>

            <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
            <input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <input type="password" name="passwordConfirmation" placeholder="Password confirmation">
            <select name="role">
                <option value="" selected disabled>Práva</option>
                <?php foreach ($roles as $key => $role): ?>
                    <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                <?php endforeach ?>
            </select>

            <!-- button podle editu nebo vytvořeni uzivatele -->
            <?php if ($isEditingUser === true): ?>
                <button type="submit" class="btn" name="update_admin">Upravit</button>
            <?php else: ?>
                <button type="submit" class="btn" name="create_admin">Uložit</button>
            <?php endif ?>
        </form>
    </div>

    <!-- data z DB-->
    <div class="table-div">
        <!-- notification message -->
        <?php include(ROOT_PATH . '/includes/messages.php') ?>

        <?php if (empty($admins)): ?>
            <h1>Admin neexistuje</h1>
        <?php else: ?>
            <table class="table">
                <thead>
                <th>N</th>
                <th>Admin</th>
                <th>Práva</th>
                <th colspan="2">Action</th>
                </thead>
                <tbody>
                <?php foreach ($admins as $key => $admin): ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td>
                            <?php echo $admin['username']; ?>, &nbsp;
                            <?php echo $admin['email']; ?>
                        </td>
                        <td><?php echo $admin['role']; ?></td>
                        <td>
                            <a class="fa fa-pencil btn edit"
                               href="users.php?edit-admin=<?php echo $admin['id'] ?>">
                            </a>
                        </td>
                        <td>
                            <a class="fa fa-trash btn delete"
                               href="users.php?delete-admin=<?php echo $admin['id'] ?>">
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
