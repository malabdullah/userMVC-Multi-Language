<?php

namespace App\Core;

abstract class Model{
	
	protected $db;

	public function __construct(){

		$this->db = new Database;

	}	
}