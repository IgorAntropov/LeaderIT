<?php 
	//подключение к библиотеке RedBeanPHP
	require "libs/rb.php";
	
	//подключение к БД
	R::setup( 'mysql:host=127.0.0.1:3307;dbname=chat_test',
        'root', '' );

	session_start();
?>