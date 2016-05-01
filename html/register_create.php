<?php
	require_once dirname(__FILE__) . "/../models/user.php";

	if(empty($_POST['user']) and $_POST['pass1'] == $_POST['pass2']){
		echo "No username";
	}

	$user = new User(0);

	$user->username = $_POST['user'];
	$user->nickname = $_POST['nickname'];
	$user->email = $_POST['email'];
	$user->password = $_POST['pass1'];
	$user->Save();
	header('location: index.php');
?>