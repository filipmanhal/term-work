<!DOCTYPE html>
<html lang="cz">
<head>
    <?php include('headSection.html') ?>
</head>
<body style="background-color: #0E7D92">
<!--menu-->
<header>
    <?php include('mainNavbar.html') ?>
</header>
<main>
    <form class="contact-form" action="contactform.php" method="post">
        <input type="text" name="name" placeholder="Full Name">
        <input type="text" name="mail" placeholder="Your e-mail">
        <input type="text" name="subject" placeholder="Subject">
        <textarea id="subject" name="message" placeholder="Message"></textarea>
        <button id="submit" type="submit" name="submit">ODESLAT </button>
    </form>

</main>
<section id="socialNetworks">
    <table border="0" style="color: transparent;border-color: transparent;position: center">
        <td><a href='https://www.instagram.com/manhist/'><img src='../img/social_icons/if_Intsagram_194923.png' alt='odkaz instagram' style="height: 5vh"/></a></td>
        <td><a href='https://www.facebook.com/profile.php?id=100004542277112'><img src='../img/social_icons/if_Facebook_194929.png' alt='odkaz facebook' style="height: 5vh"/></a></td>
        <td><a href='https://500px.com/filipmahal'><img src='../img/social_icons/if_500px_white.png' alt='odkaz 500px' style="height: 5vh"/></a></td>
    </table>
</section>

</body>
</html>

