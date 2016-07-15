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
<<<<<<< Updated upstream:html/account.php
                <form action="search_transfer.php" method="post">
                    <a><button type="submit" class="subBtn"></button>Search</a></li>
                    <input type="text" name="search" placeholder="Search Forum" style="float:right">
                </form> 
            </li>
            
            <li><a href="account.php" class="active">Register</a></li>
                <form action="login_request.php" method="post">
                    <li><a><button type="submit" class="subBtn"></button>Sign In</a></li>
                    <li><input type="password" name="pass" placeholder="Password" style="float:right;width:8%;"></li>
                    <li><input type="text" name="user" placeholder="Username" style="float:right;width:8%;margin-right:0px"></li>
                </form>
            <li style="float:left"><a href="index.php">Home</a></li>
=======
                <a href="#" class="btn" style="margin-right:16px">Search</a>
                <input type="text" name="search" placeholder="Search Forum" style="float:right">
                    </li>
            
            <!-- If logged in, replace account and form with the following:
             <li><a href="login.html">Sign Out</a></li>
             <li><a href="view-account.html">Account</a></li>
             -->
            
            <li><a href="account.html" class="btn" style="margin-right:10px">Register</a></li>
            <!--  <li><a href="login.html">Sign In</a></li> -->
            
            <!-- If login fails ==> open the login page
             If signs out   ==> open the login page -->
            <form action="#" method="post">
                <li><input type="submit" value="Sign In" class="btn" style="float:right"></li>
                <li><input type="password" name="pass" placeholder="Password" style="float:right;width:8%;"></li>
                <li><input type="text" name="user" placeholder="Username" style="float:right;width:8%;margin-right:0px"></li>
            </form>
            <li style="float:left"><a href="index.html">Index</a></li>
>>>>>>> Stashed changes:html/account.html
        </ul>
        
        <div class="container">
        <h3>Project Forum</h3>
        <div class="content">
            <div class="frame">
                <div class="inFrame">
                    <h1>Create an Account.</h1>
            
                    <form action="register_create.php" method="post">
                        <input type="text" name="user" placeholder="Username">
                            <br>
                        <input type="text" name="nickname" placeholder="Nickname (Optional)">
                            <br>
                        <input type="email" name="email" placeholder="Email Address">
                            <br>
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