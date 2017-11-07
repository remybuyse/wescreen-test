<?php

function autoloader($className){
    include('models/'.$className.'.php');
}
spl_autoload_register('autoloader');

// Fichier de configuration
require_once 'config/config.php';
require_once 'modules/common/controllers/CommonController.php';
require_once 'models/CommonModels.php';

$foldersList = array(
	'account',
    'admin',
    'common',
    'home',
    'misc'
);

// Le dossier et le controller sont autorisés et l'action spécifiée
if (isset($_GET['f']) && isset($_GET['a']))
{
    if(in_array($_GET['f'], $foldersList))
    {
        if(!isset($_GET['c']))
        {
            $_GET['c'] = 'Index';
        }
        else
        {
            $_GET['c'] = ucfirst($_GET['c']);
        }

        $controllerName = $_GET['c'] . 'Controller';
        require_once 'modules/' . $_GET['f'] . '/controllers/' . $controllerName . '.php';

        // Instanciation du controller
        $controller = new $controllerName();

        // L'action existe bien, on l'appelle
        $action = $_GET['a'] . 'Action';
        if (method_exists($controller, $action))
        {
            $controller->$action();
        }
        else
        {
            // Erreur 404
            $commonController = new CommonController();
            $commonController->pageError('404');
        }
    }
    else
    {
        // Erreur 404
        $commonController = new CommonController();
        $commonController->pageError('404');
    }
}
else
{
    // Page index avec la langue par défaut
    $langRedirect = (isset($_COOKIE['languser'])) ? substr($_COOKIE['languser'], 0, 2) : 'fr';
    header("Status: 301 Moved Permanently", false, 301);
    header("Location: /$langRedirect");
    exit();
}