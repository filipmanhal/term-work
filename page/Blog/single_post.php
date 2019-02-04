<?php include('config.php'); ?>
<?php include('comment/functions.php'); ?>
<?php include('includes/public_functions.php'); ?>
<?php

if (isset($_GET['post-slug'])) {
    $post = getPost($_GET['post-slug']);

}
$topics = getAllTopics();

$comments_query_result = mysqli_query($conn, "SELECT * FROM comments WHERE post_id=" . $post['id'] . " ORDER BY created_at DESC");
$comments = mysqli_fetch_all($comments_query_result, MYSQLI_ASSOC);


?>
<?php include('includes/head_section.php'); ?>
<title> <?php echo $post['title'] ?> | Manhist</title>
</head>
<body>

<header>
    <!-- Navbar -->
    <?php include(ROOT_PATH . '/includes/navbar.php'); ?>
    <!-- // Navbar -->
</header>
<div class="container">

    <div class="content">
        <div class="post-wrapper">
            <!-- full post div -->
            <div class="full-post-div">
                <?php if ($post['published'] == false): ?>
                    <h2 class="post-title">Příspěvek nebyl zatím zveřejněn...</h2>
                <?php else: ?>
                    <h2 class="post-title"><?php echo $post['title']; ?></h2>
                    <div class="post-body-div">
                        <?php echo html_entity_decode($post['body']); ?>
                    </div>
                <?php endif ?>
            </div>
            <!-- comments -->
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 comments-section">
                        <h2>Napiště komentář k příspěvku</h2>

                        <!-- if user is not signed in, tell them to sign in. If signed in, present them with comment form -->
                        <?php if (isset($user_id)): ?>
                            <form class="clearfix" action="single_post.php" method="post" id="comment_form">
                                <textarea name="comment_text" id="comment_text" class="form-control" cols="30"
                                          rows="3"></textarea>
                                <button class="btn btn-primary btn-sm pull-right" id="submit_comment">Odeslat
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="well" style="margin-top: 20px;">
                                <h4 class="text-center"><a href="login.php">Přihlásit se</a> pro napsání komentáře</h4>
                            </div>
                        <?php endif ?>
                        <!-- Display total number of comments on this post  -->
                        <hr>
                        <!-- comment sekce -->
                        <div id="comments-wrapper">
                            <?php if (isset($comments)): ?>
                                <!-- zobrazení comment --------------------------------------------------------------------->
                                <?php foreach ($comments as $comment): ?>
                                    <!-- comment -->
                                    <div class="comment clearfix">
                                        <img src="comment/profile.png" alt="" class="profile_pic">
                                        <div class="comment-details">
                                            <span class="comment-name"><?php echo getUsernameById($comment['user_id']) ?></span>
                                            <span class="comment-date"><?php echo date("F j, Y ", strtotime($comment["created_at"])); ?></span>
                                            <p><?php echo $comment['body']; ?></p>
                                            <a class="reply-btn" href="#"
                                               data-id="<?php echo $comment['id']; ?>">reagovat</a>
                                        </div>
                                        <!-- reply form -->
                                        <form action="single_post.php" class="reply_form clearfix"
                                              id="comment_reply_form_<?php echo $comment['id'] ?>"
                                              data-id="<?php echo $comment['id']; ?>">
                                            <textarea class="form-control" name="reply_text" id="reply_text" cols="30"
                                                      rows="2"></textarea>
                                            <button class="btn btn-primary btn-xs pull-right submit-reply">Odeslat
                                            </button>
                                        </form>

                                        <!-- vsechny odpovedi -->
                                        <?php $replies = getRepliesByCommentId($comment['id']) ?>
                                        <div class="replies_wrapper_<?php echo $comment['id']; ?>">
                                            <?php if (isset($replies)): ?>
                                                <?php foreach ($replies as $reply): ?>
                                                    <!-- reply -->
                                                    <div class="comment reply clearfix">
                                                        <img src="comment/profile.png" alt="" class="profile_pic">
                                                        <div class="comment-details">
                                                            <span class="comment-name"><?php echo getUsernameById($reply['user_id']) ?></span>
                                                            <span class="comment-date"><?php echo date("F j, Y ", strtotime($reply["created_at"])); ?></span>
                                                            <p><?php echo $reply['body']; ?></p>
                                                        </div>
                                                    </div>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <!-- // comment -->
                                <?php endforeach ?>
                            <?php else: ?>
                                <h2>Be the first to comment on this post</h2>
                            <?php endif ?>
                        </div><!-- comments wrapper -->
                    </div><!-- // all comments -->
                </div>
            </div>

        </div>
        <!-- // Page wrapper -->

        <!-- post sidebar -->
        <div class="post-sidebar">
            <div class="card">
                <div class="card-header">
                    <h2>Kategorie</h2>
                </div>
                <div class="card-content">
                    <?php foreach ($topics as $topic): ?>
                        <a
                                href="<?php echo BASE_URL . 'filtered_posts.php?topic=' . $topic['id'] ?>">
                            <?php echo $topic['name']; ?>
                        </a>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="comment/scripts.js"></script>
</body>
</html>