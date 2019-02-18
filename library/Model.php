<?php
/**
 * Le modele du dit controller est charger automatiquement 
 * et disponible par la variable $this->model
 * Les autres modeles peuvent etre charger en utilisant la methode 
 * loadModel($model) de la classe Controller qui charge le $model dans un tableau 
 * associant ou le $model est la cle
 */
class Model extends Database {

    protected $_table = "";
    protected $_key = "";

    public function __construct() {
        parent::__construct();
    }
    /**
     * Obtenir l'information en fonction de l'id de la table
     * un cas particulier de findsingle row by id
     * @param type $id
     * @return type
     */
    public function get($id){
        $params = [$this->_key => $id];
        return $this->findSingleRowBy($params);
    }


    public function getKey(){
        return $this->_key;
    }

    /**
     * Effectue la suppression
     * @param type $id
     * @return type le nombre de ligne affectee par la suppression
     */
    public function delete($id) {
        $query = "DELETE FROM `" . $this->_table . "` WHERE " . $this->_key . " = :id";
        $this->bind("id", $id);
        $result = $this->query($query);
        return ($result != 0);
    }

    /**
     * 
     * @return faux si aucun enregistrement
     * sinon retourne l'enregistrement sous forme de tableau associatif
     */
    public function selectAll() {
        $query = "SELECT * FROM `" . $this->_table . "` ORDER BY ".$this->_key;
        $res = $this->query($query);
        if (empty($res)) {
            return false;
        }
        return $res;
    }

    public function insertAll($params = array()) {
        $str = "";
        foreach ($params as $key => $val) {
            $str .= ":$key,";
        }
        $str = substr($str, 0, strlen($str) - 1);
        $query = "INSERT INTO `" . $this->_table . "` VALUES ($str)";

        return $this->query($query, $params);
    }

    public function update($params = array(), $keys = array()) {

        $str = "";
        foreach ($params as $key => $param) {
            $str .= " $key = :$key,";
        }
        $str = substr($str, 0, strlen($str) - 1);
        $condition = "";
        if (empty($keys)) {
            $condition = "1=1";
        }
        foreach ($keys as $key => $val) {
            $condition .= " $key = :$key AND ";
        }
        $condition = substr($condition, 0, strlen($condition) - 4);
        $query = "UPDATE `" . $this->_table . "` SET $str  WHERE $condition";
        return $this->query($query, array_merge($params, $keys));
    }

    /**
     * Function permettant l'insertion d'une maniere generique
     * @param type $params
     * @return type
     */
    public function insert($params = array()) {
        $str = "";
        $val = "";
        foreach ($params as $key => $param) {
            $str .= " " . strtoupper($key) . ",";
            $val .= ":$key,";
        }
        $str = substr($str, 0, strlen($str) - 1);
        $val = substr($val, 0, strlen($val) - 1);
        $query = "INSERT INTO  $this->_table($str) VALUES($val)";
        return $this->query($query, $params);
    }

    /*public function get($id) {
        return $this->query("SELECT * FROM `" . $this->_table . "` "
                        . " WHERE `" . $this->_key . "` = :id", array("id" => $id));
    }*/

    public function findBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT * FROM `" . $this->_table . "` WHERE $str";

        return $this->query($query, $params);
    }
    
    public function deleteBy($conditions = array()){
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "DELETE FROM `" . $this->_table . "` WHERE $str";

        return $this->query($query, $params);
    }

    /*
     * Retourne une et une seule ligne de la table
     */

    public function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT * FROM `" . $this->_table . "` WHERE $str";
        return $this->row($query, $params);
    }
    
    public function getBy($conditions = array()){
        return $this->findSingleRowBy($conditions);
    }

    public function updateBy($id, $params = array()) {
        $str = "";
        foreach ($params as $key => $param) {
            $str .= " SET $key = :$key ,";
        }
        $str = substr($str, 0, strlen($str) - 1);
        $params = array_merge($params, array("key" => $id));
        $query = "UPDATE `" . $this->_table . "` $str WHERE `" . $this->_key . "` = :key";

        return $this->query($query, $params);
    }

}
