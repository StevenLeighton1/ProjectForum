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


	if(!empty($_POST['userID']) and !empty($_POST['postID'])){

		$user = new User($_POST['userID']);
		$post = new Post($_POST['postID']);
		$post_likes = $post->GetUserLikes();
		$post_dislikes = $post->GetUserDislikes();
		$user_liked = in_array($_SESSION['user'], $post_likes);
		$user_disliked = in_array($_SESSION['user'], $post_dislikes);

		if($user_liked){
			$result = $user->RemoveLike($_POST['postID']);
			if($result == FALSE){
				header('location: view-post.php?postID='.$_POST['postID']);
				die();
			}
		}

		if(!$user_disliked){
			$result = $user->AddDislike($_POST['postID']);
		
			if($result == FALSE){
				header('location: view-post.php?postID='.$_POST['postID']);
				die();
			}
		}
	}
	else{
		header('location: view-post.php?postID='.$_POST['postID']);
		die();
	}

	header('location: view-post.php?postID='.$_POST['postID']);
?>