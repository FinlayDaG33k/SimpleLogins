<?php
	require(DIRNAME(__FILE__) . "/autoloader.php");
	if($_POST){
		switch($_POST['Action']){
			case "Login":
				$SimpleLogins->Users->Login($_POST['Username'],$_POST['Password'],$sl_config);
		}
	}elseif($_GET){
		switch(strtolower($_GET['Action'])){
			case "logout":
				$SimpleLogins->Users->Logout();
		}
	}else{
		echo "Invalid HTTP Method.";
	}
