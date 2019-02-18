<?php

class connexionModel extends Model {

    protected $_table = "connexions";
    protected $_key = "IDCONNEXION";

    public function __construct() {
        parent::__construct();
    }

    public function authenticate($login, $pwd) {
        $query = "SELECT u.*, p.PROFILE AS FK_PROFILE, p.IDPROFILE AS IDPROFILE FROM users u "
                . "LEFT JOIN profile p ON u.PROFILE = p.IDPROFILE "
                . "WHERE u.LOGIN = :login AND u.PASSWORD = :pwd";
        $res = $this->row($query, array("login" => $login,
            "pwd" => $pwd));
        
        if(is_array($res)){
            $val = count($res);
            $_SESSION['profile'] = $res['FK_PROFILE'];
            $_SESSION['idprofile'] = $res['IDPROFILE'];
            $_SESSION['iduser'] = $res['IDUSER'];
            return ($val != 0);
        }else{
            return $res;
        }
    }

    public function saveConnexion($con) {
        $query = "INSERT INTO connexions(COMPTE, DATEDEBUT, "
                . "MACHINESOURCE, IPSOURCE, CONNEXION, DATEFIN, DECONNEXION) "
                . "VALUE(:compte, :datedebut, :machine, :ip, :connexion, :datefin, :deconnexion)";
        $params = ['compte' => $con->compte,
            "datedebut" => $con->datedebut,
            "machine" => $con->machine,
            "ip" => $con->ipsource,
            "connexion" => $con->connexion,
            "datefin" => $con->datefin,
            "deconnexion" => $con->deconnexion
        ];
        /** Activer le verrouillage de la table du a l'obtention du lastinserId */
        //$this->query("LOCK TABLES connexions WRITE");
        $this->query($query, $params);
        $_SESSION['idconnexion'] = $this->lastInsertId();
        /** Terminer le verrouillage de la table connexion */
        //$this->query("UNLOCK TABLES");
    }

    /**
     * 
     * @param type $idconnexion
     * @param type $datefin
     * @param type $deconnexion message de deconnexion
     */
    public function updateConnexion($idconnexion, $connexion, $datefin, $deconnexion) {
        $query = "UPDATE connexions SET CONNEXION = :connexion, DATEFIN = :datefin, DECONNEXION = :deconnexion "
                . "WHERE IDCONNEXION = :id";
        $params = ["connexion" => $connexion,
            "datefin" => $datefin,
            "deconnexion" => $deconnexion,
            "id" => $idconnexion];

        return $this->query($query, $params);
    }

}
