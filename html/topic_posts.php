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

    $topic = new Topic($_GET['topicID']);
    $posts = $topic->GetPosts();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Project Forum</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
            
        <link rel="stylesheet" type="text/css" href="css/reset.css">
        <link rel="stylesheet" type="text/css" href="css/outline.css">
        <link rel="stylesheet" type="text/css" href="css/inputs.css">


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
            <table>
                <?php 
                    if($_SESSION['logged_in'] != true){
                        echo '<caption>Please sign in to create a post or comment.</caption>';
                    }
                    else{
                        echo '<caption><a href="post_create.php?topicID=' . $topic->topicID . '&message=">Submit a new post!</a></caption>';
                    }
                ?>
                <tr>
                    <th scope="col" class="id"> Post ID</th>
                    <th scope="col" class="title"> List of Posts </th>
                    <th scope="col" class="other"> Upvotes </th>
                    <th scope="col" class="other"> Comments </th>
                    <th scope="col" class="other"> Submitted By </th>
                    <th scope="col" class="lastPost"> Last Comment </th>
                </tr>

                <!-- Go through each post -->
                <?php foreach ($posts as $post) { 
                    $post_user = $post->GetUser();
                	$comments = $post->GetComments();
                	$comment_count = count($comments);
                    $recent_comment = $post->GetLatestComment();
                ?>
                    
                    <tr>
                        <td style="text-align:center"><?php echo $post->postID; ?></td>
                        <td><a href="post.php?postID=<?php echo $post->postID; ?>"><?php echo $post->title; ?></a></td>
                        <td style="text-align:center"><?php echo $post->ups; ?></td>
                        <td style="text-align:center"><?php echo $comment_count; ?></td>
                        <td style="text-align:center"><?php echo '<a href="view-account.php?userID='.$post_user->userID.'">'.
                                                                   $post_user->username .'</a>' ?></td>
                        <td style="text-align:center"><?php if($recent_comment == NULL) echo 'N/A';
                                                            else echo substr($recent_comment->comment_text,0,20); ?></td>
                    </tr>
                
                <?php } ?>
                
            </table>
        </div>
        </div>
    </body>
    <footer>Copyright &copy; Adam Bucknell &amp; Steven Leighton</footer>
    
</html>