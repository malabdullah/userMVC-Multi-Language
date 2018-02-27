<?php

namespace App\Controllers;

class Pages extends \App\Core\Controller {

	public function index(){

		$this->view('page/index');
	}

}