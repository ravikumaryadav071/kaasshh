<?php

require_once"core/init.php";

$user = new user();
$db_blog = DBblog::getInstance();

if($user->isLoggedIn()){

	if($user->hasPermission('admin')){

		if(isset($_POST) && !empty($_POST)){

			$art_id = $_POST['art_id'];
			if(isset($_POST['edit'])){

				$arr = array();
				foreach ($_POST as $key => $value) {
					
					if(!in_array($key, array('art_id', 'writer', 'edit', 'delete'))){

						$arr[$key] = $value;

					}

				}

				$db_blog->update('articles', $arr, array('art_id', '=', $art_id));

				if(!$db_blog->error()){

					echo "<p>Your changes have been saved successfully.</p>";

				}else{

					echo "<p>There is some problem. Try again!</p>";

				}

			}

			if(isset($_POST['delete'])){

				$db_blog->delete('articles', array('art_id', '=', $art_id));

				if(!$db_blog->error()){

					echo "<p>One article having article id {$art_id} has deleted.</p>";

				}else{

					echo "<p>There is some problem. Try again!</p>";

				}

			}

		}

		$articles = $db_blog->query("SELECT * FROM articles ORDER BY date DESC", array(), 'SELECT *')->assocresults();
		$total_art = $db_blog->count();

		if($total_art>0){

			for($i=0; $i<$total_art; $i++){

				$article = $articles[$i];
				$art_id = $article['art_id'];
				$writer = $article['writer'];
				$topic = $article['topic'];
				$content_type = $article['content_type'];
				$image = $article['image'];
				$content = $article['content'];
				$views = $article['views'];
				$date = $article['date'];
				?>
				<fieldset>
					<form action="" method="post">
						<div>
							<label for="">Article id</label>
							<input type="text" name="art_id" id="art_id" value="<?php echo $art_id; ?>" disabled>
							<input type="hidden" name="art_id" id="art_id" value="<?php echo $art_id; ?>">
						</div>
						<div>
							<label for="">Writer</label>
							<input type="text" name="writer" id="writer" value="<?php echo $writer; ?>" disabled>
							<input type="hidden" name="writer" id="writer" value="<?php echo $writer; ?>">
						</div>
						<div>
							<label for="">Topic</label>
							<input type="text" name="topic" id="topic" value="<?php echo $topic; ?>">
						</div>
						<div>
							<label for="">Content Type</label>
							<input type="text" name="content_type" id="content_type" value="<?php echo $content_type; ?>">
						</div>
						<div>
							<label for="">Image</label>
							<input type="text" name="image" id="image" value="<?php echo $image; ?>">
						</div>
						<div>
							<label for="">Content</label>
							<input type="text" name="content" id="content" value="<?php echo $content; ?>">
						</div>
						<div>
							<label for="">Views</label>
							<input type="text" name="views" id="views" value="<?php echo $views; ?>">
						</div>
						<div>
							<label for="">date</label>
							<input type="text" name="date" id="date" value="<?php echo $date; ?>">
						</div>
						<input type="submit" name="edit" id="edit" value="Edit">
						<input type="submit" name="delete" id="delete" value="Delete">
					</form>
				</fieldset>
				<?php

			}

		}

	}

}

?>