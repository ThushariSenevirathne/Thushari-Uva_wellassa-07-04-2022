<?php 
	// start the sessiion
	session_start();

	// Create connection
	require_once("connection.php");

	// Check for form submission
	if (isset($_POST['btnLogin'])) {
		$errors = array();
		$msg = array();

		// check if the username and password entered
		if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1 ) {
			$errors[] = 'Username is Invaied / Missing';
		}
		if (!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1 ) {
			$errors[] = 'Password is Invaied / Missing';
		}

		// check if there are any errors in the form
		if (empty($errors)) {
			// save username and password into variable
			$mail	= mysqli_real_escape_string($con, $_POST['email']);
			$password = mysqli_real_escape_string($con, $_POST['password']);
			$encript_pw = md5($password);

			// prepare database query
			$sql = "SELECT * FROM user WHERE email = '{$mail}' AND password = '{$encript_pw}' LIMIT 1";
			$result_set = mysqli_query($con, $sql);

			if($result_set){
				// query successful

				if (mysqli_num_rows($result_set) == 1) {
					// valid user found
					$user = mysqli_fetch_assoc($result_set);
					$_SESSION['user_id'] = $user['id'];
					$_SESSION['first_name'] = $user['fname'];
					//update last login
					$sql2 = "UPDATE user SET last_login = NOW()";
					$sql2 .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";
					$result= mysqli_query($con, $sql2);

					if (!$result) {
						die("Database query faild");
					}

					// rederect home.php page
					header('Location:home.php');
				}else{
					// username and password invaliid
					$errors[] = 'Invaied Username / Password';
				}
			}else{
				echo "Database query faild" . $sql . "<br>" . mysqli_error($con);
			}

		}

	}
	 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="styles.css">
	<title>Log In</title>
</head>
<body>
	<div class="navbar">
	<ul>
		<li><a href="#">Home</a></li>
		<li><a href="#">Log In</a></li>
		<li><a href="#">New user</a></li>
		<li><a href="#">User list</a></li>
	</ul>
	</div>
	<div class="container">
		<div class="login">
			<form method="post">
				<fieldset>
					<legend><h1>Log In</h1></legend>

					<?php 
						if (isset($errors) && !empty($errors)) {
							echo '<p class="err">Invalid Username / Password</p>';
						}
					?>
					
					<p>
						<label>User Name</label>
						<input type="text" name="email" placeholder="Email Address">
					</p>
					<p>
						<label>Password</label>
						<input type="password" name="password" placeholder="Password">
					</p>
					<p>
						<button type="submit" name="btnLogin" class="btn">Log In </button>
					</p>
				</fieldset>
			</form>
		</div>
	</div>
</body>
</html>
<?php mysqli_close($con); ?>