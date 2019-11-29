<?php
class DictEditWordView
{
	public function index($dicts, $marked, $word)
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
		<form action="/dict/editword/<?=$word['id']?>" class="new-word" method="post">
			<input type="text" name="edit-word-name" value="<?=$word['word']?>" required>Слово<br>
			<input type="text" name="edit-word-translate" value="<?=$word['translate']?>" required id="translate">Перевод<br>
			<input type="hidden" name="edit-word-id" value="<?=$word['id']?>">
			<select name="edit-word-dict">
				<?php
				if (is_array($dicts))
				{
					foreach ($dicts as $key => $value)
					{
						if ($dicts[$key]['id'] === $word['dict']) $selected = 'selected';
						echo '<option value="'.$dicts[$key]['id'].'" '.$selected.'>'.$dicts[$key]['name'].'</option>';
						unset($selected);
					}
				}
				?>
			</select>Словарь<br>
			<input type="submit" value="Сохранить" name="save"><input type="submit" value="Удалить" name="delete"><br>
		</form>

		</div>
	</div>

</body>
</html>

<?php
	}

}