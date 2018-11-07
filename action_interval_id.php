<?php
	require "db.php";
	$tableName = $_POST['table'];
	$messagesLastID = $_POST['messagesLastID'];
	$result = R::findAll($tableName, ' WHERE id > :mesID', [':mesID' => $messagesLastID]);
				$messagesview = $result;
				foreach ( $messagesview as $messages )
				{
					$messagesLastID = $messages->id;
				}
				echo $messagesLastID;
				?>
