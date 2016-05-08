<?php
	require_once dirname(__FILE__) . "/../models/user.php";
	session_start();

	if(empty($_POST['user']) or empty($_POST['pass1']) or empty($_POST['pass2']) or $_POST['pass1'] != $_POST['pass2']){
		echo "No username or no password input, or passwords don't match.<br>";
		echo "<a href='account.php'>Go back</a>";
		$_SESSION['logged_in'] = false;
		die();
	}


	$user = new User(0);

	$user->username = $_POST['user'];
	$user->nickname = $_POST['nickname'];
	$user->email = $_POST['email'];
	$user->password = $_POST['pass1'];
	$user->user_type = 'MEMBER';
	$user->Save();

	$_SESSION['user'] = $user;
	$_SESSION['logged_in'] = true;
	header('location: index.php');
?>