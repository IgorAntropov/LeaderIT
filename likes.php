<?php
	require "db.php";

	$data = $_POST;
	if ( isset($_POST['button_like']) )
	{
		$usid = $_SESSION['logged_user']->login;
		$mesid = $messages->id;

		$likeadd = R::dispense('likes');
				$likeadd->usersid = $usid;
				$likeadd->messagesid = $mesid;
				$likeadd->like = $boolean['like'];
				R::store($likeadd);

			if ( $likeadd )
			{
				header('Location: index.php');
			} else {
				header('Location: index.php');
			}
	}

?>