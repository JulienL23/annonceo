<?php
require_once('../inc/init.inc.php');
require_once('../inc/header.php');

//echo '<pre>'; print_r($_SERVER); echo '</pre>';

if (isset($_GET['msg']) && $_GET['msg'] == 'validation' && isset($_GET['id'])) {
    $msg .= '<p style="color: white; background: #2EB872; padding: 5px">L\'annonce N°' . $_GET['id'] . ' a été correctement modifié !</p>';
}

if (isset($_GET['msg']) && $_GET['msg'] == 'suppr' && isset($_GET['id'])) {
    $msg .= '<p style="color: white; background: #2EB872; padding: 5px">L\'annonce N°' . $_GET['id'] . ' a été correctement supprimé !</p>';
}

if($_POST) // si je clique sur le bouton submit du formulaire
{
    $resultat = $pdo->prepare("UPDATE annonce SET titre = :titre, description_courte = :description_courte, description_longue = :description_longue, prix = :prix, photo = :photo, pays = :pays, ville = :ville, adresse = :adresse, cp = :cp WHERE id_annonce = '$_GET[id_annonce]'");

    $resultat -> bindParam(':titre', $_POST['titre'], PDO::PARAM_STR);
    $resultat -> bindParam(':description_courte', $_POST['description_courte'], PDO::PARAM_STR);
    $resultat -> bindParam(':description_longue', $_POST['description_longue'], PDO::PARAM_STR);
    $resultat -> bindParam(':prix', $_POST['prix'], PDO::PARAM_INT);
    $resultat -> bindParam(':photo', $_POST['photo'], PDO::PARAM_STR);
    $resultat -> bindParam(':pays', $_POST['pays'], PDO::PARAM_STR);
    $resultat -> bindParam(':ville', $_POST['ville'], PDO::PARAM_STR);
    $resultat -> bindParam(':adresse', $_POST['adresse'], PDO::PARAM_STR);
    $resultat -> bindParam(':cp', $_POST['cp'], PDO::PARAM_INT);

    if ($resultat -> execute()) {
        header("location:gestion_des_annonces.php");
    }

}

$resultat = $pdo -> query("SELECT * FROM annonce");
$annonces = $resultat -> fetchAll(PDO::FETCH_ASSOC);
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

foreach ($annonces as $valeur) { // parcourt tous les enregistrement
    $contenu .= "<tr>"; // ligne pour chaque enregistrement
        foreach ($valeur as $indice => $valeur2) { // Parcourt toutes les infos de chaque enregistrement

            if ($indice == 'photo') {
                $contenu .= '<td><img src="' . $valeur2 . '" height="90" width="90"></td>';
            }
            else {
                $contenu .= '<td>' . $valeur2 . '</td>';
            }
        }
        $contenu .= '<td><a href="?action=modification&id_annonce='. $valeur['id_annonce'] .'"><img src="../libs/modi.png"></a></td>';
        $contenu .= '<td><a onclick="confirm(\'Etes-vous certain de vouloir supprimer cette annonce' . $valeur['id_annonce'] . '\');" href="supprimer_annonce.php?id=' . $valeur['id_annonce'] . '"><img src="../libs/supp.png"></a></td>';

    $contenu .= "</tr>";
}
$contenu .= '</table>';
$contenu .= "<br>";

if(isset($_GET['action']) && $_GET['action'] == 'modification') {

    if(isset($_GET['id_annonce']))
    {
    $resultat = $pdo->query("SELECT * FROM annonce WHERE id_annonce = '$_GET[id_annonce]'");
    $annonce_actuel = $resultat->fetch(PDO::FETCH_ASSOC);

    $id_annonce             =      (isset($annonce_actuel)) ? $annonce_actuel['id_annonce'] : '';
    $titre                  =      (isset($annonce_actuel)) ? $annonce_actuel['titre'] : '';
    $description_courte     =      (isset($annonce_actuel)) ? $annonce_actuel['description_courte'] : '';
    $description_longue     =      (isset($annonce_actuel)) ? $annonce_actuel['description_longue'] : '';
    $prix                   =      (isset($annonce_actuel)) ? $annonce_actuel['prix'] : '';
    $photo                  =      (isset($annonce_actuel)) ? $annonce_actuel['photo'] : '';
    $pays                   =      (isset($annonce_actuel)) ? $annonce_actuel['pays'] : '';
    $ville                  =      (isset($annonce_actuel)) ? $annonce_actuel['ville'] : '';
    $adresse                =      (isset($annonce_actuel)) ? $annonce_actuel['adresse'] : '';
    $cp                     =      (isset($annonce_actuel)) ? $annonce_actuel['cp'] : '';
    }

    $contenu .= '<h1>Modification :</h1>

    <form class="coucou" action="" method="post">

        <input type="hidden" name="id_annonce" value= . ' . $id_annonce .'">

        <label>Titre :</label>
        <input type="text" name="titre" value="' . $titre . '">

        <label>Description_courte : :</label>
        <input type="text" name="description_courte" value="' . $description_courte .'" >

        <label>Description_longue :</label>
        <input type="text" name="description_longue" value=" ' . $description_longue .'" >

        <label>Prix :</label>
        <input type="text" name="prix" value=" ' . $prix .'" >

        <label>Photo :</label>
        <input type="file" name="photo" value=" ' . $photo . '" >

        <label>Pays :</label>
        <input type="text" name="pays" value=" ' . $pays . '" >

        <label>Ville :</label>
        <input type="text" name="ville" value=" ' . $ville . '" >

        <label>Adresse :</label>
        <input type="text" name="adresse" value=" ' . $adresse . '" >

        <label>Code postal :</label>
        <input type="text" name="cp" value=" ' . $cp . '" >

        <input type="submit" value="Valider">

    </form>';
}

?>

<!-- Contenu HTML -->
<h1>Gestion des annonces</h1>

<a class="add_ann" href="../depose_annonce.php">Ajouter une annonce</a>

<?= $contenu ?>

<?php
require_once('../inc/footer.php');
?>
