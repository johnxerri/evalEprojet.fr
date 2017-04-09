<?php
require "inc/function.inc.php";

$abonne = $em->setTable("abonne")->findAll();
$livre = $em->setTable("livre")->findAll();
$emprunt = $em->setTable("emprunt")->findAll("id_emprunt", "DESC");

$erreur = '';
if ($_GET) {

  /* ==================================================================== */
  // MESSAGE D AJOUT
  if ( isset($_GET['method']) && $_GET['method'] == "insert" ) {
    $erreur .= '<div class="alert alert-success"><p>L\'emprunt à bien été ajouté.</p></div>';
  }
  // MESSAGE DE SUPPRESSION
  if ( isset($_GET['method']) && $_GET['method'] == "suppr" && !empty($_GET['id']) ) {
    $erreur .= '<div class="alert alert-success"><p>L\'emprunt '.$_GET['id'].' à bien été supprimé.</p></div>';
  }
  // MESSAGE DE MODIF
  if ( isset($_GET['method']) && $_GET['method'] == "modif" ) {
    $erreur .= '<div class="alert alert-success"><p>L\'emprunt à bien été modifié.</p></div>';
  }

  /* ==================================================================== */
  // SUPPRESSION 
  if ( isset($_GET['stat']) && $_GET['stat'] == "delete" && !empty($_GET['id']) ) {
    $id = $_GET['id'];
    $em->remove($id);
    header('location:emprunt.php?method=suppr&id='.$id);
  }
  // MODIFICATION
  if ( isset($_GET['stat']) && $_GET['stat'] == "edit" && !empty($_GET['id']) ) {
    $id = $_GET['id'];
    $modif = $em->find($id);
  }

  /* ==================================================================== */

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
    if (!empty($_POST['id_emprunt'])) {
      header('location:emprunt.php?method=modif');
    } else {
      header('location:emprunt.php?method=insert');
    }
  }

}

// VARIABLE DE VALUE :
$valueId = (!empty($modif[0]['id_emprunt'])) ? '<input type="hidden" name="id_emprunt" value="'.$modif[0]['id_emprunt'].'" />' : '';

$valueDateSorti = (!empty($modif[0]['date_sortie'])) ? 'value="'.$modif[0]['date_sortie'].'"' : '';
$valueDateRendu = (!empty($modif[0]['date_rendu'])) ? 'value="'.$modif[0]['date_rendu'].'"' : '';

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

    <div class="container" style="padding-bottom: 40px;">

    	<h1>emprunt(s)</h1>

      <?= $erreur; ?>

      <?= '<p>Nombre d\'emprunts : <span class="badge">'.$em->rowCount().'</span></p>'; ?>

      <?php 
        echo '<table class="table" style="width:100%; margin: 30px 0;"><thead><tr>';
        for($i=0; $i < $em->columnCount(); $i++)
        {
          echo '<th>' . $em->getColumnMeta($i)['name'] . '</th>';
        }
        echo "<th>Edit</th><th>Delete</th>";
        echo '</tr></thead><tbody>';
        foreach ($emprunt as $tab) 
        {
          echo '<tr>';
          foreach ($tab as $info) 
          {
            echo '<td>' . $info . '</td>';
          }
          echo "<td><a href='?stat=edit&id=".$tab['id_emprunt']."'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>";
          echo "<td><a href='?stat=delete&id=".$tab['id_emprunt']."' onClick='return(confirm(\"En etes vous certain ?\"))'><i class='fa fa-trash-o' aria-hidden='true'></i></a></td>";
          echo '</tr>';
        }
        echo '</tbody></table>';
      ?>

      <form method="post" action="emprunt.php">
        
        <?= $valueId; ?>

        <div class="form-group">
          <label for="abonne">Abonné</label>
          <select name="id_abonne" id="abonne">
            <?php
              foreach ($abonne as $value) {
                if ($modif[0]['id_abonne'] == $value['id_abonne']) {
                  echo "<option value='".$value['id_abonne']."' selected>".$value['id_abonne'].' - '.$value['prenom']."</option>";
                } else {
                  echo "<option value='".$value['id_abonne']."'>".$value['id_abonne'].' - '.$value['prenom']."</option>";
                }
              }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="livre">Livre</label>
          <select name="id_livre" id="livre">
            <?php
              foreach ($livre as $value) {
                if ($modif[0]['id_livre'] == $value['id_livre']) {
                  echo "<option value='".$value['id_livre']."' selected>".$value['id_livre'].' - '.$value['auteur']." | ".$value['titre']."</option>";
                } else {
                  echo "<option value='".$value['id_livre']."'>".$value['id_livre'].' - '.$value['auteur']." | ".$value['titre']."</option>";
                }
              }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="dateSorti">Date Sortie</label>
          <input type="date" name="date_sortie" id="dateSorti" <?= $valueDateSorti; ?> />
        </div>

        <div class="form-group">
          <label for="dateRendu">Date Rendu</label>
          <input type="date" name="date_rendu" id="dateRendu" <?= $valueDateRendu; ?> />
        </div>

        <button type="submit" class="btn btn-default"><?= (!empty($_GET['stat']) && $_GET['stat'] == 'edit') ? "Modifier" : "Ajouter"; ?></button>

      </form>

      <br /><hr /><br />
      <!-- Afficher les numéros et titres des livres n’ayant pas été rendus à la bibliothèque -->
      <?php 
        $resultat = $em->sqlQuery("SELECT id_livre, auteur, titre AS 'Livre non RENDU' FROM livre WHERE id_livre IN ( SELECT id_livre FROM emprunt WHERE date_rendu IS NULL )"); 
        $em->stylish($resultat);
      ?>
      <!-- Afficher le n° de(s) livre(s) que Chloé a emprunté à la bibliothèque -->
      <?php 
        $resultat = $em->sqlQuery("SELECT id_livre AS 'Livre emprunté par Chloé' FROM emprunt WHERE id_abonne = '3' IN (SELECT id_abonne FROM abonne WHERE prenom = 'Chloé')"); 
        $em->stylish($resultat);
      ?>
      <!-- Afficher la liste des abonnés ayant déjà emprunté un livre d’Alphonse DAUDET -->
      <?php 
        $resultat = $em->sqlQuery("SELECT prenom AS 'Abonnés ayant déja emprunté un livre d\'Alphonse Daudet.' FROM abonne WHERE id_abonne IN (SELECT id_abonne FROM emprunt WHERE id_livre IN (SELECT id_livre FROM livre WHERE auteur = 'ALPHONSE DAUDET'))"); 
        $em->stylish($resultat);
      ?>
      <!-- Afficher les titres des livres que Chloé n’a pas encore rendus à la bibliothèque -->
      <?php 
        $resultat = $em->sqlQuery("SELECT titre AS 'Livres que Chloé n\'a pas encore rendu' FROM livre WHERE id_livre IN (SELECT id_livre FROM emprunt WHERE date_rendu IS NULL AND id_abonne = (SELECT id_abonne FROM abonne WHERE prenom = 'Chloe'  ))"); 
        $em->stylish($resultat);
      ?>
      <!-- Afficher les titres des livres que Chloé n’a pas encore empruntés -->
      <?php 
        $resultat = $em->sqlQuery("SELECT titre AS 'Livres que Chloé n\'a pas emprunté' FROM livre WHERE id_livre NOT IN (SELECT id_livre FROM emprunt WHERE id_abonne IN (SELECT id_abonne FROM abonne WHERE prenom = 'Chloe'))"); 
        $em->stylish($resultat);
      ?>
      <!-- Afficher le prénom de l’abonné ayant emprunté le plus de livres -->
      <?php 
        $resultat = $em->sqlQuery("
          SELECT a.prenom, COUNT(e.id_livre) AS 'livreEmprunté'
          FROM abonne a, emprunt e
          WHERE a.id_abonne = e.id_abonne
          GROUP BY a.prenom;
        "); 
        $max = count($resultat);
        $precedent = 0;
        $maxAbonne = [];
        for ($i=0; $i < $max; $i++) { 
          if ( $resultat[$i]['livreEmprunté'] > $precedent ) {
            $precedent = $resultat[$i]['livreEmprunté'];
            $maxAbonne['prenom'] = $resultat[$i]['prenom'];
            $maxAbonne['livreEmprunté'] = $resultat[$i]['livreEmprunté'];
          }
        }
        echo "<p>Prénom de l’abonné ayant emprunté le plus de livres : ".$maxAbonne['prenom']."</p>";
      ?>
      <!-- Afficher le nombre de livre emprunté par Guillaume -->
      <?php 
        $resultat = $em->sqlQuery("SELECT titre AS 'Livres que Chloé a emprunté' FROM livre WHERE id_livre IN (SELECT id_livre FROM emprunt WHERE id_abonne = (SELECT id_abonne FROM abonne WHERE prenom = 'Guillaume'))"); 
        echo "<p>Nombre de livre emprunté par Guillaume : ".count($resultat)."</p>";
      ?>
      <!-- Afficher la liste des abonnés ayant emprunté le livre « Une Vie » sur l’année 2011 -->
      <?php 
        $resultat = $em->sqlQuery("
          SELECT a.prenom, l.titre, e.date_sortie
          FROM abonne a, livre l, emprunt e
          WHERE a.id_abonne = e.id_abonne
          AND l.id_livre = e.id_livre
          AND l.titre = 'Une vie'
          AND e.date_sortie LIKE '2011%'
        ");
        if (empty($resultat)) {
          echo "Liste des abonnés ayant emprunté le livre « Une Vie » sur l’année 2011 : Personne";
        } else {
          echo "<p>Liste des abonnés ayant emprunté le livre « Une Vie » sur l’année 2011 :</p>";
          $em->stylish($resultat);
        }
      ?>
      <!-- Afficher le nombre de livres empruntés par chaque abonné -->
      <?php 
        $resultat = $em->sqlQuery("
          SELECT a.prenom, COUNT(e.id_livre) AS 'Nombre de livre emprunté'
          FROM abonne a, emprunt e
          WHERE a.id_abonne = e.id_abonne
          GROUP BY a.prenom
        "); 
        $em->stylish($resultat);
      ?>
      <!-- Afficher la liste des abonnés avec les titres des livres qu’ils ont empruntés ainsi que la date de l’emprunt -->
      <?php 
        $resultat = $em->sqlQuery("
          SELECT a.prenom, l.titre, e.date_sortie
          FROM abonne a, livre l, emprunt e
          WHERE a.id_abonne = e.id_abonne
          AND l.id_livre = e.id_livre
        "); 
        $em->stylish($resultat);
      ?>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>