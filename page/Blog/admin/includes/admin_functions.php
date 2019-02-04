<?php
// proměnné Admin
$admin_id = 0;
$isEditingUser = false;
$username = "";
$role = "";
$email = "";

// proměnné příspěvek
$topic_id = 0;
$isEditingTopic = false;
$topic_name = "";

// general variables
$errors = [];

/*Admin funkce*/
// po kliknutí na button vytvoření admina/autora
if (isset($_POST['create_admin'])) {
    createAdmin($_POST);
}
// po kliknutí na button editovat admina/autora
if (isset($_GET['edit-admin'])) {
    $isEditingUser = true;
    $admin_id = $_GET['edit-admin'];
    editAdmin($admin_id);
}
// po kliknutí na button update admina/autora
if (isset($_POST['update_admin'])) {
    updateAdmin($_POST);
}
// po kliknutí na button smazání admina/autora
if (isset($_GET['delete-admin'])) {
    $admin_id = $_GET['delete-admin'];
    deleteAdmin($admin_id);
}

/*kategorie*/
// po kliknutí na vytvoření kategorie
if (isset($_POST['create_topic'])) {
    createTopic($_POST);
}
// po kliknutí na editaci kategorie
if (isset($_GET['edit-topic'])) {
    $isEditingTopic = true;
    $topic_id = $_GET['edit-topic'];
    editTopic($topic_id);
}

// po kliknutí na button update kategorie
if (isset($_POST['update_topic'])) {
    updateTopic($_POST);
}
// po kliknutí na button smazání kategorie
if (isset($_GET['delete-topic'])) {
    $topic_id = $_GET['delete-topic'];
    deleteTopic($topic_id);
}


/*Funkce pro uživatele s právy Admin*/

/*vytvoření nového admina*/
function createAdmin($request_values)
{
    global $conn, $errors, $role, $username, $email;
    $username = esc($request_values['username']);
    $email = esc($request_values['email']);
    $password = esc($request_values['password']);
    $passwordConfirmation = esc($request_values['passwordConfirmation']);

    if (isset($request_values['role'])) {
        $role = esc($request_values['role']);
    }
    // validace formuláře
    if (empty($username)) {
        array_push($errors, "Chybí přihlašovací jméno!");
    }
    if (empty($email)) {
        array_push($errors, "Email je povinný");
    }
    if (empty($role)) {
        array_push($errors, "Role is required for admin users");
    }
    if (empty($password)) {
        array_push($errors, "Nesprávné heslo!");
    }
    if ($password != $passwordConfirmation) {
        array_push($errors, "Hesla se neshodují!");
    }
    // žádný uživatel nesmí být v DB dvakrát
    // email a useraname musí být unikátní
    $user_check_query = "SELECT * FROM users WHERE username='$username' 
							OR email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) { // pokud existuje uživatel
        if ($user['username'] === $username) {
            array_push($errors, "Username už existuje");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Email už existuje");
        }
    }
    // registrace uživatele, pokud nedošlo k chybě
    if (count($errors) == 0) {
        $password = md5($password);//šifrování MD5 než se nahrajou data do DB
        $query = "INSERT INTO users (username, email, role, password, created_at, updated_at) 
				  VALUES('$username', '$email', '$role', '$password', now(), now())";
        mysqli_query($conn, $query);

        $_SESSION['message'] = "Admin byl vytvořen";
        header('location: users.php');
        exit(0);
    }
}


/*fetch admina z DB podle id*/
/*editace */
function editAdmin($admin_id)
{
    global $conn, $username, $role, $isEditingUser, $admin_id, $email;

    $sql = "SELECT * FROM users WHERE id=$admin_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $admin = mysqli_fetch_assoc($result);

    // předání username a email do formuláře při editaci
    $username = $admin['username'];
    $email = $admin['email'];
}


function updateAdmin($request_values)
{
    global $conn, $errors, $role, $username, $isEditingUser, $admin_id, $email;
    // id admina pro update
    $admin_id = $request_values['admin_id'];
    $isEditingUser = false;


    $username = esc($request_values['username']);
    $email = esc($request_values['email']);
    $password = esc($request_values['password']);
    $passwordConfirmation = esc($request_values['passwordConfirmation']);
    if (isset($request_values['role'])) {
        $role = $request_values['role'];
    }
    // vytvoření, pokud nedošlo k chybě
    if (count($errors) == 0) {
        //šifrování hesla
        $password = md5($password);

        $query = "UPDATE users SET username='$username', email='$email', role='$role', password='$password' WHERE id=$admin_id";
        mysqli_query($conn, $query);

        $_SESSION['message'] = "Admin úspěšně upraven";
        header('location: users.php');
        exit(0);
    }
}

// smazání uživatele
function deleteAdmin($admin_id)
{
    global $conn;
    $sql = "DELETE FROM users WHERE id=$admin_id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Uživatel smazán";
        header("location: users.php");
        exit(0);
    }
}

/*Funkce na kategorii*/
// vrací všechny příspěvky z DB
function getAllTopics()
{
    global $conn;
    $sql = "SELECT * FROM topics";
    $result = mysqli_query($conn, $sql);
    $topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $topics;
}

//vytvoření kategorie
function createTopic($request_values)
{
    global $conn, $errors, $topic_name;
    $topic_name = esc($request_values['topic_name']);
    //slug: identitifátor duplicit
    $topic_slug = makeSlug($topic_name);
    //
    if (empty($topic_name)) {
        array_push($errors, "Název kategorie je povinný");
    }
    // ověření zda už neexistuje
    $topic_check_query = "SELECT * FROM topics WHERE slug='$topic_slug' LIMIT 1";
    $result = mysqli_query($conn, $topic_check_query);
    if (mysqli_num_rows($result) > 0) { // if topic exists
        array_push($errors, "Kategorie už existuje");
    }
    // vytvoření kategorie, pokud nedošlo k erroru
    if (count($errors) == 0) {
        $query = "INSERT INTO topics (name, slug) 
				  VALUES('$topic_name','$topic_slug')";
        mysqli_query($conn, $query);

        $_SESSION['message'] = "Kategorie byla vytvořena";
        header('location: topics.php');
        exit(0);
    }
}

/*edit Kategorie*/
function editTopic($topic_id)
{
    global $conn, $topic_name, $isEditingTopic, $topic_id;
    $sql = "SELECT * FROM topics WHERE id=$topic_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $topic = mysqli_fetch_assoc($result);
    // předání názvu kategorie pro editaci
    $topic_name = $topic['name'];
}

function updateTopic($request_values)
{
    global $conn, $errors, $topic_name, $topic_id;
    $topic_name = esc($request_values['topic_name']);
    $topic_id = esc($request_values['topic_id']);
    //slug: identitifátor duplicit
    $topic_slug = makeSlug($topic_name);
    // validace formuláře
    if (empty($topic_name)) {
        array_push($errors, "Název kategorie je povinný");
    }
    // vytvoření kategorie, když nejsou chyby
    if (count($errors) == 0) {
        $query = "UPDATE topics SET name='$topic_name', slug='$topic_slug' WHERE id=$topic_id";
        mysqli_query($conn, $query);

        $_SESSION['message'] = "Kategorie byla úspěšně vyvořena";
        header('location: topics.php');
        exit(0);
    }
}

// smazání kategorie
function deleteTopic($topic_id)
{
    global $conn;
    $sql = "DELETE FROM topics WHERE id=$topic_id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Kategorie byla smazána";
        header("location: topics.php");
        exit(0);
    }
}


/*vrací všechny adminy a autory*/
function getAdminUsers()
{
    global $conn, $roles;
    $sql = "SELECT * FROM users WHERE role IS NOT NULL";
    $result = mysqli_query($conn, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $users;
}


function esc(String $value)
{
    // globální proměnná na DB conect
    global $conn;
    // oříznutí řetězce o bílé znaky
    $val = trim($value);
    $val = mysqli_real_escape_string($conn, $value);
    return $val;
}

// funkce na vytvoření slug(identifikátor)
function makeSlug(String $string)
{
    $string = strtolower($string);
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    return $slug;
}
?>
