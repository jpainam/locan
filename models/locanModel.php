<?php
class locanModel extends Model{
    protected  $_table = 'locan';
    protected $_key = "ID";
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * $params = ["identifiant" => $this->request->identifiant,
                "nom" => $this->request->nom,
                "adresse" => $this->request->adresse,
                "bp" => $this->request->bp,
                "tel1" => $this->request->tel1,
                "tel2" => $this->request->tel2,
                "mobile" => $this->request->mobile,
                "fax" => $this->request->fax,
                "email" => $this->request->email,
                "siteweb" => $this->request->siteweb,
                "responsable" => $this->request->responsable,
                "logo" => $logo
            ];
     */
    public function insert($params = array()){
        $query = "INSERT INTO locan(ID, NOM, RESPONSABLE, ADRESSE, "
                . "BP, TELEPHONE, TELEPHONE2, MOBILE, FAX, EMAIL, "
                . "SITEWEB, LOGO) "
                . "VALUES(:identifiant, :nom, :responsable, :adresse, :bp, :tel1, "
                . ":tel2, :mobile, :fax, :email, :siteweb, :logo)";
        return $this->query($query, $params);
    }
    
    
    
}
