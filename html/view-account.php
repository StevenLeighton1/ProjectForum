<?php
    require_once dirname(__FILE__) . "/../models/user.php";
    require_once dirname(__FILE__) . "/../models/topic.php";
    require_once dirname(__FILE__) . "/../models/post.php";
    require_once dirname(__FILE__) . "/../models/comment.php";
    session_start();
    if(empty($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = false;
        $_SESSION['user'] = new User(-1);
    }
    else if($_SESSION['logged_in'] == false){
        header("location: login.php?message=Please login first");
        die();
    }

    $user = new User($_GET['userID']);
    $user_posts = $user->GetPosts();
    $user_comments = $user->GetComments();
    $user_subscribes = $user->GetSubscribes();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Project Forum</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
            
            <link rel="stylesheet" type="text/css" href="css/reset.css">
            <link rel="stylesheet" type="text/css" href="css/inputs.css">
            <link rel="stylesheet" type="text/css" href="css/outline.css">
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
                <h2><?php echo $user->username; ?>'s Account</h2>
                <div class="centerframe">
                    
                    <!-- Show only if your account -->
                    <h1><a href="edit_account.php?message=">Edit Account Information</a></h1>
                    
                    <hr style="width:850px">
                    <!-- Start User's Posts Table -->
                    <table class="scroll">
                        <caption>Posts</caption>
                        <thead>
                            <tr>
                                <th scope="col" class="id">Post ID</th>
                                <th scope="col" class="title">Post Title </th>
                                <th scope="col" class="sub">Topic</th>
                                <th scope="col" class="lastPost">Comments</th>
                                <th scope="col" class="other">Date Created</th>
                                <?php if($user->userID == $_SESSION['user']->userID) echo '<th scope="col" class="other">Delete</th>';?>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <!-- Need to adjust the widths of the table columns at least once -->

                            <?php foreach ($user_posts as $post) {
                                $topic = $post->GetTopic();
                                $comments = $post->GetComments();
                                $last_comment = $post->GetLatestComment();
                            ?>
                            <tr>
                                <?php if($user->userID == $_SESSION['user']->userID) { ?>

                                        <td style="width:51px"><?php echo $post->postID; ?></td>
                                        <td style="text-align:left; width:262px" >
                                            <a href="view-post.php?postID=<?php echo $post->postID; ?>"> <?php echo $post->title; ?> </a>
                                        </td>
                                        <td style="text-align:left; width:140px">
                                            <a href="topic_posts.php?topicID=<?php echo $topic->topicID; ?>"><?php echo $topic->name; ?> </a?

                                        </td>
                                        <td style="width:120px">
                                            Last Comment: <br>
                                            <?php if ($last_comment != NULL) {
                                                echo '<a href="view-account.php?userID='.$last_comment->GetUser()->userID.'">'.$last_comment->GetUser()->username.'</a><br>';
                                            } ?> 
                                            Total Comments: <?php echo count($comments); ?> </td>
                                        <td style="width:80px"><?php echo $post->created_date; ?></td>
                                        <td style="width:80px">
                                                <form action="delete_post.php" method="post" id="<?php echo $post->postID; ?>">
                                                    <input type="hidden" value="<?php echo $post->postID; ?>" name="postID">
                                                    <input type="hidden" value="<?php echo $topic->topicID; ?>" name="topicID">
                                                    <input type="hidden" value="<?php echo $_GET['userID']; ?>" name="userID">
                                                </form>
                                                <button type="submit" form="<?php echo $post->postID; ?>" 
                                                    class="btn" style="float:left"  onclick="location.href='#'">Delete<btn>
                                        </td>
                                <?php } 
                                    else { ?>
                                        <td style="width:59px"><?php echo $post->postID; ?></td>
                                        <td style="text-align:left; width:296px" ><?php echo $post->title; ?></td>
                                        <td style="text-align:left; width:160px"><?php echo $topic->name; ?></td>
                                        <td style="width:120px">
                                            Last Comment:<br>
                                            <?php if ($last_comment != NULL) {
                                                echo '<a href="view-account.php?userID='.$last_comment->GetUser()->userID.'">'.$last_comment->GetUser()->username.'</a><br>';
                                            } ?> 
                                            Total Comments: <?php echo count($comments); ?> </td>
                                        <td style="width:70px"><?php echo $post->created_date; ?></td>
                                        

                                <?php } //close if ?>

                            </tr>
                            <?php } //end for loop ?>

                        </tbody>
                    </table>
                        <!-- End User's Posts Table -->

                    <br>
                    <hr style="width:850px">

                    <!-- Start User's Comments Table -->
                    <table class="scroll">
                        <caption>Comments</caption>
                        <thead>
                            <tr>
                                <th scope="col" class="id">Comment ID</th>
                                <th scope="col" class="com">Comment</th>
                                <th scope="col" class="com">Post Title </th>
                                <th scope="col" class="lastPost">Post Author</th>
                                <th scope="col" class="other">Date</th>
                                <th scope="col" class="other">Up/Down Votes</th>
                                <?php if($user->userID == $_SESSION['user']->userID) echo '<th scope="col" class="other">Delete</th>';?>

                            <!--   <th scope="col" class="other">Delete</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            
                            <!-- Need to adjust the widths of the table columns at least once -->
                             <?php foreach ($user_comments as $comment) {
                                $post = $comment->GetPost();
                                $post_user = $post->GetUser();
                                $comment_likes = $comment->GetUserLikes();
                                $comment_dislikes = $comment->GetUserDislikes();
                            ?>

                            <tr>
                                <?php if($user->userID != $_SESSION['user']->userID) { ?>

                                <td style="width:52px"><?php echo $comment->commentID; ?></td>
                                <td style="text-align:left; width:201px" >
                                    <?php echo substr($comment->comment_text,0,35); ?>
                                </td>
                                <td style="text-align:left; width:201px" >
                                    <a href="view-post.php?postID=<?php echo $post->postID; ?>"> <?php echo $post->title; ?> </a>
                                </td>
                                    
                                <td style="width:120px">
                                    Created by:<br>
                                    <?php
                                        echo '<a href="view-account.php?userID='.$post_user->userID.'">'.$post_user->username.'</a><br>on '.$post->created_date;
                                    ?>
                                    
                                <td style="width:80px">
                                    Created on: <br>
                                    <?php echo $comment->comment_date; ?>
                                    </td>
                                
                                <!-- Show delete if moderator or user
                                        else just show up/down votes-->
                                <td style="width:65px; text-align:left">
                                    <!--  <button class="btn" style="float:left"  onclick="location.href='#'">
                                     Delete<btn>  -->
                                    Up: <?php echo count($comment_likes); ?> <br>
                                    Down: <?php echo count($comment_dislikes); ?>
                                </td>

                                <?php } 
                                    else { ?>

                                <td style="width:63px"><?php echo $comment->commentID; ?></td>
                                <td style="text-align:left; width:225px" >
                                    <?php echo substr($comment->comment_text,0,35); ?>
                                </td>
                                <td style="text-align:left; width:201px" >
                                    <a href="view-post.php?postID=<?php echo $post->postID; ?>"> <?php echo $post->title; ?> </a>
                                </td>
                                    
                                <td style="width:120px">
                                    Created by:<br>
                                    <?php
                                        echo '<a href="view-account.php?userID='.$post_user->userID.'">'.$post_user->username.'</a><br>on '.$post->created_date;
                                    ?>
                                    
                                <td style="width:80px">
                                    Created on: <br>
                                    <?php echo $comment->comment_date; ?>
                                    </td>
                                
                                <!-- Show delete if moderator or user
                                        else just show up/down votes-->
                                <td style="width:65px; text-align:left">
                                    Up: <?php echo count($comment_likes); ?> <br>
                                    Down: <?php echo count($comment_dislikes); ?>
                                </td>

                                <td style="width:80px">
                                        <form action="comment_delete.php" method="post" id="<?php echo 'comment'.$comment->commentID; ?>">
                                            <input type="hidden" value="<?php echo $comment->commentID; ?>" name="commentID">
                                            <input type="hidden" value="<?php echo $user->userID; ?>" name="userID">
                                        </form>
                                        <button type="submit" form="<?php echo 'comment'.$comment->commentID; ?>" 
                                            class="btn" style="float:left">Delete<btn>
                                </td>

                                <?php } //close if ?>
                            </tr>

                            <?php } //end for ?>
                        </tbody>
                    </table>
                    <!-- End User's Comments Table -->
                    <br>
                    <hr style="width:850px">
                    <!-- Start User's Subscribed Table -->
                    <table class="scroll">
                        <caption>Subscribed</caption>
                        <thead >
                            <tr>
                                <th scope="col" class="id">Post ID</th>
                                <th scope="col" class="title">Post Title </th>
                                <th scope="col" class="sub">Topic</th>
                                <th scope="col" class="lastPost">Post Author</th>
                                <th scope="col" class="other">Last Update</th>
                                <th scope="col" class="other">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <!-- Need to adjust the widths of the table columns at least once -->
                            <tr>
                                <td style="width:51px">0</td>
                                <td style="text-align:left;width:262px">Nonexisting Post</td>
                                <td style="text-align:left;width:140px">Nonexisting Topic</td>
                                <td style="width:120px">
                                    Created by:<br>
                                    <a href="">Some_User_Name</a><br>
                                    on date_goes_here
                                <td style="width:80px">N/A</td>
                                
                                <!-- If not your profile, will tell you if you are subscribed-->
                                <!-- If your profile, you can unsubscribe-->
                                <td style="width:65px">
                                    <button class="btn" style="float:left;font-size:11px" onclick="location.href='#'">
                                        Remove <!--Follow--><btn>
                                </td>
                            </tr>
                         
                        </tbody>
                    </table>
                    <!-- End User's Subscribed Table -->
                </div>
            </div>
        </div>
    </body>
    <footer>Copyright &copy; Adam Bucknell &amp; Steven Leighton</footer>
</html>