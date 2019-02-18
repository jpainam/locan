<?php

class jpgraphController extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $view = new View();
        $this->loadJPGraph();
        $content = $view->Render("jpgraph" . DS . "index", false);
        $this->Assign("content", $content);
    }
}
