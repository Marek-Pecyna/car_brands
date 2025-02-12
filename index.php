<?php declare(strict_types=1); // strict requirement: declaration of definitive types?>
<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Erstes Projekt</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
	
	<header>
		<h1><a href="index.php">Automarken</a></h1>
		<div class=username>
			<div class=avatar>
				N
			</div>
				Nutzer
		</div>
	</header>

	<main>
		<nav> 	
			<a href="index.php?page=show" title="Automarken anzeigen">
			<img src="img/list.svg">
			Anzeigen
			</a>
			
			<a href="index.php?page=add" title="Neue Automarke anlegen">
			<img src="img/add.svg">
			Hinzufügen
			</a>
			
		</nav>
	
		<!-- div ist ein Container -->
		<div class=content>
		<?php
			// Einfache ' Anführungszeichen für einzeiligen Text
			// Doppelte " Anführungszeichen für mehrzeiligen Text
			
			//Show all errors with next two lines of code:
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
			
			//Define and fill array
			$cars = [];
			if(file_exists('cars.txt')) {
				$text = file_get_contents('cars.txt', true);
				$cars = json_decode($text, true);
			}
				
			//Define functions
			function show_all_cars($cars) {
				echo '<h1>Auflistung der Automarken</h1>';
				echo '<hr>';
				echo "<p>Ein Überblick über die gespeicherten <b>Automarken</b></p>";
				foreach ($cars as $key => $row) {
					$brand = $row['brand'];
					$company = $row['company'];
					echo "
					<div class='card'>
						<img class='car_picture' src='img/car.jpg'>
						<b>$brand</b><br>
						$company
						<div class='card_buttons'>
							<form action='?page=edit' method='post'>
								<button class='edit_button' type='submit' name='edit' value=$key>
								<img src='img/edit.svg'>
								Bearbeiten
								</button>
							</form>
							<form action='?page=delete' method='post'>
								<button class='delete_button' type='submit' name='delete' value=$key>
								<img src='img/delete.svg'>
								Löschen
								</button>
							</form>
						</div><!--'card_buttons'-->
					</div>
					";
				}
			}
			
			function add_car(&$cars) {
				if(isset($_POST['brand']) && isset($_POST['company'])) {
					$newCar = [
						'brand' => htmlentities($_POST['brand']),
						'company' => htmlentities($_POST['company'])
					];
					array_push($cars, $newCar);
					file_put_contents('cars.txt', json_encode($cars, JSON_PRETTY_PRINT));
					header('Location: ./?page=show&added=' . $_POST['brand'], true, 301);
					die();
				} else {
					echo '<h1>Neue Automarke hinzufügen</h1>';
					echo "
					<form action='?page=add' method='POST'>
						<div>
							<input type='text' placeholder='Markenname' name='brand' required>
						</div>
						<div>
							<input type='text' placeholder='Hersteller' name='company' required>
						</div>
						<button type='submit'>Anlegen</button>
					</form>
					";
				}
				return;
			}
			
			function delete_car(&$cars) {
				if(isset($_POST['delete'])) {
					$newCarList = [];
					foreach ($cars as $key => $row) {
						if($_POST['delete'] == $key) {continue;}
						$brand = $row['brand'];
						$company = $row['company'];
						$newCar = [
							'brand' => $brand,
							'company' => $company
						];
						array_push($newCarList, $newCar);
					}
					file_put_contents('cars.txt', json_encode($newCarList, JSON_PRETTY_PRINT));
					$cars = $newCarList;
					header('Location: ./?page=show&deleted=' . $_POST['delete'], true, 301);
					die();
				}
			}
			
			function edit_car(&$cars) {
				if(isset($_POST['edit'])) {
					echo '<h1>Automarke bearbeiten</h1>';				
					foreach ($cars as $key => $row) {
						if($key == $_POST['edit']) {
							$brand = $row['brand'];
							$company = $row['company'];
							echo "Marke-Nr. $key bearbeiten:
							<form action='?page=edit' method='POST'>
								<div>
									<input type='text' name='brand' value=$brand required>
								</div>
								<div>
									<input type='text' name='company' value=$company required>
								</div>
								<button class='input_form' type='submit' name='key' value=$key>Ändern</button>
							</form>
							";
						}
					}
				} elseif(isset($_POST['brand']) && isset($_POST['company']) &&isset($_POST['key'])) {
					$newCarList = [];
					foreach ($cars as $key => $row) {
						$brand = $row['brand'];
						$company = $row['company'];
						if($_POST['key'] == $key) {
							$brand = htmlentities($_POST['brand']);
							$company = htmlentities($_POST['company']);
						}
						$newCar = [
							'brand' => $brand,
							'company' => $company
						];
						array_push($newCarList, $newCar);
					}
					file_put_contents('cars.txt', json_encode($newCarList, JSON_PRETTY_PRINT));
					$cars = $newCarList;
					header('Location: ./?page=show&edited=' . $_POST['brand'], true, 301);
					die();
				}
			}
			
			function welcome() {
				$headline = 'Herzlich willkommen';
				echo '<h1>' . $headline . '</h1>';
			}
			
			//$_GET liefert URL-Parameter zurück
			if(isset($_GET['page'])) {
				$choose = $_GET['page'];
				switch ($choose) {
					case "show":
						if(isset($_GET['added'])) {
							echo "<p>Automarke: <b>" . $_GET['added'] . "</b> wurde hinzugefügt.</p>";
						}
						if(isset($_GET['deleted'])) {
							echo "<p>Automarke: <b>" . $_GET['deleted'] . "</b> wurde gelöscht.</p>";
						}
						if(isset($_GET['edited'])) {
							echo "<p>Automarke: <b>" . $_GET['edited'] . "</b> wurde geändert.</p>";
						}
						show_all_cars($cars);
						break;
					case "add":
						$cars = add_car($cars);
						break;
					case "delete":
						$cars = delete_car($cars);
					case "edit":
						$cars = edit_car($cars);
						break;
					
					default: // home
					   welcome();
				}
			} else {
				welcome();
			}
		?>
	</main>
	</div>
	<footer>
		<a href='https://daten-entdecker.de' target='_blank'>Datenanalyse Dr. Marek Pecyna</a>
	</footer>

</body>
