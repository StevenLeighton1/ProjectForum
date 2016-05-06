<?php
    require_once dirname(__FILE__) . "/../models/user.php";
    require_once dirname(__FILE__) . "/../models/topic.php";
    require_once dirname(__FILE__) . "/../models/post.php";
    require_once dirname(__FILE__) . "/../models/comment.php";
    session_start();
    if(empty($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = false;   //not logged in
        $_SESSION['user'] = new User(-1); //empty user object
    }

    $post = new Post($_GET['postID']);

    if(empty($_GET['sort'])){
        $comments = $post->GetComments();
        $sort = 1;
    }
    else{
        $comments = $post->GetSortedComments($_GET['sort']);
        $sort = $_GET['sort'];
    }
    $user_post = $post->GetUser();
    $post_likes = $post->GetUserLikes();
    $post_dislikes = $post->GetUserDislikes();
    $user_liked = in_array($_SESSION['user'], $post_likes);
    $user_disliked = in_array($_SESSION['user'], $post_dislikes);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Project Forum</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
            
            <link rel="stylesheet" type="text/css" href="css/reset.css">
            <link rel="stylesheet" type="text/css" href="css/outline.css">
            <link rel="stylesheet" type="text/css" href="css/inputs.css">
            <link rel="stylesheet" type="text/css" href="css/center_form.css">


        </head>
    <body>
        <ul>
            <li>
                <a href="#" class="btn" style="margin-right:16px">Search</a>
                <input type="text" name="search" placeholder="Search Forum" style="float:right">
            </li>
        
            <!-- If login fails ==> open the login page
                 If signs out   ==> open the login page -->
            <?php if($_SESSION['logged_in'] != true){

                echo '<li><a href="account.php">Register</a></li>
                        <form action="login_request.php" method="post">
                            <li><a><button type="submit" class="subBtn"></button>Sign In</a></li>
                            <li><input type="password" name="pass" placeholder="Password" style="float:right;width:8%;"></li>
                            <li><input type="text" name="user" placeholder="Username" style="float:right;width:8%;margin-right:0px"></li>
                        </form>';
                } 
             else {
                    // If logged in, replace account and form with the following:

                echo '<li><a href="logout.php">Sign Out</a></li>';
                echo '<li><a href="view-account.php?userID='.$_SESSION['user']->userID.'">Account</a></li>';

                } //close if else
            ?>

            <li style="float:left"><a href="index.php">Home</a></li>
        </ul>
        
        <div class="container">
            <h3>Project Forum</h3>
            <div class="content">
                <h2><?php echo $post->title; ?></h2>
                <hr width="80%">
                <br>
                
                
                <div class="comment_block">
                    <!-- The post goes hear -->
                    <p id="post">
                        <?php echo $post->content; ?>
                    </p>
                    <hr width="100%">
                    <h1><div style="margin-bottom:-30px">Posted by: <?php echo $user_post->username . " on " . $post->created_date; ?></div>
                        <span style="float:right;margin-top:15px">
                         
                         <!-- Moderator would probably have all 3 buttons available-->
                         
                         <!-- If User's Post-->
                           <!--   <button class="btn">Edit Post</button>
                                  <button class="btn">Delete Post</button> -->
                         
                         <!-- Other's posts -->
                            <button class="btn">Subscribe</button>
                        </span>
                        <br><br><br>
                        
                        <!--
                            Disabled button:
                            <button class="updown" style="background-color:____" disabled>Up</button>
                            RED: #E20 | GREEN: #0A5       Hashtag is necessary
                         -->

                         <form action="user_post_like.php" method="post" id="upvote">
                            <input type="hidden" value="<?php echo $post->postID; ?>" name="postID">
                            <input type="hidden" value="<?php echo $_SESSION['user']->userID; ?>" name="userID">
                        </form>
                        <form action="user_post_dislike.php" method="post" id="downvote">
                            <input type="hidden" value="<?php echo $post->postID; ?>" name="postID">
                            <input type="hidden" value="<?php echo $_SESSION['user']->userID; ?>" name="userID">
                        </form>
                        <?php if($user_liked) { ?>
                            <button type="submit" class="updown" form="upvote" style="background-color:#0A5" disabled>Up</button>#<?php echo count($post_likes); ?>
                        <?php } else { ?>
                            <button type="submit" class="updown" form="upvote">Up</button>#<?php echo count($post_likes); ?>
                        <?php } if($user_disliked) { ?>
                            <button type="submit" class="updown" form="downvote" style="background-color:#E20" disabled>Down</button>#<?php echo count($post_dislikes); ?>
                        <?php } else { ?>
                            <button type="submit" class="updown" form="downvote">Down</button>#<?php echo count($post_dislikes); ?>
                        <?php } ?>

                    </h1>
                    <br>
                    
                <!-- Start write comment if user is logged in-->
                <?php if($_SESSION['logged_in'] == true) { ?>
                    <form action="comment_create.php" method="post" id="commentform">
                        <textarea name="commentText" form="commentform" placeholder="Write your comment here..."></textarea>
                        <input type="hidden" name="postID" value="<?php echo $_GET['postID']; ?>">
                        <br>
                        <input type="submit" value="Submit" class="btn">
                    </form>
                <?php } ?>
                </div>
                <!-- End write comment -->
                <br><br>

                <!-- Start Sort Head -->
                <h4 style="text-align:center">User Comments:</h4>
                <div align="center">
                <form action="post_comment_sort.php" method="post">
                    <select name="sort">
                        <?php if($sort == 1) echo '<option value="1" selected>Most Recent</option>';
                                      else echo '<option value="1">Most Recent</option>';?>
                                <?php if($sort == 2) echo '<option value="2" selected>Oldest</option>';
                                      else echo '<option value="2">Oldest</option>';?>
                                <?php if($sort == 3) echo '<option value="3" selected>User</option>';
                                      else echo '<option value="3">User</option>';?>
                                <?php if($sort == 4) echo '<option value="4" selected>Most Ups</option>';
                                      else echo '<option value="4">Most Ups</option>';?>
                                <?php if($sort == 5) echo '<option value="5" selected>Most Downs</option>';
                                      else echo '<option value="5">Most Downs</option>';?>
                    </select>
                    <input type="hidden" name="postID" value="<?php echo $post->postID; ?>">
                    <input type="submit" value="Sort" class="btn">
                </form>
                
                </div>
                <!-- End Sort Head -->
                
                <br>
                <!-- 
                 Probably add some sort of sort bar here...
                 Should initially be most recent at top too...
                 -->
                
                <!-- start comment block -->
                <div class="comment_block">
                    <?php foreach ($comments as $comment) { 
                        $comment_user = $comment->GetUser();
                        $comment_likes = $comment->GetUserLikes();
                        $comment_dislikes = $comment->GetUserDislikes();
                        $user_liked_comment = in_array($_SESSION['user'], $comment_likes);
                        $user_disliked_comment = in_array($_SESSION['user'], $comment_dislikes);

                        echo '<h4><a href="view-account.php?userID='.$comment_user->userID.'">'.$comment_user->username.'</a>';
                        echo ' on '. $comment->comment_date;
                    ?>
                        <span style="float:right">
                            <!--
                                Disabled button:
                                <button class="updown" style="background-color:____" disabled>Up</button>
                                RED: #E20 | GREEN: #0A5       Hashtag is necessary
                             -->
                             <form action="user_comment_like.php" method="post" id="upvoteComment<?php echo $comment->commentID; ?>">
                                <input type="hidden" value="<?php echo $post->postID; ?>" name="postID">
                                <input type="hidden" value="<?php echo $comment->commentID; ?>" name="commentID">
                                <input type="hidden" value="<?php echo $_SESSION['user']->userID; ?>" name="userID">
                            </form>
                            <form action="user_comment_dislike.php" method="post" id="downvoteComment<?php echo $comment->commentID; ?>">
                                <input type="hidden" value="<?php echo $post->postID; ?>" name="postID">
                                <input type="hidden" value="<?php echo $comment->commentID; ?>" name="commentID">
                                <input type="hidden" value="<?php echo $_SESSION['user']->userID; ?>" name="userID">
                            </form>
                            <!-- button class="updown">Up</button>#<?php echo count($comment_likes); ?>
                            <button class="updown">Down</button>#<?php echo count($comment_dislikes); ?> -->
                            <?php if($user_liked_comment) { ?>
                                <button type="submit" class="updown" form="upvoteComment<?php echo $comment->commentID; ?>" style="background-color:#0A5" disabled>Up</button>
                                #<?php echo count($comment_likes); ?>
                            <?php } else { ?>
                                <button type="submit" class="updown" form="upvoteComment<?php echo $comment->commentID; ?>">Up</button>
                                #<?php echo count($comment_likes); ?>
                            <?php } if($user_disliked_comment) { ?>
                                <button type="submit" class="updown" form="downvoteComment<?php echo $comment->commentID; ?>" style="background-color:#E20" disabled>Down</button>
                                #<?php echo count($comment_dislikes); ?>
                            <?php } else { ?>
                                <button type="submit" class="updown" form="downvoteComment<?php echo $comment->commentID; ?>">Down</button>
                                #<?php echo count($comment_dislikes); ?>
                            <?php } ?>

                            <!-- Delete Comment button -->
                            <?php if($comment_user == $_SESSION['user']) { ?>
                                <button class="btn" style="position:relative;bottom:3px;" form="deleteComment<?php echo $comment->commentID; ?>">Delete</button>
                               <form action="comment_delete_post.php" method="post" id="deleteComment<?php echo $comment->commentID; ?>">
                                    <input type="hidden" value="<?php echo $post->postID; ?>" name="postID">
                                    <input type="hidden" value="<?php echo $comment->commentID; ?>" name="commentID">
                                </form>
                            <?php } ?>

                        </span>
                    </h4>
                    <hr width="100%">
                    <p id="comment">
                        <?php echo $comment->comment_text; ?>
                    </p>
                    <?php } ?>
                </div>
                <!-- end comment block -->
                
            </div>
        </div>
    </body>
    <footer>Copyright &copy; Adam Bucknell &amp; Steven Leighton</footer>
    
</html>