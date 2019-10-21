<?php
  // db.php

  // Opens a connection to the 3EProfiler database.

  if (defined('_DB_INCLUDED_'))
    return;
  define ('_DB_INCLUDED_', true, true);

  require_once(dirname(__FILE__) . '/../system.php');
  require_once(dirname(__FILE__) . '/../error.php');


  class Database
  {

	var $dbh;
	var $query_result;
	var $num_queries = 0;
	var $in_transaction = 0;

	//
	// Constructor
	//
	public function __construct($dsn, $username, $password)
	{
		$this->username = $username;
		$this->password = $password;
		$this->dsn = $dsn;

		$this->dbh = new PDO($this->dsn, $this->username, $this->password);
	}
    function Database($dsn, $username, $password)
    {
        self::__construct($dsn, $username, $password);
    }

	//
	// Other base methods
	//
	function close()
	{
		if(! $this->dbh)
		{
			return false;
		}

		//
		// Commit any remaining transactions
		//
		if( $this->in_transaction )
		{
			$this->dbh->exec("COMMIT");
		}

		$this->dbh = null;
		return true;
	}

	function quote($string)
	{
		return $this->dbh->quote($string);
	}

	//
	// Base query method
	//
	function query($query = "", $transaction = false)
	{
		//
		// Remove any pre-existing queries
		//
		unset($this->query_result);

		if( $query != "" )
		{
			$this->num_queries++;
			if( $transaction == BEGIN_TRANSACTION && !$this->in_transaction )
			{
				if ($this->dbh->exec("BEGIN") === false)
				{
					return false;
				}
				$this->in_transaction = true;
			}

			$this->query_result = $this->dbh->query($query);
		}
		elseif( $transaction == END_TRANSACTION && $this->in_transaction )
		{
			$this->dbh->exec("COMMIT");
		}

		if( $this->query_result )
		{
			if( $transaction == END_TRANSACTION && $this->in_transaction )
			{
				$this->in_transaction = FALSE;

				if ($this->dbh->exec("COMMIT") === false)
				{
					$this->dbh->exec("ROLLBACK");
					return false;
				}
			}

			return $this->query_result;
		}
		elseif( $this->in_transaction )
		{
			$this->dbh->exec("ROLLBACK");
			$this->in_transaction = false;
		}
		return false;
	}

	function num_rows()
	{
		return $this->query_result->rowCount();
	}

	function fetch_row($stmt = null)
	{
		if( !$stmt )
		{
			$stmt = $this->query_result;
		}

		if( $stmt )
		{
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}

		return false;
	}

	function freeresult($stmt = null)
	{
		if( !$stmt )
		{
			$stmt = $this->query_result;
		}

		if ( $stmt )
		{
			$stmt->closeCursor();
			return true;
		}
		return false;
	}

	function error()
	{
		$result['message'] = $this->dbh->errorCode();
		$result['code'] = $this->dbh->errorInfo;

		return $result;
	}

  } // class Database 

  $rpgDB = new Database($DB_DSN, $DB_USER, $DB_PWD)
?>
