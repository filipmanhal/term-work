<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>manhist homepage</title>
    <link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>
<body id="homebackground">
<header>
    <div class="navBar" id="myNavBar">
        <a href="reference.php">Reference</a>
        <a href="contact.php">Kontakt</a>
        <a href="Blog/blog.php">Blog</a>
        <div class="dropdown">
            <button class="dropbtn">Portfolio
                <i class="fa fa-caret-down"></i>
                <a href="portfolio.php"></a>
            </button>
            <div class="dropdown-content">
                <a href="Portfolio/nature.php">Příroda</a>
                <a href="Portfolio/street.php">Street</a>
                <a href="Portfolio/portrait.php">Portréty</a>
                <a href="Portfolio/product.php">Produkty</a>
            </div>
        </div>
        <a href="about.php">O mně</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>

        <!--home logo-->
        <div id="headLogo">
            <a href='index.php'><img src="../img/MANHISTWEB_CERNA.png" alt="logo" style="width:100%;height:100%;position: center"></a>
        </div>
    </div>
</header>

<main>
    <section class="socialNetworks">
        <table border="0" style="color: transparent;border-color: transparent;position: center">
            <td><a href='https://www.instagram.com/manhist/'><img src='../img/social_icons/if_Instagram_white.png' alt='odkaz instagram' style="height: 5vh"/></a></td>
            <td><a href='https://www.facebook.com/profile.php?id=100004542277112'><img src='../img/social_icons/if_Facebook_white.png' alt='odkaz facebook' style="height: 5vh"/></a></td>
            <td><a href='https://500px.com/filipmahal'><img src='../img/social_icons/if_500px_white.png' alt='odkaz 500px' style="height: 5vh"/></a></td>
            <td><a href='mailto:filipmanhal@gmail.com?subject=work together'><img src='../img/social_icons/if_Mail_white.png' alt='odkaz mail' style="height: 5vh"/></a></td>
        </table>
    </section>
</main>

<footer>
    <section id="copyleft">
        <p>
            Copyleft
            <?= date("Y", strtotime("-1 year")); ?>
            -
            <?php echo date("Y"); ?>
            <a>Filip Maňhal</a>
        </p>
    </section>
</footer>
</body>
</html>