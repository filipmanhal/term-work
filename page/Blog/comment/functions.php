<?php
if(!isset($_SESSION))
{
    session_start();
}
$user_id = $_SESSION['u_id'];
$post_id = $_SESSION['post_id'];
?>

<?php

$conn = mysqli_connect("localhost", "root", "", "manhistDb");

$post_query_result = mysqli_query($conn, "SELECT * FROM posts WHERE id= " . $post_id . "");
$post = mysqli_fetch_assoc($post_query_result);

$comments_query_result = mysqli_query($conn, "SELECT * FROM comments WHERE post_id=" . $post['id'] . " ORDER BY created_at DESC");
$comments = mysqli_fetch_all($comments_query_result, MYSQLI_ASSOC);

// Receives a user id and returns the username
function getUsernameById($id)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT username FROM users WHERE id=" . $id . " LIMIT 1");
    // return the username
    return mysqli_fetch_assoc($result)['username'];
}

// Receives a comment id and returns the username
function getRepliesByCommentId($id)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM replies WHERE comment_id=$id");
    $replies = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $replies;
}

// Receives a post id and returns the total number of comments on that post
function getCommentsCountByPostId($post_id)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM comments");
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

// If the user clicked submit on comment form...
if (isset($_POST['comment_posted'])) {
    global $conn;
    // grab the comment that was submitted through Ajax call
    $comment_text = $_POST['comment_text'];
    // insert comment into database
    $sql = "INSERT INTO comments (post_id, user_id, body, created_at, updated_at) VALUES (" . $post_id . " , " . $user_id . " , '$comment_text', now(), null)";
    $result = mysqli_query($conn, $sql);
    // Query same comment from database to send back to be displayed
    $inserted_id = $conn->insert_id;
    $res = mysqli_query($conn, "SELECT * FROM comments WHERE id=$inserted_id");
    $inserted_comment = mysqli_fetch_assoc($res);
    // if insert was successful, get that same comment from the database and return it
    if ($result) {
        $comment = "<div class='comment clearfix'>
					<img src='profile.png' alt='' class='profile_pic'>
					<div class='comment-details'>
						<span class='comment-name'>" . getUsernameById($inserted_comment['user_id']) . "</span>
						<span class='comment-date'>" . date('F j, Y ', strtotime($inserted_comment['created_at'])) . "</span>
						<p>" . $inserted_comment['body'] . "</p>
						<a class='reply-btn' href='#' data-id='" . $inserted_comment['id'] . "'>reply</a>
					</div>
					<!-- reply form -->
					<form action='single_post.php' class='reply_form clearfix' id='comment_reply_form_" . $inserted_comment['id'] . "' data-id='" . $inserted_comment['id'] . "'>
						<textarea class='form-control' name='reply_text' id='reply_text' cols='30' rows='2'></textarea>
						<button class='btn btn-primary btn-xs pull-right submit-reply'>Submit reply</button>
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
// If the user clicked submit on reply form...
if (isset($_POST['reply_posted'])) {
    global $conn;
    // grab the reply that was submitted through Ajax call
    $reply_text = $_POST['reply_text'];
    $comment_id = $_POST['comment_id'];
    // insert reply into database
    $sql = "INSERT INTO replies (user_id, comment_id, body, created_at, updated_at) VALUES (" . $user_id . ", $comment_id, '$reply_text', now(), null)";
    $result = mysqli_query($conn, $sql);
    $inserted_id = $conn->insert_id;
    $res = mysqli_query($conn, "SELECT * FROM replies WHERE id=$inserted_id");
    $inserted_reply = mysqli_fetch_assoc($res);
    // if insert was successful, get that same reply from the database and return it
    if ($result) {
        $reply = "<div class='comment reply clearfix'>
					<img src='profile.png' alt='' class='profile_pic'>
					<div class='comment-details'>
						<span class='comment-name'>" . getUsernameById($inserted_reply['user_id']) . "</span>
						<span class='comment-date'>" . date('F j, Y ', strtotime($inserted_reply['created_at'])) . "</span>
						<p>" . $inserted_reply['body'] . "</p>
						<a class='reply-btn' href='#'>reply</a>
					</div>
				</div>";
        echo $reply;
        exit();
    } else {
        echo "error";
        exit();
    }
}
