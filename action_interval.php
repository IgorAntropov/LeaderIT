<?php
	require "db.php";
	$tableName = $_POST['table'];
	$messagesLastID = $_POST['messagesLastID'];
	$result = R::findAll($tableName, ' WHERE id > :mesID', [':mesID' => $messagesLastID]);
				$messagesview = $result;
				$messagesLastID = -1;
				foreach ( $messagesview as $messages )
				{
					$messagesLastID = $messages->id;
				?><br>
				<?php
					messageHTML($messages, $_SESSION['logged_user']);
				?>
				<?php 
				}
				if ($messagesLastID == -1)
					echo 'stop';



function messageHTML($messages, $logged_user){
	?>
	<div class="messageline" id="<?=$messages->id;?>">
		<div class="messageline_left">
			<?php
				$http = "~(http|https|ftp|ftps)://(.*?)(\s|\n|[,.?!](\s|\n)|$)~";
				$youtube = '#<a(.*?)(?:href="https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=))([\w\-]{10,12}).*$#x';
				$mes = preg_replace($http, '<a href="$1://$2">$1://$2</a>$3', $messages->message);
				$mess = preg_replace($youtube, '<iframe src="http://www.youtube-nocookie.com/embed/$2"></iframe>', $mes); 
			?>
			<?="<b>".$messages->userlogin."</b>:  "./*parse_links(show(*/$mess/*))*/;?>
		</div>
		<div class="messageline_right">
			<a href="like.php?id=<?=$like->count;?>" calss="button_like" method="POST" action="likes.php">
				<img  class="likeicon" id="image" src="image/like.png" onclick="this.src = 'image/likeon.png'"/>
			</a>
			<?php
			if( $logged_user->login == $messages->userlogin ){
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
}?>


