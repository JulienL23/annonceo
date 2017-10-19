<?php
require_once('../inc/init.inc.php');

if (isset($_GET['msg']) && $_GET['msg'] == 'validation' && isset($_GET['id'])) {
    $msg .= '<p style="color: white; background: #2EB872; padding: 5px">La note N°' . $_GET['id'] . ' a été correctement modifiée !</p>';
}

if (isset($_GET['msg']) && $_GET['msg'] == 'suppr' && isset($_GET['id'])) {
    $msg .= '<p style="color: white; background: #2EB872; padding: 5px">La note N°' . $_GET['id'] . ' a été correctement supprimée !</p>';
}

if($_POST) // si je clique sur le bouton submit du formulaire
{
    $resultat = $pdo->prepare("UPDATE note SET membre_id1 = :membre_id1, membre_id2 = :membre_id2, note = :note, avis = :avis, date_enregistrement = NOW() WHERE id_note = '$_GET[id_note]'");

    $resultat -> bindParam(':membre_id1', $_POST['membre_id1'], PDO::PARAM_INT);
    $resultat -> bindParam(':membre_id2', $_POST['membre_id2'], PDO::PARAM_INT);
    $resultat -> bindParam(':note', $_POST['note'], PDO::PARAM_INT);
    $resultat -> bindParam(':avis', $_POST['avis'], PDO::PARAM_STR);

    if ($resultat -> execute()) {
        header("location:gestion_des_notes.php");
    }

}


$resultat = $pdo -> query("SELECT note.*, membre.email FROM note LEFT JOIN membre ON note.membre_id1 = membre.id_membre");
$note = $resultat -> fetchAll(PDO::FETCH_ASSOC);
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

foreach ($note as $valeur) { // parcourt tous les enregistrement
    $contenu .= "<tr>"; // ligne pour chaque enregistrement
        foreach ($valeur as $indice => $valeur2) { // Parcourt toutes les infos de chaque enregistrement

            if ($indice == 'photo') {
                $contenu .= '<td><img src="' . RACINE_SITE . 'photo/' . $valeur2 . '" height="90"></td>';
            }
            else {
                $contenu .= '<td>' . $valeur2 . '</td>';
            }
        }
        $contenu .= '<td><a href="?action=modification&id_note='. $valeur['id_note'] .'"><img src="../libs/modi.png"></a></td>';
        $contenu .= '<td><a onclick="confirm(\'Etes-vous certain de vouloir supprimer cette photo' . $valeur['id_note'] . '\');" href="supprimer_note.php?id=' . $valeur['id_note'] . '"><img src="../libs/supp.png"></a></td>';

    $contenu .= "</tr>";
}
$contenu .= '</table>';
$contenu .= "<br>";


if(isset($_GET['action']) && $_GET['action'] == 'modification') {


    if(isset($_GET['id_note'])) {
    $resultat = $pdo->query("SELECT * FROM note WHERE id_note = '$_GET[id_note]'");
    $note_actuel = $resultat->fetch(PDO::FETCH_ASSOC);

    $id_note              =      (isset($note_actuel)) ? $note_actuel['id_note'] : '';
    $membre_id1           =      (isset($note_actuel)) ? $note_actuel['membre_id1'] : '';
    $membre_id2           =      (isset($note_actuel)) ? $note_actuel['membre_id2'] : '';
    $note                 =      (isset($note_actuel)) ? $note_actuel['note'] : '';
    $avis                 =      (isset($note_actuel)) ? $note_actuel['avis'] : '';
    $date_enregistrement  =      (isset($note_actuel)) ? $note_actuel['date_enregistrement'] : '';

    $contenu .= '<h1>Modification :</h1>

    <form class="coucou" action="" method="post">


        <input type="hidden" name="id_note" value= . ' . $id_note .'">

        <label>Id Membre 1 :</label>
        <input type="text" name="membre_id1" value="' . $membre_id1 . '">

        <label>Id Membre 2 :</label>
        <input type="text" name="membre_id2" value="' . $membre_id2 . '">

        <label>Note :</label>
        <input type="text" name="note" value=" ' . $note .'" >

        <label>Avis :</label>
        <input type="text" name="avis" value=" ' . $avis .'" >

        <label>Date enregistrement :</label>
        <input type="text" name="date_enregistrement" value=" ' . $date_enregistrement .'" >

        <input type="submit" value="Valider">

    </form>';
    }
}

$page = 'Gestion Note';
require('../inc/header.php');
?>

<!-- Contenu HTML -->
<h1>Gestion des notes</h1>
<?= $contenu ?>



<?php
require_once('../inc/footer.php');
?>
