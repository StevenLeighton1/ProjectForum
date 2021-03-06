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
			return true;
		}
		return false;
	}

	public function Save(){
		$db = GetDB();
		if($this->userID != -1){
			$query = "UPDATE `user` SET ";
			$query .= "`last_login` = '" . $this->last_login . "', ";
			$query .= "`user_type` = '" . $this->user_type . "', ";
			$query .= "`email` = '" . mysql_real_escape_string($this->email) . "', ";
			$query .= "`username` = '" . mysql_real_escape_string($this->username) . "', ";
			$query .= "`nickname` = '" . mysql_real_escape_string($this->nickname) . "', ";
			$query .= "`password` = '" . mysql_real_escape_string($this->password) . "' ";
			$query .= "WHERE `userID` = " . $this->userID;

			
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

	public function GetLikesComments(){

			$query = "SELECT * FROM `user_like_comment` WHERE `userID` = {$this->userID}";

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

	public function GetDislikesComments(){

			$query = "SELECT * FROM `user_dislike_comment` WHERE `userID` = {$this->userID}";

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
					
					$u = new Post($row['postID']);
					$ret[] = $u;

				}
				return $ret;
			} else {
				return Array();
			}
	}

	public function SearchPosts($phrase){

			$query = "SELECT * FROM post 
						WHERE title like '%".$phrase."%'";

			$ret = Array();
			$db = GetDB();
			$rows = $db->query($query);
			
			if($rows){
				
				while($row = $rows->fetch_array(MYSQLI_BOTH)){
					
					$u = new Post($row['postID']);
					$ret[] = $u;

				}
			}

			$query = "SELECT * FROM post 
						WHERE content like '%".$phrase."%'";

			$rows = $db->query($query);
			
			if($rows){
				
				while($row = $rows->fetch_array(MYSQLI_BOTH)){
					
					$u = new Post($row['postID']);

					if(!in_array($u, $ret)) $ret[] = $u;

				}
			}

			return $ret;
	}

	public function GetTopics(){

			$query = "SELECT * FROM `topic`";

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

	public function GetSortedTopics($sortNum){
			$db = GetDB();

			if($sortNum == 1){
				$query = "SELECT * FROM `topic` ORDER BY `topic`.`name` ASC";

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
			else if($sortNum == 2){
				$query = "SELECT * FROM `topic` ORDER BY `topic`.`name` DESC";

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
			else if($sortNum == 3){
				$query = "SELECT `topic`.`topicID`, `topic`.`name`, COUNT(`topic_post`.`topicID`) as amt 
							FROM `topic`, `topic_post` 
							WHERE `topic`.`topicID` = `topic_post`.`topicID`
							GROUP BY `topic_post`.`topicID`
							ORDER BY amt DESC, `topic`.`name` DESC";

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
			else if($sortNum == 4){
				$query = "SELECT `topic`.`topicID`, `topic`.`name`, COUNT(`topic_post`.`topicID`) as amt 
							FROM `topic`, `topic_post`, `post_comment` 
							WHERE `topic`.`topicID` = `topic_post`.`topicID` AND
								  `post_comment`.`postID` = `topic_post`.`postID`
							GROUP BY `topic_post`.`topicID`
							ORDER BY amt DESC, `topic`.`name` ASC";

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
			else if($sortNum == 5){
				$query = "SELECT * FROM `topic` ORDER BY `topic`.`topicID` ASC";

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

	

//----------------------------------------------ADD STUFF--------------------------------------------

	public function AddPost($postID){
		$query = "INSERT INTO `user_post` (`userID`, `postID`) VALUES ";
		$query .="({$this->userID}," .$postID.")";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
			return true;
		} else {
			return false;
			die("Couldn't add post to user: " . $this->userID);
		}
	}

	public function AddComment($commentID){
		$query = "INSERT INTO `user_comment` (`userID`, `commentID`) VALUES ";
		$query .="({$this->userID}," .$commentID.")";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
			return true;
		} else {
			return false;
			die("Couldn't add comment to user: " . $this->userID);
		}
	}

	public function AddLike($postID){
		$query = "INSERT INTO `user_like` (`userID`, `postID`) VALUES ";
		$query .="({$this->userID}," .$postID.")";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
			return true;
		} else {
			return false;
			die("Couldn't add like to user: " . $this->userID);
		}
	}

	public function AddDislike($postID){
		$query = "INSERT INTO `user_dislike` (`userID`, `postID`) VALUES ";
		$query .="({$this->userID}," .$postID.")";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
			return true;
		} else {
			return false;
			die("Couldn't add dislike to user: " . $this->userID);
		}
	}

	public function AddCommentLike($commentID){
		$query = "INSERT INTO `user_like_comment` (`userID`, `commentID`) VALUES ";
		$query .="({$this->userID}," .$commentID.")";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
			return true;
		} else {
			return false;
			die("Couldn't add like to user: " . $this->userID);
		}
	}

	public function AddCommentDislike($commentID){
		$query = "INSERT INTO `user_dislike_comment` (`userID`, `commentID`) VALUES ";
		$query .="({$this->userID}," .$commentID.")";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
			return true;
		} else {
			return false;
			die("Couldn't add dislike to user: " . $this->userID);
		}
	}

	public function AddSubscribe($postID){
		$query = "INSERT INTO `user_subscribe` (`userID`, `postID`) VALUES ";
		$query .="({$this->userID}," .$postID.")";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
			return true;
		} else {
			return false;
			die("Couldn't add post to user: " . $this->userID);
		}
	}

//----------------------------------------------DELETE STUFF--------------------------------------------
	public function RemovePost($postID){
		$query = "DELETE FROM `user_post` WHERE `postID` = ". $postID ." AND `userID` = {$this->userID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			return true;
			// Removed succesfully
		} else {
			return false;
			die("Couldn't remove post from user: " . $this->userID);
		}
	}

	public function RemoveComment($commentID){
		$query = "DELETE FROM `user_comment` WHERE `commentID` = ". $commentID ." AND `userID` = {$this->userID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			return true;
			// Removed succesfully
		} else {
			return false;
			die("Couldn't remove comment from user: " . $this->userID);
		}
	}

	public function RemoveLike($postID){
		$query = "DELETE FROM `user_like` WHERE `postID` = ". $postID ." AND `userID` = {$this->userID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			return true;
			// Removed succesfully
		} else {
			return false;
			die("Couldn't remove post from user: " . $this->userID);
		}
	}

	public function RemoveDislike($postID){
		$query = "DELETE FROM `user_dislike` WHERE `postID` = ". $postID ." AND `userID` = {$this->userID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			return true;
			// Removed succesfully
		} else {
			return false;
			die("Couldn't remove post from user: " . $this->userID);
		}
	}

	public function RemoveCommentLike($commentID){
		$query = "DELETE FROM `user_like_comment` WHERE `commentID` = ". $commentID ." AND `userID` = {$this->userID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			return true;
			// Removed succesfully
		} else {
			return false;
			die("Couldn't remove comment from user: " . $this->userID);
		}
	}

	public function RemoveCommentDislike($commentID){
		$query = "DELETE FROM `user_dislike_comment` WHERE `commentID` = ". $commentID ." AND `userID` = {$this->userID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			return true;
			// Removed succesfully
		} else {
			return false;
			die("Couldn't remove comment from user: " . $this->userID);
		}
	}

	public function RemoveSubscribe($postID){
		$query = "DELETE FROM `user_subscribe` WHERE `postID` = ". $postID ." AND `userID` = {$this->userID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			return true;
			// Removed succesfully
		} else {
			return false;
			die("Couldn't remove subscribe from user: " . $this->userID);
		}
	}
}

?>