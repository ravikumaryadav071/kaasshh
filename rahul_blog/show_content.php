<p><a href="index.php">Home</a></p>
<?php
	
require_once 'core/init.php';

$db_blog = DBblog::getInstance();
$guest = false;

if(!isset($_SESSION['user'])){

	$guest = true;

}else{

	$guest = false;

}

//echo session::get(config::get('session/session_name'));
$user = new user();

if(isset($_GET['content_type'])){
	
	$content_type = $_GET['content_type'];
	$articles = $db_blog->query("SELECT * FROM articles WHERE content_type = '{$content_type}' ORDER BY date DESC", array(), 'SELECT *')->assocresults();
	$count = $db_blog->count();

	if ($user->isLoggedIn() || $guest) {
		//echo "Logged In";	

		if($user->isLoggedIn()){

			?>

			<p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?> </a>! </p>

			<ul>
				<li><a href="logout.php">Logout</a></li>
				<li><a href="update.php">Udate</a></li>
				<li><a href="changepwd.php">Change Password</a></li>
				<li><a href="profile.php?user=<?php echo escape($user->data()->username); ?>">Your current profile</a></li>
			</ul>

			</br>
			</br>
			<?php

		}

			$art_pp = 2; //number of articles per page
			if(empty($_GET['page_no'])){

				if($count>=$art_pp){
					
					$start = 0;
					$end = $start+$art_pp-1;

				}else{

					$start = 0;
					$end = $count-1;

				}

			}else{

				$page = $_GET['page_no'];
				$total_art = $page * $art_pp; //total articles upto this page

				if($total_art > $count){

					$start = ($page-1)*$art_pp;
					$end = $count-1;


				}else{

					$start = ($page-1)*$art_pp;
					$end = $start+$art_pp-1;				

				}

			}
			if(1){

				for($i=$start; $i<=$end; $i++){

					$article = $articles[$i];
					$art_id = $article['art_id'];
					$writer = $article['writer'];
					$title = $article['topic'];
					$type = $article['content_type'];
					$image = $article['image'];
					$body = $article['content'];
					$date = strtotime($article['date']);
					$date = date('d/m/Y', $date);
					
					?>

					<div style="border: 1px solid black">
						<p><h3><a href="show_art.php?art_id=<?php echo $art_id; ?>"><?php echo $title; ?></a></h3></p>
						<p><h4>By: <?php echo $writer; ?></h4></p>
						<p><?php echo $type; ?></p>
						<p>On: <?php echo $date; ?></p>
						<img src="<?php echo $image; ?>" style="">
						<p><?php echo substr($body, 0, 40)."..."; //characters shown per article?><a href="show_art.php?art_id=<?php echo $art_id; ?>">Read more.</a></p>
					</div>

					<?php

				}

				$pages = intval($count/$art_pp);
				
				if(($count/$art_pp) >$pages){

					++$pages;

				}

				?>
				<ul>
				<?php

				if($pages > 1){
					for($i=1; $i<=$pages; $i++){

						?>
						<li>
							<a href="show_content.php?page_no=<?php echo $i?>&content_type=<?php echo $content_type; ?>">
								<?php
								if(empty($_GET) && $i==1){

									?>
									<strong>
									<?php echo $i; ?>
									</strong>
									<?php
								}else{

									if(isset($_GET['page_no']) && !empty($_GET['page_no'])){

										if($_GET['page_no'] == $i){

											?>
											<strong>
											<?php echo $i; ?>
											</strong>
											<?php

										}else{

											?>

											<?php echo $i; ?>

											<?php

										}

									}else{

										?>
										<?php echo $i; ?>
										<?php

									}

								}
								?>
							</a>
						</li>
						<?php

					}
				
				}

				?>
				</ul>
				<?php


			}

		?>
	<?php
		
		if(!$guest){

			if ($user->hasPermission('admin')) {
				# code...
				echo "Your are an administrator";
				?>

				<ul>
					<li><a href="add_article.php">Add an article</a></li>
					<li><a href="edit_article.php">Edit an article</a></li>
					<li><a href="edit_by_field.php">Edit by field</a></li>
				</ul>

				<?php
			}

		}

	}

	else {

		echo '<p>You need to <a href="login.php">log in </a> or <a href="register.php">register</a></p>';

	}

}
if($guest){

	echo '<p>You need to <a href="login.php">log in </a> or <a href="register.php">register</a></p>';

}

?>