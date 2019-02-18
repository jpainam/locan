<?php

class View {

    private $data = array();
    private $render = FALSE;

    public function __construct() {
        $this->data['site_title'] = '';
        $this->data['site_icon'] = '';
        $this->data['meta_description'] = '';
        $this->data['meta_keywords'] = '';
        $this->data['clientsjs'] = '';

        $this->data['css'] = '';
        $this->data['js'] = '';

        $this->data['header'] = '';
        $this->data['content'] = '';
        $this->data['footer'] = '';
    }

    public function output($params = null, $direct_output = FALSE) {
        if ($params != null) {
            $this->data = $params;
        }
        /**
         * Variable global defini dans Router
         */
        global $url;
        $urlArray = explode("/", $url);
        $controller = $urlArray[0];
        $action = $action = (isset($urlArray[1]) && $urlArray[1] != '') ? $urlArray[1] : DEFAULT_ACTION;
        $view = $controller . DS . $action;
        return $this->Render($view, $direct_output);
    }

    /**
     * 
     * @param type $variable
     * @param type $value
     * @param type $isStr si ce n'est que tu texte, alors appliquer 
     * le htmlentities
     */
    public function Assign($variable = '', $value = "") {

        if ($variable == '') {
            $this->data = $value;
        } else {
            $this->data[$variable] = $value;
        }
    }

    public function Render($view, $direct_output = TRUE) {
        if (substr($view, -4) == ".php") {
            $file = $view;
        } else {
            $file = ROOT . DS . 'views' . DS . strtolower($view) . '.php';
        }
        //echo $file;
        if (file_exists($file)) {
            $this->render = $file;
        } else {
            throw new Exception("Le fichier  $file contenant la vue n'existe pas.");
        }
        //Capturer toute la sortie

        if ($direct_output !== TRUE) {
            ob_start();
        }


        //Convertir les data variable en variable locale
        //$data = $this->data; //ou 
        //print_r($data);
        extract($this->data);

        //Obtenir le template
        include($this->render);


        //Obtenir le contenu du buffer et le retourner
        if ($direct_output !== TRUE) {
            return ob_get_clean();
        }
    }

    //public function 

    public function setSiteTitle($name) {
        $this->data['site_title'] = '' . $name . '';
    }

    public function setSiteIcon($filename) {
        if (file_exists(SITE_ROOT . $filename)) {
            $this->data['site_icon'] = '	<link href = "' . SITE_ROOT . DS .
                    $filename . '" rel = "shortcut icon" type = "image/vnd.microsoft.icon" />';
        }
    }

    public function clientsJS($name) {
        if (file_exists(ROOT . DS . "views" . DS . strtolower($name) . ".js")) {
            $entree = file_get_contents(ROOT . DS . 'views' . DS . strtolower($name) . '.js');
            $filename = ROOT . DS . "public" . DS . "js" . DS . "clients.js";
            //si la variable est vide, vider le contenu du fichier clients.js
            if (empty($this->data['clientsjs'])) {
                fopen($filename, "w");
            }
            if (file_put_contents($filename, $entree, FILE_APPEND)) {
                $this->data['clientsjs'] = "<script type='text/javascript' src='". SITE_ROOT . "public/js/clients.js'></script>";
            } else {
                die("Impossible de copier les fichier $name.js et clients.js dans public");
            }
        } else {
            die("Fichier javascript " . ROOT . DS . 'views' . DS . $name . ".js inexistante");
        }
    }

    public function setMetaKeywords($words) {
        $this->data['meta_keywords'] = '<meta name = "keywords" content = "' . $words . '" />';
    }

    public function setMetaDescription($desc) {
        $this->data['meta_description'] = '<meta name = "description" 
		content = "' . $desc . '" />';
    }

    public function setCSS($filename) {

        if (file_exists(ROOT . DS . $filename)) {
            global $css;
            $css .= "<link href = '" . SITE_ROOT . '/' . str_replace('\\', '/', $filename) . "' rel = 'stylesheet' type = 'text/css' />";

            $this->data['css'] .= $css;
            //print $this->data['css'];
        } else {
            throw new Exception($filename . " CSS n'existe pas");
        }
    }

    public function setJS($filename) {

        $this->data['js'] = $this->data['js'] . '<script type = "text/javascript" 
		src = "' . $filename . '" language = "JavaScript"></script>' . PHP_EOL;
    }

    public function setTextJS($js = "") {
        global $_JS;
        $_JS .= PHP_EOL . $js;
        //$this->data['_JS'] .= $_JS;
    }

}
