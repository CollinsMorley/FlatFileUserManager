<?php
	class UserLogin extends ErrorHandler{
		const FILE_URL = "passwords.txt";
		
		function LogIn($username, $password){
			$password = hash("sha512",$password);
			$username_clean = strtolower($username);
			
			$fin = fopen(self::FILE_URL, "r");
			
			while(($line = fgets($fin)) !== false){
				$token = explode(":",$line);
				$token[2] = preg_replace("#\n#","",$token[2]);
				if($username_clean == $token[1] && $password == $token[2]){
					fclose($fin);
					return true;
				}
				elseif($username_clean == $token[1]){
					fclose($fin);
					$this->SendError(self::LOGIN_ERROR, "Passwords do not match.");
					return false;
				}
			}
			
			fclose($fin);
			$this->SendError(self::LOGIN_ERROR, "Passwords do not match.");
			return false;
		}
		
		function CheckUser($username_clean){
			$fin = fopen(self::FILE_URL, "r");
			if(!$fin){
				return false;
			}
			
			while(($line = fgets($fin)) !== false){
				$token = explode(":",$line);
				if($username_clean == $token[1]){
					fclose($fin);
					return true;
				}
			}
			
			fclose($fin);
			return false;
		}
		
		function CreateAccount($username, $password, $password2){
			$password_hashed = hash("sha512", $password);
			$username_clean = strtolower($username);
			
			if($password != $password2){
				$this->SendError(self::CREATE_ERROR, "Passwords do not match.");
				return false;
			}
			elseif($this->CheckUser($username_clean)){
				$this->SendError(self::CREATE_ERROR, "That username is taken.");
				return false;
			}
			else{
				$serialized_string = $username . ":" . $username_clean . ":" . $password_hashed . "\n";
				$fout = fopen(self::FILE_URL, "a");
				fwrite($fout, $serialized_string);
				fclose($fout);
				return true;
			}
		}
	}
	
	abstract class ErrorHandler{
		private $_error_msg;
		private $_error_type;
		
		const LOGIN_ERROR = 1;
		const CREATE_ERROR = 2;
		
		function SendError($eCode, $e){
			$this->_error_type = $eCode;
			$this->_error_msg = $e;
		}
		
		function Error($eCode){
			if($this->_error_type == $eCode){
				return $this->_error_msg;
			}
		}
	}	
?>
