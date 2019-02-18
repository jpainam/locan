<?php

class Request {

    private $input;

    public function __construct() {
        $this->input = new Security();
        $this->input->sanitize_globals();
        
        if (isset($_POST) && !empty($_POST)) {
            foreach ($_POST as $key => $post) {
                $this->{$key} = $this->input->post($key);
            }
        }
        if (isset($_GET) && !empty($_GET)) {
            foreach ($_GET as $key => $get) {
                $this->{$key} = $this->input->get($key);
            }
            
        }
        if(isset($_FILES) && !empty($_FILES)){
           
            foreach($_FILES as $key => $files){
                $this->{$key} = $this->input->file($key);
            }
        }
    }

}
