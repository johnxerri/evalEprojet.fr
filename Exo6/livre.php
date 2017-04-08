<?php
require "inc/function.inc.php";

$livre = $em->setTable("livre")->findAll("id_livre", "DESC");

$erreur = '';
if (isset($_GET) && isset($_GET['method']) == "insert" && isset($_GET['auteur']) && isset($_GET['titre'])) {
  $erreur .= '<div class="alert alert-success"><p>Le livre '.$_GET['titre'].' de l\'auteur '.$_GET['auteur'].' à bien été ajouté.</p></div>';
}
if($_POST){

  // ------------ CONTROLES ET ERREURS :
  // Controle de la taille
  if(strlen($_POST['auteur']) <= 3 || strlen($_POST['auteur']) > 25){

    $erreur .= '<div class="alert alert-danger"><p>L\'auteur fait : ' . strlen($_POST['auteur']) . ' caractères</p>';
    $erreur .= '<p>L\'auteur doit etre compris entre 3 caracteres min et 25 caracteres max.</p></div>';

  } 
  if(strlen($_POST['titre']) <= 3 || strlen($_POST['titre']) > 50){

    $erreur .= '<div class="alert alert-danger"><p>Le titre fait : ' . strlen($_POST['titre']) . ' caractères</p>';
    $erreur .= '<p>Le titre doit etre compris entre 3 caracteres min et 50 caracteres max.</p></div>';

  } 
  // ------------ VALIDATION :
  if( empty($erreur) ){ // Si $erreur est vide donc pas d erreur
    $_POST['auteur'] = strtoupper($_POST['auteur']);
    $auteur = $_POST['auteur'];
    $titre = $_POST['titre'];
    $em->replace($_POST);
    header('location:livre.php?method=insert&auteur='.$auteur.'&titre='.$titre);
  }

}

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

  <body style="margin-top: 50px;">

  	<!-- MENU -->
    <?php require "inc/menu.php"; ?>

    <div class="container">

    	<h1>livre(s)</h1>

      <?= $erreur; ?>

      <?php 
        echo '<table class="table" style="width:100%; margin: 30px 0;"><thead><tr>';
        for($i=0; $i < $em->columnCount(); $i++)
        {
          echo '<th>' . $em->getColumnMeta($i)['name'] . '</th>';
        }
        echo "<th>Edit</th><th>Delete</th>";
        echo '</tr></thead><tbody>';
        foreach ($livre as $tab) 
        {
          echo '<tr>';
          foreach ($tab as $info) 
          {
            echo '<td>' . $info . '</td>';
          }
          echo "<td><a href='?stat=edit&id=".$tab['id_livre']."'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>";
          echo "<td><a href='?stat=delete&id=".$tab['id_livre']."' onClick='return(confirm(\"En etes vous certain ?\"))'><i class='fa fa-trash-o' aria-hidden='true'></i></a></td>";
          echo '</tr>';
        }
        echo '</tbody></table>';
      ?>

      <form method="post" action="livre.php">
        
        <div class="form-group">
          <label for="auteur">Auteur</label>
          <input type="text" name="auteur" class="form-control" id="auteur" placeholder="auteur">
        </div>

        <div class="form-group">
          <label for="titre">Titre</label>
          <input type="text" name="titre" class="form-control" id="titre" placeholder="titre">
        </div>

        <button type="submit" class="btn btn-default">Ajouter</button>

      </form>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
