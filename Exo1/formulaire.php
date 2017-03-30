<?php

$title = "";
$response = "";
$erreur = "";

if ($_POST) {

	// Exercice 1.1 :
	// Pour cet exercice, nous allons créer un formulaire en HTML avec une récupération des saisies en PHP.
	// L'objectif est de récupérer les saisies postées sur la même page (juste au dessus du formulaire).
	//  Créez une page « formulaire.php ».

	if (isset($_POST['form1Submit'])) {

		$title .= "<h2>Formulaire 1.1 réponse(s) :</h2>";

		$response .= (empty($_POST['form1Nom'])) ? '' : '<p>Nom : '.$_POST['form1Nom'].'</p>';
		$response .= (empty($_POST['form1Prenom'])) ? '' : '<p>Prénom : '.$_POST['form1Prenom'].'</p>';
		$response .= (empty($_POST['form1Adresse'])) ? '' : '<p>Adresse : '.$_POST['form1Adresse'].'</p>';
		$response .= (empty($_POST['form1Ville'])) ? '' : '<p>Ville : '.$_POST['form1Ville'].'</p>';
		$response .= (empty($_POST['form1CodePostal'])) ? '' : '<p>Code postal : '.$_POST['form1CodePostal'].'</p>';
		$response .= (empty($_POST['form1Sexe'])) ? '' : '<p>Sexe : '.$_POST['form1Sexe'].'</p>';
		$response .= (empty($_POST['form1Description'])) ? '' : '<p>Déscription : '.$_POST['form1Description'].'</p>';

	}

	// Exercice 1.2 :
	// Créer un formulaire en affichant les saisies récupérées sur la même page. 
	// Champ à prévoir (contexte : produit) : titre, couleur, taille, poids, prix, description, stock, fournisseur.

	if (isset($_POST['form2Submit'])) {
		
		$title .= "<h2>Formulaire 1.2 réponse(s) :</h2>";

		$response .= (empty($_POST['form2Titre'])) ? '' : '<p>Titre : '.$_POST['form2Titre'].'</p>';
		$response .= (empty($_POST['form2Color'])) ? '' : '<p>Couleur : '.$_POST['form2Color'].'</p>';
		$response .= (empty($_POST['form2Taille'])) ? '' : '<p>Taille : '.$_POST['form2Taille'].'</p>';
		$response .= (empty($_POST['form2Poids'])) ? '' : '<p>Poids : '.$_POST['form2Poids'].'</p>';
		$response .= (empty($_POST['form2Description'])) ? '' : '<p>Déscription : '.$_POST['form2Description'].'</p>';
		$response .= (empty($_POST['form2Stock'])) ? '' : '<p>Stock : '.$_POST['form2Stock'].'</p>';
		$response .= (empty($_POST['form2Fournisseur'])) ? '' : '<p>Fournisseur : '.$_POST['form2Fournisseur'].'</p>';

	}

	// Exercice 1.4
	// Créer un formulaire en affichant les saisies récupérées et en controlant que le pseudo soit compris entre 3 et 10 caractères maximum (sinon prévoir un message d'erreur). 
	// Champ à prévoir (contexte : membre) : pseudo, mdp, email.

	if (isset($_POST['form4Submit'])) {

		$title .= "<h2>Formulaire 1.4 réponse(s) :</h2>";

		if ( isset($_POST['form4Pseudo']) && strlen($_POST['form4Pseudo']) >= 3 && strlen($_POST['form4Pseudo']) <= 10 ) {
			$response .= (empty($_POST['form4Pseudo'])) ? '' : '<p>Pseudo : '.$_POST['form4Pseudo'].'</p>';
		} else {
			$response .= '<p class="bg-danger">Le pseudo doit etre compris entre 3 et 10 caractères !</p>';
			$erreur .= "has-error";
		}
	
		$response .= (empty($_POST['form4Mdp'])) ? '' : '<p>Mot de passe : '.$_POST['form4Mdp'].'</p>';
		$response .= (empty($_POST['form4Mail'])) ? '' : '<p>Mail : '.$_POST['form4Mail'].'</p>';

	}

	// ====================================================

	if ( empty($response) ) {
		$response = "Aucune saisies récupérées.";
	}

}

// Pour l exo 4 ;) :
$pseudo = (!empty($_POST['form4Pseudo'])) ? $_POST['form4Pseudo'] : '';
$mdp = (!empty($_POST['form4Mdp'])) ? $_POST['form4Mdp'] : '';
$mail = (!empty($_POST['form4Mail'])) ? $_POST['form4Mail'] : '';

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Exercice 1</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body class="container-fluid">

		<section class="row">
			
			<article class="well">
				<?= $title; ?>
				<?= $response; ?>
			</article>

			<!-- FORMULAIRE EXO 1.1 -->
			<article class="col-xs-3">
				
				<form action="#" method="POST">
					<h3>Exo 1.1</h3>
					<small>Retourne le résultat posté sur la même page (juste au dessus du formulaire)</small>
					<hr />
					<div class="form-group">
						<label for="form1Nom">Nom</label>
						<input type="text" class="form-control" id="form1Nom" name="form1Nom" placeholder="Doe">
					</div>
					<div class="form-group">
						<label for="form1Prenom">Prenom</label>
						<input type="text" class="form-control" id="form1Prenom" name="form1Prenom" placeholder="John">
					</div>
					<div class="form-group">
						<label for="form1Adresse">Adresse</label>
						<input type="text" class="form-control" id="form1Adresse" name="form1Adresse" placeholder="2 rue du test">
					</div>
					<div class="form-group">
						<label for="form1Ville">Ville</label>
						<input type="text" class="form-control" id="form1Ville" name="form1Ville" placeholder="Paris">
					</div>
					<div class="form-group">
						<label for="form1CodePostal">Code Postal</label>
						<input type="text" class="form-control" id="form1CodePostal" name="form1CodePostal" placeholder="75014">
					</div>
					<div class="form-group">
						<label for="form1Sexe">Sexe</label>
						<select class="form-control" id="form1Sexe" name="form1Sexe">
						  <option value="femme">Femme</option>
						  <option value="homme">Homme</option>
						</select>
					</div>
					<div class="form-group">
						<label for="form1Description">Déscription</label>
						<textarea class="form-control" rows="3" id="form1Description" name="form1Description"></textarea>
					</div>
					<div class="text-center">
						<button type="Submit" name="form1Submit" class="btn btn-info">Envoi</button>
					</div>
				</form>

			</article>

			<!-- FORMULAIRE EXO 1.2 -->
			<article class="col-xs-3">
				
				<form action="#" method="POST">
					<h3>Exo 1.2</h3>
					<small>Retourne le résultat posté sur la même page (juste au dessus du formulaire)</small>
					<hr />
					<div class="form-group">
						<label for="form2Titre">Titre</label>
						<input type="text" class="form-control" id="form2Titre" name="form2Titre" placeholder="Produit 1">
					</div>
					<div class="form-group">
						<label for="form2Color">Couleur</label>
						<input type="text" class="form-control" id="form2Color" name="form2Color" placeholder="Rouge">
					</div>
					<div class="form-group">
						<label for="form2Taille">Taille</label>
						<input type="text" class="form-control" id="form2Taille" name="form2Taille" placeholder="XXL">
					</div>
					<div class="form-group">
						<label for="form2Poids">Poids</label>
						<input type="text" class="form-control" id="form2Poids" name="form2Poids" placeholder="0.5Kg">
					</div>
					<div class="form-group">
						<label for="form2Description">Déscription</label>
						<textarea class="form-control" rows="3" id="form2Description" name="form2Description"></textarea>
					</div>
					<div class="form-group">
						<label for="form2Stock">Stock</label>
						<input type="text" class="form-control" id="form2Stock" name="form2Stock" placeholder="25">
					</div>
					<div class="form-group">
						<label for="form2Fournisseur">Fournisseur</label>
						<input type="text" class="form-control" id="form2Fournisseur" name="form2Fournisseur" placeholder="BricoMaçon">
					</div>
					<div class="text-center">
						<button type="Submit" name="form2Submit" class="btn btn-danger">Envoi</button>
					</div>
				</form>

			</article>

			<!-- FORMULAIRE EXO 1.3 -->
			<article class="col-xs-3">
				
				<form action="resultats1-3.php" method="POST">
					<h3>Exo 1.3</h3>
					<small>Retourne le résultat posté sur page differente (resultats1-3.php)</small>
					<hr />
					<div class="form-group">
						<label for="form3Marque">Marque</label>
						<input type="text" class="form-control" id="form3Marque" name="form3Marque" placeholder="Citroen mx-5">
					</div>
					<div class="form-group">
						<label for="form3Modele">Modele</label>
						<input type="text" class="form-control" id="form3Modele" name="form3Modele" placeholder="Série 4">
					</div>
					<div class="form-group">
						<label for="form3Couleur">Couleur</label>
						<input type="text" class="form-control" id="form3Couleur" name="form3Couleur" placeholder="Bleu">
					</div>
					<div class="form-group">
						<label for="form3Km">Km</label>
						<input type="text" class="form-control" id="form3Km" name="form3Km" placeholder="12 000">
					</div>
					<div class="form-group">
						<label for="form3Carburant">Carburant</label>
						<input type="text" class="form-control" id="form3Carburant" name="form3Carburant" placeholder="Diesel">
					</div>
					<div class="form-group">
						<label for="form3Annee">Année</label>
						<input type="text" class="form-control" id="form3Annee" name="form3Annee" placeholder="2002">
					</div>
					<div class="form-group">
						<label for="form3Prix">Prix</label>
						<input type="text" class="form-control" id="form3Prix" name="form3Prix" placeholder="3500$">
					</div>
					<div class="form-group">
						[..etc..]
					</div>
					<div class="text-center">
						<button type="Submit" name="form3Submit" class="btn btn-success">Envoi</button>
					</div>
				</form>

			</article>

			<!-- FORMULAIRE EXO 1.4 -->
			<article class="col-xs-3">
				
				<form action="#" method="POST">
					<h3>Exo 1.4</h3>
					<small>Retourne le résultat posté sur la même page (juste au dessus du formulaire) et en controlant que le pseudo soit compris entre 3 et 10 caractères maximum (sinon message d'erreur).</small>
					<hr />
					<div class="form-group <?= $erreur; ?>">
						<label for="form4Pseudo">Pseudo</label>
						<input type="text" class="form-control" id="form4Pseudo" name="form4Pseudo" placeholder="Lindigo" value="<?= $pseudo; ?>">
					</div>
					<div class="form-group">
						<label for="form4Mdp">Mot de passe</label>
						<input type="password" class="form-control" id="form4Mdp" name="form4Mdp" placeholder="qwerty" value="<?= $mdp; ?>">
					</div>
					<div class="form-group">
						<label for="form4Mail">E-mail</label>
						<input type="email" class="form-control" id="form4Mail" name="form4Mail" placeholder="monmail@mail.com" value="<?= $mail; ?>">
					</div>
					<div class="text-center">
						<button type="Submit" name="form4Submit" class="btn btn-warning">Envoi</button>
					</div>
				</form>

			</article>

		</section>	

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	</body>
</html>