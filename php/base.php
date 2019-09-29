<?php

include_once 'utils.php';

class Base {
    public $id;
    
    public function __construct(array $attributes = []) {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }

        if (empty($this->db)) {
            $this->db = FALSE;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
}