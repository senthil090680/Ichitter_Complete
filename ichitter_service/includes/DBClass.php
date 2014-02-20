<?php

class DBHandler {
###############################################
// DB connection variables 
// Need to change the values according to need
###############################################

	var $DATABASE;
	var $USERNAME;
	var $PASSWORD;
	var $SERVER;

########################################### 
# Function:    SetDBvalues 
# Parameters:  $db=>Database,$usr=>Username,
# Parameters:  $pword=>Password,$host=>Server
# Return Type: boolean 
# Description: Define the DB values for current connection 
########################################### 

	function _construct($db, $usr, $pword, $host, $file, $log, $err, $con) {
		$this->DATABASE = $db;
		$this->USERNAME = $usr;
		$this->PASSWORD = $pword;
		$this->SERVER = $host;

		$this->LOGFILE = "http://localhost:3036/mysql.log";
		$this->LOGGING = $log;
		$this->SHOW_ERRORS = $err;

		$this->USE_PERMANENT_CONNECTION;
	}

	function SetDBvalues($db, $usr, $pword, $host) {
		if (isset($db) && isset($usr) && isset($pword) && isset($host)) {
			$this->DATABASE = $db;
			$this->USERNAME = $usr;
			$this->PASSWORD = $pword;
			$this->SERVER = $host;
			return true;
		} else {
			return false;
		}
	}

###############################################
# Variables for debugging mode
# Need to change the values accordingly
###############################################
	//var $LOGFILE	= "http://192.168.200.180/FileServer/DBclassexamples/mysql.log"; // full path to debug LOGFILE. Use only in debug mode! 
	//var $LOGGING	= false; // debug on or off 
	//var $SHOW_ERRORS= true; // output errors. true/false 

	var $LOGFILE;
	var $LOGGING;
	var $SHOW_ERRORS;

########################################### 
# Function:    SetLogvalues 
# Parameters:  $file=>File path,$log=>mode,
# Parameters:  $err=>err msgs
# Return Type: boolean 
# Description: Define the Debuging values for current connection 
########################################### 

	function SetLogvalues($file, $log, $err) {
		if (isset($file) && isset($log) && isset($err)) {
			$this->LOGFILE = "http://localhost:3036/mysql.log";
			$this->LOGGING = $log;
			$this->SHOW_ERRORS = $err;
			return true;
		} else {
			return false;
		}
	}

###############################################
# Selecting the connection type as normal or 
# presistent connection
# assign TRUE for presistent connection 
###############################################
//	var $USE_PERMANENT_CONNECTION = false; 
	var $USE_PERMANENT_CONNECTION;

########################################### 
# Function:   SetConnection 
# Parameters:  $con => connection type true/false
# Parameters:  $err=>err msgs
# Return Type: boolean 
# Description: Define the Debuging values for current connection 
########################################### 

	function SetConnection($con) {
		if (isset($con)) {
			$this->USE_PERMANENT_CONNECTION;
			return true;
		} else {
			return false;
		}
	}

###############################################
# Do not change the variables below 
# Variables for generating messages 
###############################################

	var $CONNECTION; // Value assign at the time of OpenConnection()
	var $FILE_HANDLER; //value assign at the time of logfile_init()
	var $ERROR_MSG = '';
###############################################
########################################### 
# Function:    init 
# Parameters:  N/A 
# Return Type: boolean 
# Description: initiates the MySQL Handler 
########################################### 

	function init() {
		$this->logfile_init();
		if ($this->OpenConnection()) {
			return true;
		} else {
			return false;
		}
	}

########################################### 
# Function:    OpenConnection 
# Parameters:  N/A 
# Return Type: boolean 
# Description: connects to the database 
########################################### 

	function OpenConnection() {
		if ($this->USE_PERMANENT_CONNECTION) {
			$conn = mysql_pconnect($this->SERVER, $this->USERNAME, $this->PASSWORD);
		} else {
			$conn = mysql_connect($this->SERVER, $this->USERNAME, $this->PASSWORD);
		}

		if ((!$conn) || (!mysql_select_db($this->DATABASE, $conn))) {
			$this->ERROR_MSG = "\r\n" . "Unable to connect to database - " . date('H:i:s');
			$this->debug();
			return false;
		} else {
			$this->CONNECTION = $conn;
			return true;
		}
	}

########################################### 
# Function:    CloseConnection 
# Parameters:  N/A 
# Return Type: boolean 
# Description: closes connection to the database 
########################################### 

	function CloseConnection() {
		if (mysql_close($this->CONNECTION)) {
			return true;
		} else {
			$this->ERROR_MSG = "\r\n" . "Unable to close database connection - " . date('H:i:s');
			$this->debug();
			return false;
		}
	}

########################################### 
# Function:    debug 
# Parameters:  N/A 
# Return Type: N/A 
# Description: logs and displays errors 
########################################### 

	function debug() {
		if ($this->SHOW_ERRORS) {
			echo $this->ERROR_MSG;
		}
		if ($this->LOGGING) {
			if ($this->FILE_HANDLER) {
				fwrite($this->FILE_HANDLER, $this->ERROR_MSG);
			} else {
				return false;
			}
		}
	}

########################################### 
# Function:    logfile_init 
# Parameters:  N/A 
# Return Type: N/A 
# Description: initiates the logfile 
########################################### 

	function logfile_init() {
		if ($this->LOGGING) {
			$this->FILE_HANDLER = fopen($this->LOGFILE, 'a');
			$this->debug();
		}
	}

########################################### 
# Function:    logfile_close 
# Parameters:  N/A 
# Return Type: N/A 
# Description: closes the logfile 
########################################### 

	function logfile_close() {
		if ($this->LOGGING) {
			if ($this->FILE_HANDLER) {
				fclose($this->FILE_HANDLER);
			}
		}
	}

########################################### 
# Function:    Insert 
# Parameters:  sql : string 
# Return Type: integer 
# Description: executes a INSERT statement and returns the INSERT ID 
########################################### 

	function Insert($sql) {
		if ((empty($sql)) || (!eregi("^insert", $sql)) || (empty($this->CONNECTION))) {
			$this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> or not an INSERT - " . date('H:i:s');
			$this->debug();
			return false;
		} else {
			$conn = $this->CONNECTION;
			$results = mysql_query($sql);

			if (!$results) {
				$this->ERROR_MSG = "\r\n" . mysql_error() . " - " . date('H:i:s');
				$this->debug();
				//exit;
				return false;
			} else {
				$result = mysql_insert_id();
				return $result;
			}
		}
	}

########################################### 
# Function:    Select 
# Parameters:  sql : string 
# Return Type: array 
# Description: executes a SELECT statement and returns a 
#              multidimensional array containing the results 
#              array[row][fieldname/fieldindex] 
########################################### 

	function executeQuery($qry) {
		$result = mysql_query($qry, $this->CONNECTION);
		return $result;
	}

	function Select($sql) {
		if ((empty($sql)) || (!eregi("^select", $sql)) || (empty($this->CONNECTION))) {
			$this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> or not a SELECT - " . date('H:i:s');
			$this->debug();
			return false;
		} else {
			$conn = $this->CONNECTION;
			$results = mysql_query($sql, $conn);
			if ((!$results) || (empty($results))) {
				$this->ERROR_MSG = "\r\n" . mysql_error() . " - " . date('H:i:s');
				$this->debug();
				return false;
			} else {
				$i = 0;
				$data = array();
				while ($row = mysql_fetch_assoc($results)) {
					$data[$i] = $row;
					$i++;
				}
				mysql_free_result($results);
				return $data;
			}
		}
	}

########################################### 
# Function:    Update 
# Parameters:  sql : string 
# Return Type: integer 
# Description: executes a UPDATE statement 
#              and returns number of affected rows 
########################################### 

	function Update($sql) {
		if ((empty($sql)) || (!eregi("^update", $sql)) || (empty($this->CONNECTION))) {
			$this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> or not an UPDATE - " . date('H:i:s');
			$this->debug();
			return false;
		} else {
			$conn = $this->CONNECTION;
			$results = mysql_query($sql, $conn);
			if (!$results) {
				$this->ERROR_MSG = "\r\n" . mysql_error() . " - " . date('H:i:s');
				$this->debug();
				return false;
			} else {
				return mysql_affected_rows();
			}
		}
	}

########################################### 
# Function:    Delete 
# Parameters:  sql : string 
# Return Type: boolean 
# Description: executes a DELETE statement 
########################################### 

	function Delete($sql) {
		if ((empty($sql)) || (!eregi("^delete", $sql)) || (empty($this->CONNECTION))) {
			$this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> or not a DELETE - " . date('H:i:s');
			$this->debug();
			return false;
		} else {
			$conn = $this->CONNECTION;
			$results = mysql_query($sql, $conn);
			if (!$results) {
				$this->ERROR_MSG = "\r\n" . mysql_error() . " - " . date('H:i:s');
				$this->debug();
				return false;
			} else {
				return true;
			}
		}
	}

########################################### 
# Function:    Query 
# Parameters:  sql : string 
# Return Type: boolean 
# Description: executes any SQL Query statement 
########################################### 

	function Query($sql) {
		if ((empty($sql)) || (empty($this->CONNECTION))) {
			$this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> - " . date('H:i:s');
			$this->debug();
			return false;
		} else {
			$conn = $this->CONNECTION;
			$results = mysql_query($sql, $conn);
			if (!$results) {
				$this->ERROR_MSG = "\r\n" . mysql_error() . " - " . date('H:i:s');
				$this->debug();
				return false;
			} else {
				return true;
			}
		}
	}

########################################### 
# Function:    Numrows 
# Parameters:  sql : string 
# Return Type: Integer (No of selected rows) 
# Description: executes SQL SELECT Query statement 
########################################### 

	function Numrows($sql) {
		if ((empty($sql)) || (!eregi("^select", $sql)) || (empty($this->CONNECTION))) {
			$this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> or not a SELECT - " . date('H:i:s');
			$this->debug();
			return false;
		} else {
			$conn = $this->CONNECTION;
			$results = mysql_query($sql, $conn);
			if ((!$results) || (empty($results))) {
				$this->ERROR_MSG = "\r\n" . mysql_error() . " - " . date('H:i:s');
				$this->debug();
				return false;
			} else {
				$data = mysql_num_rows($results);
				return $data;
			}
		}
	}

}

?>
