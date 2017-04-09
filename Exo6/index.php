<?php

require "inc/function.inc.php"; 

// EXO 6.1 : DONE
 
// EXO 6.2 : DONE

// EXO 6.3 : DONE

// EXO 6.4 : DONE

// EXO 6.5 : DONE

// EXO 6.6 : 

$abonne = $em->setTable("abonne")->findAll("id_abonne", "DESC");

$erreur = '';
if ($_GET) {
	
	/* ==================================================================== */
  	// MESSAGE D AJOUT
	if ( isset($_GET['method']) && $_GET['method'] == "insert" && isset($_GET['name']) ) {
		$erreur .= '<div class="alert alert-success"><p>L\'abonné '.$_GET['name'].' à bien été ajouté.</p></div>';
	}
	// MESSAGE DE SUPPRESSION
	if ( isset($_GET['method']) && $_GET['method'] == "suppr" && !empty($_GET['id']) ) {
		$erreur .= '<div class="alert alert-success"><p>L\'abonné '.$_GET['id'].' à bien été supprimé.</p></div>';
	}
	// MESSAGE DE MODIF
	if ( isset($_GET['method']) && $_GET['method'] == "modif" && isset($_GET['name']) ) {
    	$erreur .= '<div class="alert alert-success"><p>L\'abonné '.$_GET['name'].' à bien été modifié.</p></div>';
  	}

	/* ==================================================================== */
	// SUPPRESSION 
	if ( isset($_GET['stat']) && $_GET['stat'] == "delete" && !empty($_GET['id']) ) {
		$id = $_GET['id'];
		$em->remove($id);
		header('location:index.php?method=suppr&id='.$id);
	}
	// MODIFICATION
  	if ( isset($_GET['stat']) && $_GET['stat'] == "edit" && !empty($_GET['id']) ) {
    	$id = $_GET['id'];
    	$modif = $em->find($id);
  	}

}

if($_POST){

	// ------------ CONTROLES ET ERREURS :
	// Controle de la taille
	if(strlen($_POST['prenom']) <= 3 || strlen($_POST['prenom']) > 25){

		$erreur .= '<div class="alert alert-danger"><p>Le prenom fait : ' . strlen($_POST['prenom']) . ' caractères</p>';
		$erreur .= '<p>Le prenom doit etre compris entre 3 caracteres min et 25 caracteres max.</p></div>';

	} 
	// ------------ VALIDATION :
	if( empty($erreur) ){ // Si $erreur est vide donc pas d erreur
		$prenom = $_POST['prenom'];
		if (!empty($_POST['id_abonne'])) {
			$em->update($_POST);
      		header('location:index.php?method=modif&name='.$prenom);
	    } else {
	    	$em->replace($_POST);
	      	header('location:index.php?method=insert&name='.$prenom);
	    }
	}

}

// VARIABLE DE VALUE :
$valueId = (!empty($modif[0]['id_abonne'])) ? '<input type="hidden" name="id_abonne" value="'.$modif[0]['id_abonne'].'" />' : '';

$valuePrenom = (!empty($modif[0]['prenom'])) ? 'value="'.$modif[0]['prenom'].'"' : '';

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Site pour m'entrainé avec le language PHP">
    <meta name="author" content="Alex Hitchens">
    <link rel="icon" href="favicon.ico">

    <title>Bibliothèque</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <style type="text/css">
    	table, th, td { text-align: center; }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body style="margin-top: 90px;">

  	<!-- MENU -->
    <?php require "inc/menu.php"; ?>

    <div class="container">

    	<?= $erreur; ?>

    	<?= '<p>Nombre d\'abonnés : <span class="badge">'.$em->rowCount().'</span></p>'; ?>

    	<?php 
    		echo '<table class="table" style="width:100%; margin: 30px 0;"><thead><tr>';
			for($i=0; $i < $em->columnCount(); $i++)
			{
				echo '<th>' . $em->getColumnMeta($i)['name'] . '</th>';
			}
			echo "<th>Edit</th><th>Delete</th>";
			echo '</tr></thead><tbody>';
			foreach ($abonne as $tab) 
			{
				echo '<tr>';
				foreach ($tab as $info) 
				{
					echo '<td>' . $info . '</td>';
				}
				echo "<td><a href='?stat=edit&id=".$tab['id_abonne']."'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>";
				echo "<td><a href='?stat=delete&id=".$tab['id_abonne']."' onClick='return(confirm(\"En etes vous certain ?\"))'><i class='fa fa-trash-o' aria-hidden='true'></i></a></td>";
				echo '</tr>';
			}
			echo '</tbody></table>';
    	?>

    	<form method="post" action="index.php">

    		<?= $valueId; ?>
    		
    		<div class="form-group">
			    <label for="prenom">Prénom</label>
			    <input type="text" name="prenom" class="form-control" id="prenom" placeholder="prénom" <?= $valuePrenom; ?> />
			</div>

			<button type="submit" class="btn btn-default"><?= (!empty($_GET['stat']) && $_GET['stat'] == 'edit') ? "Modifier" : "Ajouter"; ?></button>

    	</form>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
