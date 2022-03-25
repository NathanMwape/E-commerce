<link rel="stylesheet" href="../bootstrap-5.0.2/dist/css/bootstrap.css">
<link rel="stylesheet" href="../bootstrap-5.0.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.css">
<?php
// ----------- Ce code est li� � l'eval du dernier jour et n'est donc pas � pr�senter durant le cours ------------- //	
require_once("../inc/init.inc.php");
if(!internauteEstConnecteEtEstAdmin())
{
	header("location:../connexion.php");
	exit();
}
if(isset($_GET['msg']) && $_GET['msg'] == "supok")
{
	executeRequete("DELETE from membre where id_membre=$_GET[id_membre]");
	header("Location:gestion_membre.php");
}
//-------------------------------------------------- Affichage ---------------------------------------------------------//
require_once("../inc/header.php");
//require_once("../inc/menu.inc.php");
echo '<h3> Voici les membres inscrit au site </h3>';
	$resultat = executeRequete("SELECT * FROM membre");
	echo "Nombre de membre(s) : " . $resultat->num_rows.'<br/><br>';
	echo "<table style='border-color:blue' class='table table-bordered table-striped'> <tr>";
	while($colonne = $resultat->fetch_field())
	{    
		echo '<th>' . $colonne->name . '</th>';
	}
	echo '<th> Supprimer </th>';
	echo "</tr>";
	while ($membre = $resultat->fetch_assoc())
	{
		echo '<tr>';
		foreach ($membre as $information)
		{
			echo '<td>' . $information . '</td>';
		}
		echo "<td><a href='gestion_membre.php?msg=supok&&id_membre=" . $membre['id_membre'] . "' onclick='return(confirm(\"Etes-vous sùr de vouloir supprimer ce membre?\"));'>
		<i class='fa fa-trash fa-3x'><i> </a></td>";
		echo '</tr>';
	}
	echo '</table>';