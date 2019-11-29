<?php
class VerbView
{
	// private $sql;
	public function index($dicts, $verbs)
	{
// $this->sql = new VerbModel();
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
	<?php
		// $ref = 'http://iloveenglish.ru/theory/anglijskaya_grammatika/pravilnie_i_nepravilnie_glagoli_anglijskogo_yazika';
		// $x = file_get_contents($ref);
		// require(ROOT.'/phpQuery-onefile.php');
		// $page = phpQuery::newDocument($x);
		// for ($i = 0; $i <195; $i++)
		// {
		// 	$verb = explode('[', $page->find('table.verbs tbody tr:eq('.$i.')>td:eq(1)')->text());
		// 	$tr1 = explode(']', $verb[1])[0];
		// 	$verb = trim($verb[0]);
		// 	echo $verb.'+'.$tr1.'//';

		// 	$v2 = $page->find('table.verbs tbody tr:eq('.$i.')>td:eq(2)')->text();
		// 	if (strpos($v2, ';') === FALSE)
		// 	{
		// 		$v2 = explode('[', $v2);
		// 		$tr2 = explode(']', $v2[1])[0];
		// 		$v2 = trim($v2[0]);
		// 	}
		// 	else
		// 	{
		// 		$v2 = explode(';', $v2);
		// 		$tr2 = explode(']',explode('[',$v2[0])[1])[0].','.explode(']',explode('[',$v2[1])[1])[0];
		// 		$v2 = trim(explode('[', $v2[0])[0]).','.trim(explode('[', $v2[1])[0]);
		// 	}
		// 	echo $v2.'+'.$tr2.'//';

		// 	$v3 = explode('[', $page->find('table.verbs tbody tr:eq('.$i.')>td:eq(3)')->text());
		// 	$tr3 = explode(']', $v3[1])[0];
		// 	$v3 = trim($v3[0]);
		// 	echo $v3.'+'.$tr3.'//';

		// 	$translate = trim($page->find('table.verbs tbody tr:eq('.$i.')>td:eq(4)')->text());
		// 	echo '+'.$translate.'<br>';
		// 	$this->sql->addVerb($verb, $v2, $v3, $translate, $tr1, $tr2, $tr3);
		// }

	?>
		<table>
			<?php
			if (is_array($verbs))
			{
				//echo '<table class="verbs">';
				echo '<th>Infinitive</th><th>Past Simple</th><th>Past Participle</th><th>Перевод</th>';
				foreach ($verbs as $key => $value)
				{
					echo '<tr><td>'.$verbs[$key]['verb'].'&nbsp<span style="color: #b0b0b0">['.$verbs[$key]['tr1'].']</span>'.'</td><td>'.$verbs[$key]['v2'].'&nbsp<span style="color: #b0b0b0">['.$verbs[$key]['tr2'].']</span>'.'</td><td>'.$verbs[$key]['v3'].'&nbsp<span style="color: #b0b0b0">['.$verbs[$key]['tr3'].']</span>'.'</td><td>'.$verbs[$key]['translate'].'</td><td><a href="/verb/edit/'.$verbs[$key]['id'].'">E</a></td></tr>';
				}
			}
			?>
		</table>
			<br>
		<table class="clear-border">
			<tr>
				<th>
					<form action="/verb" class="new-verb" method="post">
					<input class="new-verb" type="text" name="new-verb-name" required>
				</th>
				<th><input class="new-verb" type="text" name="new-verb-v2" required></th>
				<th><input class="new-verb" type="text" name="new-verb-v3" required></th>
				<th><input class="new-verb" type="text" name="new-verb-translate" id="translate"></th>
			</tr>
			<tr>
				<td><input type="text" class="new-verb" name="new-verb-tr1"></td>
				<td><input type="text" class="new-verb" name="new-verb-tr2"></td>
				<td><input type="text" class="new-verb" name="new-verb-tr3"></td>
			</tr>
			<tr>
				<td colspan="4">
					<input class="new-verb" type="submit" value="Add Verb">
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