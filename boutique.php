<link rel="stylesheet" href="bootstrap-5.0.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-5.0.2/dist/css/bootstrap.css">
<?php
require_once("inc/init.inc.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
//--- AFFICHAGE DES CATEGORIES ---//
$categories_des_produits = executeRequete("SELECT DISTINCT categorie FROM produit");
$contenu .= '<div class="boutique-gauche">';
$contenu .= "<ul>";
while($cat = $categories_des_produits->fetch_assoc())
{
	$contenu .= "<li><a href='?categorie="	. $cat['categorie'] . "'>" . $cat['categorie'] . "</a></li>";
}
$contenu .= "</ul>";
$contenu .= "</div>";
//--- AFFICHAGE DES PRODUITS ---//
$contenu .= '<div class="boutique-droite">';
if(isset($_GET['categorie']))
{
	$donnees = executeRequete("SELECT id_produit,reference,titre,photo,prix FROM produit WHERE categorie='$_GET[categorie]'");	
	while($produit = $donnees->fetch_assoc())
	{
		$contenu .= '<div class="boutique-produit">';
		$contenu .= "<h3>$produit[titre]</h3>";
		$contenu .= "<a href=\"fiche_produit.php?id_produit=$produit[id_produit]\"><img src=\"$produit[photo]\" width=\"130\" height=\"100\" /></a>";
		$contenu .= "<p>$produit[prix] $</p>";
		$contenu .= '<a href="fiche_produit.php?id_produit=' . $produit['id_produit'] . '">Voir la fiche</a>';
		$contenu .= '</div>';
	}
}
$contenu .= '</div>';
//--------------------------------- AFFICHAGE HTML ---------------------------------//
require_once("inc/header.php");
echo $contenu;
require_once("inc/footer.php");