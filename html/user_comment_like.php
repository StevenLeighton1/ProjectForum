<?php
	require_once dirname(__FILE__) . "/../models/user.php";
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


	if(!empty($_POST['userID']) and !empty($_POST['commentID']) and !empty($_POST['postID'])){

		$user = new User($_POST['userID']);
		$comment = new Comment($_POST['commentID']);

		$user_liked = in_array($comment, $user->GetLikesComments());
		$user_disliked = in_array($comment, $user->GetDislikesComments());

		if($user_disliked){
			$result = $user->RemoveCommentDislike($_POST['commentID']);
			if($result == FALSE){
				header('location: view-post.php?postID='.$_POST['postID']);
				die();
			}
		}

		if(!$user_liked){
			$result = $user->AddCommentLike($_POST['commentID']);
		
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