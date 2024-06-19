<?php

class Login
{
	public $errors = [];
	public $oldInputs = [];
	public $inputs = [];
 
	public function __construct() {
		$this->oldInputs = $_POST;
		$this->inputs = $this->purifyInputs($_POST);
	}
	
	/**
	 * @return Void
	 */
	public function validate()
	{
		$rules = [
			'username' => ['required'],
			'password' => ['required'],
		];
		$validator = new Validator;
		$validator->make($this->inputs, $rules);
		if($validator->errors){
			$this->errors = $validator->errors;
		}
	}

	public function attempt()
    {
		$this->validate();
		if(empty($this->errors)){
			$sql = "SELECT * from users WHERE username = ?";
			$params = [$this->inputs['username']];
			$db = new DB;
			$result = $db->read($sql, 's', $params);
			if ($result) {
				$user = $result[0];
				if($this->hash_text($this->inputs['password']) == $user['password'])
				{
					$_SESSION['id'] = $user['id'];
					$_SESSION['username'] = $user['username'];
					$_SESSION['email'] = $user['email'];
					$_SESSION['successMsg'] = "You have successfully loged in!";
					return true;
				}else
				{
					$this->errors['password'] = "Make sure you type your password correctly!";
					return false;
				}
			}
			return false;
		}else{
			return false;
		}
    }

	/**
	 * @param Array $data
	 * @return Array
	 */
	private function purifyInputs($data)
	{
		foreach ($data as $key => $value) {
			$data[$key] = trim($data[$key]);
			$data[$key] = htmlspecialchars($data[$key]);
		}
		return $data;
	}

	private function hash_text($text){

		$text = hash("sha1", $text);
		return $text;
	}

	public function check_login($id,$redirect = true)
	{
		// if(is_numeric($id))
		// {
		// 	$query = "select * from users where userid = '$id' limit 1 ";
		// 	$DB = new Database();
		// 	$result = $DB->read($query);
		// 	if($result)
		// 	{
		// 		$user_data = $result[0];
		// 		return $user_data;
		// 	}else
		// 	{
		// 		if($redirect){
		// 			header("Location: ".ROOT."login");
		// 			die;
		// 		}else{

		// 			$_SESSION['mybook_userid'] = 0;
		// 		}
		// 	}
 
			 
		// }else
		// {
		// 	if($redirect){
		// 		header("Location: ".ROOT."login");
		// 		die;
		// 	}else{
		// 		$_SESSION['mybook_userid'] = 0;
		// 	}
		// }

	}
 
}