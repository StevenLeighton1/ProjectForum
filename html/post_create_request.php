<?php
	require_once dirname(__FILE__) . "/../models/user.php";
    require_once dirname(__FILE__) . "/../models/topic.php";
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

	if(!empty($_POST['topicID'])){
		$topic = new Topic($_POST['topicID']);
	}
	else{
		header("location:index.php");
		die();
	}

	if(!empty($_POST['title']) and !empty($_POST['content'])){

		$post = new Post(0);
		$post->title = $_POST['title'];
		$post->content = $_POST['content'];

		$result = $post->Save();
	
		if($result == FALSE){
			header('location: post_create.php?topicID='. $topic->topicID .'&message=Something went wrong creating post, try again');
			die();
		}

		$result = $_SESSION['user']->AddPost($post->postID);
		if($result == FALSE){
			header('location: post_create.php?topicID='. $topic->topicID .'&message=Something went wrong adding post to user, try again');
			die();
		}

		$result = $topic->AddPost($post->postID);
		if($result == FALSE){
			header('location: post_create.php?topicID='. $topic->topicID .'&message=Something went wrong adding post to topic, try again');
			die();
		}

		
	}
	else{
		header('location: post_create.php?topicID='. $topic->topicID .'&message=Missing title and content');
		die();
	}

	header("location:topic_posts.php?topicID=".$_POST['topicID']);
?>