<?php

class Dict
{
	private $dict;

	public function __construct()
	{
		include_once(ROOT.'/models/DictModel.php');
		$this->dict = new DictModel();
	}

	public function index($dict_id = NULL, $char = NULL)
	{
		$dicts = $this->dict->getDicts();
		$marked = count($this->dict->getMarkedWords());
		if($char !== NULL)
		{
			$alphabet = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
			foreach ($alphabet as $value)
			{
				if($char === $value)
				{
					$words = $this->dict->getWordsAlphabet($char, $dict_id);
					break;
				} 
			}
		}
		else
		{
			if($dict_id !== NULL)
			{
				foreach ($dicts as $key => $value)
				{
					if($dicts[$key]['id'] === $dict_id)
					{
						$words = $this->dict->getWords($dict_id);
						break;
					}
				}
			}
			else
			{
			$words = $this->dict->getAllWords();
			}
		}
		include_once(ROOT.'/views/DictView.php');
		$view = new DictView();
		$view->index($dicts, $marked, $words, $dict_id, $char);
	}

	public function add()
	{
		if ($_SERVER['REQUEST_METHOD'] == POST)
		{
			if(isset($_POST['new-dict-name']))
			{
			$this->dict->addDict($_POST['new-dict-name']);
			}
		}
		$marked = count($this->dict->getMarkedWords());
		include_once(ROOT.'/views/DictAddView.php');
		$dicts = $this->dict->getDicts();
		$view = new DictAddView();
		$view->index($dicts, $marked);
	}

	public function editdict($dict_id)
	{
		if ($_SERVER['REQUEST_METHOD'] == POST)
		{
			if(isset($_POST['edit-dict-name']))
			{
				$this->dict->editDict($_POST['edit-dict-name'], $_POST['edit-dict-id'], $_POST['edit-dict-info']);
			}
			if(isset($_POST['del_or_replace']))
			{
				$this->dict->delDict($dict_id, $_POST['del_or_replace'], $_POST['word_to']);
				header('Location: /dict');
			}
		}
		$marked = count($this->dict->getMarkedWords());
		include_once(ROOT.'/views/DictEditDictView.php');
		$dicts = $this->dict->getDicts();
		$view = new DictEditDictView();
		$view->index($dicts, $marked, $dict_id);
	}

	public function addword()
	{
		if ($_SERVER['REQUEST_METHOD'] == POST)
		{
			if(isset($_POST['new-word-name']))
			{
			$this->dict->addWord($_POST['new-word-name'], $_POST['new-word-translate'], $_POST['new-word-dict']);
			}
		}
		$marked = count($this->dict->getMarkedWords());
		include_once(ROOT.'/views/DictAddWordView.php');
		$dicts = $this->dict->getDicts();
		$view = new DictAddWordView();
		$view->index($dicts, $marked);
	}

	public function editword($id)
	{
		if ($_SERVER['REQUEST_METHOD'] == POST)
		{
			if(isset($_POST['edit-word-id']))
			{
				if(isset($_POST['save']))
				{
					$this->dict->editWord($_POST['edit-word-id'], $_POST['edit-word-name'], $_POST['edit-word-translate'], $_POST['edit-word-dict']);
					header('Location: /dict');
				}
				elseif (isset($_POST['delete']))
				{
					$this->dict->delWord($_POST['edit-word-id']);
					header('Location: /dict');
				}
			}
		}
		$word = $this->dict->getWord($id);
		$marked = count($this->dict->getMarkedWords());
		include_once(ROOT.'/views/DictEditWordView.php');
		$dicts = $this->dict->getDicts();
		$view = new DictEditWordView();
		$view->index($dicts, $marked, $word);
	}

	public function search()
	{
		$search = $_POST['search'];
		$words = $this->dict->getSearchWords($search);
		if (is_array($words))
		{
			foreach ($words as $key => $value)
			{
				$words[$key]['word'] = ucfirst($words[$key]['word']);
				if(stripos($words[$key]['word'], $search) !== FALSE)
				{
					//$search = substr($words[$key]['word'], stripos($words[$key]['word'], $search), strlen($search));
					$words[$key]['word'] = str_ireplace($search, '<u>'.$search.'</u>', $words[$key]['word']);
					if(substr($words[$key]['word'], 0, 3) == '<u>')
					{
						$words[$key]['word']{3} = strtoupper($words[$key]['word']{3});
					}
				}
					$mark = ($words[$key]['mark'] == 'on')?'<input type="button" value="Unmark" onclick="Unmark('.$words[$key]['id'].');">':'<input type="button" value="Mark" onclick="Mark('.$words[$key]['id'].');">';
					echo '<p class="word"><span class="word"><a href="/dict/editword/'.$words[$key]['id'].'">'.$words[$key]['word'].'</a>&nbsp-&nbsp</span> '.
					$words[$key]['translate'].$mark.'</p>';
			}
		}
	}

	public function marked()
	{
		$dicts = $this->dict->getDicts();
		$words = $this->dict->getMarkedWords();
		include_once(ROOT.'/views/DictView.php');
		$view = new DictView();
		$view->index($dicts, count($words), $words, $dict_id, $char);
	}

	public function mark()
	{
		if(isset($_POST['id']))
		{
			$this->dict->addMark($_POST['id']);
		}
	}

	public function unmark()
	{
		if(isset($_POST['id']))
		{
			$this->dict->delMark($_POST['id']);
		}
	}

}
