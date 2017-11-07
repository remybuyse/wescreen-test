<?php
	/**
	*  @author Sam
	* Webservice pour l'autocomplétion de la ville en fonction du code postal
	**/
	require_once '../../config/config.php';

	ini_set("default_charset", "UTF-8");
	$host = DB_HOST;
	$dbName = DB_NAME;
	$dbUsername = DB_USERNAME;
	$dbMdp = DB_PWD;
	$pdo = new PDO('mysql:host='.$host.';dbname='.$dbName, $dbUsername, $dbMdp, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

	define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	if(!IS_AJAX) {
		die('Restricted access');
	}
	$pos = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
	if($pos===false) {
	  die('Restricted access');
	}

	if (isset($_GET['query']) && isset($_GET['country']) && $_GET['zipcodes']) {
		$cp 	 = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_STRING);
		$country = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING);

		if(strlen($cp) > 0 && strlen($cp) <= 5) {
			$sql = "";
			if(strlen($cp) == 5) {
				$sql = "SELECT `ville`, `cp` FROM `mo_ville_cp` WHERE `cp` LIKE '". $cp ."%' AND `pays` = ". $pdo->quote($country) ." ORDER BY `ville` ASC";
			} elseif (strlen($cp) < 5) {
				$sql = "SELECT `ville`, `cp` FROM `mo_ville_cp` WHERE `cp` LIKE '". $cp ."%' AND `pays` = ". $pdo->quote($country) ." ORDER BY `ville` ASC LIMIT 20";
			}
			$result = $pdo->prepare($sql);
			$result->execute();
			$villes = $result->fetchAll(PDO::FETCH_ASSOC);

			$response->query 	   = "Unit";
			$response->suggestions = array();

			for ($i=0; $i < count($villes); $i++) { 
				$ville->value = $villes[$i]['ville'] . ", " .$villes[$i]['cp'];
				$data->ville  = $villes[$i]['ville'];
				$data->cp 	  = $villes[$i]['cp'];
				$ville->data  = $data;
				array_push($response->suggestions, $ville);
				unset($ville);
				unset($data);
			}

			header('Content-type: application/json');
			echo json_encode($response);
		}
	}
	if (isset($_GET['query']) && isset($_GET['country']) && $_GET['cities']) {
		$city 	 = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_STRING);
		$country = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING);

		if(strlen($city) > 0 && strlen($city) <= 45) {

			$sql = "SELECT `ville`, `cp` FROM `mo_ville_cp` WHERE `ville` LIKE '". $city ."%' AND `pays` = ". $pdo->quote($country) ." ORDER BY `ville` ASC LIMIT 20";

			$result = $pdo->prepare($sql);
			$result->execute();
			$villes = $result->fetchAll(PDO::FETCH_ASSOC);

			$response->query 	   = "Unit";
			$response->suggestions = array();

			for ($i=0; $i < count($villes); $i++) { 
				$ville->value = $villes[$i]['ville'] . ", " .$villes[$i]['cp'];
				$data->ville  = $villes[$i]['ville'];
				$data->cp 	  = $villes[$i]['cp'];
				$ville->data  = $data;
				array_push($response->suggestions, $ville);
				unset($ville);
				unset($data);
			}

			header('Content-type: application/json');
			echo json_encode($response);
		}
	}