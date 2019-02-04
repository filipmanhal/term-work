<?php

session_start();
// connection DB
$conn = new mysqli("localhost", "root", "", "manhistDb");
if (!$conn) {
    die("Error connecting to database: " . mysqli_connect_error());
}

define ('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'http://localhost/manhistWeb/page/Blog/');
?>