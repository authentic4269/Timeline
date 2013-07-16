<?php
	class Token {
		public static function getId() {
			global $sqlController;
			if(isset($_COOKIE['token']))
			{
				$token = htmlspecialchars($_COOKIE['token']);
				$result = $sqlController->query("SELECT user_id FROM users_auth WHERE token='$token' AND expire > NOW()");
				if(count($result) > 0)
				{
					$id = $result[0]['user_id'];
					return $id;
				}
			}
			return false;
		}
		public static function set($id) {
			global $sqlController;
			$token = md5(uniqid('', true).$id);
			setcookie('token', $token, time() + 60 * 60 * 24);
			$query = "INSERT INTO users_auth(user_id, token, expire) VALUES ($id,'$token',DATE_ADD(NOW(), INTERVAL 1 DAY))";
			return $sqlController->query($query);
		}
		public static function reset() {
			global $sqlController;
			if (isset($_COOKIE['token'])) {
				$token = htmlspecialchars($_COOKIE['token']);
				$result = $sqlController->query("DELETE FROM users_auth WHERE token='$token'");
				
				setcookie('token', '');
			}
		}
		public static function refresh() {
			global $sqlController;
			if (isset($_COOKIE['token'])) {
				$token = htmlspecialchars($_COOKIE['token']);
				$result = $sqlController->query("UPDATE users_auth SET expire=DATE_ADD(NOW(), INTERVAL 1 DAY) WHERE token='$token'");
			}
		}
		public static function clean($id)
		{
			global $sqlController;
			$query = "DELETE FROM users_auth WHERE user_id=$id AND expire <= NOW()";
			$result = $sqlController->query($query);
		}
	}
?>