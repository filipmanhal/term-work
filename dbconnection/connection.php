<?php
$conn = new mysqli("localhost", "root", "", "manhistDb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

define ('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'http://localhost/manhistWeb/page/Blog/');
?>