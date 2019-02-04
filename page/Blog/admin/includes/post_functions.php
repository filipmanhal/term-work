<?php
// proměnné pro příspěvek
$post_id = 0;
$isEditingPost = false;
$published = 0;
$title = "";
$post_slug = "";
$body = "";
$featured_image = "";
$post_topic = "";


/*funkce příspěvku*********/
function getAllPosts()
{
    global $conn;

    // admin vidí všechny příspěvky
    // autor vidí pouze svoje příspěvky
    if ($_SESSION['user']['role'] == "Admin") {
        $sql = "SELECT * FROM posts";
    } elseif ($_SESSION['user']['role'] == "Author") {
        $user_id = $_SESSION['user']['id'];
        $sql = "SELECT * FROM posts WHERE user_id=$user_id";
    }
    $result = mysqli_query($conn, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $final_posts = array();
    foreach ($posts as $post) {
        $post['author'] = getPostAuthorById($post['user_id']);
        array_push($final_posts, $post);
    }
    return $final_posts;
}

// získání autora příspěvku
function getPostAuthorById($user_id)
{
    global $conn;
    $sql = "SELECT username FROM users WHERE id=$user_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        //vrací přezdívku (username)
        return mysqli_fetch_assoc($result)['username'];
    } else {
        return null;
    }
}

/*Příspěvek*/

// pro možnost Vytvořit příspěvek
if (isset($_POST['create_post'])) {
    createPost($_POST);
}
// pro button Editovat
if (isset($_GET['edit-post'])) {
    $isEditingPost = true;
    $post_id = $_GET['edit-post'];
    editPost($post_id);
}
// pro button Zveřejnit
if (isset($_POST['update_post'])) {
    updatePost($_POST);
}
// pro button Odstranit
if (isset($_GET['delete-post'])) {
    $post_id = $_GET['delete-post'];
    deletePost($post_id);
}

/*Funkce na příspěvek*/
function createPost($request_values)
{
    global $conn, $errors, $title, $featured_image, $topic_id, $body, $published;
    $title = esc($request_values['title']);
    $body = htmlentities(esc($request_values['body']));
    if (isset($request_values['topic_id'])) {
        $topic_id = esc($request_values['topic_id']);
    }
    if (isset($request_values['publish'])) {
        $published = esc($request_values['publish']);
    }
    // slug: identifikátor, zda příspěvek s titulkem již existuje (Nové tělo od Nikon nové-tělo-od-nikon)
    $post_slug = makeSlug($title);
    // validace dat ve formuláři
    if (empty($title)) {
        array_push($errors, "Titulek příspěvku je povinný!");
    }
    if (empty($body)) {
        array_push($errors, "Chybí text příspěvku!");
    }
    if (empty($topic_id)) {
        array_push($errors, "Kategorie je povinná!");
    }
    //nazev img
    $featured_image = $_FILES['featured_image']['name'];
    if (empty($featured_image)) {
        array_push($errors, "Příspěvek musí mít úvodní obrázek!");
    }
    // adresar pro uvodni img k prispevku
    $target = "../static/images_blog/" . basename($featured_image);
    if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
        array_push($errors, "Nepodařilo se nahrát obrázek.");
    }

    //ověření, zda neexistuje příspěvek pod stejný názvem
    $post_check_query = "SELECT * FROM posts WHERE slug='$post_slug' LIMIT 1";
    $result = mysqli_query($conn, $post_check_query);

    //vrací chybu, pokud příspěvek již existuje
    if (mysqli_num_rows($result) > 0) {
        array_push($errors, "Příspěvek s tímto titulkem existuje!");
    }
    //vytvoření příspěvku, pokud nedošlo k chybě
    if (count($errors) == 0) {
        $query = "INSERT INTO posts (user_id, title, slug, image, body, published, created_at, updated_at)
                  VALUES(1, '$title', '$post_slug', '$featured_image', '$body', $published, now(), now())";
        if (mysqli_query($conn, $query)) {
            $inserted_post_id = mysqli_insert_id($conn);
            // vazba mezi kategorii a prispevkem
            $sql = "INSERT INTO post_topic (post_id, topic_id) VALUES($inserted_post_id, $topic_id)";
            mysqli_query($conn, $sql);

            $_SESSION['message'] = "Příspěvek byl úspěšně vytvořen";
            header('location: posts.php');
            exit(0);
        }
    }
}

//editace prispevku
function editPost($role_id)
{
    global $conn, $title, $post_slug, $body, $published, $isEditingPost, $post_id;
    $sql = "SELECT * FROM posts WHERE id=$role_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);
    // vyplnění formuláře daty z databaze, při editu příspěvku
    $title = $post['title'];
    $body = $post['body'];
    $published = $post['published'];
}

function updatePost($request_values)
{
    global $conn, $errors, $post_id, $title, $featured_image, $topic_id, $body, $published;

    $title = esc($request_values['title']);
    $body = esc($request_values['body']);
    $post_id = esc($request_values['post_id']);
    if (isset($request_values['topic_id'])) {
        $topic_id = esc($request_values['topic_id']);
    }
    //slug: identifikator prispevku(nazev)
    $post_slug = makeSlug($title);

    if (empty($title)) {
        array_push($errors, "Titulek příspěvku chybí");
    }
    if (empty($body)) {
        array_push($errors, "Text příspěvku chybí");
    }
    if (isset($_POST['featured_image'])) {
        $featured_image = $_FILES['featured_image']['name'];
        // adresář pro obrázky k příspěvkům
        $target = "../static/images/" . basename($featured_image);
        if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
            array_push($errors, "Failed to upload image. Please check file settings for your server");
        }
    }

    // vytvoreni, pokud nedojde k chybe
    if (count($errors) == 0) {
        $query = "UPDATE posts SET title='$title', slug='$post_slug', views=0, image='$featured_image', body='$body', published=$published, updated_at=now() WHERE id=$post_id";
        if (mysqli_query($conn, $query)) {
            if (isset($topic_id)) {
                $inserted_post_id = mysqli_insert_id($conn);
                // relace kategorie a prispevku
                $sql = "INSERT INTO post_topic (post_id, topic_id) VALUES($inserted_post_id, $topic_id)";
                mysqli_query($conn, $sql);
                $_SESSION['message'] = "Příspěvek byl vytvořen";
                header('location: posts.php');
                exit(0);
            }
        }
        $_SESSION['message'] = "Post updated successfully";
        header('location: posts.php');
        exit(0);
    }
}

// odstranění příspěvku z DB
function deletePost($post_id)
{
    global $conn;
    $sql = "DELETE FROM posts WHERE id=$post_id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Příspěvek byl odstraněn";
        header("location: posts.php");
        exit(0);
    }
}

//zveřenění příspěvku na blogu
if (isset($_GET['publish']) || isset($_GET['unpublish'])) {
    $message = "";
    if (isset($_GET['publish'])) {
        $message = "Příspěvek je zveřejněný";
        $post_id = $_GET['publish'];
    } else if (isset($_GET['unpublish'])) {
        $message = "Příspěvek není zveřejněný";
        $post_id = $_GET['unpublish'];
    }
    togglePublishPost($post_id, $message);
}

function togglePublishPost($post_id, $message)
{
    global $conn;
    $sql = "UPDATE posts SET published=!published WHERE id=$post_id";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = $message;
        header("location: posts.php");
        exit(0);
    }
}

?>