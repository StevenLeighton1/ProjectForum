<?php
    require_once dirname(__FILE__) . "/../models/user.php";
    require_once dirname(__FILE__) . "/../models/topic.php";
    require_once dirname(__FILE__) . "/../models/post.php";
    require_once dirname(__FILE__) . "/../models/comment.php";
    session_start();
    if(empty($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = false;
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
            
            <li><a href="logout.php">Sign Out</a></li>
            <?php echo '<li><a href="view-account.php?userID='.$_SESSION['user']->userID.'">Account</a></li>'; ?>

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
                                $last_comment = NULL;
                            ?>
                            <tr>
                                <?php if($user->userID == $_SESSION['user']->userID) { ?>

                                        <td style="width:51px"><?php echo $post->postID; ?></td>
                                        <td style="text-align:left; width:262px" ><?php echo $post->title; ?></td>
                                        <td style="text-align:left; width:140px"><?php echo $topic->name; ?></td>
                                        <td style="width:120px">
                                            Last Comment:
                                            <br><a href=""> Some_User_Name </a><br>
                                            Total Comments: <?php echo count($comments); ?> </td>
                                        <td style="width:80px"><?php echo $post->created_date; ?></td>
                                        <td style="width:80px">
                                                <form action="delete_post.php" method="post" id="<?php echo $post->postID; ?>">
                                                    <input type="hidden" value="<?php echo $post->postID; ?>" name="postID">
                                                    <input type="hidden" value="<?php echo $topic->topicID; ?>" name="topicID">
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
                                            Last Comment:
                                            <br><a href=""> Some_User_Name </a><br>
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
                                <!-- Show delete if moderator or user
                                 else just show up/down votes
                                 may change this to last update too, don't know yet
                                 -->
                            <!--   <th scope="col" class="other">Delete</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            
                            <!-- Need to adjust the widths of the table columns at least once -->
                            <tr>
                                <td style="width:52px">0</td>
                                <td style="text-align:left; width:201px" >Nonexisting Comment</td>
                                <td style="text-align:left; width:201px" >Nonexisting Post</td>
                                    
                                <td style="width:120px">
                                    Created by:<br>
                                    <a href="">Some_User_Name</a><br>
                                    on date_goes_here
                                    
                                <td style="width:80px">
                                    Created on: <br>
                                    Date_goes_here
                                    </td>
                                
                                <!-- Show delete if moderator or user
                                        else just show up/down votes-->
                                <td style="width:65px; text-align:left">
                                    <!--  <button class="btn" style="float:left"  onclick="location.href='#'">
                                     Delete<btn>  -->
                                    Up: ## <br>
                                    Down: ##
                                </td>
                                
                            </tr>
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