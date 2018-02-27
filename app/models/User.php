<?php

namespace App\Models;

use \App\Core\Token;

class User extends \App\Core\Model {

	public function addNewUser($name,$email,$password,$ip){

		$token = new Token;
		$active_token = $token->getHash();
		$this->active_value = $token->getValue();

		$sql = "INSERT INTO users (name,email,password,active_token,created_at,ip_address) VALUES (:name,:email,:password,:active_token,:created,:ip);";
		$this->db->query($sql);

		$created = date('Y-m-d H:i:s');
		$password = password_hash($password,PASSWORD_DEFAULT);

		$this->db->bind(':name',$name);
		$this->db->bind(':email',$email);
		$this->db->bind(':password',$password);
		$this->db->bind(':active_token',$active_token);
		$this->db->bind(':created',$created);
		$this->db->bind(':ip',$ip);

		if ($this->db->execute()){
			return true;
		}else {
			return false;
		}
	}

	public function getByEmail($email){

		$sql = "SELECT * FROM users WHERE email = :email;";
		$this->db->query($sql);

		$this->db->bind(':email',$email);

		return $this->db->singleResult();
	}

	public function getByID($id){

		$sql = "SELECT * FROM users WHERE id = :id;";
		$this->db->query($sql);

		$this->db->bind(':id',$id);

		return $this->db->singleResult();
	}

	public function updateLoginTime($id,$ip){

		$loginTime = date('Y-m-d H:i:s');

		$sql = 'UPDATE users SET last_login = :login, ip_address = :ip WHERE id = :id;';
		$this->db->query($sql);

		$this->db->bind(':login',$loginTime);
		$this->db->bind(':ip',$ip);
		$this->db->bind(':id',$id);

		return $this->db->execute();
	}

	public function rememberLogin($user_id){

		$token = new Token;
		$hash_token = $token->getHash();
		$this->remember_token = $token->getValue();
		$this->expiry = time() + 60 * 60 * 24 * 30;
		$expiry_mysql = date('Y-m-d H:i:s',$this->expiry);

		$sql = "INSERT INTO remember_session (hash_token,user_id,expires_at) VALUES (:hash,:user,:expiry);";

		$this->db->query($sql);

		$this->db->bind('hash',$hash_token);
		$this->db->bind('user',$user_id);
		$this->db->bind('expiry',$expiry_mysql);

		if ($this->db->execute()){
			return true;
		}else {
			return false;
		}
	}

	public function getSessionByToken($token){

		$token = new Token($token);
		$hash_token = $token->getHash();

		$sql = "SELECT * FROM remember_session WHERE hash_token = :token;";
		$this->db->query($sql);

		$this->db->bind(':token',$hash_token);

		return $this->db->singleResult();

	}

	public function deleteToken($remember_token){

		$token = new Token($remember_token);
		$hash_token = $token->getHash();

		$sql = "DELETE FROM remember_session WHERE hash_token = :token;";

		$this->db->query($sql);

		$this->db->bind(':token',$hash_token);

		if ($this->db->execute()){
			return true;
		}else {
			return false;
		}
	}

	public function setResetPassword($id){

		$token = new Token;
		$hash_token = $token->getHash();
		$this->reset_token = $token->getValue();

		$expiry = time() + 60 * 60 * 24 * 1;
		$expiry_mysql = date('Y-m-d H:i:s',$expiry);

		$sql = "UPDATE users SET  password_reset_token = :hash, password_reset_expiry = :expiry WHERE id = :id;";

		$this->db->query($sql);

		$this->db->bind('hash',$hash_token);
		$this->db->bind('id',$id);
		$this->db->bind('expiry',$expiry_mysql);

		return $this->db->execute();
	}

	public function getByHash($value){

		$token = new Token($value);
		$hash_token = $token->getHash();

		$sql = "SELECT * FROM users WHERE password_reset_token = :token;";
		$this->db->query($sql);

		$this->db->bind(':token',$hash_token);

		return $this->db->singleResult();
	}

	public function getByActiveHash($value){

		$token = new Token($value);
		$hash_token = $token->getHash();

		$sql = "SELECT * FROM users WHERE active_token = :token;";
		$this->db->query($sql);

		$this->db->bind(':token',$hash_token);

		return $this->db->singleResult();
	}

	public function resetPasswordByID($password,$id){

		$password = password_hash($password,PASSWORD_DEFAULT);

		$sql = "UPDATE users SET  password = :password, password_reset_token = null, password_reset_expiry = null WHERE id = :id;";

		$this->db->query($sql);

		$this->db->bind('password',$password);
		$this->db->bind('id',$id);

		return $this->db->execute();
	}

	public function activateAccount($value){

		$token = new Token($value);
		$hash_token = $token->getHash();

		$sql = "UPDATE users SET  active = 1, active_token = null WHERE active_token = :token;";

		$this->db->query($sql);

		$this->db->bind('token',$hash_token);

		return $this->db->execute();		
	}
}