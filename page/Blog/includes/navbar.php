<!--menu bar -->
<nav>
    <ul>
        <li><a href="../../page/about.php">O mně</a></li>
        <li class="sub-menu"><a href="#">Portfolio</a>
            <ul>
                <li>
                    <a href="../../page/Portfolio/nature.php">Příroda</a>
                </li>
                <li>
                    <a href="../../page/Portfolio/street.php">Street</a>
                </li>
                <li>
                    <a href="../../page/Portfolio/portrait.php">Portréty</a>
                </li>
                <li>
                    <a href="../../page/Portfolio/product.php">Produkty</a>
                </li>
            </ul>
        </li>
        <li><a href="../../page/Blog/index.php">Blog</a></li>
        <li><a href="../../page/contact.php">Kontakt</a></li>
        <li><a href="../../page/reference.php">Reference</a></li>

    </ul>
</nav>
<!--home logo-->
<div id="headLogo">
    <a href='../../page/index.php'><img src="../../img/MANHISTWEB_CERNA.png" alt="logo" style="width:15%;height:auto ;position: center"></a>
</div>
<div class="menu-toggle">
    <i class="fa fa-bars" aria-hidden="true"></i>
</div>
<!--funkce na dropdownmenu-->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(
        function() {
            $('.menu-toggle').click(function() {
                $('nav').toggleClass('active')
            })
            $('ul li').click(function() {
                $(this).siblings().removeClass('active');
                $(this).toggleClass('active');
            })
        }
    )
</script>