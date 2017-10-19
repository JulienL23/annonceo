<?php
require_once('../inc/init.inc.php');

if (isset($_GET['msg']) && $_GET['msg'] == 'validation' && isset($_GET['id'])) {
    $msg .= '<p style="color: white; background: #2EB872; padding: 5px">La categorie N°' . $_GET['id'] . ' a été correctement modifié !</p>';
}

if (isset($_GET['msg']) && $_GET['msg'] == 'suppr' && isset($_GET['id'])) {
    $msg .= '<p style="color: white; background: #2EB872; padding: 5px">La categorie N°' . $_GET['id'] . ' a été correctement supprimé !</p>';
}

if($_POST) // si je clique sur le bouton submit du formulaire
{
    if(isset($_GET['action']) && $_GET['action'] == 'ajout')
    {
    $resultat2 = $pdo -> prepare("INSERT INTO categorie (titre) VALUES (:titre)");

        $resultat2 -> bindParam(':titre', $_POST['titre'], PDO::PARAM_STR);

        if($resultat2 -> execute()){
            $msg .=  '<p style="color: white; background: #2EB872; padding: 5px">Catégorie ajoutée!</p>';

        }
    }

    if(isset($_GET['action']) && $_GET['action'] == 'modification')
    {
    $resultat = $pdo->prepare("UPDATE categorie SET titre = :titre  WHERE id_categorie = '$_GET[id_categorie]'");

    $resultat -> bindParam(':titre', $_POST['titre'], PDO::PARAM_STR);


    if ($resultat -> execute()) {
        header("location:gestion_des_categories.php");

    }
    }
}

$resultat = $pdo -> query("SELECT * FROM categorie");
$categories = $resultat -> fetchAll(PDO::FETCH_ASSOC);
$contenu .= 'Nombre de résultats : ' . $resultat ->rowCount() . '<br><hr>';

//lien ajouter categorie
$contenu .= "<a class='add_ann' href='?action=ajout'>Ajout d'une catégorie</a><br><br>";


$contenu .= $msg;
$contenu .= '<table class="ges_tab" border="1">';
$contenu .= '<tr>'; // ligne des titres

for ($i = 0; $i < $resultat -> columnCount(); $i++) {
    $colonne = $resultat -> getColumnMeta($i);
    $contenu .= '<th>' . $colonne['name'] . '</th>';
}

$contenu .= '<th colspan="2">Actions</th>';
$contenu .= '</tr>'; // fin ligne des titres

foreach ($categories as $valeur) { // parcourt tous les enregistrement
    $contenu .= "<tr>"; // ligne pour chaque enregistrement
        foreach ($valeur as $indice => $valeur2) { // Parcourt toutes les infos de chaque enregistrement

            if ($indice == 'photo') {
                $contenu .= '<td><img src="' . RACINE_SITE . 'photo/' . $valeur2 . '" height="90"></td>';
            }
            else {
                $contenu .= '<td>' . $valeur2 . '</td>';
            }
        }
        $contenu .= '<td><a href="?action=modification&id_categorie='. $valeur['id_categorie'] .'"><img src="../libs/modi.png"></a></td>';
        $contenu .= '<td><a onclick="confirm(\'Etes-vous certain de vouloir supprimer cette categorie' . $valeur['id_categorie'] . '\');" href="supprimer_categorie.php?id=' . $valeur['id_categorie'] . '"><img src="../libs/supp.png"></a></td>';

    $contenu .= "</tr>";
}
$contenu .= '</table>';
$contenu .= "<br>";


if(isset($_GET['action']) && ($_GET['action'] == 'modification' || $_GET['action'] == 'ajout')) {


    if(isset($_GET['id_categorie']))
    {
    $resultat = $pdo->query("SELECT * FROM categorie WHERE id_categorie = '$_GET[id_categorie]'");
    $cat_actuel = $resultat->fetch(PDO::FETCH_ASSOC);
    }

    $id_categorie          =      (isset($cat_actuel)) ? $cat_actuel['id_categorie'] : '';
    $titre                 =      (isset($cat_actuel)) ? $cat_actuel['titre'] : '';




    $contenu .= '

    <form class="coucou" action="" method="post">


        <input type="hidden" name="id_categorie" value= . ' . $id_categorie .'">

        <label>Titre :</label>
        <input type="text" name="titre" value="' . $titre . '">



        <input type="submit" value="Valider" name="ajouter">

    </form>';

}


//$page = 'Gestion Boutique';
require('../inc/header.php');

?>

<!-- Contenu HTML -->
<h1>Gestion des categories</h1>
<?= $contenu ?>

<?php
require_once('../inc/footer.php');
?>
