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

    $topics = $_SESSION['user']->GetTopics();
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
                    <li><button type="submit" style="float:right;width:3%;margin-right:0px">Sign In</button></li>
                    <li><input type="password" name="pass" placeholder="Password" style="float:right;width:8%;"></li>
                    <li><input type="text" name="user" placeholder="Username" style="float:right;width:8%;margin-right:0px"></li>
                </form>';
                } 
             else {
                    // If logged in, replace account and form with the following:

                echo '<li><a href="logout.php">Sign Out</a></li>';
                echo '<li><a href="view-account.php">Account</a></li>';

                } //close if else
            ?>

            <li style="float:left"><a href="index.html" class="active">Home</a></li>
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
                        echo '<caption>Welcome to Project Forum '. $_SESSION['user']->username .'!</caption>';
                    }
                ?>
                <tr>
                    <th scope="col" class="id"> Topic ID</th>
                    <th scope="col" class="title"> List of Topics </th>
                    <th scope="col" class="other"> Posts </th>
                    <th scope="col" class="other"> Comments </th>
                    <th scope="col" class="lastPost"> Last Post </th>
                </tr>

                <!-- Go through each topic -->
                <?php foreach ($topics as $topic) { 
                    $posts = $topic->GetPosts();
                    $recent_post = NULL;
                    $recent_time = NULL;
                    $comment_count = 0;
                    foreach ($posts as $post) {
                        $comment_count += count($post->GetComments());
                    }
                ?>
                    
                    <tr>
                        <td style="text-align:center"><?php echo $topic->topicID; ?></td>
                        <td><?php echo $topic->name; ?></td>
                        <td style="text-align:center"><?php echo count($posts); ?></td>
                        <td style="text-align:center"><?php echo $comment_count; ?></td>
                        <td style="text-align:center">N/A</td>
                    </tr>
                
                <?php } ?>
                
            </table>
        </div>
        </div>
    </body>
    <footer>Copyright &copy; Adam Bucknell &amp; Steven Leighton</footer>
    
</html>