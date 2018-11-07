<?php 
	require "db.php";

	$data = $_POST;
	if ( isset($_POST['send']) )
	{
		$text = trim( htmlspecialchars($_POST['common_text']) );
		$id = $_SESSION['logged_user']->login;
		$time = date("m.d, H:i");

		function smile($var){
			$symbol = array(
				';)',
				':p)',
				'B)',
				':(',
				'>:(',
			);
			$graph = array(
				'<img src="http://www.kolobok.us/smiles/icq/wink.gif">',
				'<img src="http://www.kolobok.us/smiles/icq/blum1.gif">',
				'<img src="http://www.kolobok.us/smiles/icq/cool.gif">',
				'<img src="http://www.kolobok.us/smiles/icq/cray.gif">',
				'<img src="http://www.kolobok.us/smiles/icq/mad.gif">',
			);

			return str_replace($symbol, $graph, $var);
		}
			
	}

		$messageadd = R::dispense('messages');
			$messageadd->userlogin = $id;
			$messageadd->message = $text;
			$messageadd->time = $time;
			R::store($messageadd);

		if ( $messageadd )
		{
			header('Location: index.php');
		}
?>