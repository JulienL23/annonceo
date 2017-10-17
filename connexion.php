<?php

require('inc/init.inc.php');

// Traitement pour la deconnexion :
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion'){ // Si une action est demandé dans l'url... et que cette action est 'déconnexion' alors on procède à la déconnexion.
    unset($_SESSION['membre']);
    header('location:connexion.php');
}

if (!empty($_POST)) {

    // debug($_POST);

    if (!empty($_POST['pseudo']) && !empty($_POST['mdp'])) {

        $resultat = $pdo -> prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
        $resultat -> bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
        $resultat -> execute();

        if ($resultat -> rowCount() > 0) { // ok pour le pseudo existe bien
            $membre = $resultat -> fetch(PDO::FETCH_ASSOC); // on récupère toutes les infos du membre qui souhaite se connecter sous la forme d'un ARRAY.

            if ($membre['mdp'] == md5($_POST['mdp'])) {
                // si (mdp_crypté_en_bdd == mdp saisi + crypté... ALORS TOUT EST OK!!)

                // Tout est OK on peut connecter l'utilisateur

                foreach ($membre as $indice => $valeur) {
                    if ($indice != 'mdp') {
                        $_SESSION['membre'][$indice] = $valeur;
                    }
                }
                // debug($_SESSION);

                // redirection
                    header('location:profil.php');
            }
            else {
                $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Mot de passe erronné !</p>';
            }
        }
        else {
            $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Pseudo erronné !</p>';
        }
    }
    else {
        $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner un Pseudo et un Mot de passe.</p>';

    }
}

$page = 'Connexion';
require_once('inc/header.php');
?>
<!-- Contenu HTML -->
<h1>Connexion</h1>
    <form action="" method="post">

        <?= $msg ?>

        <label>Pseudo</label><br>
        <input id="co" type="text" name="pseudo"><br><br>

        <label>Mot de passe</label><br>
        <input id="co" type="password" name="mdp"><br><br>

        <input id="coco" type="submit" name="Connexion">

    </form>

<?php
require_once('inc/footer.php')
?>
