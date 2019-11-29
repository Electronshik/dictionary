<?php
class AnalysView
{
	public function index($text = [], $former_text = [])
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

		<div class="main">
			<form action="/analys" class="analys" method="post">
				<textarea name="text" rows=7 cols=70><?=$former_text?></textarea><br>
				<input type="submit" value="Анализ"><br>
				<input type="text" name="word" id="word"><br>
				<input type="submit" value="Добавить"><br>
			</form>
		</div>

		<div class="main" id="main">
		<?php
			if(is_array($text))
			{
				foreach($text as $key => $value)
				{
					echo '<p><input type="button" onclick="addWord(\''.$key.'\');" value="Запомнить"> &nbsp&nbsp&nbsp'.$key.' ('.$value.')</p>';
				}
			}
		?>
		</div>

	</div>

	<script>
		function addWord(word)
		{
			$('#word').attr('value', word);
			$('form').submit();
		}
		function translateX ()
		{
			var words = $('#main>p');
			maxi = words.length;
			function rec(i)
			{
				var word = words.eq(i).text();
				word = word.substring(4, word.indexOf('(')-1);
				console.log(word);
				$.ajax(
				{
					url: "https://translate.yandex.net/api/v1.5/tr.json/translate",
					type: "POST",
					data: 'key=trnsl.1.1.20160816T171841Z.2fd83f4b84b0b56e.0501301ff48216b27c7af99ac6474e66880060de&text='+word+'&lang=en-ru',
					success: function (result)
					{
						words.eq(i).append(' - '+result.text);
					},
					complete: function()
					{
						if (i<maxi)
						{
							rec(++i);
						}
					}
				});
			}
			rec(0);
		}
		$(document).ready(translateX);
	</script>

</body>
</html>
<?php
	}

}