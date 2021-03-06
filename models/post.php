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
		$db = GetDB();

		if($this->postID != -1){
			$query = "UPDATE `post` SET ";
			$query .= "`title` = '" . mysql_real_escape_string($this->title) . "', ";
			$query .= "`content` = '" . mysql_real_escape_string($this->content) . "', ";
			$query .= "`ups` = '" . $this->ups . "', ";
			$query .= "`downs` = '" . $this->downs . "', ";
			$query .= "`tags` = '" . mysql_real_escape_string($this->tags) . "' ";
			$query .= "WHERE `postID` = " . $this->postID;

			
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

		$db = GetDB();

		$query = "DELETE FROM `user_post` WHERE `postID` = {$this->postID}";

		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			return false;
			die("Couldn't delete post: " . $this->postID . " Because " . mysqli_error($db));
		}

		$query = "DELETE FROM `user_subscribe` WHERE `postID` = {$this->postID}";

		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			return false;
			die("Couldn't delete post: " . $this->postID . " Because " . mysqli_error($db));
		}

		$query = "DELETE FROM `user_like` WHERE `postID` = {$this->postID}";

		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			return false;
			die("Couldn't delete post: " . $this->postID . " Because " . mysqli_error($db));
		}

		$query = "DELETE FROM `user_dislike` WHERE `postID` = {$this->postID}";

		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			return false;
			die("Couldn't delete post: " . $this->postID . " Because " . mysqli_error($db));
		}

		$query = "DELETE FROM `post` WHERE `postID` = {$this->postID}";

		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			return false;
			die("Couldn't delete post: " . $this->postID . " Because " . mysqli_error($db));
		}

		return true;
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

	public function GetSortedComments($sortNum){
			$db = GetDB();

			if($sortNum == 1){
				$query = "SELECT * 
							FROM `post_comment`,`comment`
							WHERE `post_comment`.`postID` = {$this->postID} AND `post_comment`.`commentID` = `comment`.`commentID`
							ORDER BY `comment`.`comment_date` DESC";

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
			else if($sortNum == 2){
				$query = "SELECT * 
							FROM `post_comment`,`comment`
							WHERE `post_comment`.`postID` = {$this->postID} AND `post_comment`.`commentID` = `comment`.`commentID`
							ORDER BY `comment`.`comment_date` ASC";

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
			else if($sortNum == 3){
				$query = "SELECT * 
							FROM `post_comment`,`comment`,`user`,`user_comment`
							WHERE `post_comment`.`postID` = {$this->postID} AND 
								  `post_comment`.`commentID` = `comment`.`commentID` AND
							      `user_comment`.`commentID` = `comment`.`commentID`
							GROUP BY `post_comment`.`commentID`
							ORDER BY `user`.`username` DESC";

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
			else if($sortNum == 4){
				$query = "SELECT *, COUNT(`post_comment`.`commentID`) as amt
							FROM `post_comment`,`comment`,`user_like_comment`
							WHERE `post_comment`.`postID` = {$this->postID} AND 
								  `post_comment`.`commentID` = `comment`.`commentID` AND
							      `user_like_comment`.`commentID` = `comment`.`commentID`
							GROUP BY `post_comment`.`commentID`
							ORDER BY amt DESC";

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
			else if($sortNum == 5){
				$query = "SELECT *, COUNT(`post_comment`.`commentID`) as amt
							FROM `post_comment`,`comment`,`user_dislike_comment`
							WHERE `post_comment`.`postID` = {$this->postID} AND 
								  `post_comment`.`commentID` = `comment`.`commentID` AND
							      `user_dislike_comment`.`commentID` = `comment`.`commentID`
							GROUP BY `post_comment`.`commentID`
							ORDER BY amt DESC";

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

	public function GetLatestComment(){

			$query = "SELECT * FROM `comment` ORDER BY `comment`.`comment_date` DESC";

			$db = GetDB();
			$rows = $db->query($query);
			if($rows){
				$ret = Array();
				while($row = $rows->fetch_array(MYSQLI_BOTH)){
					
					$u = new Comment($row['commentID']);
					$ret[] = $u;

				}
			}

			foreach ($ret as $comment) {
				if($this->postID == $comment->GetPost()->postID){

					return $comment;
				}
			}

			return NULL;
	}

	public function GetUserLikes(){

			$query = "SELECT * FROM `user_like` WHERE `postID` = {$this->postID}";

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

			$query = "SELECT * FROM `user_dislike` WHERE `postID` = {$this->postID}";

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

	public function AddComment($commentID){
		$query = "INSERT INTO `post_comment` (`postID`, `commentID`) VALUES ";
		$query .="({$this->postID}," .$commentID.")";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
			return true;
		} else {
			return false;
			die("Couldn't add comment to post: " . $this->postID);
		}
	}

//----------------------------------------------DELETE STUFF--------------------------------------------

	public function RemoveComment($commentID){
		$query = "DELETE FROM `post_comment` WHERE `postID` = ". $commentID ." AND `postID` = {$this->postID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			return true;
			// Removed succesfully
		} else {
			return false;
			die("Couldn't remove comment from post: " . $this->postID);
		}
	}

}

?>