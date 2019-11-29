<?php
class Rand
{
	private $dict;
	
	public function __construct()
	{
		include_once(ROOT.'/models/DictModel.php');
		$this->dict = new DictModel();
	}

	public function index($reverse = FALSE)
	{
		$dicts = $this->dict->getDicts();
		if($_POST['mark'])
		{
			$this->dict->addMark($_POST['id']);
		}
		if($_POST['pron'])
		{
			$pron = TRUE;
		}
		if ($_POST['pron_us'])
		{
			$pron_us = TRUE;
		}
		if ($_POST['pron_uk'])
		{
			$pron_uk = TRUE;
		}
		$marked = count($this->dict->getMarkedWords());
		session_start();
		if($_POST['clear']) session_unset();

		if(!$_SESSION[($reverse === TRUE) ? 'allreversewords' : 'allwords'])
		{
			session_unset();
			$_SESSION[($reverse === TRUE) ? 'allreversewords' : 'allwords'] = TRUE;
			$_SESSION['round'] = 0;
			$_SESSION['count'] = 0;
			$_SESSION['words'] = $this->dict->getAllWords();
			shuffle($_SESSION['words']);
			$rand_word = array_pop($_SESSION['words']);
			$pron = TRUE;
			$pron_us = TRUE;
			$pron_uk = TRUE;
		}
		else
		{
			if(!$_SESSION['words'])
			{
				$_SESSION['round']++;
				$_SESSION['words'] = $this->dict->getAllWords();
				shuffle($_SESSION['words']);
			}
			$rand_word = array_pop($_SESSION['words']);
			$_SESSION['count']++;
		}

		include_once(ROOT.'/views/RandView.php');
		$view = new RandView();
		$view->index($dicts, $marked, $rand_word, $_SESSION['round'], $_SESSION['count'], $reverse, $pron, $pron_us, $pron_uk);
	}

	public function dict($dict_id = NULL)
	{
		$dicts = $this->dict->getDicts();
		if($_POST['mark'])
		{
			$this->dict->addMark($_POST['id']);
		}
		if($_POST['pron'])
		{
			$pron = TRUE;
		}
		if ($_POST['pron_us'])
		{
			$pron_us = TRUE;
		}
		if ($_POST['pron_uk'])
		{
			$pron_uk = TRUE;
		}
		$marked = count($this->dict->getMarkedWords());
		session_start();
			if($_POST['clear']) session_unset();
		if($dict_id !== NULL)
		{
			if($_SESSION['dict_id'] !== $dict_id)
			{
				session_unset();
				$_SESSION['dict_id']=$dict_id;
				$_SESSION['round'] = 0;
				$_SESSION['count'] = 0;
				$_SESSION['words'] = $this->dict->getWords($dict_id);
				shuffle($_SESSION['words']);
				$rand_word = array_pop($_SESSION['words']);
				$pron = TRUE;
				$pron_us = TRUE;
				$pron_uk = TRUE;
			}
			else
			{
				if(!$_SESSION['words'])
				{
					$_SESSION['round']++;
					$_SESSION['words'] = $this->dict->getWords($dict_id);
					shuffle($_SESSION['words']);
				}
				$rand_word = array_pop($_SESSION['words']);
				$_SESSION['count']++;
			}
		}
		else
		{
			$words = $this->dict->getAllWords();
		}

		include_once(ROOT.'/views/RandDictView.php');
		$view = new RandDictView();
		$view->index($dicts, $marked, $rand_word, $dict_id, $_SESSION['round'], $_SESSION['count'], $pron, $pron_us, $pron_uk);
	}

	public function custom()
	{
		$dicts = $this->dict->getDicts();
		if($_POST['mark'])
		{
			$this->dict->addMark($_POST['id']);
		}
		if($_POST['pron'])
		{
			$pron = TRUE;
		}
		if ($_POST['pron_us'])
		{
			$pron_us = TRUE;
		}
		if ($_POST['pron_uk'])
		{
			$pron_uk = TRUE;
		}
		$marked = count($this->dict->getMarkedWords());
		session_start();
		if(isset($_POST['custom']))
		{
			$flag = TRUE;
			session_unset();
			$_SESSION['words'] = [];
			$_SESSION['custom'] = [];
			foreach($dicts as $key => $value)
			{
				if($_POST['dict_'.$dicts[$key]['id']] !== NULL)
				{
					$_SESSION['words'] = array_merge($_SESSION['words'], $this->dict->getWords($dicts[$key]['id']));
					$_SESSION['custom'] += [$dicts[$key]['id'] => TRUE];
				}
			}
			$_SESSION['round'] = 0;
			$_SESSION['count'] = 0;
			shuffle($_SESSION['words']);
			$rand_word = array_pop($_SESSION['words']);
			$pron = TRUE;
			$pron_us = TRUE;
			$pron_uk = TRUE;
		}
		elseif ($_POST['clear'])
		{
			session_unset();
		}
		elseif($_SESSION['custom'])
		{
			$flag = TRUE;
			if($_POST['clear']) session_unset();
			if(!$_SESSION['words'])
			{
				$_SESSION['round']++;
				foreach($_SESSION['custom'] as $key => $value)
				{
					$_SESSION['words'] = array_merge($_SESSION['words'], $this->dict->getWords($key));
				}
				shuffle($_SESSION['words']);
			}
			$rand_word = array_pop($_SESSION['words']);
			$_SESSION['count']++;

		}
		else
		{
			$flag = 0;
		}

		include_once(ROOT.'/views/RandCustomView.php');
		$view = new RandCustomView();
		$view->index($dicts, $marked, $rand_word, $flag, $_SESSION['round'], $_SESSION['count'], $pron, $pron_us, $pron_uk);
	}

	public function marked()
	{
		if($_POST['pron'])
		{
			$pron = TRUE;
		}
		if ($_POST['pron_us'])
		{
			$pron_us = TRUE;
		}
		if ($_POST['pron_uk'])
		{
			$pron_uk = TRUE;
		}
		$dicts = $this->dict->getDicts();
		if($_POST['mark'])
		{
			$this->dict->addMark($_POST['id']);
		}
		$marked = count($this->dict->getMarkedWords());
		session_start();
		if($_POST['clear']) session_unset();

		if(!$_SESSION['marked'])
		{
			session_unset();
			$_SESSION['marked'] = TRUE;
			$_SESSION['round'] = 0;
			$_SESSION['count'] = 0;
			$_SESSION['words'] = $this->dict->getMarkedWords();
			shuffle($_SESSION['words']);
			$rand_word = array_pop($_SESSION['words']);
			$pron = TRUE;
			$pron_us = TRUE;
			$pron_uk = TRUE;
		}
		else
		{
			if(!$_SESSION['words'])
			{
				$_SESSION['round']++;
				$_SESSION['words'] = $this->dict->getMarkedWords();
				shuffle($_SESSION['words']);
			}
			$rand_word = array_pop($_SESSION['words']);
			$_SESSION['count']++;
		}

		include_once(ROOT.'/views/RandMarkedView.php');
		$view = new RandMarkedView();
		$view->index($dicts, $marked, $rand_word, $_SESSION['round'], $_SESSION['count'], $pron, $pron_us, $pron_uk);
	}

	public function literal($literal = NULL)
	{
		if($_POST['pron'])
		{
			$pron = TRUE;
		}
		if ($_POST['pron_us'])
		{
			$pron_us = TRUE;
		}
		if ($_POST['pron_uk'])
		{
			$pron_uk = TRUE;
		}
		$dicts = $this->dict->getDicts();
		if($_POST['mark'])
		{
			$this->dict->addMark($_POST['id']);
		}
		$marked = count($this->dict->getMarkedWords());
		session_start();
			if($_POST['clear']) session_unset();
		if($literal !== NULL)
		{
			if($_SESSION['literal'] !== $literal)
			{
				session_unset();
				$_SESSION['literal']=$literal;
				$_SESSION['round'] = 0;
				$_SESSION['count'] = 0;
				$_SESSION['words'] = $this->dict->getWordsAlphabet($literal);
				shuffle($_SESSION['words']);
				$rand_word = array_pop($_SESSION['words']);
				$pron = TRUE;
				$pron_us = TRUE;
				$pron_uk = TRUE;
			}
			else
			{
				if(!$_SESSION['words'])
				{
					$_SESSION['round']++;
					$_SESSION['words'] = $this->dict->getWordsAlphabet($literal);
					shuffle($_SESSION['words']);
				}
				$rand_word = array_pop($_SESSION['words']);
				$_SESSION['count']++;
			}
		}
		else
		{
			$words = $this->dict->getAllWords();
		}
		include_once(ROOT.'/views/RandLiteralView.php');
		$view = new RandLiteralView();
		$view->index($dicts, $marked, $rand_word, $literal, $_SESSION['round'], $_SESSION['count'], $pron, $pron_us, $pron_uk);
	}

	public function reverse()
	{
		$this->index(TRUE);
	}

	public function latest($num)
	{
		if(!$num) $num=1000;
		$dicts = $this->dict->getDicts();
		if($_POST['mark'])
		{
			$this->dict->addMark($_POST['id']);
		}
		if($_POST['pron'])
		{
			$pron = TRUE;
		}
		if ($_POST['pron_us'])
		{
			$pron_us = TRUE;
		}
		if ($_POST['pron_uk'])
		{
			$pron_uk = TRUE;
		}
		$marked = count($this->dict->getMarkedWords());
		session_start();
		if($_POST['clear']) session_unset();

		if((!$_SESSION[($reverse === TRUE) ? 'latestreversewords' : 'latestwords']) || ($_SESSION['num'] !== $num) )
		{
			session_unset();
			$_SESSION[($reverse === TRUE) ? 'latestreversewords' : 'latestwords'] = TRUE;
			$_SESSION['num'] = $num;
 			$_SESSION['round'] = 0;
			$_SESSION['count'] = 0;
			$_SESSION['words'] = $this->dict->getLatestWords($num);
			shuffle($_SESSION['words']);
			$rand_word = array_pop($_SESSION['words']);
			$pron = TRUE;
			$pron_us = TRUE;
			$pron_uk = TRUE;
		}
		else
		{
			if(!$_SESSION['words'])
			{
				$_SESSION['round']++;
				$_SESSION['words'] = $this->dict->getLatestWords($num);
				shuffle($_SESSION['words']);
			}
			$rand_word = array_pop($_SESSION['words']);
			$_SESSION['count']++;
		}

		include_once(ROOT.'/views/RandLatestView.php');
		$view = new RandLatestView();
		$view->index($dicts, $marked, $rand_word, $num, $_SESSION['round'], $_SESSION['count'], $reverse, $pron, $pron_us, $pron_uk);
	}
}