<?php
class DictAddWordView
{
	public function index($dicts, $marked)
	{

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="/views/css/style.css">
	<link rel="stylesheet" href="/views/css/menu.css">
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
		<form action="/dict/addword" class="new-word" method="post">
			<input type="text" name="new-word-name" required>Слово<br>
			<input type="text" name="new-word-translate" id="translate">Перевод<br>
			<select name="new-word-dict">
				<?php
				if (is_array($dicts))
				{
					foreach ($dicts as $key => $value)
					{
						echo '<option value="'.$dicts[$key]['id'].'">'.$dicts[$key]['name'].'</option>';
					}
				}
				?>
			</select>Словарь<br>
			<input type="submit" value="Add Word"><br>
		</form>

		</div>
	</div>

</body>
</html>

<?php
	}

}