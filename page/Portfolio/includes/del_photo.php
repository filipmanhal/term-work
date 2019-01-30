<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 30.01.2019
 * Time: 13:06
 */
include ('dbconfig.php');

$photo_id = filter_input(INPUT_POST, 'photo_id', FILTER_VALIDATE_INT);

if ($photo_id != false) {
    $sql = "DELETE FROM portfolio
              WHERE image_ID = :photo_id";
    $statement = $db->prepare($sql);
    $statement->bindValue(':boxer_id', $photo_id);
    $statement->execute();
    $statement->closeCursor();
}