<?php

class AboutController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $this->Assign("content", (new View())->output(
                        array("title" => "A Propos", "body" => "Une page About"), false
                )
        );
    }

}

