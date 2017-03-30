<?php

$exo2_3 = "";

if (isset($_GET['menu'])) {

	// Exercice 2.3
	// Créer une page1 avec plusieurs liens (contexte : carte de restaurant) : pizza, salade, viande, poisson. 
	// Récupérer le plat cliqué (dans la page1) et afficher-le sur la page2 en adressant un message correspondant au choix de l'internaute.
	// Exemple si l'on a cliqué sur pizza : "Vous avez choisi de manger 1 pizza" .
	
	switch ($_GET['menu']) {

		case 'pizza':
			$exo2_3 = "Vous avez choisi de manger une pizza";	break;
		case 'salade':
			$exo2_3 = "Vous avez choisi de manger une salade";	break;
		case 'viande':
			$exo2_3 = "Vous avez choisi de manger de la viande";	break;
		case 'poisson':
			$exo2_3 = "Vous avez choisi de manger du poisson";	break;
		
		default:
			$exo2_3 = "";	break;
	}

}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Exercice 2 - 2.3 résultats</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body class="container-fluid">

		<section class="row">
			
			<article class="col-xs-4 col-xs-offset-4 well">
				
				<h3>Exercice 2.3</h3>
				<hr />
				<p><?= $exo2_3; ?></p>

			</article>

		</section>

		<section class="row">
			
			<article class="col-xs-4 col-xs-offset-4 text-center">
				
				<a href="lien.php" class="btn btn-primary">Retour à la page précédante</a>

			</article>

		</section>

	</body>
</html>