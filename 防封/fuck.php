<?php
	session_start();
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false ){			
		header("HTTP/1.1 404 Not Found");  
		header("Status: 404 Not Found");  
		exit();  
	}else{
		if($_GET["fucker"]=="fucker"){
			$_SESSION["fucker"]="fucker";
			header("Location: ./");  
		}
	
	}

?>