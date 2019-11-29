	<header>
		<nav>
			<ul>
				<li><a href="/dict">Главная</a></li>
				<li><a href="/analys">Анализ</a>
					<ul>
						<li><a href="/analys/dict">Словарь</a></li>
						<li><a href="/analys/temp">Временный</a></li>
					</ul>
				</li>
				<li><a href="">Рандом</a>
					<ul>
						<li><a href="/rand">По всем</a>
							<ul>
								<li><a href="/rand/reverse">Обратный</a></li>
								<li><a href="/rand/latest">Последние</a>
									<ul>
										<li><a href="/rand/latest/50">50</a></li>
										<li><a href="/rand/latest/100">100</a></li>
										<li><a href="/rand/latest/200">200</a></li>
										<li><a href="/rand/latest/300">300</a></li>
										<li><a href="/rand/latest/500">500</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li><a href="/rand/marked">По отмеченным</a></li>
						<li><a href="">По словарю</a>
							<ul>
								<?php
								if (is_array($dicts))
								{
									foreach ($dicts as $key => $value)
									{
										echo '<li><a href="/rand/dict/'.$dicts[$key]['id'].'">'.$dicts[$key]['name'].' ('.$dicts[$key]['num'].')</a></li>';
									}
								}
								?>
							</ul>
						</li>
						<li><a href="/rand/custom">Выбрать</a></li>
						<li><a href="">По буквам</a>
							<ul>
								<?php
								$alphabet = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
								foreach($alphabet as $value)
								{
									echo '<li><a href="/rand/literal/'.$value.'">'.$value.'</a></li>';
								}
								?>
							</ul>
						</li>
					</ul>
				</li>
				<li>
					<a href="/dict">Словари</a>
					<ul>
						<li>
							<a href="">Изменить</a>
							<ul>
								<?php
								if (is_array($dicts))
								{
									foreach ($dicts as $key => $value)
									{
										echo '<li><a href="/dict/editdict/'.$dicts[$key]['id'].'">'.$dicts[$key]['name'].' ('.$dicts[$key]['num'].')</a></li>';
									}
								}
								?>
							</ul>
						</li>
						<li><a href="/dict/add">Добавить</a></li>
						<li><a href="/dict/addword">Слово</a></li>
					</ul>
				</li>
				<li>
					<a href="">Разное</a>
					<ul>
						<li><a href="/verb">Глаголы</a></li>
						<li><a href="">c</a>
							<ul>
								<li><a href="">7</a></li>
								<li><a href="">8</a></li>
							</ul>
						</li>
						<li><a href="">d</a>
							<ul>
								<li><a href="">9</a></li>
								<li><a href="">99</a></li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
	</header>