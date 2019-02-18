<?php
/*GESTION DES DROIT D'access chez user
        public function validateDroits() {
        //Parcourir les profils, et mettre a jour leur droits respectifs
        $profiles = $this->Profile->selectAll();
        $this->loadModel("profile");
        foreach ($profiles as $profile) {
            if (isset($_POST[$profile['IDPROFILE']]) && !empty($_POST[$profile['IDPROFILE']])) {
                $this->Profile->update(["LISTEDROIT" => json_encode($_POST[$profile['IDPROFILE']])], ["IDPROFILE" => $profile['IDPROFILE']]);
                //Copier les valeurs dans les droits specifique, obtenir d'abord tous les user
                //ayant ce profil
                $users = $this->User->findBy(["PROFILE" => $profile['IDPROFILE']]);
                foreach ($users as $user) {
                    
                    $specifiques = json_decode($user['DROITSPECIFIQUE']);
                    $specifiques = is_null($specifiques) ? array() : $specifiques;
                    
                    $droitspecifique = array_merge($specifiques, $_POST[$profile['IDPROFILE']]);
                    
                    //Enlever les valeurs dupliquees
                    $droitspecifique = array_unique($droitspecifique);
                    //Inserer dans la BD
                    $this->User->update(["DROITSPECIFIQUE" => json_encode($droitspecifique)], ["IDUSER" => $user['IDUSER']]);
                }
            }
        }
    }

    public function droits() {
        $view = new View();
        $view->Assign("errors", false);
        $this->loadModel("profile");
        $this->loadModel("droit");
        $profiles = $this->Profile->selectAll();

        //validation du formulaire
        if (isset($this->request->soumis)) {
            $this->validateDroits();
            header("Location" . Router::url("user", "droits"));
        }
        $listedroits = array();
        foreach ($profiles as $profile) {
            $listedroits[$profile['IDPROFILE']] = json_decode($this->Profile->getDroits($profile['IDPROFILE']));
        }
        $view->Assign("listedroits", $listedroits);
        $droits = $this->Droit->selectAll();
        $view->Assign("total", count($droits));
        $view->Assign("droits", $droits);
        $view->Assign("profiles", $profiles);

        $content = $view->Render("user" . DS . "droits", false);
        $this->Assign("content", $content);
    }*/