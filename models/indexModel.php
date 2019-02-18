<?php
class IndexModel extends Model{
	function __construct(){
		parent::__construct();
	}
	
	public function Add($var1, $var2){
		return $var1 + $var2;
	}
	
	public function Sub($var1, $var2){
		return $var1 - $var2;
	}
	
        
}
