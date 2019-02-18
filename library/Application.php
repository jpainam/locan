<?php

class Application {

    /**
     * utiliser pour sercuriser les input et les output
     * Plus precisement les GET, POST, COOKIE
     * @var type Input
     */
    protected $request;
    protected $menus;
    protected $session;
    protected $input;
    protected $pdf = null;
    protected $excel = null;
    protected $sms;

    function __construct() {
        #header('Content-Type: text/html; charset="utf-8"');
        $this->set_reporting();
        $this->remove_magic_quotes();
        $this->unregister_globals();

        $this->request = new Request();
        $this->input = new Security();
        $this->session = new Session();

        /*
         * GERER LA REDIRECTION SI L'UTILISATEUR N'EST PAS AUTHENTIFIER
         */
        global $url; //$url est une variable globale defini dans Router.php
        $urlArray = explode("/", $url);
        /**
         * $urlArray[0] = Controller
         * $urlArray[1] = Action
         * $urlArray[2...n] = Arguments
         */
        foreach ($_SESSION as $key => $val) {
            $this->session->{$key} = $this->input->session($key);
        }

        $this->resetTimeOut();

        $action = (isset($urlArray[1]) && $urlArray[1] != '') ? $urlArray[1] : DEFAULT_ACTION;
        /*
         * Pour eviter une redirection qui n'aboutira, 
         * On redirige seulement si nous ne sommes pas a la page de connexion
         * 
         */
        if (!$this->connected() && $urlArray[0] != 'connexion') {
            header("Location:" . url('connexion'));
        } elseif ($this->connected() && $urlArray[0] == 'connexion') {
            //Si je clique sur deconnect et que je suis dans le controller connexion
            //deja gerer par le constructeur de connexionController
        }
        if ($this->connected()) {
            $this->menus = new Menus();
        }
        
    }

    private function set_reporting() {
        if (DEVELOPMENT_ENVIRONMENT == true) {
            error_reporting(E_ALL);
            # error_reporting(E_ERROR | E_PARSE);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            #error_reporting(E_ERROR | E_PARSE);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
        }
    }

    private function strip_slashes_deep($value) {
        $value = is_array($value) ? array_map(array($this, 'strip_slashes_deep'), $value) : stripslashes($value);
        return $value;
    }

    private function remove_magic_quotes() {
        if (get_magic_quotes_gpc()) {
            $_GET = $this->strip_slashes_deep($_GET);
            $_POST = $this->strip_slashes_deep($_POST);
            $_COOKIE = $this->strip_slashes_deep($_COOKIE);
        }
    }

    private function unregister_globals() {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    /**
     * Renvoi vrai ou faux si l'utilisateur est connected
     * S'il connected === false, alors diriger vers la page
     * d'authentification
     */
    private function connected() {
        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * remet a jour le compteur de l'expiration de session
     */
    private function resetTimeOut() {
        if ($this->connected()) {
            if ($this->session->timeout > time()) {
                //lui accorder 10 minute de plus
                $_SESSION['timeout'] = time() + TIME_OUT; //TIME_OUT Defini dans public/index.php
            } else {
                //il a deborder ces 10 minute de grave sans activite, le deconected
                //unset($_SESSION['user']);
                header("Location:" . Router::url("connexion", "disconnect"));
            }
        }
    }

    /**
     * Activer les capacites a supporter le SMS
     */
    protected function activateSMS() {
        $this->sms = new SMS();
        # Retourne true ou false si l'initialisation du modem a reussi
        return $this->sms->init();
    }

    protected function send($tel, $message) {
        return $this->sms->send($tel, $message);
    }

    /**
     * @see SMS#personnalize
     */
    public function personnalize($params = array(), $message = "") {
        return $this->sms->personnalize($params, $message);
    }

}
