<?php

// Exercice 5.1 Créez une base de données que vous appellerez « repertoire ».
// A l’intérieur de celle-ci, vous créerez une table que vous appellerez « annuaire » avec les champs suivant : 
// - id_annuaire (INT, 3, AI - PK)
// - nom (VARCHAR, 30)
// - prenom (VARCHAR, 30)
// - telephone (INT, 10, zerofill)
// - profession (VARCHAR, 30)
// - ville (VARCHAR, 30)
// - codepostal (INT, 5, zerofill)
// - adresse (VARCHAR, 30)
// - date_de_naissance (DATE)
// - sexe (ENUM, 'm','f')
// - description (TEXT)

// CREATE TABLE annuaire ( 
// 	id_annuaire INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY , 
// 	nom VARCHAR(30) NOT NULL , 
// 	prenom VARCHAR(30) NOT NULL , 
// 	telephone INT(10) UNSIGNED ZEROFILL NOT NULL , 
// 	profession VARCHAR(30) NOT NULL , 
// 	ville VARCHAR(30) NOT NULL , 
// 	codepostal INT(5) UNSIGNED ZEROFILL NOT NULL , 
// 	adresse VARCHAR(30) NOT NULL , 
// 	date_de_naissance DATE NOT NULL , 
// 	sexe ENUM("f","m") NOT NULL , 
// 	description TEXT NOT NULL 
// ) ENGINE = InnoDB;

// Exercice 5.2 Créez une page « formulaire.php »
// - Afficher le récapitulatif des saisies au dessus du formulaire (sur la même page).

$pdo = new PDO('mysql:host=localhost;dbname=repertoire', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
// var_dump($result);

// Exercice 5.3 Une fois les valeurs récupérées du formulaire, il faudra développer le code permettant l’insertion des saisies dans la table « annuaire » de la base de données « repertoire ».
// Chaque validation du formulaire doit ajouter une nouvelle ligne d’enregistrement dans la table « annuaire ».

$success = "";
$error = "";

if ( isset($_POST['submit']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['tel']) ){

	// ------------ CONTROLES ET ERREURS :

	$error .= (strlen($_POST['nom']) > 30) ? "<p>Le nom est trop long ! (-30cara)</p>" : "";
	$error .= (strlen($_POST['prenom']) > 30) ? "<p>Le prenom est trop long ! (-30cara)</p>" : "";
	$error .= (!preg_match("/[0-9]{10}/", $_POST['tel'])) ? "<p>Mauvais format pour le téléphone ! (10 chiffres max)</p>" : "";

	// ------------ VALIDATION :

	if( empty($error) ){ // Si $error est vide donc pas d error

		$pdo->exec("INSERT INTO annuaire (nom, prenom, telephone, profession, ville, codepostal, adresse, date_de_naissance, sexe, description) VALUES ('$_POST[nom]', '$_POST[prenom]', '$_POST[tel]', '$_POST[job]', '$_POST[ville]', '$_POST[cp]', '$_POST[adresse]', '$_POST[birthday]', '$_POST[sexe]', '$_POST[description]' ) ");

		$success .= '<p style="color:#03A9F4; font-weight:bold;">Une personne à été ajouté ;) !</p>';
		$success .= (!empty($_POST['nom'])) ? '<p>Nom : '.$_POST['nom'].'</p>' : '';
		$success .= (!empty($_POST['prenom'])) ? '<p>Prenom : '.$_POST['prenom'].'</p>' : '';
		$success .= (!empty($_POST['tel'])) ? '<p>Téléphone : '.$_POST['tel'].'</p>' : '';
		$success .= (!empty($_POST['job'])) ? '<p>Profession : '.$_POST['job'].'</p>' : '';
		$success .= (!empty($_POST['ville'])) ? '<p>Ville : '.$_POST['ville'].'</p>' : '';
		$success .= (!empty($_POST['cp'])) ? '<p>Code postal : '.$_POST['cp'].'</p>' : '';
		$success .= (!empty($_POST['adresse'])) ? '<p>Adresse : '.$_POST['adresse'].'</p>' : '';
		$success .= (!empty($_POST['birthday'])) ? '<p>Date de Naissance : '.$_POST['birthday'].'</p>' : '';
		$success .= (!empty($_POST['sexe'])) ? '<p>Sexe : '.$_POST['sexe'].'</p>' : '';
		$success .= (!empty($_POST['description'])) ? '<p>Déscription : '.$_POST['description'].'</p>' : '';

		$_SESSION['success'] = $success;

		// header('location:formulaire.php');

	}

}


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Exercice 5</title>

		<style type="text/css">
			
			form { width: 350px; }
			textarea, input:not([name='sexe']) { display: block; }

		</style>
	</head>
	<body>

		<p style="text-align: center;"><a href="affichage_annuaire.php">Gestion de l'annuaire</a></p>

		<div><?= $error.$success; ?></div>

		<form method="post" action="#">
			
			<fieldset>
				<legend>Informations</legend> <!-- Titre du fieldset --> 

				<p>
					<label for="nom">Nom <sup>*</sup></label>
					<input type="text" name="nom" id="nom" value="<?= (!empty($_POST['nom'])) ? $_POST['nom'] : ''; ?>" required />
				</p>

				<p>
					<label for="prenom">Prenom <sup>*</sup></label>
					<input type="text" name="prenom" id="prenom" value="<?= (!empty($_POST['prenom'])) ? $_POST['prenom'] : ''; ?>" required />
				</p>

				<p>
					<label for="tel">Téléphone <sup>*</sup></label>
					<input type="number" name="tel" id="tel" value="<?= (!empty($_POST['tel'])) ? $_POST['tel'] : ''; ?>" required />
				</p>

				<p>
					<label for="job">Profession</label>
					<input type="text" name="job" id="job" value="<?= (!empty($_POST['job'])) ? $_POST['job'] : ''; ?>" />
				</p>

				<p>
					<label for="ville">Ville</label>
					<input type="text" name="ville" id="ville" value="<?= (!empty($_POST['ville'])) ? $_POST['ville'] : ''; ?>" />
				</p>

				<p>
					<label for="cp">Code postal</label>
					<input type="text" name="cp" id="cp" value="<?= (!empty($_POST['cp'])) ? $_POST['cp'] : ''; ?>" />
				</p>

				<p>
					<label for="adresse">Adresse</label>
					<textarea name="adresse" id="adresse" rows="3"><?= (!empty($_POST['adresse'])) ? $_POST['adresse'] : ''; ?></textarea>
				</p>

				<p>
					<label for="birthday">Date de Naissance</label>
					<input type="date" name="birthday" id="birthday" value="<?= (!empty($_POST['birthday'])) ? $_POST['birthday'] : ''; ?>" />
				</p>

				<p>
					<label for="sexe" style="display: block;">Sexe</label>
					<input type="radio" name="sexe" value="m" id="sexeHomme" <?= (isset($_POST['sexe']) && $_POST['sexe'] == "m") ? 'checked' : ''; ?> /> 
					<label for="sexeHomme">Homme</label>
       				<input type="radio" name="sexe" value="f" id="sexeFemme" <?= (isset($_POST['sexe']) && $_POST['sexe'] == "f") ? 'checked' : ''; ?> /> 
       				<label for="sexeFemme">Femme</label>
       			</p>

       			<p>
       				<label for="description">Description</label>
					<textarea name="description" id="description" rows="5"><?= (!empty($_POST['description'])) ? $_POST['description'] : ''; ?></textarea>
				</p>

				<p>
					<input type="submit" name="submit" value="enregistrement" />
				</p>

			</fieldset>

		</form>

	</body>
</html>