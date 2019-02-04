<?php include('config.php'); ?>
<?php include('includes/registration_login.php'); ?>
<?php include('includes/head_section.php'); ?>

<title>Manhist | registrace </title>
</head>
<header>
    <!-- Navbar -->
    <?php include(ROOT_PATH . '/includes/navbar.php'); ?>
    <!-- // Navbar -->
</header>
<body>

<div class="container">


    <div style="width: 40%; margin: 20px auto;">
        <form method="post" action="register.php">
            <h2>Registrace na blog</h2>
            <?php include(ROOT_PATH . '/includes/errors.php') ?>
            <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Jméno">
            <input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
            <input type="password" name="password_1" placeholder="Heslo">
            <input type="password" name="password_2" placeholder="Potvrzení hesla">
            <button type="submit" class="btn" name="reg_user">Registrovat</button>
            <p>
                Už máš účet? <a href="login.php">Přihlásit se</a>
            </p>
        </form>
    </div>
</div>
</body>