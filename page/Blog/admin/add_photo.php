<!DOCTYPE html>
<html>

<?php include('../config.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
</head>
<!-- admin navbar -->

<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 30.01.2019
 * Time: 13:06
 */
error_reporting(~E_NOTICE); // avoid notice
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

if (isset($_POST['btnsave'])) {
    $titulek = $_POST['imgtitle'];// titulek fotky
    $categorie = $_POST['imgcat'];// kategorie fotky

    $imgFile = $_FILES['bimage']['name'];
    $tmp_dir = $_FILES['bimage']['tmp_name'];
    $imgSize = $_FILES['bimage']['size'];


    if (empty($titulek)) {
        $error_message = "title je prázdný";
    } else if (empty($categorie)) {
        $error_message = "kategorie je prázdná";
    } else if (empty($imgFile)) {
        $error_message = "není vybrán obrázek";
    } else {
        $upload_dir = '../../Portfolio/'; // adresar pro upload fotky

        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

// validace format
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

// random cislo fotky
        $photo = "imgGallery/" . rand(1000, 1000000) . "." . $imgExt;

        if (in_array($imgExt, $valid_extensions)) {
// kontrola velikosti mensi nez 5 MB
            if ($imgSize < 5000000) {
                move_uploaded_file($tmp_dir, $upload_dir . $photo);
            } else {
                $error_message = "Fotografie je příliš veliká";
            }
        } else {
            $error_message = "Pouze JPG, JPEG, PNG, GIF";
        }
    }
// nahrani fotky pokud nedoslo k chybe
    if (!isset($error_message)) {
        $statement = $db->prepare('INSERT INTO portfolio(title,cat,img,shared) VALUES(:ptitle, :pcat, :pimg, now())');
        $statement->bindParam(':ptitle', $titulek);
        $statement->bindParam(':pcat', $categorie);
        $statement->bindParam(':pimg', $photo);

        if ($statement->execute()) {
            $successMSG = "fotka úspěšně vložena";
            header("refresh:2;photos.php"); // zobrazeni vsech fotek po 2s
        } else {
            $error_message = "chyba při vkládání fotky";
        }
    }
}
?>

<body>
<!-- admin navbar -->
<?php include('../../Blog/admin/includes/navbar.php') ?>

<div class="container">
    <!--menu -->
    <?php include('../../Blog/admin/includes/menu.php') ?>

    <div class="page-header">
        <h1>Nahrát novou fotografii</h1>
        <a class="btn btn-primary" href="photos.php">Zobrazit všechny </a>
    </div>
    <?php
    if (isset($error_message)) {
        ?>
        <div class="alert alert-danger">
            <strong><?php echo $error_message; ?></strong>
        </div>
        <?php
    } else if (isset($successMSG)) {
        ?>
        <div class="alert alert-success">
            <strong><?php echo $successMSG; ?></strong>
        </div>
        <?php
    }
    ?>

    <form method="post" enctype="multipart/form-data" class="form-horizontal">
        <table class="table table-bordered table-responsive micro">
            <tr>
                <td><label class="control-label">title</label></td>
                <td><input class="form-control" type="text" name="imgtitle" placeholder="Název fotografie"
                           value="<?php echo $titulek; ?>"/></td>
            </tr>
            <tr>
                <td><label class="control-label">cat</label></td>
                <td><input class="form-control" type="text" name="imgcat" placeholder="Kategorie fotografie"
                           value="<?php echo $categorie; ?>"/></td>
            </tr>
            <tr>
                <td><label class="control-label">img</label></td>
                <td><input class="input-group" type="file" name="bimage" accept="image/*"/></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="btnsave" class="btn btn-success">Uložit</button>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>