<?php

class messageTypeModel extends Model{
    protected $_table = "messages_types";
    protected $_key = "IDMESSAGETYPE";
    
    public function __construct() {
        parent::__construct();
    }
    /**
     * Obtient le message a envoye de la BD
     * @param type $type
     */
    public function getMessage($type = "0001") {
        $query = "SELECT * FROM messages_types WHERE TYPEMESSAGE = :type";
        return $this->row($query, ["type" => $type]);
    }
}
