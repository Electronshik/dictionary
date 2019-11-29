<?php
class DictView
{
	public function index($dicts, $marked, $words, $dict_id, $char)
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
		<nav class="search">
			<ul>
				<li><input type="text" id="search"></li>
				<li><input type="button" id="clear" value="Очистить"></li>
			</ul>
		</nav>
		<nav>
			<ul class="dict-list">
			<?php
			if (is_array($dicts))
			{
				foreach ($dicts as $key => $value)
				{
					$amount += $dicts[$key]['num'];
					if($dict_id == $dicts[$key]['id'])
					{
						$dicts[$key]['id'] .= '" class="current';
					}
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

		<nav class="chars">
			<ul>
			<?php
			$alphabet = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
			$href = ($dict_id === NULL)?'dict':'dict/'.$dict_id;
			foreach($alphabet as $value)
			{
				if($char === $value)
				{
					echo '<li><a class="current" href="/'.$href.'">'.$value.'</a></li>';
				}
				else
				{
					echo '<li><a href="/'.$href.'/'.$value.'">'.$value.'</a></li>';
				}
			}
			?>
			</ul>
		</nav>

		</aside>

		<div class="main">
			<?php
			if (is_array($words))
			{
				foreach ($words as $key => $value)
				{
					$mark = ($words[$key]['mark'] == 'on')?'<input type="button" value="Unmark" onclick="Unmark('.$words[$key]['id'].');">':'<input type="button" value="Mark" onclick="Mark('.$words[$key]['id'].');">';
					echo '<p class="word"><span class="word"><a href="/dict/editword/'.$words[$key]['id'].'">'.ucfirst($words[$key]['word']).'</a>&nbsp-&nbsp</span> '.
					$words[$key]['translate'].'<a href="http://wooordhunt.ru/word/'.$words[$key]['word'].'" style="float: right"><input type="button" value="O"></a><input type="button" value="UK" onclick="PlayUK(\''.$words[$key]['word'].'\');"><input type="button" value="US" onclick="PlayUS(\''.$words[$key]['word'].'\');">'.$mark.'</p>';
				}
			}
			?>
		</div>

	</div>

	<script>
		$('#search').on('input', function() {
			$.ajax({
				url: "/dict/search",
				type: "POST",
				data: 'search='+$(this).val(),
				success: function (result){
					$('div.main').html(result);
				}
			});
		} );

		$('#clear').click(function(){
			$('#search').val('');
			$.ajax({
				url: "/dict/search",
				type: "POST",
				//data: 'search='+$(this).val(),
				success: function (result){
					$('div.main').html(result);
				}
			});
		});

		function Mark(id)
		{
			$.ajax({
				url: "/dict/mark",
				type: "POST",
				data: 'id='+id,
				success: function() {
					document.location.reload(true);
				}
			});
		}

		function Unmark(id)
		{
			$.ajax({
				url: "/dict/unmark",
				type: "POST",
				data: 'id='+id,
				success: function() {
					document.location.reload(true);
				}
			});
		}

		var audio = new Audio();

		function PlayUS(word)
		{
			audio.setAttribute('src', 'http://wooordhunt.ru//data/sound/word/us/mp3/'+word+'.mp3');
			audio.play();
		}

		function PlayUK(word)
		{
			audio.setAttribute('src', 'http://wooordhunt.ru//data/sound/word/uk/mp3/'+word+'.mp3');
			audio.play();
		}

	</script>

</body>
</html>
<?php
	}
}