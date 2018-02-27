<?php

namespace App\Controllers;

use \App\Core\Email;

class Users extends \App\Core\Controller{

	public function __construct(){
		$this->userModel = $this->model('User');
	}

	public function index(){

		$data = [
			'name' => '',
			'email' => '',
			'error' => []
		];
		
		$this->view('user/index',$data);
	}

	public function signup(){

		$error = [];

		if ($_SERVER['REQUEST_METHOD'] === 'POST'){
			
			$name 		= clean_text($_POST['name']);
			$email 		= clean_text($_POST['email']);
			$password 	= clean_text($_POST['password']);
			$ip 		= getRealIP();

			if (empty($name)){
				$error['name_error'] = 'name is requiered!';
			}elseif (!preg_match("/^[a-zA-Z ]*$/",$name)){
				$error['name_error'] = 'name is not valid!';
			}

			if (empty($email)){
				$error['email_error'] = 'email is requiered!';
			}elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$error['email_error'] = 'not a valid email!';	
			}elseif ($this->userModel->getByEmail($email)){
				$error['email_error'] = 'email already exists!';
			}

			if (empty($password)){
				$error['password_error'] = 'password is requiered!';
			}elseif (strlen($_POST['password']) < 8){
				$error['password_error'] = 'password must be atleast 8 alphanumeric!';
			}

			if (empty($error)){

				if ($this->userModel->addNewUser($name,$email,$password,$ip)){

					$url = ROOTPATH . '/users/activate/' . $this->userModel->active_value;
						
					$text = 'Please click the following link to activate your account: ' . $url;
					$html = file_get_contents(ROOTPATH . '/emails/activate');
					$html = str_replace('{url}', $url, $html);

					$mail = new Email;

					if ($mail->send(MAILFROM,$email,'Activate Your Account',$html,$text,MAILFROMNAME)){
					
						header('Location: ' . ROOTPATH . '/users/signupSuccess');
					}
				}

				$error['db_error'] = 'error inserting record!';					
			}
				$data = [
					'name' 		=> $name,
					'email' 	=> $email,
					'error' 	=> $error
				];

				$this->view('user/index',$data);
			
		}else {

			$data = [
				'name' => '',
				'email' => '',
				'error' => []
			];

			$this->view('user/index',$data);
		}
	}

	public function login(){

		if ($this->isLoggedIn($this->userModel)){
			$this->loginUser();
		}

		$error = [];
		$active_warning = '';

		if ($_SERVER['REQUEST_METHOD'] === 'POST'){
			
			$email = clean_text($_POST['email']);
			$password = clean_text($_POST['password']);
			$remember = '';

			if (check('remember',$_POST)){
				$remember = clean_text($_POST['remember']);
			}

			if (empty($email)){
				$error['email_error'] = 'email is requiered!';
			}elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$error['email_error'] = 'not a valid email!';	
			}

			if (empty($password)){
				$error['password_error'] = 'password is requiered!';
			}

			if (empty($error)){

				$user = $this->userModel->getByEmail($email);
					
				if ($user){

					if (password_verify($password,$user->password)){

						if ($user->active){

							if (!empty($remember)){
								if ($this->userModel->rememberLogin($user->id)){
									setcookie('remember_login',$this->userModel->remember_token,$this->userModel->expiry);
								}
							}

							createUserSession($user);

							$ip = getRealIP();
							if ($this->userModel->updateLoginTime($user->id,$ip)){

								$this->loginUser();
							}
						}

						$active_warning = 'Please activate your account to login!';
					}
				}

				if (!check($active_warning)){
					$error['db_error'] = 'Invalid email or password, please try again later!';
					$active_warning = '';
				}
			}

			$data = [
				'email' 	=> $email,
				'remember'	=> $remember,
				'active'	=> $active_warning,
				'error' 	=> $error
			];

			$this->view('user/login',$data);
			
		}else {

			$data = [
				'email' 	=> '',
				'remember'	=> '',
				'active'	=> '',
				'error' 	=> []
			];

			$this->view('user/login',$data);
		}
	}

	public function logout(){

		destroySession();

		if (checkIfCookieSet('remember_login')){

			$cookie = $_COOKIE['remember_login'];

			if ($this->userModel->getSessionByToken($cookie)){

				if ($this->userModel->deleteToken($cookie)){

					unset($_COOKIE['remember_login']);
					setcookie('remember_login' , '' , time() - 3600, '/userMVC/');

					redirect('users/login');

				}
			}
		}

		redirect('users/login');
	}

	public function profile($data = []){

		$this->isAuth($this->userModel);

		if (!check($data)){
			redirect('notfound/index');
		}

		if (!is_numeric($data[2])){
			redirect('notfound/index');	
		}

		$user = $this->userModel->getByID($data[2]);

		if (!$user){
			redirect('notfound/index');
		}

		$data = [
			'user' => $user
		];

		$this->view('user/profile',$data);
	}

	public function passwordForget(){

		$error = [];

		$data = [
			'email' 		=> '',
			'error' 		=> ''
		];

		if ($_SERVER['REQUEST_METHOD'] === 'POST'){

			if (!check('email',$_POST)){

				$error['email_error'] = 'Email is requiered!';
			}

			if (empty($error)){
				
				$email = clean_text($_POST['email']);

				$user = $this->userModel->getByEmail($email);

				if ($user){

					if ($this->userModel->setResetPassword($user->id)){

						$url = ROOTPATH . '/users/reset/' . $this->userModel->reset_token;
						
						$text = 'Please click the following link to reset your password: ' . $url;
						$html = file_get_contents(ROOTPATH . '/emails/reset');
						$html = str_replace('{url}', $url, $html);

						$email = new Email;
						if ($email->send(MAILFROM,$user->email,'Reset Password',$html,$text,MAILFROMNAME)){

							redirect('users/resetSuccess');
						}
					}

				}else {

					$error['email_error'] = 'Email does not exists, please check the email and try again!';
				}
			}

			$data = [
				'email' 		=> $email,
				'error' 		=> $error
			];
		}

		$this->view('user/password-forget',$data);
	}

	public function reset($data){

		if (!check($data)){
			redirect('notfound/index');
		}

		$error = [];
		$token = $data[2];

		if (!preg_match('{[\da-f]+}', $token)){

			$error['token_error'] = 'Invalid token!';
		}

		if (empty($error)){

			$user = $this->userModel->getByHash($token);

			if ($user){

				if (!$this->isExpired($user->password_reset_expiry)){

					$data = [
						'token' => $token
					];

					$this->view('user/password-reset',$data);
					exit;
				}
			}

			$error['token_error'] = 'Invalid or expired token!';

		}

		$data = [
			'email' => '',
			'remember'	=> '',
			'active'	=> '',
			'error' => $error
		];

		$this->view('user/login',$data);
	}

	public function passwordReset(){

		$error = [];

		$data = [
			'error' => ''
		];

		if ($_SERVER['REQUEST_METHOD'] === 'POST'){
			
			$password 			= clean_text($_POST['new_password']);
			$confirm_password 	= clean_text($_POST['confirm_password']);
			$token 				= clean_text($_POST['token']);

			if (empty($password)){
				$error['password_error'] = 'password is requiered!';
			}

			if (strlen($password) < 8){
				$error['password_error'] = 'password must be at least 8 alphanumeric!';
			}

			if (empty($confirm_password)){
				$error['confirm_password_error'] = 'Confirm password is requiered!';
			}

			if ($confirm_password != $password){
				$error['password_error'] = 'Passwords must match!';
			}

			if (!check($token)){
				$error['token_error'] = 'Token does not exist!';
			}

			if (!preg_match('{[\da-f]+}', $token)){
				$error['token_error'] = 'Invalid token!';
			}

			if (empty($error)){

				$user = $this->userModel->getByHash($token);
					
				if ($user){

					if ($this->userModel->resetPasswordByID($password,$user->id)){

						redirect('users/passwordresetsuccess');
					}

					$error['password_error'] = 'Error resetting password, please try again!';
				}

				$error['password_error'] = 'User does not exist!';
			}

			$data = [
				'error' => $error
			];
		}

		$this->view('user/password-reset',$data);
	}

	public function activate($data){

		if (!check($data)){

			redirect('notfound/index');
		}

		$error = [];
		$token = $data[2];

		if (!preg_match('{[\da-f]+}', $token)){
			$error['active_error'] = 'Invalid token!';
		}

		if (empty($error)){

			$user = $this->userModel->getByActiveHash($token);

			if ($user){

				if ($this->userModel->activateAccount($token)){

					redirect('users/activeSuccess');
				}

				$error['active_error'] = 'Error activating account!';
			}

			$error['active_error'] = 'User does not exist!';
		}

		$data = [
			'reset' => '',
			'email' => '',
			'remember'	=> '',
			'active'	=> '',
			'error' => $error
		];

		$this->view('user/login',$data);
	}

	public function signupSuccess(){
		$this->view('user/signup-success');
	}

	public function loginSuccess(){
		$this->view('user/login-success');
	}

	public function resetSuccess(){
		$this->view('user/reset-success');
	}

	public function passwordResetSuccess(){
		
		$data = [
			'reset' 	=> 'Password has been successfully reset, your are able to login with new password!',
			'email' 	=> '',
			'remember'	=> '',
			'active'	=> '',
			'error' 	=> []
		];

		$this->view('user/login',$data);
	}

	public function activeSuccess(){

		$data = [
			'active_success' 	=> 'Account has been successfully activated, you are able to login!',
			'email' 			=> '',
			'remember'			=> '',
			'active'			=> '',
			'error' 			=> []
		];

		$this->view('user/login',$data);	
	}
}