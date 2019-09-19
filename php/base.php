<?php

abstract class Base {
    protected $id;
    
    public function __construct(array $attributes = []) {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getId() {
        return $this->id;
    }
}