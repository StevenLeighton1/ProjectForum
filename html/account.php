<?php
    session_start();
    if(empty($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = false;
    }
    else if($_SESSION['logged_in'] == true){
        header("location: index.php");
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
            
            <li><a href="account.php">Register</a></li>
                <form action="login_request.php" method="post">
                    <li><a><button type="submit" class="subBtn">Sign In</button></a></li>
                    <li><input type="password" name="pass" placeholder="Password" style="float:right;width:8%;"></li>
                    <li><input type="text" name="user" placeholder="Username" style="float:right;width:8%;margin-right:0px"></li>
                </form>
            <li style="float:left"><a href="index.php">Home</a></li>
        </ul>
        
        <div class="container">
        <h3>Project Forum</h3>
        <div class="content">
            <div class="frame">
                <div class="inFrame">
                    <h1>Create an Account.</h1>
            <!-- <h1>Edit your credentials.</h1> -->
                    <form action="register_create.php" method="post">
                        <input type="text" name="user" placeholder="Username">
                            <br>
                        <input type="text" name="nickname" placeholder="Nickname (Optional)">
                            <br>
                        <input type="email" name="email" placeholder="Email Address">
                            <br>
                    <!-- Old Password
                     <input type="password" name="pass0" placeholder="Old Password">
                     <br>
                     -->
                        <input type="password" name="pass1" placeholder="Password">
                            <br>
                        <input type="password" name="pass2" placeholder="Confirm Password">
                            <br>
                    <!-- is moderator check box
                        <input id="check1" type="checkbox" name="check" value="check1">
                        <label for="check1">Moderator</label>
                            <br>
                     -->
                            <br>
                        <input type="submit" value="Sign Up!" class="btn">
                    <!-- Done Edit -->
                    </form>
                </div>
            </div>
        </div>
        </div>
    </body>
    <footer>Copyright &copy; Adam Bucknell &amp; Steven Leighton</footer>
    
</html>