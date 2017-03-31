<?php

$resultat = "";

if ($_POST) {
	
	if ( isset($_POST['nombre1']) && isset($_POST['nombre2']) ) {

		$nombre1 		= intval($_POST['nombre1']);
		$signeOperation = $_POST['signeOperation'];
		$nombre2		= intval($_POST['nombre2']);

		$resultat .= "Résultat : ";

		switch ($signeOperation) {
			case '+':
				$resultat .= $nombre1 + $nombre2; break;
			case '-':
				$resultat .= $nombre1 - $nombre2; break;
			case '*':
				$resultat .= $nombre1 * $nombre2; break;
			case '/':
				$resultat .= $nombre1 / $nombre2; break;
			
			default:
				$resultat .= "";	break;
		}
	}

}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Exercice 4</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<style type="text/css">
			html { font-size: 62.5%; }
			body { font-size: 1.6rem; }
		</style>
	</head>
	<body class="container-fluid" style="padding-top: 50px;">

		<section class="row">
			
			<article class="col-xs-8 col-xs-offset-2">
				
				<h3>Exercice 4</h3>

				<form class="form-inline" method="post" action="#">
				 	<div class="form-group">
				    	<input type="number" class="form-control" name="nombre1" placeholder="Nombre 1">
				  	</div>
				  	<div class="form-group">
				  		<select class="form-control" name="signeOperation">
						  <option value="+">+</option>
						  <option value="-">-</option>
						  <option value="*">*</option>
						  <option value="/">/</option>
						</select>
				  	</div>
				  	<div class="form-group">
				    	<input type="number" class="form-control" name="nombre2" placeholder="nombre 2">
				  	</div>
				  	<button type="submit" name="submit" class="btn btn-default">Calculer</button>
				</form>

			</article>

		</section>

		<section class="row">
			
			<article class="col-xs-8 col-xs-offset-2">
				<br />
				<p class="alert alert-success"><?= $resultat; ?></p>
			</article>

		</section>

	</body>
</html>