<?php

function autoloader($className){
    include('models/'.$className.'.php');
}
spl_autoload_register('autoloader');

// Fichier de configuration
require_once '/config/config.php';
require_once '/modules/common/controllers/CommonController.php';
require_once '/models/CommonModels.php';

$foldersList = array(
    'admin',
    'blog',
    'common',
    'enquete',
    'home',
    'misc',
    'petition',
    'auteur',
    'survey',
    'pay',
    'message'
);

include('layouts/header.php');
?>

<h2>Texte</h2>


<?php
include("layouts/footer.php");