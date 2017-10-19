<?php

require('inc/init.inc.php');


if (!empty($_POST)) {

    // Vérification pseudo :
    $verif_pseudo = preg_match('#^([a-zA-Z0-9._-]{3,20})$#', $_POST['pseudo']); // Cette fonction me permet de mettre une règle en place pour les caractères autorisés :
        // arg 1 : REGEX - EXPRESSIONS REGULIERES
        // arg 2 : La chaîne de caractère (CC)
        // Retour : TRUE (si OK) - FALSE (si pas OK)

        if (!empty($_POST['pseudo'])) {

            if (!$verif_pseudo) { // Si verif pseudo nous retourne FALSE
                $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner un pseudo comportant entre 3 et 20 caractères et sans caractères spéciaux.</p>';
            }
        }
        else {
            $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner un pseudo.</p>';
        }

        // Vérification Mot de passe :
        $verif_pwd = preg_match('#^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$#', $_POST['mdp']); // 8 caractères min, 20 max, au moins un chiffre, au moins une MAJ.

        if (!empty($_POST['mdp'])) {

            if (!$verif_pwd) {
                $msg .= '<p style="color: white; background:#AB1212; padding: 5px">Veuillez renseigner un mot de passe comportant au minimum 8 caractères et maximum 20 caractères, avec au moins un chiffre et une majuscule.</p>';
            }
        }
        else {
            $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner un mot de passe.</p>';
        }

        // Vérification du prénom
        if (!empty($_POST['prenom'])) {

            if (!$verif_pseudo) { // Si verif pseudo nous retourne FALSE
                $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner un prenom comportant entre 3 et 20 caractères et sans caractères spéciaux.</p>';
            }
        }
        else {
            $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner un prenom.</p>';
        }

        // vérification du nom
        if (!empty($_POST['nom'])) {

            if (!$verif_pseudo) { // Si verif pseudo nous retourne FALSE
                $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner un nom comportant entre 3 et 20 caractères et sans caractères spéciaux.</p>';
            }
        }
        else {
            $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner un nom.</p>';
        }

        // Vérification de l'email :
        $verif_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); // Vérifie que le format de l'email est OK Retourne TRUE (si OK) - FALSE (si pas OK)

        // yakine.hamide@gmail.com
        $pos = strpos($_POST['email'], '@'); // la position de @
        $ext = substr($_POST['email'], $pos +1); // 'gmail.com'

        $ext_non_autorisees = array('wimsg.com', 'yopmail.com', 'mailinator.com', 'tafmail.com', 'mvrht.net');

        if (!empty($_POST['email'])) {

            if (!$verif_email || in_array($ext, $ext_non_autorisees)) {
                $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez saisir un email valide.</p>';
            }
        }
        else {
            $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner un email.</p>';
        }

        // Vérification du téléphone
        if(empty($_POST['telephone'])){
    		$msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner votre numéro de téléphone</p>';
    	}
    	else{
    		if(strlen($_POST['telephone']) > 10){
    			$msg .= '<p style="color: white; background: #AB1212; padding: 5px">Attention : votre téléphone doit comporter jusqu\'à 10 caractères maximum.</p>';
    		}
    		else{
    			if(!is_numeric($_POST['telephone'])){
    				$msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner un numéro de téléphone valide !</p>';
    			}
    		}
    	}

        // A ce stade, si notre variable $msg est encore vide, cela signifie qu'il n'y a pas d'erreur au moins sur email, pseudo et MDP (Pensez à faire vérifs des autres champs).

        if (empty($msg)) { // Tout est OK !!
            // enregsitrement du nouvel utilisateur :

            // Attention, le pseudo et le mail est-il disponible ?
            $resultat = $pdo -> prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
            $resultat -> bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
            $resultat -> execute();

            if ($resultat -> rowCount() > 0) { // Signifie que le pseudo est déjà utilisé.

                // Nous aurions pu lui proposé 2/3 variante de son pseudo, en ayant vérifiée qu'ils sont disponibles.

                $msg .= '<div class="erreur">Le pseudo ' . $_POST['pseudo'] . ' n\'est pas disponible, veuillez choisir un autre pseudo.</div>';
            }
            else { // OK le pseudo est disponible, on va pouvoir enregistrer le membre dans la BDD... (attention, nous devrions également vérifier la disponiblité de l'email.)

                // crypte le MDP
                $mdp = md5($_POST['mdp']); // md5 va crypter le mdp selon en hashage 64o

                // requete INSERT
                    $resultat = $pdo -> prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, telephone, email, civilite, date_enregistrement) VALUES (:pseudo, :mdp, :nom, :prenom, :telephone, :email, :civilite,  NOW())");

                    $resultat -> bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                    $resultat -> bindParam(':mdp', $mdp, PDO::PARAM_STR);
                    $resultat -> bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
                    $resultat -> bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                    $resultat -> bindParam(':telephone', $_POST['telephone'], PDO::PARAM_INT);
                    $resultat -> bindParam(':email', $_POST['email'], PDO::PARAM_STR);
                    $resultat -> bindParam(':civilite', $_POST['civilite'], PDO::PARAM_STR);

                // redirection
                if ($resultat -> execute()) { // Si la requête est OK !
                    header('location:connexion.php');
                }
            }
        }

}

// On peut écrire le if/else de manière simplifiée ;
$pseudo     =      (isset($_POST['pseudo'])) ? $_POST['pseudo'] : '';
$nom        =      (isset($_POST['nom'])) ? $_POST['nom'] : '';
$prenom     =      (isset($_POST['prenom'])) ? $_POST['prenom'] : '';
$email      =      (isset($_POST['email'])) ? $_POST['email'] : '';
$telephone  =      (isset($_POST['telephone'])) ? $_POST['telephone'] : '';


$page = 'Inscription';
require_once('inc/header.php');
?>

<!-- CONTENU HTML -->
<h1>S'inscrire :</h1>

<form class="coucou" action="" method="post">
    <?= $msg ?>

    <input type="text" name="pseudo" value="<?= $pseudo ?>" placeholder="Votre pseudo"><br><br>

    <input type="password" name="mdp" placeholder="Votre mot de passe"><br><br>

    <input type="text" name="nom" value="<?= $nom ?>" placeholder="Votre nom"><br><br>

    <input type="text" name="prenom" value="<?= $prenom ?>" placeholder="Votre prénom"><br><br>

    <input type="text" name="email" value="<?= $email ?>" placeholder="Votre email"><br><br>

    <input type="text" name="telephone" value="<?= $telephone ?>" placeholder="Votre téléphone" maxlength="10"><br><br>

    <select name="civilite">
        <option value="homme">Homme</option>
        <option value="femme">Femme</option>
    </select><br><br>

    <input type="submit" value="Inscription">

</form>

<?php
require_once('inc/footer.php');
?>
