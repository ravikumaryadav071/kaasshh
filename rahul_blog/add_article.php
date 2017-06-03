<?php

require_once("core/init.php");

$user = new user();
$db_blog = DBblog::getInstance();

if($user->isLoggedIn()){

	$userid = $_SESSION['user'];
	$user->find($userid);
	$userdata = $user->data();
	$username = $userdata->username;

	if($user->hasPermission('admin')){

		if(isset($_POST['submit']) && !empty($_POST['submit'])){

			$img_name = $_FILES['file']['name'];

			if(isset($img_name)){

				$writer = $_POST['writer'];
				$topic = $_POST['topic'];
				$content = $_POST['content'];
				$content_type = $_POST['content_type'];
				$image = $_POST['image'];

				$db_blog->insert('articles', array(
												'writer' => $username,
												'topic' => $topic,
												'content' => $content,
												'content_type' => $content_type,
												'image' => $image
											));

				$img_type = $_FILES['file']['type'];
				$tmp_img = $_FILES['file']['tmp_name'];
				$extention = substr($img_name, strpos($img_name, '.') + 1);
				$location = 'images/';
				
				if(in_array($extention, array('jpg', 'jpeg', 'png', 'gif', 'bmp')) && in_array($img_type, array('image/jpeg', 'image/png', 'image/gif', 'image/bmp'))){

					if(move_uploaded_file($tmp_img, $location.$img_name)){

						echo "Image uploaded sucessfully.";

					}else{

						echo "Image has not been uploaded. There is an error in uploading.";

					}

				}				

				if(!$db_blog->error()){

					unset($_POST);
					echo "<p>Your article has been added.</p>";

				}else{

					echo "<p>There is some problem. Try again!</p>";

				}

			}else{

				echo "Please choose a file.";

			}
		}

		?>
		<form action="" method="post" enctype="multipart/form-data">
			<div>
				<label for="writer">Writer</label>
				<input type="text" id="writer" name="writer" value="<?php echo $username; ?>">
			</div>

			<div>
				<label for="topic">Topic</label>
				<input type="text" id="topic" name="topic" value="">
			</div>

			<div>
				<label for="topic">Content Type</label>
				<input type="text" id="content_type" name="content_type" value="">
			</div>

			<div>
				<label for="topic">Image</label>
				<input type="text" id="image" name="image" value="images/">
			</div>

			<div>
				<label for="content">Content</label>
				<input type="text" id="content" name="content" value="">
			</div>
			<div>
				<label for="file">Upload Image</label>
				<input type="file" id="file" name="file">
			</div>
			<input type="submit" name="submit" id="submit" value="Submit">
			<input type="reset" name="reset" id="reset" value="Reset">
		</form>
		<?php

	}

}

?>