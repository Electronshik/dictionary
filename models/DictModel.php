<?php
class DictModel extends mysqli
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

	private function syncNum()
	{
		$query = $this->query("SELECT * FROM dicts");
		while($row = $query->fetch_assoc())
		{
			$num = $this->query("SELECT id FROM words WHERE dict=".$row['id'])->num_rows;
			$this->query("UPDATE dicts SET num=$num WHERE id=".$row['id']);
		}
	}

	public function delWord($id)
	{
		$this->query("DELETE FROM words WHERE id=$id");
		$this->syncNum();
	}

	public function getWord($id)
	{
		return $this->query("SELECT * FROM words WHERE id=$id")->fetch_assoc();
	}

	public function getWords($id)
	{
		return $this->query("SELECT * FROM words WHERE dict=$id ORDER BY word")->fetch_all(MYSQLI_ASSOC);
	}

	public function getWordsAlphabet($char, $dict = NULL)
	{
		$char = $this->real_escape_string(trim($char));
		if ($dict === NULL)
		{
			$query = "SELECT * FROM words WHERE word LIKE '$char%' ORDER BY word ";
		}
		else
		{
			$query = "SELECT * FROM words WHERE word LIKE '$char%' AND dict = $dict ORDER BY word";
		}
			return $this->query($query)->fetch_all(MYSQLI_ASSOC);
	}

	public function getAllWords()
	{
		return $this->query("SELECT * FROM words ORDER BY word")->fetch_all(MYSQLI_ASSOC);
	}

	public function getDicts()
	{
		return $this->query("SELECT * FROM dicts")->fetch_all(MYSQLI_ASSOC);
	}

	public function addDict($name, $info='')
	{
		$name = $this->real_escape_string(trim($name));
		$info = $this->real_escape_string(trim($info));
		$this->query("INSERT INTO dicts VALUES ('', '$name', '$info', '')");
	}

	public function editDict($name, $id, $info='')
	{
		$name = $this->real_escape_string(trim($name));
		$info = $this->real_escape_string(trim($info));
		$this->query("UPDATE dicts SET name='$name', info='$info' WHERE id=$id");
	}

	public function delDict($id, $del_or_replace, $word_to)
	{
		if($del_or_replace == 0)
		{
		$this->query("DELETE FROM words WHERE dict=$id");
		$this->query("DELETE FROM dicts WHERE id=$id");
		$this->syncNum();
		}
		else
		{
		$this->query("UPDATE words SET dict=$word_to WHERE dict=$id");
		$this->query("DELETE FROM dicts WHERE id=$id");
		$this->syncNum();
		}
	}

	public function addWord($name, $translate, $dict)
	{
		//$name = strtolower($this->real_escape_string(trim($name)));
		//$translate = strtolower($this->real_escape_string(trim($translate)));
		$this->query("INSERT INTO words VALUES (NULL, '$name', '$translate', '$dict', '')");
		$this->syncNum();
	}

	public function editWord($id, $word, $translate, $dict)
	{
		$word = strtolower($this->real_escape_string(trim($word)));
		$translate = strtolower($this->real_escape_string(trim($translate)));
		$this->query("UPDATE words SET word='$word', translate='$translate', dict='$dict' WHERE id=$id");
		$this->syncNum();
	}

	public function getSearchWords($search)
	{
		$search = $this->real_escape_string(trim($search));
		return $this->query("SELECT * FROM words WHERE word LIKE '%$search%' ORDER BY word")->fetch_all(MYSQLI_ASSOC);
	}

	public function addMark($id)
	{
		$this->query("UPDATE words SET mark='on' WHERE id=$id");
	}

	public function delMark($id)
	{
		$this->query("UPDATE words SET mark='' WHERE id=$id");
	}

	public function getMarkedWords()
	{
		return $this->query("SELECT * FROM words WHERE mark='on' ORDER BY word")->fetch_all(MYSQLI_ASSOC);
	}

	public function getLatestWords($num=10)
	{
		return $this->query("SELECT * FROM words ORDER BY id DESC LIMIT $num")->fetch_all(MYSQLI_ASSOC);
	}

}