<?php
/**
 *
 * Controller qui va gérer tout le compte auteur
 * @author Florent
 */

class IndexController extends CommonController {

    public function __construct(){
        parent::__construct();
        if((isset($_GET['reset']) && $_GET['reset'] == 1) && $_SESSION['isAdmin']) $this->cache->emptyCache();
        $this->module = 'account';
        //$_SESSION['mobile'] = 1;
    }

    public function inscriptionAction() {
    	$this->layout['title']       = 'Inscription - WeScreen.com';

        // On traite les données soumises dans le form
        $error = false;
        $message = "";
        // => si le form a été soumis
        if(isset($_POST["signup"])) {
            // valider les données (contraintes)
            // champs doivent pas être vides
            if(!isset($_POST["gender"])) {
                $this->view['error']['gender'] = "Saisissez votre civilité.<br>";
                $error = true;
            }
            if($_POST["firstName"] == "") {
                $this->view['error']['firstname'] = "Saisissez votre prénom<br>";
                $error = true;
            }
            if($_POST["lastName"] == "") {
                $this->view['error']['lastname'] = "Saisissez votre nom de famille<br>";
                $error = true;
            }
            // l'email doit être valide
            if(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
               $this->view['error']['email'] = "Saisissez votre email valide.<br>";
               $error = true;
            }
            // password: 8 caractères minimum
            if(strlen($_POST["password"]) < 8) {
               $this->view['error']['mdp'] = "Votre mot de passe doit contenir au moins 8 caractères.<br>";
               $error = true;
            }
            // password == confirm
            if($_POST["password"] != $_POST["confirmPassword"]) {
               $this->view['error']['confirmmdp'] = "Les deux mots de passe ne correspondent pas.<br>";
               $error = true;
            }

            // si la saisie est valide
            if(!$error) {
                // on hache le mdp
                $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
                if($_POST["gender"] == 'Mme') {
                    $gender = 2;
                } else {
                    $gender = 1;
                }

                if($_POST['day'] != '01' && $_POST['month'] != '01' && $_POST['year'] != '1970') {
                    $birthDate = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
                }
                
                $firstName = trim($_POST["firstName"]);
                $lastName = trim($_POST["lastName"]);
                $email = trim($_POST["email"]);
                $dateCreation = date('Y-m-d H:i:s');

                require_once("models/Users.php");
                $user = new Users();

                $result = $user->insertUser($gender, $firstName, $lastName, $email, $birthDate, $dateCreation, $hash);
                if($result) {
                    $_SESSION["messages"][] = "Vous êtes à présent inscrit !";
                    // redirection
                    header('Location: index.php?f=account&a=connexion');
                }
                else {
                    $_SESSION["messages"][] = "Erreur lors de l'inscription.";
                }
            }
        }
        parent::setViewInLayout('modules/' . $this->module .'/views/register.php');
    }

    public function connexionAction() {
        $this->layout['title']       = 'Connexion - WeScreen.com';

        // On traite les données soumises dans le form
        $error = false;

        // => si le form a été soumis
        if(isset($_POST["login"])) {
            require_once("models/Users.php");
            $user = new Users();

            $getUser = $user->getUserFromEmail($_POST["email"]);

            if($getUser) {
                if(password_verify( $_POST["password"], $getUser["mdp"])) {
                    $user->rememberUserData($getUser);
                    header("Location: index.php?f=home&a=index");
                } else {
                    $this->view['error']['password'] = 'Adresse email ou mot de passe incorrect.';
                }                
            }
            else {
                $this->view['error']['mail'] = 'Cette adresse email n\'existe pas.';
            }
        }
        parent::setViewInLayout('modules/' . $this->module .'/views/login.php');
    }
}