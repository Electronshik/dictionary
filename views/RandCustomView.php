<?php
include_once(ROOT.'/views/RandView.php');
class RandCustomView extends RandView
{
	public function index($dicts, $marked, $rand_word, $flag=FALSE, $round=0, $count=0, $pron=FALSE, $pron_us=FALSE, $pron_uk=FALSE)
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
					if(isset($_SESSION['custom']) and key_exists($dicts[$key]['id'], $_SESSION['custom']))
					{
						$dicts[$key]['id'] .= '" style="text-decoration: underline;';
					}
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
			if($flag)
			{

				echo '<p class="word"><span class="word">'.ucfirst($rand_word['word']).' - </span> <span class="hidden">'.$rand_word['translate'].'</span></p>';
			?>
			<form action="/rand/custom" method="post">
			<input type="button" value="Показать" onclick="Show()"><br>
			<input type="hidden" name="id" value="<?=$rand_word['id']?>">
			<input type="button" value="Дальше" onclick="Next()"><input type="checkbox" name="mark">Отметить
			<input type="checkbox" name="pron" <?=$pron ? 'checked' : '' ?>>Произношение<br>
			</form>
			<p>Кругов: <?=$round?> <br> Слов:<?=$count?></p>
			<input type="button" value="Сбросить" onclick="Clear()"><br>

			<?php
				if($pron)
				{
					$this->pron($rand_word['word'], $pron_us, $pron_uk);
				}
			}
			else
			{
			?>

			<form action="/rand/custom" method="post">
				<?php
				if (is_array($dicts))
				{
					foreach ($dicts as $key => $value)
					{
						echo '<input type="checkbox" name="dict_'.$dicts[$key]['id'].'">'.$dicts[$key]['name'].' ('.$dicts[$key]['num'].')<br>';
					}
				}
				?>
				<input type="submit" name="custom"><br>
			</form>

			<?php
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

}