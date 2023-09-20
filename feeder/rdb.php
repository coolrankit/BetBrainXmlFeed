<?php
define('DB_NAME', '003');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_PREFIX', 'fd_');
/*function require_db() {
	global $db;
	//require_once('db.php' );
	if ($db)
		return;
	$db = new db(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST, DB_PREFIX);
}
require_db();*/
global $db;
$db = new db(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST, DB_PREFIX);
class db{
	function __construct($dbuser, $dbpassword, $dbname, $dbhost, $dbprefix) {
		register_shutdown_function(array($this, '__destruct'));

		$this->dbuser = $dbuser;
		$this->dbpassword = $dbpassword;
		$this->dbname = $dbname;
		$this->dbhost = $dbhost;
		$this->prefix = $dbprefix;

		$this->db_connect();
		$this->real_escape = function_exists('mysql_real_escape_string');
	}
	function rdb($dbuser, $dbpassword, $dbname, $dbhost, $dbprefix) {
		register_shutdown_function(array($this, '__destruct'));

		$this->dbuser = $dbuser;
		$this->dbpassword = $dbpassword;
		$this->dbname = $dbname;
		$this->dbhost = $dbhost;
		$this->prefix = $dbprefix;

		$this->db_connect();
		$this->real_escape = function_exists('mysql_real_escape_string');
	}
	function __destruct() {
		return true;
	}
	function reset_vars() {
		unset($this->error);
		unset($this->num_rows);
		unset($this->rows_affected);
		unset($this->insert_id);
		unset($this->result);
		unset($this->last_result);
	}
	function db_connect() {
		$this->dbh = mysql_connect($this->dbhost, $this->dbuser, $this->dbpassword);
		if ($this->dbh) {
			$this->dbf = @mysql_select_db($this->dbname, $this->dbh);
			if (!$this->dbf) {$this->error = "DB NOT FOUND";}
		} else {$this->error = "DB NOT CONNECTED";}
	}
	function replace($table, $data) {
		return $this->_insert_replace_helper($table, $data, 'REPLACE')? $this->insert_id : false;
	}
	function insert($table, $data) {
		return $this->_insert_replace_helper($table, $data, 'INSERT')? $this->insert_id : false;
	}
	function _insert_replace_helper($table, $data, $type = 'INSERT') {
		if (!in_array(strtoupper($type), array('REPLACE', 'INSERT'))) {return false;}
		
		$fields = array_keys($data);
		$formats = array();
		foreach ($fields as $field) {
			if (is_int($data[$field])) {$form = '%d';}
			elseif (is_float($data[$field])) {$form = '%f';}
			elseif (is_string($data[$field])) {$form = '%s';}
			elseif (is_array($data[$field])) {$form = '%s'; $data[$field] = serialize($data[$field]);}
			else {$form = '%s';}

			$formats[] = $form;
		}
		$sql = "{$type} INTO `$table` (`" . implode('`,`', $fields) . "`) VALUES ('" . implode("','", $formats) . "')";
		return $this->query($this->prepare($sql, $data));
	}
	function update($table, $data, $where) {
		if (! is_array($data) || ! is_array($where)) {return false;}

		$bits = $wheres = array();
		foreach (array_keys($data) as $field) {
			if (is_int($data[$field])) {$form = '%d';}
			elseif (is_float($data[$field])) {$form = '%f';}
			elseif (is_string($data[$field])) {$form = '%s';}
			elseif (is_array($data[$field])) {$form = '%s'; $data[$field] = serialize($data[$field]);}
			else {$form = '%s';}

			$bits[] = "`$field` = {$form}";
		}
		foreach (array_keys($where) as $field) {
			if (is_int($where[$field])) {$form = '%d';}
			elseif (is_float($where[$field])) {$form = '%f';}
			elseif (is_string($where[$field])) {$form = '%s';}
			elseif (is_array($where[$field])) {$form = '%s'; $where[$field] = serialize($where[$field]);}
			else {$form = '%s';}

			$wheres[] = "`$field` = {$form}";
		}

		$sql = "UPDATE `$table` SET " . implode(', ', $bits) . ' WHERE ' . implode(' AND ', $wheres);
		return $this->query($this->prepare($sql, array_merge(array_values($data), array_values($where))));
	}
	function delete($table, $where) {
		if (!is_array($where)) {
			return false;
		}

		$wheres = array();
		foreach (array_keys($where) as $field) {
			if (is_null($where[$field])) {$wheres[] = "`$field` IS NULL"; unset($where[$field]);}
			elseif (is_int($where[$field])) {$form = '%d';}
			elseif (is_float($where[$field])) {$form = '%f';}
			elseif (is_string($where[$field])) {$form = '%s';}
			elseif (is_array($where[$field])) {$form = '%s'; $where[$field] = serialize($where[$field]);}
			else {$form = '%s';}
			$wheres[] = "`$field` = {$form}";
		}
		$sql = "DELETE FROM `$table` WHERE ". implode(' AND ', $wheres);

		return $this->query($this->prepare($sql, array_values($where)));
	}
	function prepare($query = null) { // ($query, *$args)
		if (is_null($query)) {return;}

		$args = func_get_args();
		array_shift($args);
		if (isset($args[0]) && is_array($args[0])) {$args = $args[0];}
		$query = str_replace("'%s'", '%s', $query);
		$query = str_replace('"%s"', '%s', $query);
		$query = preg_replace('|(?<!%)%s|', "'%s'", $query);
		array_walk($args, array(&$this, 'escape_by_ref'));
		return vsprintf($query, $args);
	}
	function escape_by_ref(&$string) {
		$string = $this->_real_escape($string);
	}
	function _real_escape($string) {
		if ($this->dbh && $this->real_escape) {return mysql_real_escape_string($string, $this->dbh);}
		else {return addslashes($string);}
	}
	function unserialized_by_ref(&$data) {
		$data = is_serialized($data)? unserialize($data) : $data;
	}
	function get_object($array, $multi_d = false) {
		$keys = array_keys($array);
		if($multi_d) {
			foreach($keys as $key) {
				foreach(array_keys($array[$key]) as $col) {
					$return[$key]->$col = $array[$key][$col];
				}
			}
		} else {
			foreach($keys as $col) {
				$return->$col = $array[$col];
			}
		}
		return $return;
	}
	function get_var($query = null, $x = 0, $y = 0) {
		if ($query) {$this->query($query);}
		if (!empty($this->last_result[$y])) {
			$values = array_values(get_object_vars($this->last_result[$y]));
		}
		if(isset($values[$x]) && $values[$x] !== ''){
			return ((is_serialized($values[$x]))? unserialize($values[$x]):$values[$x]);
		} else {return null;}
	}
	function get_row($query = null, $output = OBJECT, $y = 0) {
		if ($query) {$this->query($query);}
		else {return null;}

		if (!isset($this->last_result[$y]) || !$this->last_result[$y]) {return null;}

		$return = get_object_vars($this->last_result[$y]);
		array_walk($return, array(&$this, 'unserialized_by_ref'));
		if ($output == ARRAY_A) {return $return;}
		elseif ($output == ARRAY_N) {return array_values($return);}
		else {return $this->get_object($return);}
	}
	function get_col($query = null , $x = 0) {
		if ($query) {$this->query($query);}

		$new_array = array();
		for ($i = 0, $j = count($this->last_result); $i < $j; $i++) {
			$new_array[$i] = $this->get_var(null, $x, $i);
		}
		return empty($new_array)? null : $new_array;
	}
	function get_results($query = null, $output = OBJECT) {
		if ($query) {$this->query($query);} else {return null;}

		if (!isset($this->last_result) || !$this->last_result) {return null;}

		$return = array();
		foreach((array) $this->last_result as $row) {
			$temp_row = get_object_vars($row);
			array_walk($temp_row, array(&$this, 'unserialized_by_ref'));
			if($output == OBJECT_K) {
				$key = array_shift(get_object_vars($row));
				$return[$key] = $temp_row;
			} elseif ($output == ARRAY_N) {
				$return[] = array_values($temp_row);
			} else {$return[] = $temp_row;}
		}
		
		if ($output == ARRAY_A) {return $return;}
		elseif ($output == ARRAY_N) {return $return;}
		else {return $this->get_object($return, true);}
	}
	function query($query) {
		$return_val = 0;
		$this->reset_vars();
		$this->result = @mysql_query($query, $this->dbh);
		if ($this->error = @mysql_error($this->dbh)) {return false;}
		
		if (preg_match('/^\s*(create|alter|truncate|drop) /i', $query)) {
			$return_val = $this->result;
		} elseif (preg_match('/^\s*(insert|delete|update|replace) /i', $query)) {
			$this->rows_affected = @mysql_affected_rows($this->dbh);
			if (preg_match('/^\s*(insert|replace) /i', $query)) {
				$this->insert_id = @mysql_insert_id($this->dbh);
			}
			$return_val = $this->rows_affected;
		} else {
			$i = 0;
			while ($i < @mysql_num_fields($this->result)) {
				$this->col_info[$i] = @mysql_fetch_field($this->result);
				$i++;
			}
			$num_rows = 0;
			while ($row = @mysql_fetch_object($this->result)) {
				$this->last_result[$num_rows] = $row;
				$num_rows++;
			}
			@mysql_free_result($this->result);
			$this->num_rows = $num_rows;
			$return_val = $num_rows;
		}
		
		return $return_val;
	}
}
if(!function_exists('is_serialized')) {
	function is_serialized($data, $strict = true) {
		// if it isn't a string, it isn't serialized
		if (!is_string($data)) {return false;}
		$data = trim($data);
		if ('N;' == $data) {return true;}
		$length = strlen($data);
		if ($length < 4) {return false;}
		if (':' !== $data[1]) {return false;}
		if ($strict) {
			$lastc = $data[$length - 1];
			if (';' !== $lastc && '}' !== $lastc) {return false;}
			else {
				$semicolon = strpos($data, ';');
				$brace = strpos($data, '}');
				// Either ; or } must exist.
				if (false === $semicolon && false === $brace) {return false;}
				// But neither must be in the first X characters.
				if (false !== $semicolon && $semicolon < 3) {return false;}
				if (false !== $brace && $brace < 4) {return false;}
			}
		}
		$token = $data[0];
		switch ($token) {
			case 's' :
				if ($strict) {
					if ('"' !== $data[$length - 2]) {return false;}
					elseif (false === strpos($data, '"')) {return false;}
				}
			case 'a' :
			case 'O' :
				return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
			case 'b' :
			case 'i' :
			case 'd' :
				$end = $strict ? '$' : '';
				return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
		}
		return false;
	}
}
?>