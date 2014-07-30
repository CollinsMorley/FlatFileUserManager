<?php
	session_start();
	
	require_once("UserLogin.php");
	$userLogin = new UserLogin();
	
	if(isset($_POST['username']) && !isset($_POST['password2'])){
		if($userLogin->LogIn($_POST['username'], $_POST['password'])){
			$_SESSION['USERNAME'] = $_POST['username'];
		}
	}
	elseif(isset($_POST['username']) && isset($_POST['password2'])){
		$userLogin->CreateAccount($_POST['username'], $_POST['password'], $_POST['password2']);
	}
?>
	<?=$userLogin->Error(UserLogin::LOGIN_ERROR);?>
	<form action="index.php" method="post">
		Username: <input type="text" name="username"><br>
		Password: <input type="password" name="password"><br>
		<input type="submit" value="Log In">
	</form>
	
	<br>
	
	<?=$userLogin->Error(UserLogin::CREATE_ERROR);?>
	<form action="index.php" method="post">
		Username: <input type="text" name="username"><br>
		Password: <input type="password" name="password"><br>
		Confirm Password: <input type="password" name="password2"><br>
		<input type="submit" value="Create Account">
	</form>