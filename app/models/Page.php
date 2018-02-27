<?php 

namespace App\Models;

class Page extends \App\Core\Model {

	protected $id;
	protected $name;
	protected $content;
	protected $title;

	public function addPage(array $data){
		
		$this->db->query('INSERT INTO pages (name,content,title) VALUES (:name,:content,:title)');
		$this->db->bind(':name',$data['name']);
		$this->db->bind(':content',$data['content']);
		$this->db->bind(':title',$data['title']);
		return $this->db->execute();
	}

	public function showPages(){

		$this->db->query('SELECT * FROM pages');
		return $this->db->multiResult();
	}

	public function showPage($id){

		$this->db->query('SELECT * FROM pages WHERE id=:id');
		$this->db->bind(':id',$id);
		return $this->db->singleResult();
	}
	
}