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

	if(!empty($_POST['postID']) and !empty($_POST['topicID'])){

		$post = new Post($_POST['postID']);
		$comments = $post->GetComments();
		$topic = new Topic($_POST['topicID']);

		foreach($comments as $comment){
			$result = $comment->Delete();
			if($result == FALSE){
			header('location:view-account.php?userID='.$_POST['userID']);
			die();
		}
		}
		$result = $topic->RemovePost($post->postID);
	
		if($result == FALSE){
			header('location:view-account.php?userID='.$_POST['userID']);
			die();
		}

		$result = $post->Delete();
		if($result == FALSE){
			header('location:view-account.php?userID='.$_POST['userID']);
			die();
		}
		
	}
	else{
		header('location: view-account.php?userID='.$_POST['userID']);
		die();
	}

	header("location: view-account.php?userID=".$_POST['userID']);
?>