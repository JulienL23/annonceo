<?php
require_once('../inc/init.inc.php');

if (isset($_GET['msg']) && $_GET['msg'] == 'validation' && isset($_GET['id'])) {
    $msg .= '<p style="color: white; background: #2EB872; padding: 5px">Le commantaire N°' . $_GET['id'] . ' a été correctement modifié !</p>';
}

if (isset($_GET['msg']) && $_GET['msg'] == 'suppr' && isset($_GET['id'])) {
    $msg .= '<p style="color: white; background: #2EB872; padding: 5px">Le commentaire N°' . $_GET['id'] . ' a été correctement supprimé !</p>';
}

if($_POST) // si je clique sur le bouton submit du formulaire
{
    $resultat = $pdo->prepare("UPDATE commentaire SET membre_id = :membre_id, annonce_id = :annonce_id, commentaire = :commentaire, date_enregistrement = NOW() WHERE id_commentaire = '$_GET[id_commentaire]'");

    $resultat -> bindParam(':membre_id', $_POST['membre_id'], PDO::PARAM_INT);
    $resultat -> bindParam(':annonce_id', $_POST['annonce_id'], PDO::PARAM_INT);
    $resultat -> bindParam(':commentaire', $_POST['commentaire'], PDO::PARAM_STR);

    if ($resultat -> execute()) {
        header("location:gestion_des_commentaires.php");
    }

}


$resultat = $pdo -> query("SELECT commentaire.*, membre.email FROM commentaire LEFT JOIN membre ON commentaire.membre_id = membre.id_membre");
$commentaire = $resultat -> fetchAll(PDO::FETCH_ASSOC);
$contenu .= 'Nombre de résultats : ' . $resultat ->rowCount() . '<br><hr>';

$contenu .= $msg;
$contenu .= '<table class="ges_tab" border="1">';
$contenu .= '<tr>'; // ligne des titres

for ($i = 0; $i < $resultat -> columnCount(); $i++) {
    $colonne = $resultat -> getColumnMeta($i);
    $contenu .= '<th>' . $colonne['name'] . '</th>';
}

$contenu .= '<th colspan="2">Actions</th>';
$contenu .= '</tr>'; // fin ligne des titres

foreach ($commentaire as $valeur) { // parcourt tous les enregistrement
    $contenu .= "<tr>"; // ligne pour chaque enregistrement
        foreach ($valeur as $indice => $valeur2) { // Parcourt toutes les infos de chaque enregistrement

            if ($indice == 'photo') {
                $contenu .= '<td><img src="' . RACINE_SITE . 'photo/' . $valeur2 . '" height="90"></td>';
            }
            else {
                $contenu .= '<td>' . $valeur2 . '</td>';
            }
        }
        $contenu .= '<td><a href="?action=modification&id_commentaire='. $valeur['id_commentaire'] .'"><img src="../libs/modi.png"></a></td>';
        $contenu .= '<td><a onclick="confirm(\'Etes-vous certain de vouloir supprimer ce commentaire' . $valeur['id_commentaire'] . '\');" href="supprimer_commentaire.php?id=' . $valeur['id_commentaire'] . '"><img src="../libs/supp.png"></a></td>';

    $contenu .= "</tr>";
}
$contenu .= '</table>';
$contenu .= "<br>";


if(isset($_GET['action']) && $_GET['action'] == 'modification') {


    if(isset($_GET['id_commentaire'])) {
    $resultat = $pdo->query("SELECT * FROM commentaire WHERE id_commentaire = '$_GET[id_commentaire]'");
    $com_actuel = $resultat->fetch(PDO::FETCH_ASSOC);

    $id_commentaire         =      (isset($com_actuel)) ? $com_actuel['id_commentaire'] : '';
    $membre_id              =      (isset($com_actuel)) ? $com_actuel['membre_id'] : '';
    $annonce_id             =      (isset($com_actuel)) ? $com_actuel['annonce_id'] : '';
    $commentaire            =      (isset($com_actuel)) ? $com_actuel['commentaire'] : '';
    $date_enregistrement    =      (isset($com_actuel)) ? $com_actuel['date_enregistrement'] : '';

    $contenu .= '<h1>Modification :</h1>

    <form class="coucou" action="" method="post">


        <input type="hidden" name="id_commentaire" value= . ' . $id_commentaire .'">

        <label>Membre :</label>
        <input type="text" name="membre_id" value="' . $membre_id . '">

        <label>Annonce :</label>
        <input type="text" name="annonce_id" value="' . $annonce_id .'" >

        <label>Commentaire :</label>
        <input type="text" name="commentaire" value=" ' . $commentaire .'" >

        <label>Date enregistrement :</label>
        <input type="text" name="date_enregistrement" value=" ' . $date_enregistrement .'" >

        <input type="submit" value="Valider">

    </form>';
    }
}

$page = 'Gestion Commentaire';
require('../inc/header.php');
?>

<!-- Contenu HTML -->
<h1>Gestion des commentaires</h1>
<?= $contenu ?>



<?php
require_once('../inc/footer.php');
?>
