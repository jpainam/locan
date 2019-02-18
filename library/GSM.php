<?php
/**
 * SMS via GSM Modem - Une classe PHP  charger d'envoyer des messages SMS 
 * via un modem GSM connecter a une machine sur le port serie. La plupart des nouvelle utilise 
 * des ports serie virtuel, cela marche aussi avec ca
 */
abstract class GSM {

    /**
     * Port serie COM valeur par defaut COM2
     * @var string $port
     */
    protected $port = 'COM3';

    /**
     * Ouvrir le port en mode lecture et ecriture binaire
     * parametre utiliser dans la fonction fopen()
     * @var string mode
     */
    public $mode = 'r+b';

    /**
     *
     * @var int baud rate valeur par defaut 9600
     */
    public $baud = 9600;

    /**
     *  activer le debuggage, autorise l'affichage des message d'erreur
     * valeur par defaut false
     * @var boolean $debug
     */
    public $debug = false;

    /**
     * descripteur du fichier COM ouvert par la methode fopen
     * @var stream $fp
     */
    public $fp;

    /**
     * Stocker le message lu avec fread
     * @var string $buffer
     */
    public $buffer;

    /**
     * Constructeur defini avec le mot clef protected afin d'empecher 
     * toute instanciation (avec le mot clef new) de la classe hors de la classe 
     * elle meme
     */
    protected function __construct() {
        # Avant de faire quoi ce soit, definir la methode a appeler
        # en case d'arret d'execution
        register_shutdown_function(array($this, "close"));
        try {
            # Initialiser les attributs de la classe
            $this->init();
        } catch (Exception $e) {
            if($this->debug){
                echo $e->getMessage();
            }
        }

        # Definir les operations de lecture comme non bloquante
        if ($this->fp !== null) {
            stream_set_blocking($this->fp, 0);
        }
    }

    

    /**
     * Defini les parametre de communication avec le modem
     * @return boolean true si tout va bien, false si une erreur s'est produite
     */
    private function init() {
        $output = array();
        $retval = 0;
        $this->debugmsg("Parametrage du port: \"{$this->port} @ \"{$this->baud}\" baud");

        # $val = exec("MODE {$this->port}: BAUD={$this->baud} PARITY=N DATA=8 STOP=1", $output, $retval); 
        $val = exec("mode " . $this->port . ": BAUD=9600 xon=on", $output, $retval);

        # Si une erreur s'est produite
        if ($retval != 0) {
            throw new Exception('Impossible de parametrer COM port, Verifier la disponibilite du port');
        }

        $this->debugmsg(implode("\n", $output));

        $this->debugmsg("Ouverture port avec valeur de retour " . $val . "<br/>" . $retval);

        # Ouverture du port COM suivant le mode r+b
        $this->fp = fopen($this->port . ':', $this->mode);

        # Verifier si l'ouverture du port a marche
        if (!$this->fp) {
            throw new Exception("Impossible d'ouvrir le port \"{$this->port}\"");
        }

        $this->debugmsg("Port ouvert");
        $this->debugmsg("Verifier l'accessibilite et reponse du modem");

        # Doit renvoyer OK
        fwrite($this->fp, "AT\r");
        sleep(1);

        /* Les lectures ne marche pas encore 
          # Attente d'une reponse de la part du modem
          $status = $this->wait_reply("OK\r\n", 5);

          if (!$status) {
          throw new Exception('Aucune reponse de la part du modem');
          }
         */
        $this->debugmsg('Modem connecter');

        # Definir le mode text pour l'envoi des SMS
        $this->debugmsg('Definition du mode text');
        fwrite($this->fp, "AT+CMGF=1\r");

        /**
          # Attente d'une reponse de la part du modem lors de la definition du mode text
          $status = $this->wait_reply("OK\r\n", 5);

          if (!$status) {
          throw new Exception('Impossible de definir le mode text');
          }
         */
        $this->debugmsg('Mode text defini');
    }

    /**
     * Attente d'une reponse de la part du modem
     */
    public function wait_reply($expected_result, $timeout) {

        if(!$this->fp){
            return false;
        }
        
        $this->debugmsg("Attente {$timeout} seconds");

        # Vider la variable buffer
        $this->buffer = '';

        # Definir le delai d'attente
        $timeoutat = time() + $timeout;

        # Boucle tant que le temps est inferieur au delai ou que 
        # aucune reponse n'est recue
        do {

            $this->debugmsg('Now: ' . time() . ", Timeout at: {$timeoutat}");

            $buffer = fread($this->fp, 1024);
            $this->buffer .= $buffer;

            usleep(200000); //0.2 sec

            $this->debugmsg("Received: {$buffer}");

            # Verifier si le modem a donnee la reponse attendu
            if (preg_match('/' . preg_quote($expected_result, '/') . '$/', $this->buffer)) {
                $this->debugmsg('match trouvee');
                return true;
            } else if (preg_match('/\+CMS ERROR\:\ \d{1,3}\r\n$/', $this->buffer)) {
                return false;
            }
        } while ($timeoutat > time());

        $this->debugmsg('Delai depassee');

        return false;
    }

    /**
     * Permet l'affichage des message d'erreur, utilise l'attribut debug a true pour proceder
     * au debuggage
     */
    public function debugmsg($message) {

        if ($this->debug == true) {
            $message = preg_replace("%[^\040-\176\n\t]%", '', $message);
            echo "<br/>" . $message . "\n<br/>";
        }
    }

    /**
     * Fermeture du port COM precedemment ouvert avec fopen
     */
    public function close() {

        $this->debugmsg('Fermeture du port');
        if ($this->fp !== null) {
            fclose($this->fp);
        }
    }

    /**
     * Envoi le message passee en second argument au numero de telephone passe en 1 argument
     * @param string $tel le numero de destinataire
     * @param string $message le contenu du message a envoyee
     * @return boolean
     */
    public function send($tel, $message) {
        if(!$this->fp){
            return false;
        }
        # Filtrer le numero du tel
        $tel = preg_replace("%[^0-9\+]%", '', $tel);

        # Filtrer le message 
        $message = preg_replace("%[^\033-\176\r\n\t]%", '', $message);

        $this->debugmsg("Envoi du message \"{$message}\" au \"{$tel}\"");

        # Stockage du numero de telephone 
        fwrite($this->fp, "AT+CMGS=\"$tel\"\r");
        sleep(1);
        /**
          # Attente d'une confirmation
          $status = $this->wait_reply("\r\n> ", 5);

          if (!$status) {
          throw new Exception('Aucune reponse de confirmation recu du modem');
          $this->debugmsg('Aucune reponse de confirmation recu du modem');
          return false;
          }
         */
        # Envoi du message text
        fwrite($this->fp, $message);
        sleep(1);
        # Indication de termination equivaut a ctrl+z pour declencher l'envoi
        fwrite($this->fp, chr(26));
         
        /**
          # Wait for confirmation
          $status = $this->wait_reply("OK\r\n", 180);

          if (!$status) {
          throw new Exception('Aucune reponse de confirmation de la part du modem');
          $this->debugmsg('Aucune reponse de confirmation de la part du modem');
          return false;
          }
         */
        $this->debugmsg("Message envoye");

        return true;
    }
    /**
     * obtenir le descripteur du ficher, attribut fp
     * @return descripteur
     */
    public function getFP(){
        return $this->fp;
    }
}
