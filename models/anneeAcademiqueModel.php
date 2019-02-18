<?php
class anneeAcademiqueModel extends Model{
    protected $_table = 'anneeacademique';
    protected $_key = 'ANNEEACADEMIQUE';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "ANNEEACADEMIQUE";
    }
    /**
     * Selectionner les periode non verrouiller
     * 1 = verrouiller et 0 = non verrouiller
     * @return type
     */
    public function selectAll() {
        $query = "SELECT * FROM `" . $this->_table ."` "
                . "WHERE VERROUILLER = 0";
        return $this->query($query);
    }
    /**
     * Retourne un resultset contenant la contenation des periode sequences 
     * et periode trimestrielle, premierement utiliser dans bulletin/impression accessible dans la 
     * rubrique bulletins et note sous le libelle de impression de bulletins
     * @param type $anneecademique
     */
    public function getPeriodes($anneecademique){
        $query = "SELECT CONCAT('S', '_', s.IDSEQUENCE) AS IDPERIODE, s.LIBELLE AS LIBELLE "
                . "FROM sequences s "
                . "INNER JOIN trimestres t ON t.IDTRIMESTRE = s.TRIMESTRE AND t.PERIODE = :anneeacad1 "
                . "UNION "
                . "SELECT CONCAT('T', '_', t.IDTRIMESTRE) AS IDPERIODE, t.LIBELLE AS LIBELLE "
                . "FROM trimestres t "
                . "WHERE t.PERIODE = :anneeacad2 "
                . "UNION "
                . "SELECT CONCAT('A', '_', a.ANNEEACADEMIQUE) AS IDPERIODE, 'Annuelle' AS LIBELLE "
                . "FROM anneeacademique a "
                . "WHERE a.ANNEEACADEMIQUE = :anneeacad3";
        
        return $this->query($query, ['anneeacad1' => $anneecademique, 'anneeacad2' => $anneecademique, 
            "anneeacad3" => $anneecademique]);
        
    }
    
    
}
