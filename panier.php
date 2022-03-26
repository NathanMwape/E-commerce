<link rel="stylesheet" href="bootstrap-5.1.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-5.1.3/dist/css/bootstrap.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
<?php
require_once("inc/init.inc.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
//--- AJOUT PANIER ---//
if(isset($_POST['ajout_panier'])) 
{	// debug($_POST);
	$resultat = executeRequete("SELECT * FROM produit WHERE id_produit='$_POST[id_produit]'");
	$produit = $resultat->fetch_assoc();
	ajouterProduitDansPanier($produit['titre'],$_POST['id_produit'],$_POST['quantite'],$produit['prix']);
}
//--- VIDER PANIER ---//
if(isset($_GET['action']) && $_GET['action'] == "vider")
{
	unset($_SESSION['panier']);
}
//--- PAIEMENT ---//
if(isset($_POST['payer']))
{
	for($i=0 ;$i < count($_SESSION['panier']['id_produit']) ; $i++) 
	{
		$resultat = executeRequete("SELECT * FROM produit WHERE id_produit=" . $_SESSION['panier']['id_produit'][$i]);
		$produit = $resultat->fetch_assoc();
		if($produit['stock'] < $_SESSION['panier']['quantite'][$i])
		{
			$contenu .= '<hr /><div class="erreur">Stock Restant: ' . $produit['stock'] . '</div>';
			$contenu .= '<div class="erreur">Quantite demandée: ' . $_SESSION['panier']['quantite'][$i] . '</div>';
			if($produit['stock'] > 0)
			{
				$contenu .= '<div class="erreur">la quantite de l\'produit ' . $_SESSION['panier']['id_produit'][$i] . ' a été réduite car notre stock etait insuffisant, veuillez vérifier vos achats.</div>';
				$_SESSION['panier']['quantite'][$i] = $produit['stock'];
			}
			else
			{
				$contenu .= '<div class="erreur">l\'produit ' . $_SESSION['panier']['id_produit'][$i] . ' a été retiré de votre panier car nous sommes en rupture de stock, veuillez vérifier vos achats.</div>';
				retirerproduitDuPanier($_SESSION['panier']['id_produit'][$i]);
				$i--;
			}
			$erreur = true;
		}
	}
	if(!isset($erreur))
	{
		executeRequete("INSERT INTO commande (id_membre, montant, date_enregistrement) VALUES (" . $_SESSION['membre']['id_membre'] . "," . montantTotal() . ", NOW())");
		$id_commande = $mysqli->insert_id;
		for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
		{
			executeRequete("INSERT INTO details_commande (id_commande, id_produit, quantite, prix) VALUES ($id_commande, " . $_SESSION['panier']['id_produit'][$i] . "," . $_SESSION['panier']['quantite'][$i] . "," . $_SESSION['panier']['prix'][$i] . ")");
		}
		unset($_SESSION['panier']);
		$contenu .= "<div class='validation'>Merci pour votre commande. votre numero de suivi est le $id_commande</div>";
	}
}

//--------------------------------- AFFICHAGE HTML ---------------------------------//
include("inc/header.php");
echo $contenu;
echo "<table border='1' style='border-collapse: collapse' class='table table-bordered table-striped'>";
echo "<tr><td colspan='5'>Panier</td></tr>";
echo "<tr><th>Titre</th><th>Produit</th><th>Quantité</th><th>Prix Unitaire</th><th>Action</th></tr>";
if(empty($_SESSION['panier']['id_produit'])) // panier vide
{
	echo "<tr><td colspan='5'>Votre panier est vide</td></tr>";
}
else
{
	for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++) 
	{
		echo "<tr>";
		echo "<td>" . $_SESSION['panier']['titre'][$i] . "</td>";
		echo "<td>" . $_SESSION['panier']['id_produit'][$i] . "</td>";
		echo "<td>" . $_SESSION['panier']['quantite'][$i] . "</td>";
		echo "<td>" . $_SESSION['panier']['prix'][$i] . "</td>";
		echo "</tr>";
	}
	echo "<tr><th colspan='3'>Total</th><td colspan='2'>" . montantTotal() . " dollard</td></tr>";
	if(internauteEstConnecte()) 
	{
		echo '<form method="post" action="">';
		echo '<tr><td colspan="5"><input type="submit" name="payer" value="Valider et déclarer le paiement" /> <i class="fa fa-check-circle fa-2x"></i></td></tr>';
		echo '</form>';	
	}
	else 
	{
		echo '<tr><td colspan="3">Veuillez vous <a href="inscription.php">inscrire</a> ou vous <a href="connexion.php">connecter</a> afin de pouvoir payer</td></tr>';
	}
	echo "<tr><td colspan='5'><a href='?action=vider' style='color: red'>Vider mon panier  <i class='fa fa-trash-o  fa-2x'><i></a></td></tr>";
}
echo "</table><br />";
echo "<i>Réglement par CHEQUE uniquement à l'adresse suivante : 302 Avenue kamanyola Lubumbashi</i><br />";
include("inc/footer.php");