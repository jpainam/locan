<?php

# Restriction des matieres pour lesquelle il enseigne
# Droit 531

class matiereModel extends Model {

    protected $_table = "matieres";
    protected $_key = "IDMATIERE";

    public function __construct() {
        parent::__construct();
    }

    public function selectAll() {
        if (isAuth(531)) {
        $query = "SELECT * FROM matieres ORDER BY LIBELLE";
        return $this->query($query);
        }else{
            $query = "SELECT DISTINCT(m.IDMATIERE), m.* "
                    . "FROM `" . $this->_table ."` m "
                    . "INNER JOIN enseignements ens ON ens.MATIERE = m.IDMATIERE "
                    . "INNER JOIN personnels p ON p.IDPERSONNEL = ens.PROFESSEUR AND p.USER = :restriction "
                    . "ORDER BY LIBELLE";
            return $this->query($query, ["restriction" => $_SESSION['iduser']]);
    }
    }

    public function getLibelle() {
        return "LIBELLE";
    }
   
}
