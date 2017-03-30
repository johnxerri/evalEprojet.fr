<?php
//----------------------------------------------------------------------------------------------------------
// Enregistrement :
if($_POST)
{
	if(isset($_POST['id_abonne'])) $id_abonne = $_POST['id_abonne']; else $id_abonne = ''; 
	$resultat = $mysqli->query("REPLACE INTO abonne(id_abonne,prenom) VALUES('$id_abonne', '$_POST[prenom]')");
	if(!empty($mysqli->error)) header('location:?page=abonne&enregistrement=erreur');
	else  header('location:?page=abonne&enregistrement=valide');
}
//----------------------------------------------------------------------------------------------------------
// Suppression
if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{
	$resultat = $mysqli->query("DELETE FROM abonne WHERE id_abonne=$_GET[id_abonne]");
	if(!empty($mysqli->error)) $contenu .= $suppressionErreur;
	else $contenu .= $suppressionValide;
	$_GET['action'] = '';
}
//----------------------------------------------------------------------------------------------------------
// Message
if(isset($_GET['enregistrement']))
{
	if($_GET['enregistrement'] == 'valide')	 $contenu .= $enregistrementValide;
	else $contenu .= $enregistrementErreur;
}
//----------------------------------------------------------------------------------------------------------
// Affichage
	$resultat = $mysqli->query("SELECT * FROM abonne");
	$contenu .= '<table class="table">';
	$contenu .= '<tr>';
	while($affichage_champs_abonne = $resultat->fetch_field())
	{
		$contenu .= '<th>' . $affichage_champs_abonne->name . '</th>';
	}
	$contenu .= '<th>modification</th>';
	$contenu .= '<th>suppression</th>';
	$contenu .= '</tr>';
	while($affichage_abonne = $resultat->fetch_assoc())
	{
		$contenu .= '<tr>';
		foreach($affichage_abonne as $indice => $valeur )
		{
			$contenu .= '<td>' . $valeur . '</td>';
		}
		$contenu .= '<td><a href="?page=abonne&action=modification&id_abonne='.$affichage_abonne['id_abonne'].'"><span class="glyphicon glyphicon-pencil"></span></a></td>';
		$contenu .= '<td><a href="?page=abonne&action=suppression&id_abonne='.$affichage_abonne['id_abonne'].'"><span class="glyphicon glyphicon-remove"></span></a></td>';
		$contenu .= '</tr>';
	}
	$contenu .= '</table>';
//----------------------------------------------------------------------------------------------------------
// Ajout/Modif
$modif = false;
$contenu .= '<form method="post" action="">
 <div class="form-group">';
if(isset($_GET['action']) && $_GET['action'] == 'modification')
{
	$modif = true;
	$resultat = $mysqli->query("SELECT * FROM abonne WHERE id_abonne = $_GET[id_abonne]");
	$abonne = $resultat->fetch_assoc();
	$contenu .= '<input type="hidden" name="id_abonne" value="' . $abonne['id_abonne'] . '">'; 
}
$contenu .= '<label for="prenom">Prenom</label>
	<input type="text" name="prenom" id="prenom" class="form-control" placeholder="prenom"';
	if($modif) $contenu .= " value=\"$abonne[prenom]\"";
	$contenu .= '><br>';
	
	$contenu .= '<input type="submit" value="';
		if($modif) $contenu .= 'Modification';
		else $contenu .= 'Ajouter';
	$contenu .= '" class="btn btn-default">
</div>
</form>';