<?php
	require_once dirname(__FILE__) . "/../models/user.php";
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

	if(!empty($_POST['postID']) and !empty($_POST['commentText']) and $_POST['commentText'] != ""){

		$post = new Post($_POST['postID']);
		$comment = new Comment(0);
		$comment->comment_text = $_POST['commentText'];

		$result = $comment->Save();
	
		if($result == FALSE){
			header("location: view-post.php?postID=".$_POST['postID']."&message=Save Error");
			die();
		}

		$result = $_SESSION['user']->AddComment($comment->commentID);
		if($result == FALSE){
			header("location: view-post.php?postID=".$_POST['postID']."&message=Save Error");
			die();
		}

		$result = $post->AddComment($comment->commentID);
		if($result == FALSE){
			header("location: view-post.php?postID=".$_POST['postID']."&message=Save Error");
			die();
		}

		
	}

	header("location: view-post.php?postID=".$_POST['postID']);
?>