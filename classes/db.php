<?php

class DB
{
	private $host = "localhost";
	private $username = "root";
	private $password = "";
	private $db = "tagm";

	/**
	 * @return Object
	 */
	function connect()
	{
		$connection = mysqli_connect($this->host, $this->username, $this->password, $this->db);
		return $connection;
	}

	/**
	 * @param Object $conn
	 * @return Void
	 */
	function close($conn)
	{
		mysqli_close($conn);
	}

	/**
	 * @param String $sql
	 * @param String $paramTypes
	 * @param Array $params
	 * @return Array
	 */
	function read($sql, $paramTypes, $params = [])
	{
		$data = [];
		$conn = $this->connect();
		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, $sql)) {
			if(!empty($params)){
				mysqli_stmt_bind_param($stmt, $paramTypes, ...$params);
			}
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			while ($row = mysqli_fetch_assoc($result)) {
				$data[] = $row;
			}
			return $data;
		} else {
			echo 'Database Query failed';die;
		}
		$this->close($conn);
	}

	/**
	 * @param String $sql
	 * @param String $paramTypes
	 * @param Array $params
	 * @return Interger
	 */
	function create($sql, $paramTypes, $params = [])
	{
		$conn = $this->connect();
		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, $sql)) {
			mysqli_stmt_bind_param($stmt, $paramTypes, ...$params);
			mysqli_stmt_execute($stmt);
			return mysqli_insert_id($conn);
		} else {
			echo 'Database Query failed';die;
		}
		$this->close($conn);
	}

	/**
	 * @param String $sql
	 * @param String $paramTypes
	 * @param Array $params
	 * @return Boolean
	 */
	function delete($sql, $paramTypes, $params = [])
	{
		$conn = $this->connect();
		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, $sql)) {
			mysqli_stmt_bind_param($stmt, $paramTypes, ...$params);
			mysqli_stmt_execute($stmt);
			return true;
		} else {
			echo 'Database Query failed';die;
		}
		$this->close($conn);
	}
}
