<?php
if (!isset($_SESSION)) {
    session_start();
}

$user_id = $_SESSION['u_id'];
?>

<?php
$post_query_result = mysqli_query($conn, "SELECT * FROM posts WHERE id= " . $post_id = $_SESSION['post_id'] . "");


//vraci username podle id prihlaseneho uz.
function getUsernameById($id)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT username FROM users WHERE id=" . $id . " LIMIT 1");

    return mysqli_fetch_assoc($result)['username'];
}

//vraci reakce na komentar podle id
function getRepliesByCommentId($id)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM replies WHERE comment_id=$id");
    $replies = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $replies;
}

// vraci celkovy pocet komentaru u prispevku
function getCommentsCountByPostId($post_id)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM comments");
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

//vraci vsechny komenty k prispevku
function getAllComments($post_id)
{
    global $conn;
    $sql = "SELECT * FROM comments";
    $result = mysqli_query($conn, $sql);
    $topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $topics;
}

//odeslani komentare do DB
if (isset($_POST['comment_posted'])) {
    global $conn;
    $comment_text = $_POST['comment_text'];
    // vlozeni komentare do databaze
    $sql = "INSERT INTO comments (post_id, user_id, body, created_at, updated_at) VALUES (" . $post_id . " , " . $user_id . " , '$comment_text', now(), null)";
    $result = mysqli_query($conn, $sql);
    // vraci stejny obsah z DB a zobrazi ho
    $inserted_id = $conn->insert_id;
    $res = mysqli_query($conn, "SELECT * FROM comments WHERE id=$inserted_id");
    $inserted_comment = mysqli_fetch_assoc($res);
    // po vlozeni do DB se komentar zobrazi
    if ($result) {
        $comment = "<div class='comment clearfix'>
					<img src='profile.png' alt='' class='profile_pic'>
					<div class='comment-details'>
						<span class='comment-name'>" . getUsernameById($inserted_comment['user_id']) . "</span>
						<span class='comment-date'>" . date('F j, Y ', strtotime($inserted_comment['created_at'])) . "</span>
						<p>" . $inserted_comment['body'] . "</p>
						<a class='reply-btn' href='#' data-id='" . $inserted_comment['id'] . "'>reakce</a>
					</div>
					<!-- reakce formular -->
					<form action='s ingle_post.php' class='reply_form clearfix' id='comment_reply_form_" . $inserted_comment['id'] . "' data-id='" . $inserted_comment['id'] . "'>
						<textarea class='form-control' name='reply_text' id='reply_text' cols='30' rows='2'></textarea>
						<button class='btn btn-primary btn-xs pull-right submit-reply'>Odeslat reakci</button>
					</form>
				</div>";
        $comment_info = array(
            'comment' => $comment,
            'comments_count' => getCommentsCountByPostId(1)
        );
        echo json_encode($comment_info);
        exit();
    } else {
        echo "error";
        exit();
    }
}
// volba reakce na komentar
if (isset($_POST['reply_posted'])) {
    global $conn;
    $reply_text = $_POST['reply_text'];
    $comment_id = $_POST['comment_id'];
    // vlozeni reakce na komentar do DB
    $sql = "INSERT INTO replies (user_id, comment_id, body, created_at, updated_at) VALUES (" . $user_id . ", $comment_id, '$reply_text', now(), null)";
    $result = mysqli_query($conn, $sql);
    $inserted_id = $conn->insert_id;
    $res = mysqli_query($conn, "SELECT * FROM replies WHERE id=$inserted_id");
    $inserted_reply = mysqli_fetch_assoc($res);
    // po vlozeni reakce do DB se text zobrazi
    if ($result) {
        $reply = "<div class='comment reply clearfix'>
					<img src='profile.png' alt='' class='profile_pic'>
					<div class='comment-details'>
						<span class='comment-name'>" . getUsernameById($inserted_reply['user_id']) . "</span>
						<span class='comment-date'>" . date('F j, Y ', strtotime($inserted_reply['created_at'])) . "</span>
						<p>" . $inserted_reply['body'] . "</p>
						<a class='reply-btn' href='#'>reakce</a>
					</div>
				</div>";
        echo $reply;
        exit();
    } else {
        echo "error";
        exit();
    }
}
