<?php
require_once dirname(__FILE__) . "/../system/database.php";

class Comment {

	public $commentID = -1;
	public $comment_text;
	public $comment_date;

	public function Comment($comment_id){
		//check to see if valid comment_id
		if($comment_id <= -1){
			return;
		}

		$this->commentID = $comment_id;

		$db = GetDB();

		// If the comment_id is equal to zero, then this must be a new comment
		if($this->commentID == 0){
			$query = "INSERT INTO `comment` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->commentID = $db->insert_id;
			} else {
				die("Couldn't create comment");
			}
			return;
		}

		$query = "SELECT * FROM `comment` WHERE `commentID` = " . $this->commentID;

		$comment = $db->query($query, MYSQLI_STORE_RESULT );
		if($comment){
			$comment = $comment->fetch_array(MYSQLI_BOTH);

			if($comment != NULL){
				$this->comment_text = $comment['comment_text'];
				$this->comment_date = $comment['comment_date'];
			} else {
				die("Couldn't find comment: " . $this->commentID);
			}
		} else {
			die("Couldn't find comment: " . $this->commentID);
		}
	}

	public function Save(){
		$db = GetDB();
		if($this->commentID != -1){
			$query = "UPDATE `comment` SET ";
			$query .= "`comment_text` = '" . mysql_real_escape_string($this->comment_text). "' ";
			$query .= "WHERE `commentID` = " . $this->commentID;

			
			if($db->query($query) === TRUE){
				// Updated succesfully
				return TRUE;
			} else {
				return FALSE;
				die("Couldn't update comment: " . $this->commentID);
			}
		}
		return FALSE;
	}

	public function Delete(){
		if(!filter_var($this->commentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong commentID
		}
		$db = GetDB();

		$query = "DELETE FROM `post_comment` WHERE `commentID` = {$this->commentID}";

		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			return false;
			die("Couldn't delete comment: " . $this->commentID . " Because " . mysqli_error($db));
		}

		$query = "DELETE FROM `user_like_comment` WHERE `commentID` = {$this->commentID}";

		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			return false;
			die("Couldn't delete comment: " . $this->commentID . " Because " . mysqli_error($db));
		}

		$query = "DELETE FROM `user_dislike_comment` WHERE `commentID` = {$this->commentID}";

		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			return false;
			die("Couldn't delete comment: " . $this->commentID . " Because " . mysqli_error($db));
		}

		$query = "DELETE FROM `user_comment` WHERE `commentID` = {$this->commentID}";

		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			return false;
			die("Couldn't delete comment: " . $this->commentID . " Because " . mysqli_error($db));
		}

		$query = "DELETE FROM `comment` WHERE `commentID` = {$this->commentID}";

		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			die("Couldn't delete comment: " . $this->commentID . " Because " . mysqli_error($db));
		}

		return true;
	}
//----------------------------------------------GET STUFF--------------------------------------------

	public function GetUser(){
		$db = GetDB();

		$query =  "SELECT * FROM `user_comment` WHERE `commentID` = {$this->commentID}";

		
		$result = $db->query($query);
		if($result->num_rows != 0){
			$post = $result->fetch_array(MYSQLI_BOTH);

			$post = new User($post['userID']);
			return $post;
		}
		else{
			die("Couldn't find user for commentID: " . $this->commentID);
		}
	}

	public function GetPost(){
		$db = GetDB();


		$query =  "SELECT * FROM `post_comment` WHERE `commentID` = {$this->commentID}";

		
		$result = $db->query($query);
		if($result->num_rows != 0){
			$post = $result->fetch_array(MYSQLI_BOTH);

			$post = new Post($post['postID']);
			return $post;
		}
		else{
			die("Couldn't find post for commentID: " . $this->commentID);
		}
	}

	public function GetUserLikes(){

			$query = "SELECT * FROM `user_like_comment` WHERE `commentID` = {$this->commentID}";

			$db = GetDB();
			$rows = $db->query($query);
			if($rows){
				$ret = Array();
				while($row = $rows->fetch_array(MYSQLI_BOTH)){
					
					$u = new User($row['userID']);
					$ret[] = $u;

				}
				return $ret;
			} else {
				return Array();
			}
	}

	public function GetUserDislikes(){

			$query = "SELECT * FROM `user_dislike_comment` WHERE `commentID` = {$this->commentID}";

			$db = GetDB();
			$rows = $db->query($query);
			if($rows){
				$ret = Array();
				while($row = $rows->fetch_array(MYSQLI_BOTH)){
					
					$u = new User($row['userID']);
					$ret[] = $u;

				}
				return $ret;
			} else {
				return Array();
			}
	}

//----------------------------------------------ADD STUFF--------------------------------------------
}

?>