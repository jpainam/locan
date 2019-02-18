<?php

class CompteModel extends Model {

    protected  $_table = "compte";
    protected  $_key = "IDCOMPTE";
            function __construct() {
        parent::__construct();
    }

    function modifPwd($idCompte) {
        
    }

    public function modifierTelephone($idCompte) {
        
    }

    /**
     * 
     * @param type $idCompte
     * @return enregistrement contenant les connexion du compte
     */
    public function showConnexions($idCompte) {
        return $this->query("SELECT * FROM connexions WHERE idCompte = :id", array('id' => $idCompte));
    }

}
