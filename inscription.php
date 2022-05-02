<link rel="stylesheet" href="bootstrap-5.1.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-5.1.3/dist/css/bootstrap.css">
<?php
require_once("inc/init.inc.php");
if($_POST)
{
	debug($_POST);
	$verif_caractere = preg_match('#^[a-zA-Z0-9._-]+$#', $_POST['pseudo']); 
	if(!$verif_caractere || strlen($_POST['pseudo']) < 1 || strlen($_POST['pseudo']) > 20 )
	{
		$contenu .= "<div class='erreur'>Le pseudo doit contenir entre 1 et 20 caracteres. <br> Caractere accepte : Lettre de A à Z et chiffre de 0 à 9</div>";
	}
	if(empty($contenu)) 
	{
		$membre = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'"); 
		if($membre->num_rows > 0)
		{
			$contenu .= "<div class='erreur'>Pseudo indisponible. Veuillez en choisir un autre svp.</div>";
		}
		else
		{
			foreach($_POST as $indice => $valeur)
			{
				$_POST[$indice] = htmlEntities(addSlashes($valeur));
			}
			executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse) VALUES ('$_POST[pseudo]', '$_POST[mdp]', '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[civilite]', '$_POST[ville]', '$_POST[code_postal]', '$_POST[adresse]')");
			$contenu .= "<div class='validation'>Vous ètes inscrit à notre site web. <a href=\"connexion.php\"><u>Cliquez ici pour vous connecter</u></a></div>";
		}
	}
}
?>
<?php require_once("inc/header.php"); ?>
<?php echo $contenu; ?>
<div class="d-flex justify-content-center align-items-center">
    <div class="w-50 p-5 shadow rounded">
		<form method="post" action="">
			<div class="mb-3 form-floating">
				<input type="text" class="form-control" name="pseudo" maxlength="20" placeholder="votre pseudo" pattern="[a-zA-Z0-9-_.]{1,20}" title="caracteres acceptés : a-zA-Z0-9-_." required>
				<label for="pseudo">Pseudo</label>
			</div>
			<div class="mb-3 form-floating">
				<input type="password" class="form-control" id="mdp" name="mdp" placeholder="votre mot de passe">
				<label for="mdp">Mot de pass</label>
			</div>
			<div class="mb-3 form-floating">
				<input type="text" class="form-control" id="nom" name="nom" placeholder="votre nom">
				<label for="nom">Nom</label>
			</div>
			<div class="mb-3 form-floating">
				<input type="text" class="form-control" id="prenom" name="prenom" placeholder="votre prenom">
				<label for="prenom">Prenom</label>
			</div>
		
			<div class="mb-3 form-floating">
				<input type="email" class="form-control" id="email" name="email" placeholder="exemple@gmail.com">
				<label for="nom">Email</label>
			</div>
				
			<label for="civilite">Civilite </label><br><br>
			<input name="civilite" value="M" checked="" type="radio">Homme
			<input name="civilite" value="F" type="radio"> Femme<br><br>

			<div class="mb-3 form-floating">
				<input type="text" class="form-control" name="ville" maxlength="20" placeholder="votre ville" pattern="[a-zA-Z0-9-_.]{1,20}" title="caracteres acceptés : a-zA-Z0-9-_." required="required">
				<label for="ville">Ville</label>
			</div>             
			<div class="mb-3 form-floating">     
				<input type="text" id="code_postal" class="form-control" name="code_postal" placeholder="code postal"  title="5 chiffres requis : 0-9">
				<label for="cp">Code Postal</label>
			</div>
			<div class="mb-3 form-floating">
				<textarea id="adresse" class="form-control" name="adresse" placeholder="votre dresse" title="caracteres acceptes :  a-zA-Z0-9-_."></textarea>
				<label for="adresse">Adresse</label>
			</div>
		
			<input name="inscription" class="btn btn-primary" value="S'inscrire" type="submit">
		</form>
	</div>
</div>
 
<?php require_once("inc/footer.php"); ?>