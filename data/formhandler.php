<?php
// strict requirement: declaration of definitive types
declare(strict_types=1);

//Show all errors with next two lines of code:
error_reporting(E_ALL);
ini_set('display_errors', '1');

/* DEBUG
	echo "<pre>";
	var_dump($_SERVER["REQUEST_METHOD"]);

	$the_request = $_GET;
	echo "Daten werden nur ausgeben:\n";
	echo "\$_GET-Parameter:\n";
	var_dump($_GET);

	$the_request = $_POST; 
	echo "Userdaten werden verarbeitet:\n";
	echo "\$_POST-Parameter:\n";
	var_dump($_POST);
	echo "</pre>";
	// Ende DEBUG*/

// Getting all request superglobals
$the_request = "";
switch ($_SERVER["REQUEST_METHOD"]) {
	case 'GET':
		$the_request = $_GET;
		break;
	case 'POST':
		$the_request = $_POST; 
		break;
}

//Skript wurde irregulär aufgerufen
// Rückkehr zur Startseite
if (empty($the_request)) {
	header("Location: ../index.php");
	exit();
}

//Define and fill array
$cars = [];
if(file_exists('../data/cars.json')) {
	$text = file_get_contents('../data/cars.json', true);
	$cars = json_decode($text, true);
}

//Methode anhand von POST-Parameter ausgewählt
switch ($the_request['action']) {
	case "add":
		$brand = add_car($cars);
		header('Location: ../index.php?page=show&added=' . $brand, true, 301);
		break;
	case "edit":
		$brand = edit_car($cars);
		header('Location: ../index.php?page=show&edited=' . $brand, true, 301);
		break;
	case "delete":
		$brand = delete_car($cars);
		header('Location: ../index.php?page=show&deleted=' . $brand, true, 301);
		break;
}

//Ende von Formhandler, falls noch nicht vorher beendet und Rückkehr zur Hauptseite
exit();

/* Funktionsdefinitionen ******************************************************************** */
function add_car(&$cars) {
	$brand = "";
	if(isset($_POST['brand']) and isset($_POST['company'])) {
		$newCar = [
			'brand' => htmlentities($_POST['brand']),
			'company' => htmlentities($_POST['company'])
		];
		$brand = $newCar['brand'];
		array_push($cars, $newCar);
		file_put_contents('../data/cars.json', json_encode($cars, JSON_PRETTY_PRINT));
	}
	return $brand;
}

function edit_car(&$cars) {
	$brand = "";
	if(isset($_POST['brand']) and isset($_POST['company']) and isset($_POST['key'])) {
		$key = $_POST['key'];
		$brand = $cars[$_POST['key']]['brand'];
		if (array_key_exists($key, $cars)) {
			$newCar = [
				'brand' => htmlentities($_POST['brand']),
				'company' => htmlentities($_POST['company'])
			];
			$cars[$key] = $newCar;
			file_put_contents('../data/cars.json', json_encode($cars, JSON_PRETTY_PRINT));
		}
	}
	return $brand;
}

function delete_car(&$cars) {	
	$brand = "";	
	if(isset($_POST['key'])) {
		try {
			$brand = $cars[$_POST['key']]['brand'];
			unset($cars[$_POST['key']]); // delete entry in array at position $_POST['key']
			$cars = array_values($cars); // renumbering the keys
			file_put_contents('../data/cars.json', json_encode($cars, JSON_PRETTY_PRINT));
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	return $brand;
}		

