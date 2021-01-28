<?php
class Verb
{
	private $sql;

	public function __construct()
	{
		require_once(ROOT.'/models/VerbModel.php');
		$this->sql = new VerbModel();
	}

	public function index()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST['new-verb-name']) and !empty($_POST['new-verb-name']))
			{
				$this->sql->addVerb($_POST['new-verb-name'], $_POST['new-verb-v2'], $_POST['new-verb-v3'], $_POST['new-verb-translate'], $_POST['new-verb-tr1'], $_POST['new-verb-tr2'], $_POST['new-verb-tr3']);
				header('Location: /verb');
			}
		}
		$dicts = $this->sql->getDicts();
		$verbs = $this->sql->getVerbs();
		require_once(ROOT.'/views/VerbView.php');
		$view = new VerbView();
		$view->index($dicts, $verbs);
	}

	public function edit($id)
	{
		if($id !== NULL)
		{
		$verb = $this->sql->getVerb($id);
		}
		elseif($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST['verb-name']) and !empty($_POST['verb-name']))
			{
				$this->sql->editVerb($_POST['verb-id'], $_POST['verb-name'], $_POST['verb-v2'], $_POST['verb-v3'], $_POST['verb-translate'], $_POST['verb-tr1'], $_POST['verb-tr2'], $_POST['verb-tr3']);
				header('Location: /verb');
			}
		}
		require_once(ROOT.'/views/VerbEditView.php');
		$view = new VerbEditView();
		$view->index($dicts, $verb);	
	}

}