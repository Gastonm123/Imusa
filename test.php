<?php

class asd{
	protected $a = 'a';
	public $b = 'b';
}

class jo extends asd {

}

function de (asd $a) {
	return $a;
}
$test = new jo;

de($test);

$conn = new mysqli('localhost', 'poli_siete', 'poli7', 'poli_siete');

$result = $conn->query("SELECT LAST_INSERT_ID()");

var_dump($result->fetch_assoc());
