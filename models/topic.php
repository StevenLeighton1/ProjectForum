<?php
require_once dirname(__FILE__) . "/../system/database.php";

class Topic {

	public $topicID = -1;
	public $name;

	public function Topic($topic_id){
		//check to see if valid topic_id
		if($topic_id <= -1){
			return;
		}

		$this->topicID = $topic_id;

		$db = GetDB();

		// If the topic_id is equal to zero, then this must be a new topic
		if($this->topicID == 0){
			$query = "INSERT INTO `topic` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->topicID = $db->insert_id;
			} else {
				die("Couldn't create topic");
			}
			return;
		}

		$query = "SELECT * FROM `topic` WHERE `topicID` = " . $this->topicID;

		$topic = $db->query($query, MYSQLI_STORE_RESULT );
		if($topic){
			$topic = $topic->fetch_array(MYSQLI_BOTH);

			if($topic != NULL){
				$this->name = $topic['name'];
			} else {
				die("Couldn't find topic: " . $this->topicID);
			}
		} else {
			die("Couldn't find topic: " . $this->topicID);
		}
	}

	public function Save(){
		if($this->topicID != -1){
			$query = "UPDATE `topic` SET ";
			$query .= "`name` = '" . $this->name . "' ";
			$query .= "WHERE `topicID` = " . $this->topicID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
				return TRUE;
			} else {
				return FALSE;
				die("Couldn't update topic: " . $this->topicID);
			}
		}
		return FALSE;
	}

	public function Delete(){
		if(!filter_var($this->topicID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong topicID
		}

		$query = "DELETE FROM `topic` WHERE `topicID` = {$this->topicID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			die("Couldn't delete topic: " . $this->topicID . " Because " . mysqli_error($db));
		}
	}
//----------------------------------------------GET STUFF--------------------------------------------
	public function GetPosts(){

			$query = "SELECT * FROM `topic_post` WHERE `topicID` = {$this->topicID}";

			$db = GetDB();
			$rows = $db->query($query);
			if($rows){
				$ret = Array();
				while($row = $rows->fetch_array(MYSQLI_BOTH)){
					
					$u = new Post($row['postID']);
					$ret[] = $u;

				}
				return $ret;
			} else {
				return Array();
			}
	}

	public function GetModerators(){

			$query = "SELECT * FROM `user_moderator` WHERE `topicID` = {$this->topicID}";

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
	

	public function GetLatestPost(){

			$query = "SELECT * FROM `post` ORDER BY `post`.`created_date` DESC";

			$db = GetDB();
			$rows = $db->query($query);
			if($rows){
				$ret = Array();
				while($row = $rows->fetch_array(MYSQLI_BOTH)){
					
					$u = new Post($row['postID']);
					$ret[] = $u;

				}
			}

			foreach ($ret as $post) {
				if($this->topicID == $post->GetTopic()->topicID){

					return $post;
				}
			}

			return NULL;
	}

//----------------------------------------------ADD STUFF--------------------------------------------
	public function AddPost($postID){
		$query = "INSERT INTO `topic_post` (`topicID`, `postID`) VALUES ";
		$query .="({$this->topicID}," .$postID.")";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
			return true;
		} else {
			return false;
			die("Couldn't add post to topic: " . $this->topicID);
		}
	}

//----------------------------------------------DELETE STUFF--------------------------------------------
	public function RemovePost($postID){
		$query = "DELETE FROM `topic_post` WHERE `postID` = ". $postID ." AND `topicID` = {$this->topicID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			return true;
			// Removed succesfully
		} else {
			return false;
			die("Couldn't remove post from topic: " . $this->topicID);
		}
	}
}

?>