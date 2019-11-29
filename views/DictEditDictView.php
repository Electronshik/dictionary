<?php
class DictEditDictView
{
	public function index($dicts, $marked, $dict_id)
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
					if($dicts[$key]['id'] == $dict_id)
					{
						$dict_id = $dicts[$key];
					}
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
		<form action="/dict/editdict/<?=$dict_id['id']?>" class="new-dict" method="post">
			<input type="text" name="edit-dict-name" value="<?=$dict_id['name']?>" required>Name<br>
			<textarea name="edit-dict-info" rows=2 cols=55 placeholder="info"><?=$dict_id['info']?></textarea><br>
			<input type="hidden" name="edit-dict-id" value="<?=$dict_id['id']?>">
			<input type="submit" value="Сохранить"><br>
			<input type="radio" name="del_or_replace" value="1">Переместить в словарь
			<select id=dict-list name="word_to">
				<?php
				if (is_array($dicts))
				{
					foreach ($dicts as $key => $value)
					{
						echo '<option value="'.$dicts[$key]['id'].'">'.$dicts[$key]['name'].'</option>';
					}
				}
				?>
			</select><br>
			<input type="radio" name="del_or_replace" value="0">Удалить слова<br>
			<input type="button" value="Удалить" onclick="delDict();"><br>
		</form>
		</div>
	</div>

<script>
	$('input:radio').change(function() {
	if ($('input:radio').eq(0).is(":checked"))
	{
		$('#dict-list').show();
	}
	if ($('input:radio').eq(1).is(":checked"))
	{
		$('#dict-list').hide();
	}
	});

	function delDict() {
	if ($('input:radio').is(":checked"))
	{
		$('form').submit();
	}
	}

</script>

</body>
</html>

<?php
	}

}