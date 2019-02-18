<?php

class messageRappelModel extends Model{
    protected $_table = "messages_rappels";
    protected $_key = "IDMESSAGERAPPEL";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function selectAll() {
        $query = "SELECT mr.*, p.* "
                . "FROM `" . $this->_table."` mr "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = mr.REALISERPAR "
                . "ORDER BY DATERAPPEL DESC";
        return $this->query($query);
        
    }
    
}
