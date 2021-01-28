<?php
class RandView
{
	public function index($dicts, $marked, $rand_word, $round=0, $count=0, $reverse=FALSE, $pron=FALSE, $pron_us=FALSE, $pron_uk=FALSE)
	{

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="/views/css/style.css">
	<link rel="stylesheet" href="/views/css/menu.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.min.js"></script>
</head>
<body>

	<?php
	include_once('header.php');
	?>

	<div class="content">
		<aside>
		<nav>
			<ul class="dict-list">
			<?php
			if (is_array($dicts))
			{
				foreach ($dicts as $key => $value)
				{
					$amount += $dicts[$key]['num'];
					echo '<li><a href="/dict/'.$dicts[$key]['id'].'">'.$dicts[$key]['name'].' ('.$dicts[$key]['num'].')</a></li>';
				}
			}
			?>
			</ul>
			<ul>
				<li><a href="/dict/marked">Отмеченные (<?=$marked?>)</a></li>
				<li>
					<a>Всего: <?=$amount?></a>
				</li>
			</ul>
		</nav>
		</aside>

		<div class="main">
			<?php
				echo '<p class="word"><span class="word">'.($reverse ? $rand_word['translate'] : ucfirst($rand_word['word'])).
					' - </span> <span class="hidden">'.($reverse ? ucfirst($rand_word['word']) : $rand_word['translate']).'</span></p>';
			?>
			<form action="<?=$reverse?'/rand/reverse':'/rand'?>" method="post">
			<input type="button" value="Показать" onclick="Show()"><br>
			<input type="hidden" name="id" value="<?=$rand_word['id']?>">
			<input type="button" value="Дальше" onclick="Next()">&nbsp&nbsp<input type="checkbox" name="mark">Отметить&nbsp&nbsp&nbsp&nbsp
			<input type="checkbox" name="pron" <?=$pron ? 'checked' : '' ?>>Произношение<br>
			</form>
			<p>Кругов: <?=$round?> <br> Слов:<?=$count?></p>
			<input type="button" value="Сбросить" onclick="Clear()"><br>
		 	<?php
				if($pron)
				{
					$this->pron($rand_word['word'], $pron_us, $pron_uk);
				}
			?>
		</div>

	</div>

	<script>
		function Show() {
			$('span.hidden').show();
		}
		function Clear() {
			$('form').append('<input type="hidden" name="clear" value="on">').submit();
		}
		function Next() {
			$('span.hidden').show();
			setTimeout(function() { $('form').submit(); }, 5<?=!$pron ? '00' : ''?>);
		}
	</script>

</body>
</html>
<?php
	}

	protected function pron($rand_word, $pron_us=FALSE, $pron_uk=FALSE)
	{
		if (strpos($rand_word, ' ') === FALSE)
		{
			$word = $rand_word;
			$ref = 'http://dictionary.cambridge.org/ru/словарь/английский/'.$rand_word;
		}
		else
		{
			$ref = explode(' ', $rand_word);
			$i = rand(0, count($ref)-1);
			$word = $ref[$i];
			$ref = 'http://dictionary.cambridge.org/ru/словарь/английский/'.$ref[$i];
		}
		if($this->url_exists($ref))
		{
			$x = file_get_contents($ref);
		}
			require(ROOT.'/phpQuery-onefile.php');
			$page = phpQuery::newDocument($x);
			//preg_match_all('~data-src-mp3=\"(?P<mp>[^"]+)\"~', $x, $src, PREG_PATTERN_ORDER);
			//preg_match('~listen to British English pronunciation" data-src-mp3=\"([^"]+)~', $x, $preg);
			//preg_match('~<span class="ipa">(.+?)</span>~', $x, $trans);
			//$x = substr($x, strpos($x, $trans[1]));
			//$file = $page->find('span.pron-info[pron-region="US"]:eq(0)>span.us>span:eq(1)')->attr('data-src-mp3');
			//$trans = $page->find('span.pron-info[pron-region="US"]:eq(0)>span.uk>span.pron>span.ipa')->text();
			$file = $page->find('span.us>span.daud>amp-audio>source')->attr('src');
			$file = "https://dictionary.cambridge.org".$file;
			//echo $file;
			$trans = $page->find('span.us>span.pron:eq(0)>span.ipa')->text();
			echo '<p*                                               *p>';
			echo '<audio controls>';
				echo '<source src="'.$file.'" type="audio/mpeg">';
				echo 'Your browser does not support the audio element.data-src-mp3';
			echo '</audio> <b>US </b> '.$trans;
			echo '&nbsp&nbsp<input type="checkbox" id="pron_us"> autoplay';
			echo '<p>***********************************************</p>';
			//preg_match('~listen to American pronunciation" data-src-mp3=\"([^"]+)~', $x, $preg);
			//preg_match('~<span class="ipa">(.+?)</span>~', $x, $trans);
			$file = $page->find('span.uk>span.daud>amp-audio>source')->attr('src');
			$file = "https://dictionary.cambridge.org".$file;
			//$trans = $page->find('span.pron-info[pron-region="UK"]:eq(0)>span.uk:eq(1)>span.pron>span.ipa')->text();
			$trans = $page->find('span.uk>span.pron:eq(0)>span.ipa')->text();
			echo '<audio controls>';
				echo '<source src="'.$file.'" type="audio/mpeg">';
				echo 'Your browser does not support the audio element.data-src-mp3';
			echo '</audio> <b>UK </b> '.$trans;
			echo '&nbsp&nbsp<input type="checkbox" id="pron_uk"> autoplay';
			echo '<p>***********************************************</p>';
			echo $ref;
			$strlen = strlen($word);
			?>
			<script>
				$('#pron_us').change(function(){
					if ($('#pron_us').is(':checked'))
					{
						$('form').append('<input type="hidden" name="pron_us" value="on" id="pron_us_auto">');
						$('audio').get(0).play();
					}
					else
					{
						$('#pron_us_auto').remove();
					}
				});
				$('#pron_uk').change(function(){
					if ($('#pron_uk').is(':checked'))
					{
						$('form').append('<input type="hidden" name="pron_uk" value="on" id="pron_uk_auto">');
						if ($('audio').get(0).paused == true)
						{
							$('audio').get(1).play();
						}
						else
						{
							setTimeout(function() {
								$('audio').get(1).play();
							}, <?=($strlen > 4) ? ($strlen > 8) ? $strlen*150 : $strlen*200 : $strlen*250 ?>)
						}

					}
					else
					{
						$('#pron_uk_auto').remove();
					}
				});
			</script>
			<?php
			if ($pron_us)
			{
				echo "<script>$('#pron_us').attr('checked', 'checked').click().click()</script>";
			}
			if ($pron_uk)
			{
				echo "<script>$('#pron_uk').attr('checked', 'checked').click().click()</script>";
			}
	}

	private function url_exists($url)
	{
	// Version 4.x supported
	$handle   = curl_init($url);
	if (false === $handle)
	{
	    return false;
	}
	curl_setopt($handle, CURLOPT_HEADER, false);
	curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
	curl_setopt($handle, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") ); // request as if Firefox    
	curl_setopt($handle, CURLOPT_NOBODY, true);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
	$connectable = curl_exec($handle);
	curl_close($handle);   
	return $connectable;
	}
}