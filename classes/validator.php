<?php

class Validator
{
	public $errors = [];

	/**
	 * @param Array $data
	 * @param Array $rules
	 * @param Array $messages
	 * @return Void
	 */
	public function make($data, $rules = [])
	{
		foreach ($rules as $fieldname => $ruleArr) {
			foreach ($ruleArr as $key => $rule) {
				if ($rule == 'required') {
					if (!$this->required($fieldname, $data[$fieldname])) break;
				}
				if ($rule == 'email') {
					if (!$this->email($fieldname, $data[$fieldname])) break;
				}
				if ($rule == 'numeric') {
					if (!$this->numeric($fieldname, $data[$fieldname])) break;
				}
				if (preg_match('/max/', $rule)) {
					$max = intval(str_replace('max:', '', $rule));
					if (!$this->max($max, $fieldname, $data[$fieldname])) break;
				}
				if (preg_match('/unique/', $rule)) {
					$uniqueInfo = explode(',', str_replace('unique:', '', $rule));
					$tableName = $uniqueInfo[0];
					$columnName = $uniqueInfo[1];
					if (!$this->unique($tableName, $columnName, $fieldname, $data[$fieldname])) break;
				}
			}
		}
	}

	/**
	 * @param String $fieldname
	 * @param String $value
	 * @return Boolean
	 */
	private function required($fieldname, $value)
	{
		if (empty($value)) {
			$this->errors[$fieldname] = "The $fieldname field is required.";
			return false;
		}
		return true;
	}

	/**
	 * @param Interger $max
	 * @param String $fieldname
	 * @param String $value
	 * @return Boolean
	 */
	private function max($max, $fieldname, $value)
	{
		if (strlen($value) > $max) {
			$this->errors[$fieldname] = "The $fieldname field must not be greater than $max characters.";
			return false;
		}
		return true;
	}

	/**
	 * @param String $fieldname
	 * @param String $value
	 * @return Boolean
	 */
	private function email($fieldname, $value)
	{
		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)) {
			$this->errors[$fieldname] = "The $fieldname field must be a valid email address.";
			return false;
		}
		return true;
	}

	/**
	 * @param String $fieldname
	 * @param String $value
	 * @return Boolean
	 */
	private function numeric($fieldname, $value)
	{
		if (!preg_match("/^[0-9]*$/", $value)) {
			$this->errors[$fieldname] = "The $fieldname field must be a number.";
			return false;
		}
		return true;
	}

	/**
	 * @param String $tableName
	 * @param String $columnName
	 * @param String $fieldname
	 * @param String $value
	 * @return Boolean
	 */
	private function unique($tableName, $columnName, $fieldname, $value)
	{
		$sql = "SELECT id FROM $tableName WHERE $columnName = ?";
		$params = [$value];
		$db = new DB;
		$result = $db->read($sql, 's', $params);
		if ($result) {
			$this->errors[$fieldname] = "The $fieldname has already been taken.";
			return false;
		}
		return true;
	}
}
