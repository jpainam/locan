<?php

class parametreController extends Controller{
    public function __construct() {
        parent::__construct();
        $this->loadModel("user");
    }
    
    public function mdp(){
        
        if(!empty($this->request->pwd) && !empty($this->request->comboUtilisateurs)){
            $mdpcrypte = md5($this->request->pwd);
            $this->User->update(["PASSWORD" => $mdpcrypte], ["IDUSER" => $this->request->comboUtilisateurs]);
            header("Location:" . Router::url("user", "droit"));
        }
        $this->view->clientsJS("parametre" . DS . "mdp");
        $view = new View();
        $users = $this->User->selectAll();
        $comboUtilsateurs = new Combobox($users, "comboUtilisateurs", "IDUSER", "LOGIN");
        $comboUtilsateurs->first = " ";
        
        $view->Assign("comboUtilisateurs", $comboUtilsateurs->view());
        $content = $view->Render("parametre" . DS . "mdp", false);
        $this->Assign("content", $content);
    }
}
