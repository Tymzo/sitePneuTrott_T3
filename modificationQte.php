<?php
require_once('php/fonction.php');
try {
    $bdd = getConnexion();

    $idProduit = $_POST['produit'];
    $quantite = $_POST['quantite'];

    $reponseUser = $bdd->prepare('SELECT * FROM personne WHERE PER_ID = ?');
    $reponseUser->execute(array($_SESSION['user']));
    $data = $reponseUser->fetch();

    $reponseProduit = $bdd->prepare('SELECT * FROM produit WHERE PRO_ID = ?');
    $reponseProduit->execute(array($idProduit));
    $dataProduit = $reponseProduit->fetch();

    $reponseProduitCmd = $bdd->prepare('SELECT * FROM produitCommander WHERE PRO_ID = ?');
    $reponseProduitCmd->execute(array($idProduit));
    $dataProduitCmd = $reponseProduitCmd->fetch();

    $varQte = $dataProduitCmd['QTECOMMANDER'] - $quantite;

    if (isset($_POST['enregistrer'])) {

        if ($quantite > $dataProduit['PRO_QTESTOCK']) {
            header('Location:panier.php?reg_err=pasEnStock');
            die();
        }

        $sqlModificationQte = $bdd->prepare('UPDATE `produitCommander` SET `QTECOMMANDER` = :qte WHERE `PRO_ID` = :id ');
        $sqlModificationQte->execute([
            'qte' => $quantite,
            'id' => $idProduit
        ]);
    } elseif (isset($_POST['supprimer'])) {
        $sqlSuppressionProduit = $bdd->prepare('DELETE FROM produitCommander WHERE PRO_ID = :id ');
        $sqlSuppressionProduit->execute([
            'id' => $idProduit
        ]);

        header('Location:panier.php?reg_err=succes');
    }

    header('Location:panier.php?reg_err=succes');
} catch (PDOException $e) {
    echo "Erreur !: " . $e->getMessage() . "<br />";
    die();
}