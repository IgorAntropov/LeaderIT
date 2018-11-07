<?php
	require "db.php";

	$data = $_POST;
	$user = R::findOne('users', 'login = ?', array($data['login']) );
	if( isset($data['do_signup']) )
	{
		$errors = array();
		if( trim($data['login']) == '' )
		{
			$errors[] = 'Введите логин!';
		}

		if( trim($data['email']) == '' )
		{
			$errors[] = 'Введите E-mail!';
		}

		if( trim($data['password']) == '' )
		{
			$errors[] = 'Введите пароль!';
		}

		if( R::count( 'users', "login = ?", array($data['login'])) > 0 )
		{
			$errors[] = 'Пользователь с таким логином уже существует!';
		}

		if( R::count( 'users', "email = ?", array($data['email'])) > 0 )
		{
			$errors[] = 'Пользователь с таким E-mail уже существует!';
		}

		if( empty($errors) )
		{
			$user = R::dispense('users');
			$user->login = $data['login'];
			$user->email = $data['email'];
			$user->password = password_hash($data['password'], PASSWORD_DEFAULT);
			R::store($user);
			header('Location: index.php');
		} else
		{
			?>
			<center>
			<?php
			echo '<div style="color: red;">'.array_shift($errors).'</div><hr>';
			?>
			</center>
			<?php
		}
	}
?>

<form action="signup.php" method="POST">
	<title>Подобие чата</title>
	<link href="style/feed.css" rel="stylesheet">
	<center>
		<br><br><br>
		<p>
			<p>
				<strong>Введите логин:</strong>
			</p>
			<input class="login" type="text" name="login" value="<?php echo @$data['login']; ?>" placeholder="login"/><br><br>
		</p>
		<p>
			<p>
				<strong>Введите E-mail:</strong>:
			</p>
			<input class="login" type="email" name="email" value="<?php echo @$data['email']; ?>" placeholder="email@gmail.com"/><br><br>
		</p>
		<p>
			<p>
				<strong>Введите пароль:</strong>:
			</p>
			<input class="login" type="password" name="password" value="<?php echo @$data['password']; ?>" placeholder="password"/><br><br>
		</p>
		<p>
			<button class="registrate_button" type="submit" name="do_signup">Зарегистрироваться</button><br><br>
		</p>
	</center>
</form>