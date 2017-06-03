<?php

require_once 'core/init.php';

$user = new user();

if (!$user->isLoggedIn()) {
	redirect::to('index.php');
}

if (input::exists()) {
	if (token::check(input::get('token'))) {
		# echo "Okay";
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
				'name' => array(
						'required' => true,
						'min' => 2,
						'max' => 50
				),

				'email_id' => array(
					'required' => true,
					'min' => 4
				),

				'contact_no' => array(
					'required' => true,
					'min' => 6
				)
		));

		if ($validation->passed()) {
			# update
				try {
					$user->update(array(
						'name' => input::get('name'),
						'email' => input::get('email_id'),
						'contact_no' => input::get('contact_no')
					));

					session::flash('home', 'Your details have been updated');
					redirect::to('index.php');

				} catch(Exception $e) {
					die($e->getMessage());
				}

		} else {
			foreach ($validation->errors() as $error) {
				echo $error, '<br>';
			}
		}
	}
}

?>

<form action="" method="post">
	<div class="field">
		<lable for="name">Name</lable>
		<input type="text" name="name" value="<?php escape($user->data()->name); ?>">
		<lable for="name">Email Id</lable>
		<input type="text" name="email_id" value="<?php escape($user->data()->email); ?>">
		<lable for="name">Contact Number</lable>
		<input type="text" name="contact_no" value="<?php escape($user->data()->contact_no); ?>">
		<input type="submit" value="Update">
		<input type="hidden" name="token" value="<?php  echo token::generate(); ?>">
	</div>
</form>
