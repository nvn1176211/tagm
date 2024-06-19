<?php

class Register
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
			'email' => ['required', 'email'],
			'username' => ['required', 'max:20', 'unique:users,username'],
			'password' => ['required', 'max:20'],
		];
		$validator = new Validator;
		$validator->make($this->inputs, $rules);
		if($validator->errors){
			$this->errors = $validator->errors;
		}
	}

	public function save()
	{
		$this->validate();
		if(empty($this->errors)){
			$now = date("Y-m-d H:i:s");
			$password = hash("sha1", $this->inputs['password']);
			$insertSql = "INSERT INTO users (username, password, email, created_at, updated_at) VALUES (?, ?, ?, '$now', '$now')";
			$params = [$this->inputs['username'], $password, $this->inputs['email']];
			$db = new DB;
			$insertId = $db->create($insertSql, 'sss', $params);
			// echo '<pre>';var_dump($insertId);echo '</pre>';die;
			if($insertId){
				$readSql = "SELECT username, email FROM users WHERE id = ?";
				$data = $db->read($readSql, 'i', [$insertId]);
				$user = $data[0];
				$_SESSION['id'] = $insertId;
				$_SESSION['username'] = $user['username'];
				$_SESSION['email'] = $user['email'];
				$_SESSION['successMsg'] = "You have successfully registered!";
				// echo '<pre>';var_dump($data);echo '</pre>';die;
				return true;
			}
			return false;
		}else{
			return false;
		}
	}

	// private function create_userid()
	// {

	// 	$length = rand(4,19);
	// 	$number = "";
	// 	for ($i=0; $i < $length; $i++) { 
	// 		# code...
	// 		$new_rand = rand(0,9);

	// 		$number = $number . $new_rand;
	// 	}

	// 	return $number;
	// }

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
}
