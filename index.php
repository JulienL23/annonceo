<?php
require('inc/init.inc.php');

$resultat = $pdo->query("SELECT DISTINCT titre FROM categorie");
$categorie = $resultat->fetchAll(PDO::FETCH_ASSOC);
// debug($categorie);


if (isset($_GET['cat']) && !empty($_GET['cat']) && is_string($_GET['cat'])) {
// Soit une catégorie est demandée dans l'URL...

    $resultat = $pdo->prepare("SELECT * FROM annonce WHERE categorie_id = :categorie_id");
    $resultat->bindParam(':categorie_id', $_GET['cat'], PDO::PARAM_STR);
    $resultat->execute();

    if ($resultat->rowCount() == 0) { // Si la categorie retourne aucun produit, alors on change la requete :
        $resultat = $pdo->query("SELECT * FROM annonce");
    }
} else {
// Soit il n'y a pas de catégorie dans URL (ou catégorie non valide)

    $resultat = $pdo->query("SELECT * FROM annonce");
}
// On sort forcément de cette condition avec $resultat qui est soit les résultats d'une requete ciblée par produit, soit tous les produits...
$produits = $resultat->fetchAll(PDO::FETCH_ASSOC);
// debug($produits);

$page = 'Boutique';
require('inc/header.php');
?>
<h1>Annonces</h1>

<div class="boutique-gauche">
    <ul>

        <?php for ($i = 0; $i < count($categorie); $i ++) : ?>
            <li><a href="?cat=<?= $categorie[$i]['titre'] ?>"><?= $categorie[$i]['titre'] ?> </a></li>
        <?php endfor; ?>

        <!-- La boucle ci-dessus parcourt tous les résultats de la requête SELECT DISTINCT CATEGORIE FROM PRODUIT. Le résultat un tableau multidimentionnel dans lequel à chaque indice (0, 1, 2 etc...) on récpère un array, avec la catégorie à l'indice 'categorie'. Donc $categories[$i]['categorie'] nous affiche chaque catégorie. -->

    </ul>
</div>

<div class="boutique-droite">

    <?php foreach ($produits as $pdt) : ?>
        <!-- Debut vignette produit -->
        <div class="boutique-produit">
            <h3><?= $pdt['titre'] ?></h3>
            <a href="fiche_annonce.php?id=<?= $pdt['id_annonce'] ?>"><img src="<?= $pdt['photo'] ?>" height="100"/></a>
            <p style="font-weight: bold; font-size: 20px;"><?= $pdt['prix'] ?>€</p>

            <p style="height: 40px"><?= substr($pdt['description_courte'], 0, 40) ?>...</p>
            <a href="fiche_annonce.php?id=<?= $pdt['id_annonce'] ?>" style="padding:5px 15px; background: #c44057; color:white; text-align: center; border: 2px solid black; border-radius: 3px" >Voir la fiche</a>
            <!-- href="fiche_produit.php?id=id_du_produit" -->
        </div>
        <!-- Fin vignette produit -->

    <?php endforeach; ?>
</div>
<?php
require('inc/footer.php');
?>
