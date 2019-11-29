<?php
class VerbEditView
{
	public function index($dicts, $verb)
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

		<table class="clear-border">
			<tr>
				<th>
					<form action="/verb/edit" class="new-verb" method="post">
					<input class="new-verb" type="text" name="verb-name" value="<?=$verb['verb']?>" required>
				</th>
				<th><input class="new-verb" type="text" name="verb-v2" value="<?=$verb['v2']?>" required></th>
				<th><input class="new-verb" type="text" name="verb-v3" value="<?=$verb['v3']?>" required></th>
				<th><input class="new-verb" type="text" name="verb-translate" value="<?=$verb['translate']?>" id="translate"></th>
			</tr>
			<tr>
				<td><input type="text" class="new-verb" name="verb-tr1" value="<?=$verb['tr1']?>"></td>
				<td><input type="text" class="new-verb" name="verb-tr2" value="<?=$verb['tr2']?>"></td>
				<td><input type="text" class="new-verb" name="verb-tr3" value="<?=$verb['tr3']?>"></td>
			</tr>
			<tr>
				<td colspan="4">
					<input type="hidden" name="verb-id" value="<?=$verb['id']?>">
					<input class="new-verb" type="submit" value="Save">
					</form>
				</td>
			</tr>
		</table>
 
	</div>

</body>
</html>
<?php

	}
}