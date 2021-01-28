<?php
class VerbModel extends mysqli
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

	public function getVerb($id)
	{
		return $this->query("SELECT * FROM verbs WHERE id=$id")->fetch_assoc();
	}

	public function getVerbs()
	{
		return $this->query("SELECT * FROM verbs ORDER BY verb")->fetch_all(MYSQLI_ASSOC);
	}

	public function addVerb($verb, $v2, $v3, $translate, $tr1='', $tr2='', $tr3='')
	{
		$verb = $this->real_escape_string(trim($verb));
		$v2 = $this->real_escape_string(trim($v2));
		$v3 = $this->real_escape_string(trim($v3));
		$translate = $this->real_escape_string(trim($translate));
		$tr1 = $this->real_escape_string(trim($tr1));
		$tr2 = $this->real_escape_string(trim($tr2));
		$tr3 = $this->real_escape_string(trim($tr3));
		$this->query("INSERT INTO verbs VALUES ('', '$verb', '$v2', '$v3', '$translate', '$tr1', '$tr2', '$tr3')");
	}

	public function editVerb($id, $verb, $v2, $v3, $translate, $tr1='', $tr2='', $tr3='')
	{
		$verb = $this->real_escape_string(trim($verb));
		$v2 = $this->real_escape_string(trim($v2));
		$v3 = $this->real_escape_string(trim($v3));
		$translate = $this->real_escape_string(trim($translate));
		$tr1 = $this->real_escape_string(trim($tr1));
		$tr2 = $this->real_escape_string(trim($tr2));
		$tr3 = $this->real_escape_string(trim($tr3));
		$this->query("UPDATE verbs SET verb='$verb', v2='$v2', v3='$v3', translate='$translate', tr1='$tr1', tr2='$tr2', tr3='$tr3' WHERE id=$id");
	}

	public function getDicts()
	{
		return $this->query("SELECT * FROM dicts")->fetch_all(MYSQLI_ASSOC);
	}
}