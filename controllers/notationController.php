<?php

class notationController extends Controller{
    public function __construct() {
        parent::__construct();
    }
    
    public function delete($id){
        $this->Notation->delete($id);
        # Rediriger vers la liste des notes 
        header("Location:". Router::url("note"));
    }
}
