<?php
require_once('../inc/init.inc.php');

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {

    $resultat = $pdo -> prepare("SELECT * FROM note WHERE id_note = :id");
    $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $resultat -> execute();

    if ($resultat -> rowCount() > 0) { // signifie que le produit existe
        $note = $resultat -> fetch(PDO::FETCH_ASSOC);

        // supprimer le produit de la BDD :
        $resultat = $pdo -> exec("DELETE FROM note WHERE id_note = $note[id_note]");

        if($resultat) {
            header('location:gestion_des_notes.php?msg=suppr&id=' . $note['id_note']);
        }
    }
}



?>
