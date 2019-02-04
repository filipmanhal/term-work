<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 30.01.2019
 * Time: 13:06
 */

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'manhistDb';

try {
    $db = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}", $DB_USER, $DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

define('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'http://localhost/manhistWeb/page/Blog/');
?>

<?php
$photo_id = filter_input(INPUT_POST, 'photo_id', FILTER_VALIDATE_INT);

if ($photo_id != false) {
    $sql = "DELETE FROM portfolio WHERE image_ID = :photo_id";
    $statement = $db->prepare($sql);
    $statement->bindValue(':photo_id', $photo_id);
    $statement->execute();
    $statement->closeCursor();
}