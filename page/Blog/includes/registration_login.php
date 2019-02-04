<?php
//deklarace proměnných uživatele
$username = "";
$email = "";
$errors = array();
// registrace uzivatele
if (isset($_POST['reg_user'])) {
    //inicializace promennych z hodnotami z formulare
    $username = esc($_POST['username']);
    $email = esc($_POST['email']);
    $password_1 = esc($_POST['password_1']);
    $password_2 = esc($_POST['password_2']);
    // form validation: ensure that the form is correctly filled
    if (empty($username)) {
        array_push($errors, "Jméno je povinné");
    }
    if (empty($email)) {
        array_push($errors, "Email je povinný");
    }
    if (empty($password_1)) {
        array_push($errors, "Heslo je povinné");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "Hesla se neshodují");
    }

    //jméno a email musí být unikátní
    $user_check_query = "SELECT * FROM users WHERE username='$username' 
								OR email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) { // uzivatel existuje
        if ($user['username'] === $username) {
            array_push($errors, "Jméno není volné");
        }
        if ($user['email'] === $email) {
            array_push($errors, "Email je už používán");
        }
    }
    // registrace uzivatele, když nedošlo k chybě
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database
        $query = "INSERT INTO users (username, email, password, created_at, updated_at) 
					  VALUES('$username', '$email', '$password', now(), now())";
        mysqli_query($conn, $query);
        // get id of created user
        $reg_user_id = mysqli_insert_id($conn);
        // put logged in user into session array
        $_SESSION['user'] = getUserById($reg_user_id);
        // if user is admin, redirect to admin area
        if (in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
            $_SESSION['message'] = "You are now logged in";
            // redirect to admin area
            header('location: ' . BASE_URL . 'admin/dashboard.php');
            exit(0);
        } else {
            $_SESSION['message'] = "You are now logged in";
            // redirect to public area
            header('location: blog.php');
            exit(0);
        }
    }
}
//přihlášení uživatele
if (isset($_POST['login_btn'])) {
    $username = esc($_POST['username']);
    $password = esc($_POST['password']);
    if (empty($username)) {
        array_push($errors, "Username required");
    }
    if (empty($password)) {
        array_push($errors, "Password required");
    }
    if (empty($errors)) {
        $password = md5($password); // encrypt password
        $sql = "SELECT * FROM users WHERE username='$username' and password='$password' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // id uživatele
            $reg_user_id = mysqli_fetch_assoc($result)['id'];
            // uchovani jmena a id uzivatele v session
            $_SESSION['user'] = getUserById($reg_user_id);
            $_SESSION['u_id'] = $reg_user_id;
            // pokud je uzivatel admin, presmeruje se do admin sekce (dashboard)
            if (in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
                $_SESSION['message'] = "Jste přihlášen";
                header('location: ' . BASE_URL . '/admin/dashboard.php');
                exit(0);
            } else {
                $_SESSION['message'] = "Jste přihlášen";
                //
                header('location: blog.php');
                exit(0);
            }
        } else {
            array_push($errors, 'Špatné přihlašovacící údaje');
        }
    }
}
// hodnota z formulaře
function esc(String $value)
{
    global $conn;
    $val = trim($value);
    $val = mysqli_real_escape_string($conn, $value);
    return $val;
}

function getUserById($id)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE id=$id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    return $user;
}

?>