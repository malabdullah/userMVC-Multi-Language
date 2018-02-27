<?php

namespace App\Controllers;

class NotFound extends \App\Core\Controller {

	public function index(){

		$this->view('404/index');
	}
}