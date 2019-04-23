<?php

class locanController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $view = new View();
        $content = $view->Render("locan" . DS . "index", false);
        $this->Assign("content", $content);
    }
}
