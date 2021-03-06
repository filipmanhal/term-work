<?php if (isset($_SESSION['user']['username'])) { ?>
    <div class="logged_in_info">
        <span>uživatel: <?php echo $_SESSION['user']['username'] ?></span>
        |
        <span><a href="logout.php">odhlásit se</a></span>
    </div>
<?php } else { ?>
    <div class="banner">
        <div class="welcome_msg">
            <p>
                Vytvoření účtu na blogu.<br>
            </p>
            <a href="register.php" class="btn">Registrace</a>
        </div>

        <div class="login_div">
            <form action="<?php echo BASE_URL . 'blog.php'; ?>" method="post">
                <h2>Login</h2>
                <div style="width: 60%; margin: 0px auto;">
                    <?php include(ROOT_PATH . '/includes/errors.php') ?>
                </div>
                <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Jméno">
                <input type="password" name="password" placeholder="Heslo">
                <button class="btn" type="submit" name="login_btn">Přihlásit se</button>
            </form>
        </div>
    </div>
<?php } ?>
