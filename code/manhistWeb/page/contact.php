<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog page</title>
    <link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <div class="navBar" id="myNavBar">
        <a href="reference.php">References</a>
        <a href="contact.php">Contact</a>
        <a href="Blog/blog.php">Blog</a>
        <div class="dropdown">
            <button class="dropbtn">Portfolio
                <i class="fa fa-caret-down"></i>
                <a href="portfolio.php"></a>
            </button>
            <div class="dropdown-content">
                <a href="Portfolio/nature.php">Nature</a>
                <a href="Portfolio/street.php">Urban and Street</a>
                <a href="Portfolio/portrait.php">Portrait</a>
                <a href="Portfolio/product.php">Product</a>
            </div>
        </div>
        <a href="about.php">About me</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>

        <!--home logo-->
        <div id="headLogo">
            <a href='index.php'><img src="../img/MANHISTWEB_CERNA.png" alt="logo" style="width:100%;height:100%;position: center"></a>
        </div>
    </div>
</header>
</body>
</html>