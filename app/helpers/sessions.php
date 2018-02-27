<?php

function createUserSession($user){

	session_regenerate_id(true);

	$_SESSION['user_id'] = $user->id;
	$_SESSION['user_name'] = $user->name;
}

function destroySession(){
	
	$_SESSION = array();

	if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), '', time() - 42000,
	        $params["path"], $params["domain"],
	        $params["secure"], $params["httponly"]
	    );
	}

	session_destroy();
}

function checkIfSessionSet($session){
	
	if (isset($_SESSION[$session]) && !empty($_SESSION[$session])){
		return true;
	}

	return false;
}

function setSession($session,$value){
	$_SESSION[$session] = $value;
}

function checkIfCookieSet($cookie){
	
	if (isset($_COOKIE[$cookie]) && !empty($_COOKIE[$cookie])){
		return true;
	}

	return false;
}