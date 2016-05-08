<?php
	require_once dirname(__FILE__) . "/../models/user.php";
	session_start();

	if( empty($_POST['user'])  or 
		empty($_POST['email']) or 
		empty($_POST['pass3']) or 
		$_POST['pass3'] != $_SESSION['user']->password ){

		header('location: edit_account.php?message=Missing username or email or correct password');
		die();
	}
	else{
		$_SESSION['user']->username = $_POST['user'];

		if(!empty($_POST['nickname'])) 
			$_SESSION['user']->nickname = $_POST['nickname'];

		$_SESSION['user']->email = $_POST['email'];

		if(!empty($_POST['pass1']) and !empty($_POST['pass2'])){
			if($_POST['pass1'] == $_POST['pass2']){
				$_SESSION['user']->password = $_POST['pass1'];
			}
			else{
				header('location: edit_account.php?message=New passwords do not match');
				die();
			}
		}

		$result = $_SESSION['user']->Save();

		if($result){
			header('location: edit_account.php?message=Successfully changed');
		}
		else{
			header('location: edit_account.php?message=Something went wrong, try again');
		}
	}
?>