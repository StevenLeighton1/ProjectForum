<?php
	require_once dirname(__FILE__) . "/../models/user.php";
	session_start();

	if(empty($_POST['user']) or empty($_POST['pass'])){
		header("location: login.php?message=Missing username or password");
	}
	
	$user = new User(-1);
	$result = $user->Login_Username($_POST['user'], $_POST['pass']);
	if($result){
		$_SESSION['user'] = $user;
		$_SESSION['logged_in'] = true;
		header('location: index.php');
	}
	else{
		$_SESSION['logged_in'] = false;
		header("location: login.php?message=Incorrect username or password");
	}

?>