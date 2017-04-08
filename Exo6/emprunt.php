<?php
require "inc/function.inc.php";

  $abonne = $em->setTable("abonne")->findAll();
  $livre = $em->setTable("livre")->findAll();

$emprunt = $em->setTable("emprunt")->findAll("id_emprunt", "DESC", 3);
var_dump($emprunt);

$erreur = '';
if ( isset($_GET) && isset($_GET['method']) == "insert" ) {
  $erreur .= '<div class="alert alert-success"><p>L\'emprunt à bien été ajouté.</p></div>';
}
if($_POST){

  // ------------ CONTROLES ET ERREURS :
  if ( empty($_POST['id_abonne']) || empty($_POST['id_livre']) || empty($_POST['date_sortie']) ) {
    $erreur .= '<div class="alert alert-alert"><p>Les champs "Abonné", "Livre" et "Date Sortie" doivent etre renseigner.</p></div>';
  }
  if ($_POST['date_rendu'] == '') {
    $_POST['date_rendu'] = NULL;
  }

  // ------------ VALIDATION :
  if( empty($erreur) ){ // Si $erreur est vide donc pas d erreur
    $em->replace($_POST);
    header('location:emprunt.php?method=insert');
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
      
      label { width: 100%; }
      select, input {
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
      }

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

    	<h1>emprunt(s)</h1>

      <?= $erreur; ?>

      <form method="post" action="emprunt.php">
        
        <div class="form-group">
          <label for="abonne">Abonné</label>
          <select name="id_abonne" id="abonne">
            <?php
              foreach ($abonne as $value) {
                echo "<option value='".$value['id_abonne']."'>".$value['id_abonne'].' - '.$value['prenom']."</option>";
              }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="livre">Livre</label>
          <select name="id_livre" id="livre">
            <?php
              foreach ($livre as $value) {
                echo "<option value='".$value['id_livre']."'>".$value['id_livre'].' - '.$value['auteur']." | ".$value['titre']."</option>";
              }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="dateSorti">Date Sortie</label>
          <input type="date" name="date_sortie" id="dateSorti">
        </div>

        <div class="form-group">
          <label for="dateRendu">Date Rendu</label>
          <input type="date" name="date_rendu" id="dateRendu">
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