<?php
require_once dirname(__FILE__) . "/../system/database.php";

class Post {

	public $postID = -1;
	public $title;
	public $content;
	public $created_date;
	public $ups;
	public $downs;
	public $tags;

	public function Post($post_id){
		//check to see if valid post_id
		if($post_id <= -1){
			return;
		}

		$this->postID = $post_id;

		$db = GetDB();

		// If the post_id is equal to zero, then this must be a new post
		if($this->postID == 0){
			$query = "INSERT INTO `post` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->postID = $db->insert_id;
			} else {
				die("Couldn't create post");
			}
			return;
		}

		$query = "SELECT * FROM `post` WHERE `postID` = " . $this->postID;

		$post = $db->query($query, MYSQLI_STORE_RESULT );
		if($post){
			$post = $post->fetch_array(MYSQLI_BOTH);

			if($post != NULL){
				$this->title = $post['title'];
				$this->content = $post['content'];
				$this->created_date = $post['created_date'];
				$this->ups = $post['ups'];
				$this->downs = $post['downs'];
				$this->tags = $post['tags'];
			} else {
				die("Couldn't find post: " . $this->postID);
			}
		} else {
			die("Couldn't find post: " . $this->postID);
		}
	}

	public function Save(){
		if($this->postID != -1){
			$query = "UPDATE `post` SET ";
			$query .= "`title` = '" . $this->title . "', ";
			$query .= "`content` = '" . $this->content . "', ";
			$query .= "`created_date` = '" . $this->created_date . "', ";
			$query .= "`ups` = '" . $this->ups . "', ";
			$query .= "`downs` = '" . $this->downs . "', ";
			$query .= "`tags` = '" . $this->tags . "' ";
			$query .= "WHERE `postID` = " . $this->postID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
				return TRUE;
			} else {
				return FALSE;
				die("Couldn't update post: " . $this->postID);
			}
		}
		return FALSE;
	}

	public function Delete(){
		if(!filter_var($this->postID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong postID
		}

		$query = "DELETE FROM `post` WHERE `postID` = {$this->postID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			die("Couldn't delete post: " . $this->postID . " Because " . mysqli_error($db));
		}
	}
//----------------------------------------------GET STUFF--------------------------------------------
	public function GetComments(){

			$query = "SELECT * FROM `post_comment` WHERE `postID` = {$this->postID}";

			$db = GetDB();
			$rows = $db->query($query);
			if($rows){
				$ret = Array();
				while($row = $rows->fetch_array(MYSQLI_BOTH)){
					
					$u = new Comment($row['commentID']);
					$ret[] = $u;

				}
				return $ret;
			} else {
				return Array();
			}
	}

	public function GetTopic(){
		$db = GetDB();


		$query =  "SELECT * FROM `topic_post` WHERE `postID` = {$this->postID}";

		
		$result = $db->query($query);
		if($result->num_rows != 0){
			$topic = $result->fetch_array(MYSQLI_BOTH);

			$topic = new Topic($topic['topicID']);
			return $topic;
		}
		else{
			die("Couldn't find topic for postiD: " . $this->postID);
		}
	}

	public function GetUser(){
		$db = GetDB();


		$query =  "SELECT * FROM `user_post` WHERE `postID` = {$this->postID}";

		
		$result = $db->query($query);
		if($result->num_rows != 0){
			$user = $result->fetch_array(MYSQLI_BOTH);

			$user = new User($user['userID']);
			return $user;
		}
		else{
			die("Couldn't find user for postiD: " . $this->postID);
		}
	}

//----------------------------------------------ADD STUFF--------------------------------------------
}

?>