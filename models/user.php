<?php
require_once dirname(__FILE__) . "/../system/database.php";

class User {

	public $userID = -1;
	public $last_login;
	public $user_type;
	public $date_joined;
	public $email;
	public $username;
	public $nickname;
	public $password;

	public function User($user_id){
		//check to see if valid user_id
		if($user_id <= -1){
			return;
		}

		$this->userID = $user_id;

		$db = GetDB();

		// If the user_id is equal to zero, then this must be a new user
		if($this->userID == 0){
			$query = "INSERT INTO `user` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->userID = $db->insert_id;
			} else {
				die("Couldn't create user");
			}
			return;
		}

		$query = "SELECT * FROM `user` WHERE `userID` = " . $this->userID;

		$user = $db->query($query, MYSQLI_STORE_RESULT );
		if($user){
			$user = $user->fetch_array(MYSQLI_BOTH);

			if($user != NULL){
				$this->last_login = $user['last_login'];
				$this->user_type = $user['user_type'];
				$this->date_joined = $user['date_joined'];
				$this->email = $user['email'];
				$this->username = $user['username'];
				$this->password = $user['password'];
				$this->nickname = $user['nickname'];
			} else {
				die("Couldn't find user: " . $this->userID);
			}
		} else {
			die("Couldn't find user: " . $this->userID);
		}
	}

	public function Login_Email($email, $password){
		$db = GetDB();

		//query for the user in the database using credentials

		$query = "SELECT * FROM `user` WHERE `email` = '" .  $email . "' AND `password` = '" .  $password . "';";
		$result = $db->query($query);

		// $query = "SELECT * FROM `user` WHERE `email` = '" .  $email . "' AND `password` = '" .  $password . "';";
		// $result = $db->query($query);

		//if the result isn't empty
		if($result->num_rows != 0){
			$user = $result->fetch_array(MYSQLI_BOTH);
			$this->userID = $user['userID'];
			$this->last_login = $user['last_login'];
			$this->user_type = $user['user_type'];
			$this->date_joined = $user['date_joined'];
			$this->email = $user['email'];
			$this->username = $user['username'];
			$this->password = $user['password'];
			$this->nickname = $user['nickname'];
		}
	}

	public function Login_Username($username, $password){
		$db = GetDB();

		//query for the user in the database using credentials

		$query = "SELECT * FROM `user` WHERE `username` = '" .  $username . "' AND `password` = '" .  $password . "';";
		$result = $db->query($query);

		// $query = "SELECT * FROM `user` WHERE `email` = '" .  $email . "' AND `password` = '" .  $password . "';";
		// $result = $db->query($query);

		//if the result isn't empty
		if($result->num_rows != 0){
			$user = $result->fetch_array(MYSQLI_BOTH);
			$this->userID = $user['userID'];
			$this->last_login = $user['last_login'];
			$this->user_type = $user['user_type'];
			$this->date_joined = $user['date_joined'];
			$this->email = $user['email'];
			$this->username = $user['username'];
			$this->password = $user['password'];
			$this->nickname = $user['nickname'];
		}
	}

	public function Save(){
		if($this->userID != -1){
			$query = "UPDATE `user` SET ";
			$query .= "`last_login` = '" . $this->last_login . "', ";
			$query .= "`user_type` = '" . $this->user_type . "', ";
			$query .= "`date_joined` = '" . $this->date_joined . "', ";
			$query .= "`email` = '" . $this->email . "', ";
			$query .= "`username` = '" . $this->username . "', ";
			$query .= "`nickname` = '" . $this->nickname . "', ";
			$query .= "`password` = '" . $this->password . "' ";
			$query .= "WHERE `userID` = " . $this->userID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
				return TRUE;
			} else {
				return FALSE;
				die("Couldn't update user: " . $this->userID);
			}
		}
		return FALSE;
	}

	public function Delete(){
		if(!filter_var($this->userID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong userID
		}

		$query = "DELETE FROM `user` WHERE `userID` = {$this->userID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			die("Couldn't delete user: " . $this->userID . " Because " . mysqli_error($db));
		}
	}
//---------------------------GET STUFF---------------------------------------------------
	public function GetComments(){

			$query = "SELECT * FROM `user_comment` WHERE `userID` = {$this->userID}";

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

	public function GetLikes(){

			$query = "SELECT * FROM `user_like` WHERE `userID` = {$this->userID}";

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

	public function GetDislikes(){

			$query = "SELECT * FROM `user_dislike` WHERE `userID` = {$this->userID}";

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

	public function GetPosts(){

			$query = "SELECT * FROM `user_post` WHERE `userID` = {$this->userID}";

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

			$query = "SELECT * FROM `user_moderator` WHERE `userID` = {$this->userID}";

			$db = GetDB();
			$rows = $db->query($query);
			if($rows){
				$ret = Array();
				while($row = $rows->fetch_array(MYSQLI_BOTH)){
					
					$u = new Topic($row['topicID']);
					$ret[] = $u;

				}
				return $ret;
			} else {
				return Array();
			}
	}

	public function GetSubscribes(){

			$query = "SELECT * FROM `user_subscribe` WHERE `userID` = {$this->userID}";

			$db = GetDB();
			$rows = $db->query($query);
			if($rows){
				$ret = Array();
				while($row = $rows->fetch_array(MYSQLI_BOTH)){
					
					$u = new Topic($row['topicID']);
					$ret[] = $u;

				}
				return $ret;
			} else {
				return Array();
			}
	}
}

?>