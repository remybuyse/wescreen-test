<?php

class WsController extends CommonController {
    public function __construct() {
        parent::__construct();
        header('Content-Type: application/json; charset=utf-8');
    }

    public function insertuserAction() {
        //On formate les données postées
        $postDatas = $this->formatPost($_POST);

        if(!$this->validMail($postDatas['email'])){
            //Erreur email
            echo $this->jsonize(array('errorMail' => _ERROR_EMAIL_BIS));
        }
        else{
        	//Infos
            $datas                  = array();                                              //Décla du tableau qui récupère les données
            $txt_ps                 = '';                                                   //Texte en PS sur certains emails
            $type                   = $postDatas['type'];                                   //Petition ou survey
            $abo_optin              = $postDatas['abo'];                                    //Abonnement optin pétition premium
            $page_perso             = $postDatas['pagePerso'];                              //Pétition avec page d'arrivée et mail perso
            $caritatif              = $postDatas['caritatif'];                              //Pétition premium
            $email                  = $this->charFormat($postDatas['email'], 'lower');      //Email
            $subscriptionForm       = $postDatas['subscriptionForm'];                       //1 = Vient du formulaire d'inscription
            $categorie_id           = $postDatas['catId'];

            //Récupération de l'id user en fonction de l'email
            $user = new Users();
            $userinfo = $user->checkUserByEmail($email);
            $iduser = $userinfo['id'];

            if(($iduser > 0)) {
            	//Il existe -> on récupère ses informations via la table mo_2user
                $recupuser = $user->getUser($iduser);

                switch($recupuser[0]['civilite']){
                    case 0 : $gender = 'Mr';
                    break;
                    case 1 : $gender = 'Mme';
                    break;
                    case 2 : $gender = 'Mlle';
                    break;
                }
                $name        = $recupuser[0]['nom'];
                $fname       = $recupuser[0]['prenom'];
                $address     = $recupuser[0]['adresse'];
                $city        = $recupuser[0]['ville'];
                $zipcode     = $recupuser[0]['cp'];
                $country     = $recupuser[0]['pays'];
                $pwd         = $recupuser[0]['mdp'];
                $idMbz       = $recupuser[0]['id_mindbaz'];
            }

        }
    }

    public function logoutAction(){
        unset($_SESSION['isLoggued']);
        unset($_SESSION['login']);
        unset($_SESSION['userPict']);
        unset($_SESSION['idUser']);
        unset($_SESSION['isAdmin']);
        echo $this->jsonize(array('response' => '/' . _URL_COMMUNITY . '/' . _URL_ACCOUNT));
    }
}