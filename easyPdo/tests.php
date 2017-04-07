<?php

require "Bdd.php";

// Connexion à la bdd :

$em = new Bdd();

echo "<hr />";
echo '<p><strong>Methode : setTable("annuaire") :</strong></p>';
$em->setTable("annuaire");
$table = $em->getTable();
echo "La table déclarée est : <strong>".$table."</strong>";

echo "<hr />";
echo '<p><strong>Methode : getClassMethods($em) :</strong></p>';
$getClass = $em->getClassMethods($em);
$em->stylish($getClass);

echo "<hr />";
echo '<p><strong>Methode : showBdd() :</strong></p>';
$bdd = $em->showBdd();
$em->stylish($bdd);

echo "<hr />";
echo '<p><strong>Methode : showTable() :</strong></p>';
$show = $em->showTable();
$em->stylish($show);

echo "<hr />";
echo '<p><strong>Methode : descTable() :</strong></p>';
$desc = $em->descTable();
$em->stylish($desc);

echo "<hr />";
echo '<p><strong>Methode : primaryKey() :</strong></p>';
echo "<p>Clé(s) primary de la table " . $em->getTable() . " : " . $em->primaryKey() . "</p>";

echo "<hr />";
echo '<p><strong>Methode : $em->columnCount() :</strong></p>';
echo "<p>Il y a ". ($em->columnCount()) ." champ(s)/colonne(s) au total.</p>";

echo "<hr />";
echo '<p><strong>Methode : $em->rowCount() :</strong></p>';
echo "<p>Il y a ". ($em->rowCount()) ." ligne(s) au total.</p>";

echo "<hr />";
echo '<p><strong>Methode : $em->rowCount("sexe", "f") :</strong></p>';
$totalF = $em->rowCount("sexe", "f");
echo '<p>Il y a ' . $totalF . ' femme(s)</p>';

echo "<hr />";
echo '<p><strong>Methode : find(6) :</strong></p>';
$uniqueContent = $em->find(6);
$em->stylish($uniqueContent);

echo "<hr />";
echo '<p><strong>Methode : findAll() :</strong></p>';
$content = $em->findAll("id_annuaire", "DESC");
$em->stylish($content);

echo "<hr />";
echo '<p><strong>Methode : remove(25) :</strong></p>';
$delete = $em->remove(25);
echo "l'ID : 25 à bien été supprimer !";

echo "<hr />";
echo '<p><strong>Methode : getColumnMeta($i) :</strong></p>';
$meta = $em->getColumnMeta(1);
var_dump($meta);

