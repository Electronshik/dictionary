<?php
class AnalysDictView
{
	public function index($words)
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
			<form action="/analys/dict" method="post">
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

	</div>

</body>
</html>
<?php
	}
}