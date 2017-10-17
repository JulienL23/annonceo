<?php

require_once('inc/init.inc.php');


// 1 : On va vérifier qu'il y a bien un id dans l'URL (no vide, numeric)
// 2 : On récupère les infos du produit
// 3 : On va vérifier que l'id correspond bien à un produit existant sinon redirection vers Boutique
// 4 : On va afficher les infos du produit
// 5 : On gère le nbre de produits max à ajouter au panier
// 6 : On va faire le traitement pour ajouter le produit au panier
// 7 : Suggestion d'autres produits

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    $resultat = $pdo -> prepare("SELECT * FROM annonce WHERE id_annonce = :id_annonce");
    $resultat -> bindParam(':id_annonce', $_GET['id'], PDO::PARAM_INT);
    $resultat -> execute();

    if ($resultat -> rowCount() > 0) { // Le produit existe bien !
        $annonce = $resultat -> fetch(PDO::FETCH_ASSOC);
        extract($annonce);
        //debug($produit);
    }
    else { // Le produit n'exiqte pas : REDIRECTION !
        header('location:accueil.php');
    }
}
else { // Il n'y a pas d'ID dans l'url ou vide, ou pas numérique : REDIRECTION !
    header('location:acceuil.php');
}

if (!empty($_POST)) {
    ajouterAnnoncer($id_annonce, $photo, $titre, $description_courte, $description_longue, $prix, $categorie, $pays, $ville, $adresse, $cp); // Id, quantité, photo, titre, prix
    // Fonction codée dans le fichier fonctions.php
}

debug($_SESSION);


// $page = 'Boutique';
require_once('inc/header.php');
?>
<h1><?= $titre ?></h1>

<img src="<?= RACINE_SITE ?>photo/<?= $photo ?>" width="250" />
<p>Détails du produit : </p>
<ul>
	<li>Référence : <b><?= $reference ?></b></li>
	<li>Catégorie : <b><?= $categorie ?></b></li>
	<li>Couleur : <b><?= $couleur ?></b></li>
	<li>Taille : <b><?= $taille ?></b></li>
	<li>Public : <b><?= $public ?></b></li>
	<li>Prix : <b style="color: red; font-size:20px"><?= $prix ?>€ TTC</b></li>
</ul>
<br/>
<p>Description du produit : <br/>
<em><?= $description ?></em></p>

<div class="profil" style="overflow:hidden;">
	<h2>Suggestions de produits</h2>

	<!-- Dans le PHP faire une requête qui va récupérer des produits (limités à 5):
		Soit des produits de la même catégorie (sauf celui qu'on est en train de visiter)

		Soit les produits des autres catégories
	-->



</div>



<?php
require_once('inc/footer.php');
?>
