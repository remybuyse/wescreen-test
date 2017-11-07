<?php
class Users extends CommonModels{
    public function __construct(){
        $this->table      = '`ws_user`';
        $this->primaryKey = '`id_user`';
    }
    public function insertUser($gender, $firstName, $lastName, $email, $birthDate, $dateCreation, $hash) {
    	$pdo = $this->pdoConnectUtf8();

    	$result = $pdo->prepare("INSERT INTO ws_user (mdp, civilite, nom, prenom, adresse, cp, ville, pays, email, date_naissance, telephone, ip, date_creation, derniere_connexion, role, pseudo, bio, facebook, twitter, instagram, img_profil)
    						     VALUES ('$hash', '$gender', '$lastName', '$firstName','', '', '', '', '$email', '$birthDate', '', '', '$dateCreation', '$dateCreation', 2, '', '', '', '', '', '')");

    	$result->execute();
    	return $result;
    }

    public function getUserFromEmail($email) {
    	$pdo = $this->pdoConnectUtf8();
    	
    	$result = $pdo->prepare("SELECT * FROM ws_user WHERE email = '$email'");

    	$result->execute();
    	return $result->fetch(PDO::FETCH_ASSOC);
    }

    // remplir $_SESSION["user"] <==> "connecter mon utilisateur"
	public function rememberUserData($user) {
	    $_SESSION["user"] = [
	        "id" 			 => $user["id"],
	        "civilite" 		 => $user["civilite"],
	        "prenom" 		 => $user["prenom"],
	        "nom" 			 => $user["nom"],
	        "adresse" 		 => $user["adresse"],
	        "cp" 			 => $user["cp"],
	        "ville" 		 => $user["ville"],
	        "pays" 			 => $user["pays"],
	        "email" 		 => $user["email"],
	        "date_naissance" => $user["date_naissance"],
	        "telephone" 	 => $user["telephone"],
	        "role" 			 => $user["role"],
	        "pseudo" 		 => $user["pseudo"],
	        "bio" 			 => $user["bio"],
	        "facebook" 		 => $user["facebook"],
	        "twitter" 		 => $user["twitter"],
	        "instagram" 	 => $user["instagram"],
	        "img_profil" 	 => $user["img_profil"]
	    ];
	}

	public function isLoggedIn() {
	    return isset($_SESSION["user"]);
	}
	public function isAdmin() {
	    return $_SESSION["user"]["group"] == "admin";
	}
	public function logUserOut() {
	    //  "déconnecter" mon user mais conserver le contenu de son panier
	    unset($_SESSION["user"]);
	    // vide les variables de la session, garde la même session active (id de session ne change pas)
	    // session_unset();
	    // détruit la session (sur le serveur) plus d'id de session, le cookie est toujours dans le navigateur de l'utilisateur mais l'id ne correspond plus à aucune donnée sur le serveur
	    //  vide le panier avec
	    // session_destroy();
	}

}