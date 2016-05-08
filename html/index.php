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

    if(empty($_GET['sort'])){
        $topics = $_SESSION['user']->GetTopics(); //get all topics natural order
        $sort = 1;
    }
    else{
        $topics = $_SESSION['user']->GetSortedTopics($_GET['sort']); //get all topics on particular order
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
                <form action="search_transfer.php" method="post">
                    <a><button type="submit" class="subBtn"></button>Search</a></li>
                    <input type="text" name="search" placeholder="Search Forum" style="float:right">
                </form>    
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

            <li style="float:left"><a href="index.php" class="active">Home</a></li>
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
                            echo 'Welcome to Project Forum '. $_SESSION['user']->username .'!';
                        }
                        ?>
                        <br><br>
                    <span>
                        <form action="#" method="get">
                            <select name="sort">
                                <?php if($sort == 1) echo '<option value="1" selected>Topic Name (Asc)</option>';
                                      else echo '<option value="1">Topic Name (Asc)</option>';?>
                                <?php if($sort == 2) echo '<option value="2" selected>Topic Name (Desc)</option>';
                                      else echo '<option value="2">Topic Name (Desc)</option>';?>
                                <?php if($sort == 3) echo '<option value="3" selected>Most Posts</option>';
                                      else echo '<option value="3">Most Posts</option>';?>
                                <?php if($sort == 4) echo '<option value="4" selected>Most Comments</option>';
                                      else echo '<option value="4">Most Comments</option>';?>
                                <?php if($sort == 5) echo '<option value="5" selected>Topic ID</option>';
                                      else echo '<option value="5">Topic ID</option>';?>
                            </select>
                            <button type="submit" value="send" class="btn">Sort By</button>
                        </form>
                    </span>
                </caption>

                <tr>
                    <th scope="col" class="id"> Topic ID</th>
                    <th scope="col" class="title"> List of Topics </th>
                    <th scope="col" class="other"> Posts </th>
                    <th scope="col" class="other"> Comments </th>
                    <th scope="col" class="lastPost"> Last Post </th>
                </tr>

                <!-- Go through each topic -->
                <?php foreach ($topics as $topic) { 
                    $posts = $topic->GetPosts(); //all posts in a topic
                    $last_post = $topic->GetLatestPost();
                    $recent_post = NULL;
                    $recent_time = NULL;
                    $comment_count = 0;
                    foreach ($posts as $post) {
                        $comment_count += count($post->GetComments());
                    }
                ?>
                    
                    <tr>
                        <td style="text-align:center"><?php echo $topic->topicID; ?></td>
                        <td><a href="topic_posts.php?topicID=<?php echo $topic->topicID; ?>"><?php echo $topic->name; ?></a></td>
                        <td style="text-align:center"><?php echo count($posts); ?></td>
                        <td style="text-align:center"><?php echo $comment_count; ?></td>
                        <td style="text-align:center"><?php if($last_post == NULL) echo 'N/A';
                                                            else echo "<a href=view-post.php?postID=" . $last_post->postID . ">"
                                                                        .substr($last_post->title,0,20)
                                                                        . "</a>"; ?></td>
                    </tr>
                
                <?php } ?>
                
            </table>
        </div>
        </div>
    </body>
    <footer>Copyright &copy; Adam Bucknell &amp; Steven Leighton</footer>
    
</html>