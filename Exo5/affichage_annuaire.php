<?php

require "../easyPDO/Bdd.php";

// Connexion à la bdd :

$em = new Bdd();

// Exercice 5.4 Créez une page « affichage_annuaire.php » qui permettra de récupérer les données et ainsi afficher le nom des champs suivi des informations contenues à l’intérieur de la table « annuaire ».

$em->setTable("annuaire");
$content = $em->findAll("id_annuaire", "DESC");

// Exercice 5.5, Sur la page « affichage_annuaire.php », Ajouter 2 informations :
// - Le nombre d’hommes
// - Le nombre de femmes

$totalF = $em->rowCount("sexe", "f");
$totalM = $em->rowCount("sexe", "m");

// Exercice 5.6, MODIFICATION ET SUPPRESSION Sur la page « affichage_annuaire.php » :
// Donnez la possibilité de modifier les enregistrements (ouvrant un formulaire pour effectuer les modifications)
// Donnez la possibilité de supprimer les enregistrements (avec un message demandant une confirmation).
// Ces deux actions doivent être possibles directement via la page web.

$response = "";
if ($_GET) {

	// BOUTON CLOSE AFFICHAGE
	$close = " <a href='affichage_annuaire.php' title='Close'><i class='fa fa-window-close' aria-hidden='true'></i></a>";
	// MESSAGE DE SUCCES
	if (isset($_GET['response']) && $_GET['response'] == "ok" && isset($_GET['id'])) {
		$id = $_GET['id'];
		$response .= "<p class='alert alert-danger'>ID $id à bien été supprimer ! $close</p>";
	}
	// MESSAGE DE MODIF
	if (isset($_GET['response']) && $_GET['response'] == "modif" && isset($_GET['id'])) {
		$id = $_GET['id'];
		$response .= "<p class='alert alert-success'>ID $id à bien été modifier ! $close</p>";
	}
	// MODIFICATION AFFICHAGE
	if (isset($_GET['stat']) && $_GET['stat'] == "edit" && isset($_GET['id'])) {
		$id = $_GET['id'];
		$update = $em->find($id);

		$response .= "<h3 class='text-center'>Modifications du client $id $close</h3>";
		$sexeM = (isset($update[0]["sexe"]) && $update[0]["sexe"] == "m") ? "checked" : "";
		$sexeF = (isset($update[0]["sexe"]) && $update[0]["sexe"] == "f") ? "checked" : "";
		$formulaire = '<form method="post" action="affichage_annuaire.php" class="row" style="padding-bottom: 30px; margin-bottom: 20px; border-bottom: 1px solid #ccc;">
			<div class="col-xs-1 text-right"><input type="hidden" name="id_annuaire" value="'.$update[0]["id_annuaire"].'" /><i class=\'fa fa-pencil-square-o\' style="font-size: x-large;" aria-hidden=\'true\'></i></div>
			<div class="col-xs-1">
				<p>nom</p>
				<input type="text" class="form-control" name="nom" value="'.$update[0]["nom"].'" />
			</div>
			<div class="col-xs-1">
				<p>prenom</p>
				<input type="text" class="form-control" name="prenom" value="'.$update[0]["prenom"].'" />
			</div>
			<div class="col-xs-1">
				<p>telephone</p>
				<input type="number" class="form-control" name="telephone" value="'.$update[0]["telephone"].'" />
			</div>
			<div class="col-xs-1">
				<p>profession</p>
				<input type="text" class="form-control" name="profession" value="'.$update[0]["profession"].'" />
			</div>
			<div class="col-xs-1">
				<p>ville</p>
				<input type="text" class="form-control" name="ville" value="'.$update[0]["ville"].'" />
			</div>
			<div class="col-xs-1">
				<p>code postal</p>
				<input type="text" class="form-control" name="codepostal" value="'.$update[0]["codepostal"].'" />
			</div>
			<div class="col-xs-1">
				<p>adresse</p>
				<textarea name="adresse" class="form-control" rows="2">'.$update[0]["adresse"].'</textarea>
			</div>
			<div class="col-xs-1">
				<p>date de naissance</p>
				<input type="date" class="form-control" name="date_de_naissance" value="'.$update[0]["date_de_naissance"].'" />
			</div>
			<div class="col-xs-1">
				<p>sexe</p>
				<input type="radio" name="sexe" value="m" id="sexeHomme" '. $sexeM .' /> 
				<label for="sexeHomme">Homme</label><br />
   				<input type="radio" name="sexe" value="f" id="sexeFemme" '. $sexeF .' /> 
   				<label for="sexeFemme">Femme</label>
			</div>
			<div class="col-xs-1">
				<p>description</p>
				<textarea name="description" class="form-control" rows="2">'.$update[0]["description"].'</textarea>
			</div>
			<div class="col-xs-1">
				<input type="submit" class="btn btn-primary" value="Valider">
			</div>
		</form>';
	}
	// SUPPRESSION
	if (isset($_GET['stat']) && $_GET['stat'] == "delete" && isset($_GET['id'])) {
		$id = $_GET['id'];
		$em->remove($id);
		unset($_GET);
		header('Location:affichage_annuaire.php?response=ok&id='.$id);
	}
}

$error = "";
if ($_POST) {
	// var_dump($_POST);
	// ------------ CONTROLES ET ERREURS :

	$error .= (strlen($_POST['nom']) > 30) ? "<p class='alert alert-danger'>Le nom est trop long ! (-30cara)</p>" : "";
	$error .= (strlen($_POST['prenom']) > 30) ? "<p class='alert alert-danger'>Le prenom est trop long ! (-30cara)</p>" : "";
	$error .= (!preg_match("/[0-9]{10}/", $_POST['telephone'])) ? "<p class='alert alert-danger'>Mauvais format pour le téléphone ! (10 chiffres max)</p>" : "";
 	
	// ------------ VALIDATION :
	
	if( empty($error) ){ // Si $error est vide donc pas d error
		$em->replace($_POST);
		$id = $_POST['id_annuaire'];
		header('Location:affichage_annuaire.php?response=modif&id='.$id);
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Gestionnaire de l'annuaire</title>
		<link rel="stylesheet" type="text/css" href="../Assets/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="../Assets/fontAwesome/css/font-awesome.min.css" />
		<style type="text/css">table { margin: 0 auto!important; }</style>
	</head>
	<body style="padding-bottom: 50px;">

		<?php
			echo $error;
			echo $response; 
			if(isset($_GET['stat']) && $_GET['stat'] == "edit" && isset($_GET['id'])) { 
				$em->stylish($update);
				echo "<br />"; 
				echo $formulaire;
			}
		?>

		<p style="text-align: center;"><a href="formulaire.php">Retour au Formulaire</a></p>

		<?php

			echo '<table class="table" style="width:100%; margin: 10px 0;" border="1"><tr>';
			for($i=0; $i < $em->columnCount(); $i++)
			{
				echo '<th style="text-align:left;">' . $em->getColumnMeta($i)['name'] . '</th>';
			}
			echo "<th>Edit</th><th>Delete</th>";
			echo '</tr>';
			foreach ($content as $tab) 
			{
				echo '<tr>';
				foreach ($tab as $info) 
				{
					echo '<td>' . $info . '</td>';
				}
				echo "<td><a href='?stat=edit&id=".$tab['id_annuaire']."'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>";
				echo "<td><a href='?stat=delete&id=".$tab['id_annuaire']."' onClick='return(confirm(\"En etes vous certain ?\"))'><i class='fa fa-trash-o' aria-hidden='true'></i></a></td>";
				echo '</tr>';
			}
			echo '</table>';

		?>

		<?= '<p>Il y a '. $totalM . ' homme(s) et ' . $totalF . ' femme(s)</p>'; ?>

	</body>
</html>