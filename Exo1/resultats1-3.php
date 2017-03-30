<?php

$title = "";
$response = "";

if ($_POST) {

	// Exercice 1.3
	// Créer un formulaire en affichant les saisies récupérées sur deux pages différentes. 
	// Champ à prévoir (contexte : voiture) : marque, modele, couleur, km, carburant, annee, prix, puissance, options.

	if (isset($_POST['form3Submit'])) {
		
		$title .= "<h2>Formulaire 1.3 réponse(s) :</h2>";

		$response .= (empty($_POST['form3Marque'])) ? '' : '<p>Marque : '.$_POST['form3Marque'].'</p>';
		$response .= (empty($_POST['form3Modele'])) ? '' : '<p>Modele : '.$_POST['form3Modele'].'</p>';
		$response .= (empty($_POST['form3Couleur'])) ? '' : '<p>Couleur : '.$_POST['form3Couleur'].'</p>';
		$response .= (empty($_POST['form3Km'])) ? '' : '<p>Km : '.$_POST['form3Km'].'</p>';
		$response .= (empty($_POST['form3Carburant'])) ? '' : '<p>Carburant : '.$_POST['form3Carburant'].'</p>';
		$response .= (empty($_POST['form3Annee'])) ? '' : '<p>Année : '.$_POST['form3Annee'].'</p>';
		$response .= (empty($_POST['form3Prix'])) ? '' : '<p>Prix : '.$_POST['form3Prix'].'</p>';

	}

	if ( empty($response) ) {
		$response = "Aucune saisies récupérées.";
	}

}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Exercice 1 - 1.3 résultats</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body class="container-fluid">

		<section class="row">
			
			<article class="col-xs-4 col-xs-offset-4 well">
				
				<?= $title; ?>
				<?= $response; ?>

			</article>

		</section>

		<section class="row">
			
			<article class="col-xs-4 col-xs-offset-4 text-center">
				
				<a href="formulaire.php" class="btn btn-primary">Retour à la page précédante</a>

			</article>

		</section>

	</body>
</html>