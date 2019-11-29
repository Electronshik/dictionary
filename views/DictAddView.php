<?php
class DictAddView
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
		<form action="/dict/add" class="new-dict" method="post">
			<input type="text" name="new-dict-name" required>Name<br>
			<textarea name="new-dict-info" rows=2 cols=55 placeholder="info"></textarea><br>
			<input type="submit" value="Add dictionary"><br>
		</form>
		</div>
	</div>

</body>
</html>

<?php
	}

}