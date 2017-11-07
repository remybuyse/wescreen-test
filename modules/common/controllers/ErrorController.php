<?php

class ErrorController extends CommonController {
    
    public function __construct()
    {
        parent::__construct();
        $this->module = 'common';
    }

    public function errorAction($errorType)
    {
        $this->layout['pubBtm']= true;
        
        if(!empty($_GET['type'])) $errorType = $_GET['type'];
        
        $this->layout['title']   = 'Erreur 404 - Page non trouvée';
        $this->view['viewTitle'] = 'Erreur 404 - Page non trouvée';
        if($errorType == '500')
        {
            $this->layout['title']   = 'Erreur 500 - Erreur sur le serveur';
            $this->view['viewTitle'] = 'Erreur 500 - Erreur sur le serveur';
        }
        
        $this->layout['breadcrumbs'] = array(
            '' => $this->layout['title']
        );
        
        switch($errorType)
        {
            case '404': $this->view['errorMsg'] = 'Désolé, la page demandée n\'existe pas.';
            break;
            
            case '500': $this->view['errorMsg'] = 'Désolé, une erreur s\'est produite sur notre serveur.<br /><br /> Un mail vient d\'être envoyé au webmaster, elle sera corrigée au plus vite.<br /><br />Merci de votre compréhension.';
            break;
        }
        
        // On inclut la vue
        $this->setViewInLayout('modules/' . $this->module .'/views/error.php');
    }
}