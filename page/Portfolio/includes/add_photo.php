<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 30.01.2019
 * Time: 13:06
 */
error_reporting(~E_NOTICE); // avoid notice
require_once('dbconfig.php');
if (isset($_POST['btnsave'])) {
    $titulek = $_POST['imgtitle'];// boxer name
    $categorie = $_POST['imgcat'];// boxer weight

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
        $upload_dir = '../imgGallery'; // upload directory

        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

// valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

// rename uploading image
        $photo = rand(1000, 1000000) . "." . $imgExt;

// allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
// Check file size '5MB'
            if ($imgSize < 5000000) {
                move_uploaded_file($tmp_dir, $upload_dir . $photo);
            } else {
                $error_message = "Sorry, your file is too large.";
            }
        } else {
            $error_message = "Pouze JPG, JPEG, PNG, GIF";
        }
    }
// if no error occured, continue ....
    if (!isset($error_message)) {
        $statement = $db->prepare('INSERT INTO portfolio(title,cat,img,shared) VALUES(:ptitle, :pcat, :pimg, now())');
        $statement->bindParam(':ptitle', $titulek);
        $statement->bindParam(':pcat', $categorie);
        $statement->bindParam(':pimg', $photo);

        if ($statement->execute()) {
            $successMSG = "new record succesfully inserted ...";
            header("refresh:2;index.php"); // redirects image view page after 2 seconds.
        } else {
            $error_message = "error while inserting....";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Upload, Insert, Update, Delete an Image using PHP MySQL</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container">
    <div class="page-header">
        <h1>Nahrát novou fotografii</h1>
        <a class="btn btn-primary" href="index.php">Zobrazit všechny </a>
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
                <td><input class="form-control" type="text" name="imgtitle" placeholder="Enter Name"
                           value="<?php echo $titulek; ?>"/></td>
            </tr>
            <tr>
                <td><label class="control-label">cat</label></td>
                <td><input class="form-control" type="text" name="imgcat" placeholder="Weight Category"
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
<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
        integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
        crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
        integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
        crossorigin="anonymous"></script>
</body>
</html>