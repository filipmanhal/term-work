<?php include('config.php'); ?>
<?php include('includes/registration_login.php'); ?>
<?php include('includes/head_section.php'); ?>
<title>Manhist | login </title>
</head>
<body>

<header>
    <!-- Navbar -->
    <?php include(ROOT_PATH . '/includes/navbar.php'); ?>
</header>

<div class="container">

    <div style="width: 40%; margin: 20px auto;">
        <form method="post" action="login.php">
            <h2>Login</h2>
            <?php include(ROOT_PATH . '/includes/errors.php') ?>
            <input type="text" name="username" value="<?php echo $username; ?>" value="" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button type="submit" class="btn" name="login_btn">Login</button>
            <p>
                Založ si účet <a href="register.php">Registrace</a>
            </p>
        </form>
    </div>
</div>
