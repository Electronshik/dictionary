<?php
class AnalysModel extends mysqli
{
	const HOST = 'localhost';
	const USER = 'mysql';
	const PASSWORD = 'mysql';
	const DATABASE = 'english';

	public function __construct()
	{
		parent::__construct(self::HOST, self::USER, self::PASSWORD, self::DATABASE);
		if ($this->connect_errno)
		{
			exit('error');
		}
	}

	public function addWord($word)
	{
		$word = strtolower($this->real_escape_string(trim($word)));
		$this->query(" INSERT INTO analys VALUES ('', '$word') ");
	}

	public function getWords()
	{
		$query = $this->query(" SELECT word FROM analys ORDER BY word");
		while($row = $query->fetch_assoc())
		{
			$dict[] = $row['word'];
		}
		return $dict;
	}

	public function getKnownWords()
	{
		$query = $this->query(" SELECT word FROM words ORDER BY word");
		while($row = $query->fetch_assoc())
		{
			$dict[] = $row['word'];
		}
		return $dict;
	}

	public function addTempWord($word)
	{
		$word = strtolower($this->real_escape_string(trim($word)));
		$this->query(" INSERT INTO temp VALUES ('', '$word', '', '') ");
	}

	public function getTempWords()
	{
		$query = $this->query(" SELECT word FROM temp ORDER BY word");
		while ($row = $query->fetch_assoc())
		{
			$words[] = $row['word'];
		}
		return $words;
	}

	public function clearTemp()
	{
		$this->query(" DELETE FROM temp");
	}

}