<!DOCTYPE html>
<html>
    <head>
        <title>Mon Site - <?= $page ?></title>
        <link rel="stylesheet" href="<?= RACINE_SITE ?>css/style.css"/>
    </head>
    <body>
        <header>
			<div class="conteneur">
                <img src="libs/logo.png" alt="">
				<span>
					<a href="" title="Mon Site">Annonceo</a>
                </span>
				<nav>

                        <?php if(userConnecte()) : ?>
                        <a class="<?=( $page == 'Profil') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>profil.php">Profil</a>
                        <a href="<?= RACINE_SITE ?>connexion.php?action=deconnexion">Déconnexion</a>
                        <?php else : ?>
    					<a class="<?=( $page == 'Inscription') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>inscription.php">Inscription</a>
    					<a class="<?=( $page == 'Connexion') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>connexion.php">Connexion</a>
                        <?php endif; ?>

                        <?php if(userAdmin()) : ?>
    					<a class="<?=( $page == 'Boutique') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>boutique.php">Boutique</a>
                        <a class="<?=( $page == 'Gestion Boutique') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>backoffice/gestion_boutique.php">Gestion Boutique</a>
                        <a class="<?=( $page == 'Gestion Membres') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>backoffice/gestion_membres.php">Gestion Membres</a>
                        <?php endif; ?>

				</nav>
			</div>
        </header>
        <section>
			<div class="conteneur">
