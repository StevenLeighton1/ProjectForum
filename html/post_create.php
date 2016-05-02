<?php
    require_once dirname(__FILE__) . "/../models/user.php";
    require_once dirname(__FILE__) . "/../models/topic.php";
    require_once dirname(__FILE__) . "/../models/post.php";
    session_start();
    if(empty($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = false;
    }
    else if($_SESSION['logged_in'] != true){
        header("location: login.php?message=Please login first");
        die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Project Forum</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
            
        <link rel="stylesheet" type="text/css" href="css/reset.css">
        <link rel="stylesheet" type="text/css" href="css/outline.css">
        <link rel="stylesheet" type="text/css" href="css/center_form.css">
        <link rel="stylesheet" type="text/css" href="css/inputs.css">

    </head>
    <body>
        <ul>
            <li>
                <a href="#" class="btn" style="margin-right:16px">Search</a>
                <input type="text" name="search" placeholder="Search Forum" style="float:right">
                    </li>
            
            <li><a href="logout.php">Sign Out</a></li>
            <li><a href="view-account.php">Account</a></li>

            <li style="float:left"><a href="index.php">Home</a></li>
        </ul>
        
        <div class="container">
        <h3>Project Forum</h3>
        <div class="content">
            <div class="frame">
                <div class="inFrame">
                    <?php echo $_GET['message']; ?>
                    <h1>Create Post</h1>
            
                    <form action="post_create_request.php" method="post" id="postform">
                        Title: <input type="text" name="title">
                            <br><br>
                        Content:<br>
                        <textarea name="content" form="postform" rows="30" cols="40"></textarea>
                            <br>
                        <input type="hidden" name="topicID" value="<?php echo $_GET['topicID']; ?>">
                            <br>
                        <input type="submit" value="Create" class="btn">
                    <!-- Done Edit -->
                    </form>
                </div>
            </div>
        </div>
        </div>
    </body>
    <footer>Copyright &copy; Adam Bucknell &amp; Steven Leighton</footer>
    
</html>