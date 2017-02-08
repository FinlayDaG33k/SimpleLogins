<?php
	class SimpleLogins{
		public function __construct(){
    	$this->Database = new Database;
			$this->Captcha = new Captcha;
  	}
		function Login($conn,$Table,$Username,$Password){
			if(!$conn){
				return "No_Conn";
			}else{
				$sql = "SELECT * FROM `".$Table."` WHERE `Username`='".mysqli_real_escape_string($conn,$Username)."' OR `Email`='".mysqli_real_escape_string($conn,$Username)."';";
				$sql_output = $conn->query($sql);
				if ($sql_output->num_rows > 0) {
					$user = $sql_output->fetch_assoc();
					if(password_verify($Password,$user['Password']) == true){
						return 1;
					}else{
						return "Invalid_Credentials";
					}
				}else{
					return "Invalid_Credentials";
				}
			}
		}
		function Logout($conn){
			session_start();
			session_destroy();
			session_regenerate_id();
		}
		function Change_password(){}
		function Reset_password(){}
		function Check_Session(){}
		function sl_Vars(){
			require(DIRNAME(__FILE__) . "/config.php");
			if(!empty($_SERVER['HTTPS'])){
				$server_proto = "https://";
			}else{
				$server_proto = "http://";
			}
			$sl_vars = 	array(
										"Server_proto" => $server_proto,
										"System_url" => htmlentities($_SERVER['HTTP_HOST']) . "/simplelogins/system.php",
										"Captcha_form" => "<div class=\"g-recaptcha\" data-sitekey=\"".$sl_config['Captcha']['Sitekey']."\"></div>",
										"Captcha_script" => "<script src='https://www.google.com/recaptcha/api.js'></script>"
									);
			return $sl_vars;
		}
	}

	class Database{
		function Initialize($host,$username,$password,$database){
			$conn = new mysqli($host, $username, $password, $database);
			// Check connection
			if ($conn->connect_error) {
    		die("Connection failed: " . $conn->connect_error);
			}
			return $conn;
		}

		function Initialize_No_Database($host,$username,$password){
			$conn = new mysqli($host, $username, $password);
			if ($conn->connect_error) {
    		die("Connection failed: " . $conn->connect_error);
			}
			return $conn;
		}
	}

	class Captcha{
		function Check($secret,$g_response,$remoteip){
			$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$sl_config['Captcha']['Sitekey']."&response=".$g_response."&remoteip=".$remoteip);
			$responseKeys = json_decode($response,true);
			if(intval($responseKeys["success"]) !== 1) {
				return 0;
			} else {
				return 1;
			}
		}
	}
?>
