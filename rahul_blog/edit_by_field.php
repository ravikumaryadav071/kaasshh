<?php

require_once "core/init.php";

$user = new user();
$db_blog = DBblog::getInstance();

if($user->isLoggedIn()){

	if($user->hasPermission('admin')){

		if(isset($_POST) && !empty($_POST)){

			$condition="";

			foreach($_POST as $key=>$value){

				if($value != "" && !in_array($key, array( 'date', 'search'))){

 					if($condition == ""){

 						$condition .= " {$key} = '{$value}' ";

 					}else{

 						$condition .= " AND {$key} = '{$value}' ";

 					}

				}else{

					if($key == "date" && $condition == "" && $value != ""){

						$condition .=" date LIKE '%{$value}%' ";

					}else{

						if($key == "date" && $value != ""){

							$condition .=" AND date LIKE '%{$value}%' ";

						}

					}

				}

			}

			$art_id = $_POST['art_id'];
			if(isset($_POST['edit'])){

				$arr = array();
				foreach ($_POST as $key => $value) {
					
					if(!in_array($key, array('art_id', 'writer', 'edit', 'delete', 'search'))){

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

			$query = "SELECT * FROM articles WHERE {$condition} ORDER BY date DESC";
			$results = $db_blog->query($query, array(), 'SELECT *')->assocresults();
			$total_results = $db_blog->count();

			for($i=0; $i<$total_results; $i++){

				$result = $results[$i];
				?>
				<fieldset>
					<form action="" method="post">
				
					<div>
						<label for="">Article Id</label>
						<input type="text" id="art_id" name="art_id" value="<?php echo $result['art_id']; ?>" disabled>
						<input type="hidden" id="art_id" name="art_id" value="<?php echo $result['art_id']; ?>">
					</div>

					<div>
						<label for="">Writer</label>
						<input type="text" id="writer" name="writer" value="<?php echo $result['writer']; ?>" disabled>
						<input type="hidden" id="writer" name="writer" value="<?php echo $result['writer']; ?>">
					</div>

					<div>
						<label for="">Topic</label>
						<input type="text" id="topic" name="topic" value="<?php echo $result['topic']; ?>">
					</div>

					<div>
						<label for="">Content</label>
						<input type="text" id="content" name="content" value="<?php echo $result['content']; ?>">
					</div>

					<div>
						<label for="">Content Type</label>
						<input type="text" id="content_type" name="content_type" value="<?php echo $result['content_type']; ?>">
					</div>

					<div>
						<label for="">Image</label>
						<input type="text" id="image" name="image" value="<?php echo $result['image']; ?>">
					</div>

					<div>
						<label for="">Views</label>
						<input type="text" id="views" name="views" value="<?php echo $result['views']; ?>">
					</div>

					<div>
						<label for="">Date</label>
						<input type="text" id="date" name="date" value="<?php echo $result['date']; ?>">
					</div>

					<input type="submit" id="edit" name="edit" value="Edit">
					<input type="submit" id="delete" name="delete" value="Delete">
					</form>
				</fieldset>
				<?php

			}

		}

		$sas = $db_blog->query("SELECT * FROM articles", array(), 'SELECT *')->assocresults();
		$sa = $sas[0];

		?>
		<fieldset>
		<form method="post" action="">
		<?php
		foreach ($sa as $key => $value) {

			?>
			<div>
				<label><?php echo $key; ?></label>
				<input type="text" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="">
			</div>
			<?php

		}

		?>
		<input type="submit" id="search" name="search" value="search">
		</form>
		</fieldset>
		<?php

	}

}

?>