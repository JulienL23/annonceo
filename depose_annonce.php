<?php
require_once('inc/init.inc.php');

if(!empty($_POST)){

	// Les vérifications du titre
	if(empty($_POST['titre'])){
		$msg .= '<p style="background: #AB1212; font-weight: bold; color: white; padding: 5px">Veuillez renseigner un champs</p>';
	}
	else{
		if(strlen($_POST['titre']) < 5){
			$msg .= '<p style="color: white; background: #AB1212; padding: 5px">Attention : votre titre doit comporter au moins 5 caractères !</p>';
		}
	}

	// Les vérifications de description_courte
	if(empty($_POST['description_courte'])){
		$msg .= '<p style="background: #AB1212; font-weight: bold; color: white; padding: 5px">Veuillez renseigner un champs</p>';
	}
	else{
		if(strlen($_POST['description_courte']) < 3){
			$msg .= '<p style="color: white; background: #AB1212; padding: 5px">Attention : votre descriprion doit comporter au moins 3 caractères !</p>';
		}
	}

	// Les vérifications description_longue
    if(empty($_POST['description_longue'])){
		$msg .= '<p style="background: #AB1212; font-weight: bold; color: white; padding: 5px">Veuillez renseigner un champs</p>';
	}
	else{
		if(strlen($_POST['description_longue']) < 5){
			$msg .= '<p style="color: white; background: #AB1212; padding: 5px">Attention : votre description doit comporter au moins 5 caractères !</p>';
		}
	}

    // vérifications prix
    if(empty($_POST['prix'])){
        $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner le prix</p>';
    }
    else{
        if(!is_numeric($_POST['prix'])){
            $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner un prix valide !</p>';
        }
    }

    // Les vérifications de l'adresse
    if(empty($_POST['adresse'])){
		$msg .= '<p style="background: #AB1212; font-weight: bold; color: white; padding: 5px">Veuillez renseigner un champs</p>';
	}
	else{
		if(strlen($_POST['adresse']) < 5){
			$msg .= '<p style="color: white; background: #AB1212; padding: 5px">Attention : votre adresse doit comporter au moins 5 caractères !</p>';
		}
	}

    // vérification du code postal
    if(empty($_POST['cp'])){
        $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner votre code postal</p>';
    }
    else{
        if(strlen($_POST['cp']) != 5){
            $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Attention : votre code postal doit comporter au minimum 5 chiffres.</p>';
        }
        else{
            if(!is_numeric($_POST['cp'])){
                $msg .= '<p style="color: white; background: #AB1212; padding: 5px">Veuillez renseigner un code postal valide !</p>';
            }
        }
    }

	if (!empty($_FILES['photo']['name'])) { // Si une photo est uploadée
        $nom_photo = time() . '_' . $_FILES['photo']['name'];
        // Si la photo est nommée tshirt.jpg, on va lui donnée un nom plus compliquée : XX24_54634_tshirt.jpg pour éviter les doublons possibles sur le serveur (cf les noms des photos sur facebook par exemple).

        $chemin_photo = $_SERVER['DOCUMENT_ROOT'] . RACINE_SITE . 'photo/' . $nom_photo;
        //chemin : c://xampp/htdocs github/WebForce3/PHP/site/ photo/ XX23_546464_tshirt.jpg
		$url_photo = URL . '/photo/' . $nom_photo;

        $ext = array('image/png', 'image/jpeg', 'image/gig');
        if(!in_array($_FILES['photo']['type'], $ext)){
            $msg .= '<div class="erreut">Images autorisées : PNG, JPG, JPEG et GIF</div>';
            // Si le fichier uploadée ne correspond pas aux extensions autorisées (ici PNG, JPEG, JPG et GIF) alors on affiche un message d'erreur.
        }

        if ($_FILES['photo']['size'] > 2000000) {
            $msg .= '<div class="erreur">Images : 2Mo maximum autorisé</div>';
            // Si la photo uploadées est trop volumineuse (ici 2Mo max), alors on met un message d'erreur.
            // Par défeut XAMPP eutorise 2,5Mo. Voir dans php.ini, rechercher upload_max_file_size=2.5M
        }

        if (empty($msg) && $_FILES['photo']['error'] == 0) {

            copy($_FILES['photo']['tmp_name'], $chemin_photo);
            // On enregistre la photo sur le serveur. Dans les faits, on la copier depuis son emplacement temporaire et on la colle dans son emplacement définitif.
        }
    }

    if(empty($msg)){ // Tout est OK !!

		// Traitement pour l'enregistrement dans la BDD
		// Il y a des données sensibles dans la future requête, car nous allons insérer toutes les infos transmises, par l'utilisateur. Il peut avoir tenté des injections SQL !!
		//prepare() + execute() : DELETE-REPLACE-INSERT-UPDATE-SELECT - SHOW si données sensibles

    $resultat = $pdo -> prepare("INSERT INTO annonce (titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, date_enregistrement) VALUES (:titre, :description_courte, :description_longue, :prix, :photo, :pays, :ville, :adresse, :cp, NOW()) ");

    $resultat -> bindParam(':titre', $_POST['titre'], PDO::PARAM_STR);
    $resultat -> bindParam(':description_courte', $_POST['description_courte'], PDO::PARAM_STR);
    $resultat -> bindParam(':description_longue', $_POST['description_longue'], PDO::PARAM_STR);
    $resultat -> bindParam(':prix', $_POST['prix'], PDO::PARAM_INT);
    $resultat -> bindParam(':photo', $url_photo, PDO::PARAM_STR);
    $resultat -> bindParam(':pays', $_POST['pays'], PDO::PARAM_STR);
    $resultat -> bindParam(':ville', $_POST['ville'], PDO::PARAM_STR);
    $resultat -> bindParam(':adresse', $_POST['adresse'], PDO::PARAM_STR);
    $resultat -> bindParam(':cp', $_POST['cp'], PDO::PARAM_INT);

        // Attention à ne pas oublier d'exécuter la requête
        if($resultat -> execute()){
			$pdt_insert = $pdo->lastInsertId();
			header('location:fiche_annonce.php?msg=validation&id=' . $pdt_insert);
        }
    }
}

require_once('inc/header.php');
?>

<h1>Déposer une annonce :</h1>

<form class="coucou" action="" method="post" enctype=multipart/form-data>

    <?= $msg ?>

    <label for="">Titre</label><br>
    <input type="text" name="titre" value="" placeholder="Titre de l'annonce"><br><br>

    <label for="">Description courte</label><br>
    <textarea name="description_courte" rows="8" cols="30" placeholder="Description courte de votre annonce"></textarea><br><br>

    <label for="">Description longue</label><br>
    <textarea name="description_longue" rows="8" cols="30" placeholder="Description longue de votre annonce"></textarea><br><br>

    <label for="">Prix</label><br>
    <input type="text" name="prix" value="" placeholder="Prix figurant dans votre annonce"><br><br>

    <label for="">Catégorie</label><br>
    <select name="categorie">
        <option value="">Auto - Moto</option>
        <option value="">Multimedia</option>
        <option value="">Vêtement - Accessoires</option>
    </select><br><br>

    <label for="">Photo</label><br>
    <input type="file" name="photo" value=""><br><br>

    <label for="">Pays</label><br>
    <select name="pays">
        <option value="france">France</option>
        <option value="angletterre">Angletterre</option>
        <option value="espagne">Espagne</option>
        <option value="japon">Japon</option>
    </select><br><br>

    <label for="">Ville</label><br>
    <select name="ville">
        <option value="paris">Paris</option>
        <option value="lyon">Lyon</option>
        <option value="marseille">Marseille</option>
        <option value="bordeaux">Bordeaux</option>
    </select><br><br>

    <label for="">Adresse</label><br>
    <textarea name="adresse" rows="8" cols="30" placeholder="Adresse figurant dans l'annonce"></textarea><br><br>

    <label for="">Code postal</label><br>
    <input type="text" name="cp" value=""><br><br>

    <input type="submit" value="Enregistrer">

</form>
<?php
require_once('inc/footer.php');
 ?>
