<?php

/**
 * Classe Enveloppe de la classe GSM
 */
class SMS {

    /**
     *
     * @var GSM variable de type GSM @see GSM
     */
    private $gsm = null;
    private $mtn = null;

    /**
     * 
     */
    public function __construct() {
        
    }

    public function init() {
        $this->gsm = GSMOrange::getInstance();
        $this->mtn = GSMMTN::getInstance();

        if (!$this->gsm->fp && !$this->mtn->fp) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Identique a la methode send defini dans GSM, sauf que ce dernier met deja en oeuvre
     * le try en catch afin de les eviter dans les controller
     * @param type $tel
     * @param type $message
     */
    public function send($tel, $message) {
        #mettre le message en Majuscule
        $message = strtoupper($message);

        #Limiter le text a 160 caracteres, quand ca deborde, il n'envoi pas
        #$message = substr($message, 0, 158);
        try {
            if (is_array($tel)) {
                return $this->envoiMultiple($tel, $message);
            }
            # Si le numero commence par 69, 655 = Orange
            elseif (preg_match("(^69|^655)", $tel)) {
                return $this->gsm->send($tel, $message);
            } elseif (preg_match("(^67|^65|^68)", $tel)) {
                return $this->mtn->send($tel, $message);
            }
        } catch (Exception $e) {
            if ($this->gsm->debug || $this->mtn->debug) {
                echo $e->getMessage();
            }
            return false;
        }
    }

    private function envoiMultiple($tels, $message) {
        $retVal = false;
        foreach ($tels as $tel) { 
            $retVal = $this->send($tel, $message);
            sleep(4);
        }
        return $retVal;
    }

    /**
     * Cette function personnalise le SMS, pour cela, laisser les champs a personnaliser 
     * avec les #content, inspirer de la methode bind de PDO
     * @param associative array $params ou les clef sont les valeur contenu dans le message 
     * et les value les valeur a inserer dans le message en lieu et place de ces code
     * @param $message message qu'il faut personaliser
     * @return string Le message personnalise
     */
    public function personnalize($params = array(), $message = "") {
        return str_replace(array_keys($params), array_values($params), $message);
    }

}
