<?php
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
// fotky z DB
$queryPhotos = "SELECT image_ID, title, cat,img FROM portfolio ORDER BY shared DESC";
$statement1 = $db->prepare($queryPhotos);
$statement1->execute();
$photos = $statement1->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- styl pro public  -->
    <link rel="stylesheet" href="../static/css/admin_styling.css">
    <title>Admin | foto</title>
</head>
<body>
<!-- admin navbar -->
<?php include('../../Blog/admin/includes/navbar.php') ?>

<div class="container">
    <div class="page-header">
        <h1>Porfolio</h1>
        <a class="btn btn-primary" href="add_photo.php"> Nahrát fotku </a>
    </div>
    <br/>
    <div class="row">
        <table class="photo_table">
            <tr>
                <th>Fotka</th>
                <th>Název</th>
                <th>Kategorie</th>
                <th>Smazat</th>
            </tr>
            <?php foreach ($photos as $photo) : ?>
                <tr>
                    <td><img src="../../Portfolio/<?php echo $photo['img']; ?>" class="img-rounded" width="200px"
                             height="200px"/></td>
                    <td><p><?php echo $photo['title']; ?></p></td>
                    <td><p><?php echo $photo['cat']; ?></p></td>
                    <td>
                        <form action="del_photo.php" method="post" id="delete_img_form">
                            <input type="hidden" name="image_ID"
                                   value="<?php echo $photo['photoID']; ?>">
                            <input type="submit" class="btn btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>
</body>
</html>