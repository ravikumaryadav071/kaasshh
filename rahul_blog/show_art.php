<?php

require_once("core/init.php");
$db_blog = DBblog::getInstance();
$user = new user();


if($user->isLoggedIn()){

	$userid = $_SESSION['user'];
	$user->find($userid);
	$userdata = $user->data();
	$username = $userdata->username;

}

if(isset($_POST) && !empty($_POST)){

	if($_POST['comment'] != ""){

		$posted_comm = $_POST['comment'];
		if(!($user->isLoggedIn())){
			$username = $_POST['username'];
		}

		$art_id = $_GET['art_id'];

		$db_blog->insert('blog_comments', array(
													'name' => $username,
													'comment' => $posted_comm,
													'art_id' => $art_id
												));

		if(!$db_blog->error()){

			unset($_POST);
			echo "Your review has been added.";

		}else{

			echo "Sorry! Your comment cannot";

		}
	}
}

if(isset($_GET) && !empty($_GET)){

	$art_id = $_GET['art_id'];
	$article = $db_blog->get("articles", array('art_id', '=', $art_id))->first();
	$writer = $article->writer;
	$topic = $article->topic;
	$type = $article->content_type;
	$image = $article->image;
	$body = $article->content;
	$views = $article->views;
	$date = strtotime($article->date);
	$date = date('d/m/Y', $date);


	$views = $views + 1;

	$db_blog->update('articles', array('views' => $views), array('art_id', '=', $art_id));

	?>
	<div style="border: 1px solid black">
		<p><h2><?php echo $topic; ?></h2></p>
		<p>By: <strong><?php echo $writer; ?></strong></p>
		<p><strong><?php echo $type; ?></strong></p>
		<p>On: <strong><?php echo $date; ?></strong></p>
		<img src="<?php echo $image; ?>" style="">
		<p><?php echo $body; ?></p>
	</div>

	<p> Comments </p>
	
	<?php
	$comments = $db_blog->get("blog_comments", array('art_id', '=', $art_id))->assocresults();
	$total_comment = $db_blog->count();

	if($total_comment == 0){

		?>
		<div style="border: 1px solid black">
			No comments found. Be the first one to give your comment.
		</div>
		<?php

	}else{

		for($i=0; $i<$total_comment; $i++){

			$comment = $comments[$i];
			$name = $comment['name'];
			$content = $comment['comment'];
			$comm_date = strtotime($comment['date']);
			$comm_date = date('d/m/Y', $comm_date);
			?>
			<div style="border: 1px solid black">
				<p><strong>By: <?php echo $name; ?> | On: <?php echo $comm_date; ?></strong></p>
				<p><?php echo $content;?></p>
			</div>
			<?php

		}

	}

	?>
	<fieldset>
		<legend>Comment</legend>
		<form method="post" action="">
			<div>
				<label for="username">Your Name</label>
				<input type="text" name="username" id="username" value="<?php echo $username; ?>">
			</div>

			<div>
				<label for="comment">Comment</label>
				<input type="text" name="comment" id="comment" value="">
			</div>
			<input type="submit" name="submit" id="submit">
		</form>
	</fieldset>
	<?php

}else{

	?>
	<p>No input. Go to the <a href="index.php">home</a> page.</p>
	<?php

}

?>