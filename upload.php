<?php
require "db.php";

$send = $_POST['send'];
$upload = $_POST['uploads'];
if ( isset($upload && $send) )
{
	if ($_FILES['userfile']['type'] != 'image/jpeg' || 'image/png' || 'image/bmp' || 'image/gif')
	{
		echo 'Данный файл не является изображением!';
		exit();
	} else {
		$upfile = 'upload/' . $_FILES['userfile']['name'];
		$file_content = file_get_contents($upfile);
		echo ($file_content);
		header('Location: index.php');
	}
}

?>