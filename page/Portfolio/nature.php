<!DOCTYPE html>
<html lang="en">
<head>
    <title>Nature photos</title>
    <?php include('head-gallery.html') ?>
    <?php include ('../../db/connection.php')?>
</head>
<body>
<header>
    <?php include('mainNavbar.html') ?>
</header>
<main>
    <h1>Příroda</h1>
    <div class="gallery">
        <?php
        $sql = "SELECT * FROM portfolio 
                WHERE cat = 'nature' ORDER BY shared DESC";
        $result = mysqli_query($conn,$sql) or die ("Spatny sql dotaz: $sql");
        ?>

        <?php
        while ($row = mysqli_fetch_array($result)) {
            ?>
            <div class="thumnails">
                <a href="<?php echo $row['img']; ?>" data-fancybox="images" data-caption="Příroda">
                    <img src="<?php echo $row['img']; ?>" alt="<?php echo $row['title']; ?>">
                </a>
            </div>
        <?php
        }
        ?>
    </div>
</main>
</body>
</html>