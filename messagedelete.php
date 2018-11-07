<?php 
	require "db.php";

	if( isset($_GET['id']) )
	{
		$id = $_GET['id'];
		$messagedelete = R::exec("DELETE FROM `messages` WHERE `id` = $id");

		if ( $messagedelete )
		{
			header('Location: index.php');
		}else
		{
			header('Location: index.php');
		}
	}else
	{
		header('Location: index.php');
	}
?>