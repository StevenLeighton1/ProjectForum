<?php
	require_once dirname(__FILE__) . "/../models/user.php";
    require_once dirname(__FILE__) . "/../models/topic.php";
    require_once dirname(__FILE__) . "/../models/post.php";
    require_once dirname(__FILE__) . "/../models/comment.php";
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

	if(!empty($_POST['commentID'])){

		$comment = new Comment($_POST['commentID']);
		
		$result = $comment->Delete();
	
		if($result == FALSE){
			header('location:view-post.php?postID='.$_POST['postID']);
			die();
		}

	}
	else{
		header('location: view-post.php?postID='.$_POST['postID']);
		die();
	}

	header("location: view-post.php?postID=".$_POST['postID']);
?>