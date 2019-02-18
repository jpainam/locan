<?php

class Menus extends Database {

    public function __construct() {
        $this->setDroits();
        parent::__construct();
    }

    /**
     * Obtenir la liste des droits de l'utilisateur connected
     * En fonction de son profil
     * Sa liste des droits = a la liste des droit du groupe 
     * auquel il fait parti + ses droit specifiq
     */
    public function setDroits() {
        //if (!isset($_SESSION['droits']) || empty($_SESSION['droits'])) {
            $user = $_SESSION['user'];
            $query = "SELECT DROITSPECIFIQUE, ETATMENU FROM users WHERE LOGIN = :login";
            $res = $this->row($query, ["login" => $user]);
            $_SESSION['droits'] = json_decode($res["DROITSPECIFIQUE"]);
            $_SESSION['etatmenu'] = $res["ETATMENU"];
            
       // }
    }

    public function getMenus() {
        $droits = implode(",", $_SESSION['droits']);
        /*$droits = str_replace("\\", "", $droits);
        $droits = str_replace("\"", "'", $droits);
        $droits = substr($droits, 0, strlen($droits) - 1);
        $droits = substr($droits, - strlen($droits) + 1);*/
        $men = json_encode(str_split($_SESSION['etatmenu']));
        $men = str_replace("\"", "'", $men);
        $c = 0;
   
        $groupes = $this->query(" SELECT g.* FROM groupemenus g "
                               ." WHERE ( SELECT COUNT(m.IDMENUS) FROM menus m WHERE m.CODEDROIT IN ($droits)) > 0 "
                               ." ORDER BY IDGROUPE ASC");
        $str = "<ul id='menu-accordeon'>";
        foreach ($groupes as $groupe) {
            $c++;
            $query = "SELECT m.* FROM menus m "
                    . "WHERE m.CODEDROIT IN ($droits) " 
                    . "AND m.IDGROUPE = :groupe AND m.VERROUILLER = 0";
            $menus = $this->query($query, ["groupe" => $groupe['IDGROUPE']]);
            if (count($menus) > 0) {
                $str .= "<li class='ent-menu'><div onclick=\"javascript:clickMenu(this,$c,".$groupe['IDGROUPE'].",'".$_SESSION['user']."'); \" ><img class='img1' onload=\"javascript: loaded(".$men.", ".$groupe['IDGROUPE'].",this);\" src = '" . SITE_ROOT . "public/img/" . $groupe['ICON'] . "' alt = '" . $groupe['ALT'] . "' title = '" . $groupe['TITLE'] . "'/>"
                        . "<span>" . $groupe['LIBELLE'] . "</span><img class='img2' src = '" . SITE_ROOT . "public/images/sort_asc_disabled.png'/></div><ul>";
            }
            foreach ($menus as $menu) {
                $str .= "<li class='ent-lien'><a href = '" . SITE_ROOT . $menu['HREF'] . "'><img src ='" . SITE_ROOT . "public/img/icons/" . $menu['ICON'] . "' alt ='" . $menu['ALT'] . "' title = '" . $menu['TITLE'] . "' />"
                        . "<span>" . $menu['LIBELLE'] . "</span></a></li>";
            }
            if (count($menus) > 0) {
                $str .= "</ul></li>";
            }
        }
        $str .= "</ul>";
        return $str;
    }

    
   
}
