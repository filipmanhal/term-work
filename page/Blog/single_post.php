<?php include('config.php'); ?>
<?php include('comment/functions.php'); ?>
<?php include('includes/public_functions.php'); ?>
<?php
if (isset($_GET['post-slug'])) {
    $post = getPost($_GET['post-slug']);
}
$topics = getAllTopics();
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
        <!-- Page wrapper -->
        <div class="post-wrapper">
            <!-- full post div -->
            <div class="full-post-div">
                <?php if ($post['published'] == false): ?>
                    <h2 class="post-title">Sorry... This post has not been published</h2>
                <?php else: ?>
                    <h2 class="post-title"><?php echo $post['title']; ?></h2>
                    <div class="post-body-div">
                        <?php echo html_entity_decode($post['body']); ?>
                    </div>
                <?php endif ?>
            </div>
            <!-- // full post div -->

            <!-- comments section -->
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 comments-section">
                        <!-- if user is not signed in, tell them to sign in. If signed in, present them with comment form -->
                        <?php if (isset($user_id)): ?>
                            <form class="clearfix" action="comment/post_details.php" method="post" id="comment_form">
                                <textarea name="comment_text" id="comment_text" class="form-control" cols="30"
                                          rows="3"></textarea>
                                <button class="btn btn-primary btn-sm pull-right" id="submit_comment">Submit comment
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="well" style="margin-top: 20px;">
                                <h4 class="text-center"><a href="#">Sign in</a> to post a comment</h4>
                            </div>
                        <?php endif ?>
                        <!-- Display total number of comments on this post  -->
                        <h2><span id="comments_count"><?php echo count($comments) ?></span> Comment(s)</h2>
                        <hr>
                        <!-- comments wrapper -->
                        <div id="comments-wrapper">
                            <?php if (isset($comments)): ?>
                                <!-- Display comments -->
                                <?php foreach ($comments as $comment): ?>
                                    <!-- comment -->
                                    <div class="comment clearfix">
                                        <img src="comment/profile.png" alt="" class="profile_pic">
                                        <div class="comment-details">
                                            <span class="comment-name"><?php echo getUsernameById($comment['user_id']) ?></span>
                                            <span class="comment-date"><?php echo date("F j, Y ", strtotime($comment["created_at"])); ?></span>
                                            <p><?php echo $comment['body']; ?></p>
                                            <a class="reply-btn" href="#"
                                               data-id="<?php echo $comment['id']; ?>">reply</a>
                                        </div>
                                        <!-- reply form -->
                                        <form action="comment/post_details.php" class="reply_form clearfix"
                                              id="comment_reply_form_<?php echo $comment['id'] ?>"
                                              data-id="<?php echo $comment['id']; ?>">
                                            <textarea class="form-control" name="reply_text" id="reply_text" cols="30"
                                                      rows="2"></textarea>
                                            <button class="btn btn-primary btn-xs pull-right submit-reply">Submit
                                                reply
                                            </button>
                                        </form>

                                        <!-- GET ALL REPLIES -->
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
                                                            <a class="reply-btn" href="#">reply</a>
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

            <!--  coming soon ...  -->
        </div>
        <!-- // Page wrapper -->

        <!-- post sidebar -->
        <div class="post-sidebar">
            <div class="card">
                <div class="card-header">
                    <h2>Topics</h2>
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

<!-- Javascripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap Javascript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="comment/scripts.js"></script>
</body>
</html>