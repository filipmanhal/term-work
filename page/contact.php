<!DOCTYPE html>
<html lang="cz">
<head>
    <?php include('headSection.html') ?>
</head>
<header>
    <?php include('mainNavbar.html') ?>
    <link rel="stylesheet" href="../styles/contactFormStyle.css">

</header>

<body style="background-color: #ffffff">
<!--menu-->


<!--kontaktni formular-->
<div class="container">
    <form class="contact-form" action="contactform.php" method="post">
        <input type="text" id="name" name="fullname" placeholder="Celé jméno">
        <input type="text" id="mail" name="mailaddres" placeholder="Váš email">
        <input type="text" id="sub" name="subject" placeholder="Předmět">
        <textarea id="msg" name="message" placeholder="Zpráva"></textarea>
        <button type="submit" name="submit">ODESLAT</button>
    </form>
</div>

<!--socialni site-->
<div class="media-contact">
    <ul>
        <li><a href='https://www.instagram.com/manhist/'><img src='../img/social_icons/if_Intsagram_194923.png'
                                                              alt='odkaz instagram' style="height: 5vh"/></a></li>
        <li><a href='https://www.facebook.com/profile.php?id=100004542277112'><img
                        src='../img/social_icons/if_Facebook_194929.png' alt='odkaz facebook' style="height: 5vh"/></a>
        </li>
        <li><a href='https://500px.com/filipmahal'><img src='../img/social_icons/if_500px.png' alt='odkaz 500px'
                                                        style="height: 5vh"/></a></li>
    </ul>
</div>
</body>
</html>

