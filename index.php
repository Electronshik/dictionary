<?php
header('Content-type: text/html; charset=utf-8');

define("ROOT", __DIR__);

$uri_list = require_once('uri.php');
$request = trim($_SERVER['REQUEST_URI'], ' /');
$alphabet = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];

foreach( $uri_list as $key => $value )
{
	if (strpos($request, $key) === 0)
	{
		$request = explode('/', $request);
		if ($request[0] === $key)
		{
			$controller_name = ucfirst($key);
			if ($request[1] !== NULL)
			{	
				if(is_numeric($request[1]) and $request[1] < 100 )
				{
					$method_name = 'index';
					$param = $request[1];
					if(strlen($request[2]) === 1)
					{
						foreach($alphabet as $value)
						{
							if($request[2] === $value)
							{
								$method_name = 'index';
								$param_2 = $request[2];
							}
						}
					}
				}
				elseif(strlen($request[1]) === 1)
				{
					foreach($alphabet as $value)
					{
						if($request[1] === $value)
						{
							$method_name = 'index';
							$param_2 = $request[1];
						}
					}
				}
				else
				{
					foreach ($uri_list[$key] as $num => $method)
					{
						if ($method === $request[1])
						{
							$method_name = $request[1];
							if(is_numeric($request[2]) and $request[2] < 10000 )
							{
								$param = $request[2];
							}
							elseif(strlen($request[2]) === 1)
							{
								foreach($alphabet as $value)
								{
									if($request[2] === $value)
									{
										$param = $request[2];
									}
								}	
							}
						}
					}
				}
			}
			else
			{
				$method_name = 'index';
			}
			if(isset($method_name))
			{
			include_once('controllers/'.$controller_name.'Controller.php');
			$controller = new $controller_name;
			$controller->$method_name($param, $param_2);
			exit();
			}
			exit();
		}
	}
}

?>