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
            <li><b>Pseudo : <?= $pseudo ?></b></li>
            <li><b>Prénom : <?= $prenom ?></b></li>
            <li><b>Nom : <?= $nom ?></b></li>
            <li><b>Email : <?= $email ?></b></li>
            <li><b>Téléphone : <?= $telephone ?></b></li>
        </ul>
    </div>
</div>



<?php
require_once('inc/footer.php');
?>
