<?php
	require_once dirname(__FILE__) . "/../models/user.php";


	$user = new User(-1); //User with no user id to give
	$user->Login_Username('steve', 'serka'); //check for right credentials

	//if correct credentials, set SESSION variables and go to correct home page
	if($user->userID != -1){
		echo 'Login Successful!';
	}
	else {
		echo "Wrong Username/Password</br>Please try again.</br>";
	}
	
?>