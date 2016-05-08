<?php
    require_once dirname(__FILE__) . "/../models/user.php";
    session_start();
    if(empty($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = false;
    }
    else if($_SESSION['logged_in'] != true){
        header("location: login.php?message=Please login first");
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
                <form action="search_transfer.php" method="post">
                    <a><button type="submit" class="subBtn"></button>Search</a></li>
                    <input type="text" name="search" placeholder="Search Forum" style="float:right">
                </form> 
            </li>
            
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
            <div class="frame">
                <div class="inFrame">
                    <h1>Edit Account Information</h1>
            <!-- <h1>Edit your credentials.</h1> -->
                    <form action="edit_account_request.php" method="post">
                        <input type="text" name="user" value="<?php echo $_SESSION['user']->username; ?>">
                            <br>
                        <input type="text" name="nickname" value="<?php echo $_SESSION['user']->nickname; ?>">
                            <br>
                        <input type="email" name="email" value="<?php echo $_SESSION['user']->email; ?>">
                            <br>
                        <input type="password" name="pass1" placeholder="New Password (Optional)">
                            <br>
                        <input type="password" name="pass2" placeholder="Confirm New Password (Optional)">
                            <br>
                        <input type="password" name="pass3" placeholder="Current Password (Required)">
                            <br>
                    <!-- is moderator check box
                        <input id="check1" type="checkbox" name="check" value="check1">
                        <label for="check1">Moderator</label>
                            <br>
                     -->
                            <br>
                        <input type="submit" value="Edit" class="btn">
                    <!-- Done Edit -->
                    </form>
                    <?php echo $_GET['message']; ?>
                </div>
            </div>
        </div>
        </div>
    </body>
    <footer>Copyright &copy; Adam Bucknell &amp; Steven Leighton</footer>
    
</html>