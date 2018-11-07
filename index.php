<?php
	require "db.php";


	// ini_set('session.gc_probability', 1);
	// ini_set('session.save_path', './sessions');
	// session_id('$_SESSION["logged_user"]->login');

	// ini_set('session.gc_maxlifetime', 60); // время жизни 1 
	// ini_set('session.cookie_lifetime',     60); //время жизни 2 
	// ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'] .'./sessions/'); 

	// $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
?>

<?php 
if( isset($_SESSION['logged_user']) ) : ?>
	<link href="style/feed.css" rel="stylesheet">
	<div class="hr">
		<div class="hr_title">
			<span  calss ="top_head" id="autorize">Вы авторизовались как: </span><?php ?> <b> <?php echo $_SESSION['logged_user']->login; 
			?> </b>
		</div>
		<div class="hr_logout">
			<a href="logout.php">Выйти</a> 
		</div>
	</div>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Подобие чата</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link href="style/style.css" rel="stylesheet">
	<link href="style/feed.css" rel="stylesheet">	
	<!--script type="text/javascript" src="js/jquery.js"></script-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function show(){
			$(".smile").click(function(){
				var smile = $(this).attr('alt');
				var text = $.trim($("#common_text").val());
				$("#common_text").focus().val(text + " " + smile + " ");
			});
		});
	</script>

	<script type="text/javascript">
		function keycheck(e){
    		if (e.ctrlKey = true && e.keyCode == 13) {
       		send();        
    		}
    	};
    	textarea.addEventListener('keyup',keycheck);
    </script>

    <script type="text/javascript">
    	window.onload = function(){
    		document.getElementById('scroll').scrollTop = 9999;
    	}
    </script> 

   <!-- <script type="text/javascript">
    	function get_online(){ 
	    	clearstatcache(); 
	    	$sess_dir = session_save_path(); 
	    	$lifetime = 10; 
	    	if ($path = scandir ($sess_dir)){ 
	        	$count = count ($path); 
	        	$users = 0; 
	        	for ($i = 2; $i < $count; $i++){ 
	            	if (time() - fileatime ($sess_dir . '/' . $path[$i]) < $lifetime){ 
	                	$users++; 
	            	} 
	        	}
	        	return $users; 
	    	} else { 
	        	return 'error'; 
	    	} 
		}
    </script> -->

   <!-- <script type="text/javascript">
    	$text = $messages->message
    	function parse_links($text){
		    $text = str_replace('www.', 'http://www.', $text);
		    $text = preg_replace('|http://([a-zA-Z0-9-./]+)|', '<a href="http://$1">$1</a>', $text);
		    $text = preg_replace('/(([a-z0-9+_-]+)(.[a-z0-9+_-]+)*@([a-z0-9-]+.)+[a-z]{2,6})/', '<a href="mailto:$1">$1</a>', $text);
		    return $text;
		}
    </script> -->

</head>
<body>
<div class="wrapper">
	<header class="header">
		<div class="headertitle" id="headertitle">
			<?php 
			?>
				<div class="main_title">
					<h2><img src="image/isq.png">  Мы общались как могли... </h2>
				</div>
			<?php
			?>
		</div>
	</header> 
	<div class="middle">
		<div class="container">
			<main class="content">
				<div class="all_messages" id="scroll">

				<?php 
				//$parse_links = parse_links();
				$messagesview = R::findAll('messages');
				$messagesLastID = -1;
				foreach ( $messagesview as $messages )
				{
					$messagesLastID = $messages->id;
				?><br>
				<?php
				$text = $messages->message;
				/*$regexp = "/(http:\\/\\/)?([a-z_0-9-.]+\\.[a-z]{2,3}(([ \"'>\r\n\t])|(\\/([^ \"'>\r\n\t]*)?)))/";
				$urls = array();
				preg_match($regexp, $text, $urls);
				$x = explode(" ", $text);
				for ( $j=0; $j<count($x); $j++ ) {
					if ( preg_match($regexp, $x[$j],$ok ) )
						echo str_replace($ok[2],"<a href='http://$ok[2]'>$ok[2]</a>",
                         str_replace("http://","",$x[$j]))." ";
				else
					echo $x[$j]." ";
				}*/
				?>
				<div class="messageline" id="<?=$messages->id;?>">
					<div class="messageline_left">
						<?php
							$http = "~(http|https|ftp|ftps)://(.*?)(\s|\n|[,.?!](\s|\n)|$)~";
							$youtube = '#<a(.*?)(?:href="https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=))([\w\-]{10,12}).*$#x';
							$mes = preg_replace($http, '<a href="$1://$2">$1://$2</a>$3', $messages->message);
							$mess = preg_replace($youtube, '<iframe src="http://www.youtube-nocookie.com/embed/$2"></iframe>', $mes); 
						?>
						<?="<b>".$messages->userlogin."</b>:  "./*$parse_links(show(*/$mess/*))*/;?>
					</div>
					<div class="messageline_right">
						<a href="like.php?id=<?=$like->count;?>" calss="button_like" method="POST" action="likes.php">
							<img  class="likeicon" id="image" src="image/like.png" onclick="this.src = 'image/likeon.png'"/>
						</a>
						<?php
							if( $_SESSION['logged_user']->login == $messages->userlogin )
							{
								?>
								<a href="messagedelete.php?id=<?=$messages->id;?>">
									<img src="image/delete.png" class="deleteicon">
								</a>
								<?php
							}
						?>
						<?="<b>".$messages->time."</b>";?>
					</div>
				</div>
				<?php 
				}
				?>
			</div><br />
			<div class="message_send" id="message_send">
				<form method="POST" action="messageadd.php">
					<textarea name="common_text" id="common_text" placeholder="Введите ваше сообщение"></textarea><br />
					<div class="upload" action="upload.php" method="POST" enctype="multipart/form-data">
						<input type="file" name="userfile" id="selectedFile" style="display: none;" />
						<input name="uploads" type="button" value="Прикрепить" onclick="document.getElementById('selectedFile').click();" />
						<!-- <a href="upload.php" calss="button_upload" >
							<img  class="uploadicon" id="image" src="image/clip.png"/>
						</a> -->
					</div>
					<div class="smiles">
						<span>
							<img class="smile" src="http://www.kolobok.us/smiles/icq/wink.gif" alt=";)">
						</span>
						<span>
							<img class="smile" src="http://www.kolobok.us/smiles/icq/blum1.gif" alt=":p)">
						</span>
						<span>
							<img class="smile" src="http://www.kolobok.us/smiles/icq/cool.gif" alt="B)">
						</span>
						<span>
							<img class="smile" src="http://www.kolobok.us/smiles/icq/mad.gif" alt=">:(">
						</span>
						<span>
							<img class="smile" src="http://www.kolobok.us/smiles/icq/cray.gif" alt=":(">
						</span>
					</div>
					<input class="send_message_button" type="submit" name="send" value="Отправить">
				</form>
			</div>	
			
			</main>
		</div>
		<aside class="right-sidebar">
			<div class="onlineusers">
				<?php
					$onlineusers = R::findAll('users');
					if ( $onlineusers > 0 )
					{
						print "<b> Список пользователей : <br></b>";	

						foreach ( $onlineusers as $users )
						{
							$users_name = $users->login;
							?>
							<div class="usersline">
								<?= $users_name;
								 ?>
							</div>
							<?php
						}
					}
				?>
			</div>
		</aside>
	</div>
</div>
</body>
</html>

<?php else : ?>
	<title>Подобие чата</title>
	<link href="style/feed.css" rel="stylesheet">
	<center>
		<br><br><br>
		<h1>Выберите действие:</h1><br><br>
		<form method="POST" action="">
			<a href="login.php">Авторизоваться</a><br><br>
			<a href="signup.php">Зарегистрировать новый аккаунт</a>
		</form>
	</center>
<?php endif; ?>

<script type="text/javascript">
	var messagesLastID = <?php echo $messagesLastID; ?>;
	window.setInterval(function(){
		$.ajax({
			url: "action_interval.php",
			type: "POST",
			data: {
				table: "messages", 
				messagesLastID: messagesLastID},
				success: function(dataHTML){
					if (dataHTML.trim() != "stop")
					{
						$(".all_messages").append(dataHTML);
						$.ajax({
							url: "action_interval_id.php",
							type: "POST",
							data: {
								table: "messages", 
								messagesLastID: messagesLastID},
							success: function(dataID){
    							messagesLastID = Number(dataID.trim());
    							document.getElementById('scroll').scrollTop = 9999;
    						}
    					});
					}
				}
			});
	}, 1000);
</script>