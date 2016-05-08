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
            
            <!-- If logged in, replace account and form with the following:
             <li><a href="login.html">Sign Out</a></li>
             <li><a href="view-account.html">Account</a></li>
             
             -->
            
            <li><a href="account.php">Register</a></li>
            <!--  <li><a href="login.html">Sign In</a></li> -->
            
            <!-- If login fails ==> open the login page
             If signs out   ==> open the login page -->
            <form action="login_request.php" method="post">
                <li><a class="active"><button type="submit" class="subBtn"></button>Sign In</a></li>
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
                    
    <!--                <h1 style="color:#990000">There was an error, try again.</h1>  -->
                    <?php if($_GET['message'] == '') echo "<h1>Please sign in to your acount.</h1>";
                          else echo $_GET['message']; 
                    ?>
    
                    <form action="login_request.php" method="post">
                        <input type="text" name="user" placeholder="Username">
                            <br>
                        <input type="password" name="pass" placeholder="Password">
                            <br><br>
                        <input type="submit" value="Sign In!" class="btn">
                    </form>
                </div>
            </div>
        </div>
        </div>
    </body>
    <footer>Copyright &copy; Adam Bucknell &amp; Steven Leighton</footer>
    
</html>