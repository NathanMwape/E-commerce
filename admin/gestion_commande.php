<link rel="stylesheet" href="../bootstrap-5.0.2/dist/css/bootstrap.css">
<link rel="stylesheet" href="../bootstrap-5.0.2/dist/css/bootstrap.min.css">
<?php
require_once("../inc/init.inc.php");
if(!internauteEstConnecteEtEstAdmin())
{
	header("location:../connexion.php");
	exit();
}
//-------------------------------------------------- Affichage ---------------------------------------------------------//
require_once("../inc/header.php");
//require_once("../inc/menu.inc.php");
	echo '<h3> Voici les commandes passées sur le site </h3>';
	echo '<table border="1" class="table table-bordered table-striped"><tr>';
	
	$information_sur_les_commandes = executeRequete("SELECT c.*, m.pseudo, m.adresse, m.ville,m.code_postal FROM commande c left join membre m ON  m.id_membre = c.id_membre");
	echo "Nombre de commande(s) : " . $information_sur_les_commandes->num_rows;
	echo "<table style='border-color:blue' class='table table-bordered table-striped'> <tr>";
	while($colonne = $information_sur_les_commandes->fetch_field())
	{    
		echo '<th>' . $colonne->name . '</th>';
	}
	echo "</tr>";
	$chiffre_affaire = 0;
	while ($commande = $information_sur_les_commandes->fetch_assoc())
	{
		$chiffre_affaire += $commande['montant'];
		echo '<div>'.
		'<tr>'.
			'<td><a href="gestion_commande.php?suivi=' . $commande['id_commande'] . '">Voir la commande ' . $commande['id_commande'] . '</a></td>'.
			'<td>' . $commande['id_membre'] . '</td>'.
			'<td>' . $commande['montant'] . '</td>'.
			'<td>' . $commande['date_enregistrement'] . '</td>'.
			'<td>' . $commande['etat'] . '</td>'.
			'<td>' . $commande['pseudo'] . '</td>'.
			'<td>' . $commande['adresse'] . '</td>'.
			'<td>' . $commande['ville'] . '</td>'.
			'<td>' . $commande['code_postal'] . '</td>'.
		'</tr>	'.
		'</div>';
	}
	echo '</table><br />'.'
	<b>Calcul du montant total des revenus:  <b>'."<br>
	le chiffre d'affaires de la societe est de : $chiffre_affaire $ <br><br>"; 
	

	if(isset($_GET['suivi']))
	{	
		echo '<h1> Voici le détails pour une commande</h1>'.
		'<table border="1" >'.
		'<tr>';
		$information_sur_une_commande = executeRequete("SELECT * from details_commande where id_commande=$_GET[suivi]");
		
		$nbcol = $information_sur_une_commande->field_count;
		echo "<table style='border-color:blue' class='table table-bordered table-striped'> <tr>";
		for ($i=0; $i < $nbcol; $i++)
		{    
			$colonne = $information_sur_une_commande->fetch_field(); 
			echo '<th>' . $colonne->name . '</th>';
		}
		echo "</tr>";

		while ($details_commande = $information_sur_une_commande->fetch_assoc())
		{
			echo '<tr>'.
				'<td>' . $details_commande['id_details_commande'] . '</td>'.
				'<td>' . $details_commande['id_commande'] . '</td>'.
				'<td>' . $details_commande['id_produit'] . '</td>'.
				'<td>' . $details_commande['quantite'] . '</td>'.
				'<td>' . $details_commande['prix'] . '</td>'.
			'</tr>';
		}
		echo '</table>';
	}