<!DOCTYPE html>
<html>
    <head>
        <title>Mon Site - <?= $page ?></title>
        <link rel="stylesheet" href="<?= RACINE_SITE ?>css/style.css"/>
    </head>
    <body>
        <header>
			<div class="conteneur">
                <img src="<?= RACINE_SITE ?>libs/logo.png" alt="">
				<span>
					<a href="" title="Mon Site">/CashBox\</a>
                </span>
				<nav>
                    <div id="na">
                        <ul id="menu">

                            <?php if(userConnecte()) : ?>
                                <li><a class="<?=( $page == 'Profil') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>profil.php">Profil</a></li>
                                <li><a class="<?=( $page == 'Index') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>index.php">Accueil</a></li>
                                <li><a class="<?=( $page == 'Depose Annonce') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>depose_annonce.php">Déposer Annonce</a></li>
                            <?php else : ?>
                                <li><a class="<?=( $page == 'Index') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>index.php">Accueil</a></li>
            					<li><a class="<?=( $page == 'Inscription') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>inscription.php">Inscription</a></li>
            					<li><a class="<?=( $page == 'Connexion') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>connexion.php">Connexion</a></li>
                            <?php endif; ?>
                            <?php if(userAdmin()) : ?>
                                <li>
                                    <a href="#">Gestion</a>
                                    <ul>
                                        <li><a class="<?=( $page == 'Gestion Annonces') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>backoffice/gestion_des_annonces.php">Gestion Annonces</a></li>
                                        <li><a class="<?=( $page == 'Gestion Membres') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>backoffice/gestion_des_membres.php">Gestion Membres</a></li>
                                        <li><a class="<?=( $page == 'Gestion Catégorie') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>backoffice/gestion_des_categories.php">Gestion Catégories</a></li>
                                        <li><a class="<?=( $page == 'Gestion Commentaire') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>backoffice/gestion_des_commentaires.php">Gestion Commentaires</a></li>
                                        <li><a class="<?=( $page == 'Gestion Note') ? 'active' : '' ?>" href="<?= RACINE_SITE ?>backoffice/gestion_des_notes.php">Gestion Notes</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if(userConnecte()) : ?>
                                <li><a href="<?= RACINE_SITE ?>connexion.php?action=deconnexion">Déconnexion</a></li>
                            <?php endif; ?>

                        </ul>
                    </div>
				</nav>
			</div>
        </header>
        <section>
			<div class="conteneur">
