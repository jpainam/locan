<?php

class userModel extends Model{
  
    protected $_table = "users";
    protected  $_key = "IDUSER";
    public function __construct() {
        parent::__construct();
    }
    
    public function mesConnexions($compte){
        $query = "SELECT * FROM connexions WHERE COMPTE = :compte ORDER BY IDCONNEXION DESC";
        return $this->query($query, ["compte" => $compte]);
    }
       
    public function selectAll() {
        $query = "SELECT u.*, p.*, pp.* "
                . "FROM users u "
                . "LEFT JOIN profile p ON p.IDPROFILE = u.PROFILE "
                . "LEFT JOIN personnels pp ON pp.USER = u.IDUSER "
                . "ORDER BY u.LOGIN";
        return $this->query($query);
    }
    /**
     * Liste des personnels ne disponsant pas d'iduser
     * utiliser lors de la saisie d'un nouvel utilisateur,
     * proposer uniquement les personnels non liee a un utilisateur
     */
    public function getFreePersonnels(){
        $query = "SELECT * FROM personnels WHERE "
                . "NOT EXISTS (SELECT * FROM users WHERE "
                . "users.IDUSER = personnels.USER) "
                . "ORDER BY personnels.NOM";
        
        return $this->query($query);
    }
    /**
     * Utiliser pour obtenir la liste des utilisateur de ce profile,
     * utiliser dans user/profile
     * @param type $idprofile
     */
    public function findByProfile($idprofile){
        $query = "SELECT u.*, p.* "
                . "FROM users u "
                . "INNER JOIN personnels p ON p.USER = u.IDUSER "
                . "WHERE u.PROFILE = :idprofile "
                . "ORDER BY u.LOGIN";
        return $this->query($query, ["idprofile" => $idprofile]);
}
}
