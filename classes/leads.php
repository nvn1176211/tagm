<?php

class Leads
{
	public $errors = [];
	public $oldInputs = [];
	public $inputs = [];

	public function __construct()
	{
		$this->oldInputs = $_POST;
		$this->inputs = $this->purifyInputs($_POST);
	}

	/**
	 * @return Void
	 */
	public function validate()
	{
		$rules = [
			'name' => ['required', 'max:550'],
			'phone' => ['required', 'max:550', 'numeric'],
			'email' => ['required', 'email'],
		];
		$validator = new Validator;
		$validator->make($this->inputs, $rules);
		if ($validator->errors) {
			$this->errors = $validator->errors;
		}
	}

	/**
	 * @return Boolean
	 */
	public function create()
	{
		$this->validate();
		if (empty($this->errors)) {
			$now = date("Y-m-d H:i:s");
			$sql = "INSERT INTO leads (name, phone, email, created_at, updated_at, created_by, updated_by) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$params = [$this->inputs['name'], $this->inputs['phone'], $this->inputs['email'], $now, $now, $_SESSION['id'], $_SESSION['id']];
			$db = new DB;
			$insertId = $db->create($sql, 'sssssii', $params);
			if ($insertId) {
				$_SESSION['successMsg'] = "You have successfully created new lead!";
				return true;
			}
			return false;
		} else {
			return false;
		}
	}

	/**
	 * @return Array
	 */
	public function get()
	{
		$db = new DB;
		$sql = "SELECT id, name, phone, email FROM leads";
		$result = $db->read($sql, '', []);
		return $result;
	}

	/**
	 * @return Boolean
	 */
	public function delete($id)
	{
		$db = new DB;
		$sql = "DELETE FROM leads WHERE id = ?";
		$result = $db->delete($sql, 'i', [$id]);
		$_SESSION['successMsg'] = "You have successfully deleted a lead!";
		return $result;
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
}
