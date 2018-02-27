<?php

namespace App\Models;

class Language extends \App\Core\Model{

    public function getAll(){

        $sql = 'SELECT * FROM lang;';
        $this->db->query($sql);

        return $this->db->multiResult();
    }
}