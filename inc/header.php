<link rel="stylesheet" href="../bootstrap-5.1.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-5.1.3/dist/css/bootstrap.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!Doctype html>
<html>
    <head>
        <title>Mon Site</title>
        <link rel="stylesheet" href="<?php echo RACINE_SITE; ?>inc/css/style.css" />
    </head>
    <body>    
        <header>
			<div class="conteneur">                      
				<span>
					<a href="" title="Mon Site">MonSite.com</a>
        </span>
				<nav>
					<?php
					if(internauteEstConnecteEtEstAdmin()) // admin
					{ 
						echo '<a href="' . RACINE_SITE . 'admin/gestion_membre.php">Gestion des membres |</a>'.
						'<a href="' . RACINE_SITE . 'admin/gestion_commande.php">Gestion des commandes |</a>'.
						'<a href="' . RACINE_SITE . 'admin/gestion_boutique.php">Gestion de la boutique |</a>';
					}
					if(internauteEstConnecte()) // membre et admin
					{
						echo '<a href="' . RACINE_SITE . 'profil.php">Voir votre profil |</a>'.
						'<a href="' . RACINE_SITE . 'boutique.php">Acces à la boutique |</a>'.
						'<a href="' . RACINE_SITE . 'panier.php">Voir votre panier |</a>'.
						'<a href="' . RACINE_SITE . 'connexion.php?action=deconnexion">Se déconnecter |</a>';
					}
					else // visiteur
					{
						echo '<a href="' . RACINE_SITE . 'inscription.php">Inscription |</a>'.
						'<a href="' . RACINE_SITE . 'connexion.php">Connexion |</a>'.
						'<a href="' . RACINE_SITE . 'boutique.php">Accés à la boutique |</a>'.
						'<a href="' . RACINE_SITE . 'panier.php">Voir votre panier |</a>';
					}
					// visiteur=4 liens - membre=4 liens - admin=7 liens
					?>
				</nav>
			</div>
        </header>
    <section>
<!-- <nav class="navbar navbar-expand navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">E-achat</a>
    <button class="navbar-toggler" type="button" >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="#">Link</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="text" placeholder="Search">
        <button class="btn btn-primary" type="button">Search</button>
      </form>
    </div>
  </div>
</nav> -->

			<div class="conteneur">