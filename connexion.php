<link rel="stylesheet" href="bootstrap-5.1.3/dist/css/bootstrap.css">
<link rel="stylesheet" href="bootstrap-5.1.3/dist/css/bootstrap.min.css">
<?php
require_once("inc/init.inc.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
if(isset($_GET['action']) && $_GET['action'] == "deconnexion") 
{
	session_destroy(); 
}
if(internauteEstConnecte()) 
{
	header("location:profil.php");
}
if($_POST)
{
    $resultat = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'");
    if($resultat->num_rows != 0)
    {
        $membre = $resultat->fetch_assoc();
        if($membre['mdp'] == $_POST['mdp'])
        {
            foreach($membre as $indice => $element)
            {
                if($indice != 'mdp')
                {
                    $_SESSION['membre'][$indice] = $element; 
                }
            }
            header("location:profil.php"); 
        }
        else
        {
            $contenu .= '<div class="erreur">Erreur de MDP</div>';
        }       
    }
    else
    {
        $contenu .= '<div class="erreur">Erreur de pseudo</div>';
    }
}
//--------------------------------- AFFICHAGE HTML ---------------------------------//
?>
<?php require_once("inc/header.php"); ?>
<?php echo $contenu; ?>

<div class="d-flex justify-content-center align-items-center">
    <div class="w-300 p-5 shadow rounded">
            <form action="" method="post">
                <div class="mb-3 form-floating">
                    <input type="text" name="pseudo" class="form-control" placeholder="Pseudo" required>
                    <label class="form-label">Pseudo</label>
                </div>
                <div class="mb-3 form-floating">
                    <input type="text" name="mdp" class="form-control" placeholder="Mot de passe">
                    <label class="form-label">Mot de passe</label>
                </div>
                <input type="submit" class="btn-lg btn-primary" value="Se connecter">
            </form><br>
    </div>
</div>
<?php require_once("inc/footer.php"); ?>