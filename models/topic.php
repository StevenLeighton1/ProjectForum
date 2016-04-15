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

}

?>