<?php
	require "db.php";

	$data = $_POST;
	if ( isset($data['do_login']) )
	{
		$errors = array();
		$user = R::findOne('users', 'login = ?', array($data['login']) );
		if ( $user )
		{
			if ( password_verify($data['password'], $user->password) )
			{
				$_SESSION['logged_user'] = $user;
				header('Location: index.php');
			} else
			{
				$errors[] = 'Неверно введен пароль!';
			}
		} else
		{
			$errors[] = 'Пользователь с таким логином не найден!';
		}

		if( ! empty($errors) )
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

<form action="login.php" method="POST">
	<title>Подобие чата</title>
	<link href="style/feed.css" rel="stylesheet">
	<center>
		<br><br><br>
		<p>
			<p>
				<strong>Введите логин</strong>:
			</p>
			<input class="login" type="text" name="login" value="<?php echo @$data['login']; ?>"placeholder="login"/><br><br>
		</p>
		<p>
			<p>
				<strong>Введите пароль</strong>:
			</p>
			<input class="login" type="password" name="password" value="<?php echo @$data['password']; ?>" placeholder="password"/><br><br>
		</p>
		<p>
			<button class="authorization_button" type="submit" name="do_login">Войти</button><br><br>
		</p>
	</center>
</form>