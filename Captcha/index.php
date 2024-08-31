	<?php
	session_start();
	 
	if(isset($_POST['captcha'])) {
	   if($_POST['captcha'] == $_SESSION['captcha']) {
	      echo "Captcha valide !";
	   } else {
	      echo "Captcha invalide...";
	   }
	}
	 
	?>
	<form method="POST">
	   <img src="captcha.php" />
	   <input type="text" name="captcha" />
	   <input type="submit" />
	</form>