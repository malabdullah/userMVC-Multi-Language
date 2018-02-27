<?php

namespace App\Core;

abstract class Controller {

	public function model($model){
		
		if (file_exists(APPPATH . '/models/' . $model . '.php')){
			$class = '\\App\\Models\\' . $model;
			return new $class;
		}
	}

	public function view($view, array $data = [], $title = SITENAME){
		if (file_exists(APPPATH . '/views/' . $view . '.php')){

			foreach ($data as $key => $value) {
				$$key = $value;
			}

			require APPPATH . '/views/' . $view . '.php';
		}elseif (file_exists(APPPATH . '/views/' . $view . '.html')){
			require APPPATH . '/views/' . $view . '.html';
		}
	}

	public function isAuth($model){

		if (!$this->isLoggedIn($model)){

			$this->setRequestedPage();
			redirect('users/login');
		}
	}

	public function isLoggedIn($model){

		if (checkIfSessionSet('user_id')){

			return true;

		}elseif (checkIfCookieSet('remember_login')){

			$cookie = $_COOKIE['remember_login'];
			$user_cookie = $model->getSessionByToken($cookie);

			if ($user_cookie && !$this->isExpired($user_cookie->expires_at)){
				
				$user_id = $user_cookie->user_id;

				if ($user_id){
				
					$user = $model->getByID($user_id);
					
					if ($user){

						createUserSession($user);

						return true;

					}
				}
			}
		}

		return false;
	}

	public function getRequestedPage(){
		
		$page = 'users/loginSuccess';

		if (checkIfSessionSet('redirect_to')){
			$page = $_SESSION['redirect_to'];
		}

		return $page;
	}

	public function setRequestedPage(){
		
		$page = str_replace('/userMVC/', '', $_SERVER['REQUEST_URI']);
		setSession('redirect_to',$page);

	}

	public function loginUser(){

		$page = $this->getRequestedPage();
		redirect($page);

	}

	public function isExpired($time){

		if (strtotime($time) < time()){
			return true;
		}

		return false;

	}
}