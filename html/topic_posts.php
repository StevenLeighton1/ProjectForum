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

    if(empty($_GET['sort'])){
        $posts = $topic->GetPosts();
        $sort = 1;
    }
    else{
        $posts = $topic->GetSortedPosts($_GET['sort']);
        $sort = $_GET['sort'];
    }
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
                <caption>
                    <?php
                        if($_SESSION['logged_in'] != true){
                            echo 'Please sign in to create a post or comment.';
                        }
                        else{
                            echo '<a href="post_create.php?topicID=' . $topic->topicID . '&message=">Submit a new post!</a>';
                        }
                    ?>
                        <br><br>
                    <span>
                        <!-- Needs to reload exact page, rather than the default -->

                        <form action="topic_post_sort.php" method="post">
                            <select name="sort">
                                <?php if($sort == 1) echo '<option value="1" selected>Post Name (Asc)</option>';
                                      else echo '<option value="1">Post Name (Asc)</option>';?>
                                <?php if($sort == 2) echo '<option value="2" selected>Post Name (Desc)</option>';
                                      else echo '<option value="2">Post Name (Desc)</option>';?>
                                <?php if($sort == 3) echo '<option value="3" selected>Most Ups</option>';
                                      else echo '<option value="3">Most Ups</option>';?>
                                <?php if($sort == 4) echo '<option value="4" selected>Most Comments</option>';
                                      else echo '<option value="4">Most Comments</option>';?>
                                <?php if($sort == 5) echo '<option value="5" selected>Post ID</option>';
                                      else echo '<option value="5">Post ID</option>';?>
                                <?php if($sort == 6) echo '<option value="6" selected>Most Recent</option>';
                                      else echo '<option value="6">Most Recent</option>';?>
                            </select>
                            <input type="hidden" name="topicID" value="<?php echo $topic->topicID; ?>">
                            <button type="submit" value="send" class="btn">Sort</button>
                        </form>
                    </span>
                </caption>
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
                    $comment_like_count = count($post->GetUserLikes());
                    $recent_comment = $post->GetLatestComment();
                ?>
                    
                    <tr>
                        <td style="text-align:center"><?php echo $post->postID; ?></td>
                        <td><a href="view-post.php?postID=<?php echo $post->postID; ?>"><?php echo $post->title; ?></a></td>
                        <td style="text-align:center"><?php echo $comment_like_count; ?></td>
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