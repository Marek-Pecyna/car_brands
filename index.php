<?php
// strict requirement: declaration of definitive types
declare(strict_types=1);

//Show all errors with next two lines of code:
error_reporting(E_ALL);
ini_set('display_errors', true);

//////////////////////////////////////////////////////////////////////
// start output buffer for collecting all content for main template
ob_start();

//Define and fill array
$cars = [];
if(file_exists('./data/cars.json')) {
	$text = file_get_contents('./data/cars.json', true);
	$cars = json_decode($text, true);
}
	
//Define functions
function show_all_cars($cars) {
	echo '<h2>Auflistung der Automarken</h2>';
	echo '<hr>';
	echo "<p>Ein Überblick über die gespeicherten <b>Automarken</b></p>";
	echo "<div class='scroll_box'>";

	foreach ($cars as $key => $row) {
		$brand = $row['brand'];
		$company = $row['company'];
		include('./templates/show_frame.html');
	}
	echo "</div>";
}

function delete_car(&$cars) {		
	if(isset($_POST['delete'])) {
		$key = $_POST['delete'];
		$brand = $cars[$key]['brand'];
		$company = $cars[$key]['company'];
		include('./templates/delete_frame.html');
		return 0;
	}
	return 1;
}

function edit_car(&$cars) {
	if(isset($_POST['edit'])) {
		$key = $_POST['edit'];
		$brand = $cars[$key]['brand'];
		$company = $cars[$key]['company'];
		include('./templates/edit_frame.html');
		return 0;
	}
	return 1;
}

function welcome() {
	include('./templates/welcome.html');
}

//$_GET liefert URL-Parameter zurück
// Wenn nicht gesetzt, dann Willkomensseite anzeigen
if(isset($_GET['page'])) {
	$choose = $_GET['page'];
	switch ($choose) {
		case "show":
			if(isset($_GET['added']) and !empty($_GET['added'])) {
				echo "<p>Automarke <b>'" . $_GET['added'] . "'</b> wurde hinzugefügt.</p>";
			}
			if(isset($_GET['deleted']) and !empty($_GET['deleted'])) {
				echo "<p>Automarke <b>'" . $_GET['deleted'] . "'</b> wurde gelöscht.</p>";
			}
			if(isset($_GET['edited']) and !empty($_GET['edited'])) {
				echo "<p>Automarke <b>'" . $_GET['edited'] . "'</b> wurde geändert.</p>";
			}
			show_all_cars($cars);
			break;
		case "add":
			include("./templates/add_frame.html");		
			break;
		case "delete":
			$status = delete_car($cars);
			if ($status == 1) {welcome();}
			break;
		case "edit":
			$status = edit_car($cars);
			if ($status == 1) {welcome();}
			break;
		default:
			welcome();
	}

} else {
	welcome();
}

$mainContent = ob_get_clean();
include('./templates/main_template.html');

