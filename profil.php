<?php

require_once('inc/init.inc.php');

// Traitement pour rediriger l'utilisateur s'il est déjà connecté
// if (!userConnecte()) {
//     header('location:connexion.php');
// }

extract($_SESSION['membre']);

$page = 'Profil';
require_once('inc/header.php');
?>

<!-- Contenu HTML- -->
<h1>Profil de <?= $pseudo ?> </h1>

<div class="profil">
    <p>Bonjour <?= $pseudo ?> !! </p><br>

        <img src="libs/profil.jpg">

    <div class="profil_infos">
        <ul>
            <li><b><span class="stpro">Pseudo : </span> <?= $pseudo ?></b></li><hr>
            <li><b><span class="stpro">Prénom : </span> <?= $prenom ?></b></li><hr>
            <li><b><span class="stpro">Nom : </span> <?= $nom ?></b></li><hr>
            <li><b><span class="stpro">Email : </span> <?= $email ?></b></li><hr>
            <li><b><span class="stpro">Téléphone : </span> <?= $telephone ?></b></li>
        </ul>
    </div>
</div>



<?php
require_once('inc/footer.php');
?>
