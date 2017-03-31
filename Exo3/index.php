<?php

$total3_1 = "";
$total3_2 = "";
$total3_3 = "";
$total3_4 = "";
$total3_5 = "";

	// Exercice 3.1
	// Afficher des nombres allant de 1 à 100.
	for ($i=1; $i < 101; $i++) { 
		$total3_1 .= "<li>$i</li>";
	}

	// Exercice 3.2
	// Afficher des nombres allant de 1 à 100 avec le chiffre 50 en rouge.
	for ($i=1; $i < 101; $i++) { 
		if ($i == 50) {
			$total3_2 .= "<li style='color:red; font-weight:bold;'>$i</li>";
		} else {
			$total3_2 .= "<li>$i</li>";
		}
	}

	// Exercice 3.3
	// Afficher des nombres allant de 2000 à 1930.
	for ($i=2000; $i >= 1930 ; $i--) { 
		$total3_3 .= "<li>$i</li>";
	}

	// Exercice 3.4
	// Afficher le titre suivant 100 fois : <h1>Titre à afficher 100 fois</h1>
	for ($i=1; $i <= 100 ; $i++) { 
		$total3_4 .= "<h1>Titre à afficher 100 fois</h1>";
	}

	// Exercice 3.5
	// Afficher le titre suivant "<h1>Je m\'affiche pour la Nème fois</h1>".
	// Remplacer le N avec la valeur de $i (tour de boucle).
	for ($i=1; $i <= 100 ; $i++) { 
		$total3_5 .= "<h1>Je m'affiche pour la ".$i."ème fois</h1>";
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Exercice 3</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<style type="text/css">
			html { font-size: 62.5%; }
			body { font-size: 1.6rem; }
			small { min-height: 5rem; display: block; }
			ul { border: .1rem solid #000; height: 30rem; overflow: auto; }
		</style>
	</head>
	<body class="container-fluid" style="padding-top: 50px;">

		<section class="row">
			
			<article class="col-xs-2">
				
				<h3>Exercice 3.1</h3>

				<small>1 à 100.</small>

				<ul><?= $total3_1; ?></ul>

			</article>

			<article class="col-xs-2">
				
				<h3>Exercice 3.2</h3>

				<small>1 à 100 avec le chiffre 50 en rouge.</small>

				<ul><?= $total3_2; ?></ul>

			</article>

			<article class="col-xs-2">
				
				<h3>Exercice 3.3</h3>

				<small>Nombres allant de 2000 à 1930.</small>

				<ul><?= $total3_3; ?></ul>

			</article>

			<article class="col-xs-3">
				
				<h3>Exercice 3.4</h3>

				<small>Titre h1 : 100 fois.</small>

				<ul><?= $total3_4; ?></ul>

			</article>

			<article class="col-xs-3">
				
				<h3>Exercice 3.5</h3>

				<small>Titre h1 : N avec la valeur de $i.</small>

				<ul><?= $total3_5; ?></ul>

			</article>

		</section>

	</body>
</html>