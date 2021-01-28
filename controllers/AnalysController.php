<?php
class Analys
{
	private $sql;
	public function __construct()
	{
		include_once(ROOT.'/models/AnalysModel.php');
		$this->sql = new AnalysModel();
	}

	public function index()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$former_text = $_POST['text'];
			if(isset($_POST['word']) and !empty($_POST['word']))
			{
				//echo $_POST['word'];
				$this->sql->addWord($_POST['word']);
			}
			//$_POST['text'] = strtolower($_POST['text']);
			$search = [',','.','\'',';',':','/','?','!','\\','"','`','~','*','&','#','@','$','>','<','[',']','{','}','|','_','-','=','+','(',')','^','%','1','2','3','4','5','6','7','8','9','0',' q ',' w ',' e ',' r ',' t ','  y ',' u ',' i ',' o ',' p ',' a ',' s ',' d ',' f ',' g ',' h ',' j ',' k ',' l ',' z ',' x ',' c ',' v ',' b ',' n ',' m ','ё','й','ц','у','к','е','н','г','ш','щ','з','х','ъ','ф','ы','в','а','п','р','о','л','д','ж','э','я','ч','с','м','и','т','ь','б','ю'];
			$text = str_ireplace($search, ' ', $_POST['text']);
			$text = explode(' ',$text);
			foreach($text as &$value)
			{
				//$value = trim($value);
				$value = strtolower(trim($value));
			}
			//$text = array_unique($text);
			//sort($text);
			$dict = $this->sql->getWords();
			$dict = array_merge($dict, $this->sql->getKnownWords());
			$text = array_diff($text, $dict);
			foreach($text as $key => &$word)
			{
				if(($word == '') or ($word == ' '))
				{
					unset($text[$key]);
				}
				else
				{
					foreach($dict as $sample)
					{
						if(strlen($sample) >= 3)
						{

							$endings = ['s','es','ly','er','or','y','d','ed','ing'];
							foreach($endings as $end)
							{
								if($word == $sample.$end)
								{
									unset($text[$key]);
									break;	
								}
							}

							if((strrpos($sample, 'e') === (strlen($sample)-1)) and ($word == substr($sample, 0, strlen($sample)-1).'ing' ))
							{
								unset($text[$key]);
								break;		
							}

							if((strpos($word, $sample) === 0) or (strpos($word, 'to ') === 0))
							{
								unset($text[$key]);
								break;
							}
						}
					}
				}
			}
			$text = array_count_values($text);
			arsort($text);
		}
		include_once(ROOT.'/views/AnalysView.php');
		$view = new AnalysView();
		$view->index($text, $former_text);
	}

	public function dict()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->sql->addWord($_POST['word']);
		}
		$words = $this->sql->getWords();
		include_once(ROOT.'/views/AnalysDictView.php');
		$view = new AnalysDictView;
		$view->index($words);
	}

	public function temp()
	{
		if(($_SERVER['REQUEST_METHOD'] == 'POST') and (!empty($_POST['word'])))
		{
			$this->sql->addTempWord($_POST['word']);
		}
		if(($_SERVER['REQUEST_METHOD'] == 'POST') and (!empty($_POST['clear'])))
		{
			$this->sql->clearTemp();
		}
		$words = $this->sql->getTempWords();
		include_once(ROOT.'/views/AnalysTempView.php');
		$view = new AnalysTempView();
		$view->index($words);
	}

}