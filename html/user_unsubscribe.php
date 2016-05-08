<?php
	require_once dirname(__FILE__) . "/../models/user.php";
    require_once dirname(__FILE__) . "/../models/post.php";
	session_start();
	if(empty($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = false;
        header("location: login.php?message=Please login first");
        die();
    }
	if($_SESSION['logged_in'] != true){
		header("location: login.php?message=Please login first");
        die();
	}


	if(!empty($_POST['userID']) and !empty($_POST['postID']) and !empty($_POST['return'])){

		$user = new User($_POST['userID']);
		$result = $user->RemoveSubscribe($_POST['postID']);
		if($result == FALSE){
			header('location: view-post.php?postID='.$_POST['postID']);
			die();
		}
		else{
			if($_POST['return'] == 'post') header("location: view-post.php?postID=".$_POST['postID']);
			else header("location: view-account.php?userID=".$_POST['userID']);
		}
		
	}
	else{
		if($_POST['return'] == 'post') header("location: view-post.php?postID=".$_POST['postID']);
		else header("location: view-account.php?userID=".$_POST['userID']);

		die();
	}

	if($_POST['return'] == 'post') header("location: view-post.php?postID=".$_POST['postID']);
	else header("location: view-account.php?userID=".$_POST['userID']);
?>