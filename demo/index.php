<!DOCTYPE HTML>
<html>
	<head>
		<?php
			require(DIRNAME(__FILE__) . "/SimpleLogins/autoloader.php");
		?>
	</head>
	<body>
		<?php if($_SESSION['Loggedon'] == 1){ ?>
			<ul>
				<li>Welcome, <?= htmlentities($_SESSION["Username"]); ?></li>
				<li><a href="<?= htmlentities($SimpleLogins->sl_Vars()['System_url']); ?>?Action=logout">Logout</a></li>
			</ul>
		<?php }else{ ?>
			<form action="<?= htmlentities($SimpleLogins->sl_Vars()['System_url']); ?>" method="POST">
				Username: <input type="text" name="Username"><br />
				Password: <input type="password" name="Password"><br />
				<br />
				<input type="hidden" name="Action" value="Login">
				<input type="Submit">
			</form>
		<?php } ?>
	</body>
</html>
