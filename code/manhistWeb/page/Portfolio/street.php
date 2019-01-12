<!DOCTYPE html>
<html lang="en">
<head>
    <title>Nature photos</title>
    <?php include('head_Gallery.php') ?>
</head>
<body>
<header>
    <?php include('navBar_Gallery.php') ?>
</header>
<main>
    <h1>Urban and Street</h1>
    <div class="gallery">
        <?php

        $dir = glob('../../img/portfolio_img/street/*.jpg', GLOB_BRACE);

        foreach ($dir as $value) {

            ?>
            <div class="thumnails">
                <a href="<?php echo $value; ?>" data-fancybox="images" data-caption="Urban and Street">
                    <img src="<?php echo $value; ?>" alt="<?php echo $value; ?>">
                </a>
            </div>
            <?php
        }
        ?>
    </div>
</main>
</body>
</html>