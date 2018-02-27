<?php

namespace App\Controllers;

class Emails extends \App\Core\Controller {

	public function activate(){

		$this->view('email/activate');
	}

	public function reset(){

		$this->view('email/reset');
	}

}