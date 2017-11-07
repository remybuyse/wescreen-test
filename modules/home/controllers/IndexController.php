<?php
class IndexController extends CommonController{

    public function __construct(){
        parent::__construct();
        if((isset($_GET['reset']) && $_GET['reset'] == 1) && $_SESSION['isAdmin']) $this->cache->emptyCache();
        $this->module = 'home';
    }

    public function indexAction(){
        $this->layout['title']       = 'WeScreen.com - Partage ton cinéma';
        $this->layout['description'] = 'Site de partage de films et séries - Partagez votre salle de cinéma';
        $this->layout['canonical']   = 'http://localhost/fr';
        $this->layout['selected']    = 'home';

        require_once("models/Users.php");
        $user = new Users();

        if($user->isLoggedIn()) {
            $this->view['connecte'] = 'Bonjour ' . $_SESSION['user']['prenom'];
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.themoviedb.org/3/movie/popular?api_key=cefb77c896541c52e2647edd2da146ab&language=fr-FR&page=1",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "{}",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        // if ($err) {
        //   echo "cURL Error #:" . $err;
        // } else {
        //   echo $response;
        // }
        $json = json_decode($response, true);

        foreach($json['results'] as $movie) {
                $this->view['allMovies'][] = array(
                    'title'      => $movie['title'],
                    'popularity' => (int)$movie['popularity'],
                    // Synopsis
                    'overview'   => $movie['overview'],
                    // url de l'image du film
                    'img'        => $movie['poster_path']
                );        
        }

        parent::setViewInLayout('modules/' . $this->module .'/views/index.php');
    }

    public function redirectAction() {
        $email = $_GET['e'];
        $redirect = $_GET['redirect'];
        $this->redirect($redirect);
    }

}