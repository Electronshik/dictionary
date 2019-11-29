<?php
class AnalysTempView
{
	public function index($words = [])
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

		</aside>

		<div class="main">
			<form action="/analys/temp" method="post">
				<input type="text" name="word" required><br>
				<input type="submit" value="Добавить"><br>
			</form>
			<?php
			if (is_array($words))
			{
				foreach ($words as $key => $value)
				{
					echo '<p class="word"><span class="word">'.$words[$key].'</span></p>';
				}
			}
			?>
		</div>

		<form action="/analys/temp" method="post">
			<input type="submit" name="clear" value="Удалить">
		</form>

	</div>

	<script>
		function translateX ()
		{
			var words = $('div.main>p.word');
			maxi = words.length;
			function rec(i)
			{
				var word = words.eq(i).text();
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