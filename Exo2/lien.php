<?php

$exo2_1 = "";
$exo2_2 = "";

if ($_GET) {

	// Exercice 2.1 :
	// Pour cet exercice, nous allons créer plusieurs liens en HTML (qui pointent vers la même page) avec une récupération des paramètres en PHP.
	// L'objectif est de récupérer les paramètres véhiculés par l'url sur la même page.
	//  Créez une page « lien.php ».

	if (isset($_GET['pays'])) {
	
		switch ($_GET['pays']) {

			case 'France':
				$exo2_1 = "Vous êtes Français ?";	break;
			case 'Italie':
				$exo2_1 = "Vous êtes Italien ?";	break;
			case 'Espagne':
				$exo2_1 = "Vous êtes Espagnol ?";	break;
			case 'Angleterre':
				$exo2_1 = "Vous êtes Anglais ?";	break;
			
			default:
				$exo2_1 = "";	break;
		}

	}

	// Exercice 2.2
	// Créer une page avec deux liens : homme, femme. 
	// Récupérer le texte du lien cliqué en affichant le message "Vous êtes un Homme" ou "Vous êtes une femme".

	if (isset($_GET['sexe'])) {

		$exo2_2 = ($_GET['sexe'] == 'homme') ? "Vous êtes un homme" : "Vous êtes une femme";

	}

}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Exercice 2</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body class="container-fluid" style="padding-top: 50px;">

		<!-- Exercice 2.1 -->
		<section class="row">
			
			<article class="col-xs-4">
				
				<h3>Exercice 2.1</h3>
				<ul>
					<li><a href="lien.php?pays=France">France</a></li>
					<li><a href="lien.php?pays=Italie">Italie</a></li>
					<li><a href="lien.php?pays=Espagne">Espagne</a></li>
					<li><a href="lien.php?pays=Angleterre">Angleterre</a></li>
				</ul>
				<hr />
				<p><?= $exo2_1; ?></p>

			</article>

			<article class="col-xs-4">
				
				<h3>Exercice 2.2</h3>
				<ul>
					<li><a href="lien.php?sexe=homme">homme</a></li>
					<li><a href="lien.php?sexe=femme">femme</a></li>
				</ul>
				<hr />
				<p><?= $exo2_2; ?></p>

			</article>

			<article class="col-xs-4">
				
				<h3>Exercice 2.3</h3>
				<ul>
					<li><a href="resultats2-3.php?menu=pizza">pizza</a></li>
					<li><a href="resultats2-3.php?menu=salade">salade</a></li>
					<li><a href="resultats2-3.php?menu=viande">viande</a></li>
					<li><a href="resultats2-3.php?menu=poisson">poisson</a></li>
				</ul>
				<hr />

			</article>

		</section>

	</body>
</html>