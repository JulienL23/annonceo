<?php
require_once('../inc/init.inc.php');

if (isset($_GET['msg']) && $_GET['msg'] == 'validation' && isset($_GET['id'])) {
    $msg .= '<p style="color: white; background: #2EB872; padding: 5px">Le membre N°' . $_GET['id'] . ' a été correctement modifié !</p>';
}

if (isset($_GET['msg']) && $_GET['msg'] == 'suppr' && isset($_GET['id'])) {
    $msg .= '<p style="color: white; background: #2EB872; padding: 5px">Le membre N°' . $_GET['id'] . ' a été correctement supprimé !</p>';
}

if($_POST) // si je clique sur le bouton submit du formulaire
{
    $resultat = $pdo->prepare("UPDATE membre SET pseudo = :pseudo, mdp = :mdp, nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, civilite = :civilite, statut = :statut WHERE id_membre = '$_GET[id_membre]'");

    $resultat -> bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $resultat -> bindParam(':mdp', $_POST['mdp'], PDO::PARAM_STR);
    $resultat -> bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
    $resultat -> bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
    $resultat -> bindParam(':telephone', $_POST['telephone'], PDO::PARAM_INT);
    $resultat -> bindParam(':email', $_POST['email'], PDO::PARAM_STR);
    $resultat -> bindParam(':civilite', $_POST['civilite'], PDO::PARAM_STR);
    $resultat -> bindParam(':statut', $_POST['statut'], PDO::PARAM_STR);

    if ($resultat -> execute()) {
        header("location:gestion_des_membres.php");
    }
}

$resultat = $pdo -> query("SELECT * FROM membre");
$membres = $resultat -> fetchAll(PDO::FETCH_ASSOC);
$contenu .= 'Nombre de résultats : ' . $resultat ->rowCount() . '<br><hr>';

$contenu .= $msg;
$contenu .= '<table class="ges_tab" border="1">';
$contenu .= '<tr>'; // ligne des titres

for ($i = 0; $i < $resultat -> columnCount(); $i++) {
    $colonne = $resultat -> getColumnMeta($i);
     if($colonne['name'] != 'mdp') {
         $contenu .= '<th>' . $colonne['name'] . '</th>';
    }
}

$contenu .= '<th colspan="2">Actions</th>';
$contenu .= '</tr>'; // fin ligne des titres

foreach ($membres as $valeur) { // parcourt tous les enregistrement
    $contenu .= "<tr>"; // ligne pour chaque enregistrement
        foreach ($valeur as $indice => $valeur2) { // Parcourt toutes les infos de chaque enregistrement

            if ($indice != 'mdp') {

                $contenu .= '<td>' . $valeur2 . '</td>';
            }
        }
        $contenu .= '<td><a href="?action=modification&id_membre='. $valeur['id_membre'] .'"><img src="../libs/modi.png"></a></td>';
        $contenu .= '<td><a onclick="confirm(\'Etes-vous certain de vouloir supprimer ce  membre' . $valeur['id_membre'] . '\');" href="supprimer_membre.php?id=' . $valeur['id_membre'] . '"><img src="../libs/supp.png"></a></td>';

    $contenu .= "</tr>";
}
$contenu .= '</table>';
$contenu .= "<br>";


if(isset($_GET['action']) && $_GET['action'] == 'modification') {


    if(isset($_GET['id_membre']))
    {
    $resultat = $pdo->query("SELECT * FROM membre WHERE id_membre = '$_GET[id_membre]'");
    $membre_actuel = $resultat->fetch(PDO::FETCH_ASSOC);


    $id_membre             =      (isset($membre_actuel)) ? $membre_actuel['id_membre'] : '';
    $pseudo                =      (isset($membre_actuel)) ? $membre_actuel['pseudo'] : '';
    $mdp                   =      (isset($membre_actuel)) ? $membre_actuel['mdp'] : '';
    $nom                   =      (isset($membre_actuel)) ? $membre_actuel['nom'] : '';
    $prenom                =      (isset($membre_actuel)) ? $membre_actuel['prenom'] : '';
    $telephone             =      (isset($membre_actuel)) ? $membre_actuel['telephone'] : '';
    $email                 =      (isset($membre_actuel)) ? $membre_actuel['email'] : '';
    $civilite              =      (isset($membre_actuel)) ? $membre_actuel['civilite'] : '';
    $statut                =      (isset($membre_actuel)) ? $membre_actuel['statut'] : '';
    }

    $contenu .= '<h1>Modification :</h1>

    <form class="coucou" action="" method="post">

        <input type="hidden" name="id_membre" value= . ' . $id_membre .'">

        <label>Pseudo :</label>
        <input type="text" name="pseudo" value="' . $pseudo . '">

        <label>Nom :</label>
        <input type="text" name="nom" value=" ' . $nom .'" >

        <label>Prénom :</label>
        <input type="text" name="prenom" value=" ' . $prenom .'" >

        <label>Téléphone :</label>
        <input type="number" name="telephone" value=" ' . $telephone . '" >

        <label>Email :</label>
        <input type="text" name="email" value=" ' . $email . '" >

        <label>Civilité</label>
            <select name="civilite">
                <option '; $contenu .= ($civilite == 'm') ? 'selected' : ''; $contenu .= ' value="m">Homme</option>
                <option '; $contenu .=  ($civilite == 'f') ? 'selected' : ''; $contenu .= ' value="f">Femme</option>
            </select>

        <label>Statut</label>
            <select name="statut">
                <option '; $contenu .= ($statut == 0) ? 'selected' : ''; $contenu .=' value="0">Membre</option>
                <option '; $contenu .= ($statut == 1) ? 'selected' : ''; $contenu .='value="1">Admin</option>
            </select>

        <input type="submit" value="Valider">

    </form>';

}

// $page = 'Gestion Membres';
require_once('../inc/header.php');
?>

<!-- Contenu HTML -->
<h1>Gestion des membres</h1>
<?= $contenu ?>

<?php
require_once('../inc/footer.php');

?>
