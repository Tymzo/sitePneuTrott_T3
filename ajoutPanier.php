<?php
require_once("php/fonction.php");
try {



    $bdd = getConnexion();

    if (!isset($_SESSION['user'])) {
        header('Location:produits.php');
        die();
    }

    $reponseUser = $bdd->prepare('SELECT * FROM personne WHERE PER_ID = ?'); // recuperation des données de l'utilisateur
    $reponseUser->execute(array($_SESSION['user']));
    $data = $reponseUser->fetch();

    //RECUPERATION DE LA COMMANDE AU PANIER DU CLIENT CONNECTE
    $reponseCommande = $bdd->prepare('SELECT * FROM commande WHERE PER_ID =:id AND COM_STATUT = :statut ');
    $bdd->beginTransaction();
    $reponseCommande->execute([
        'id' => $data['PER_ID'],
        'statut' => 'PANIER'
    ]);
    $derniereData = $bdd->lastInsertId();
    $bdd->commit();
    $dataCmdClient = $reponseCommande->fetch();
    $nbCommande = $reponseCommande->rowCount();
    //FACON RAPIDE DE METTRE DANS LE PANIER (QTE PAR DEFAUT : 1)
    if (isset($_GET['idProduitChoisi']) && $_GET['idProduitChoisi'] > 0) {

        $idProduitRapide = $_GET['idProduitChoisi'];
        //recup des infos du produit selectionner
        $check = $bdd->prepare('SELECT * FROM produit WHERE PRO_ID = ?');
        $check->execute(array($idProduitRapide));
        $dataProduit = $check->fetch();
        $qteAutoChoisie = 1;



        if ($qteAutoChoisie > $dataProduit['PRO_QTESTOCK']) {
            header("Location:produits.php?reg_err=pasEnStock");
        } else {

            //Verification si le client n'a pas un panier deja cree
            if (!isset($dataCmdClient['COM_ID'])) {
                $sqlQuery = 'INSERT INTO commande(PER_ID, COM_STATUT) VALUES (:perID, :comStatut)';
                $req = $bdd->prepare($sqlQuery);
                $req->execute([
                    'perID' => $data['PER_ID'],
                    'comStatut' =>  'PANIER'
                ]);

                $reponseCommande = $bdd->prepare('SELECT * FROM commande WHERE PER_ID =:id AND COM_STATUT = :statut ');
                $bdd->beginTransaction();
                $reponseCommande->execute([
                    'id' => $data['PER_ID'],
                    'statut' => 'PANIER'
                ]);
                $derniereData = $bdd->lastInsertId();
                $bdd->commit();
                $dataCmdClient = $reponseCommande->fetch();
                $commandePanier = $dataCmdClient['COM_ID'];

                $checkProduitCmd = $bdd->prepare('SELECT * FROM produitCommander WHERE PRO_ID =:produit and COM_ID = :commande');
                $checkProduitCmd->execute(array(
                    'produit' => $idProduitRapide,
                    'commande' => $commandePanier
                ));
                $dataProduitCmd = $checkProduitCmd->fetch();
                $nbProduitCmd = $checkProduitCmd->rowCount();
            } elseif (isset($dataCmdClient['COM_ID'])) {
                $commandePanier = $dataCmdClient['COM_ID'];
                $checkProduitCmd = $bdd->prepare('SELECT * FROM produitCommander WHERE PRO_ID =:produit and COM_ID = :commande');
                $checkProduitCmd->execute(array(
                    'produit' => $idProduitRapide,
                    'commande' => $commandePanier
                ));
                $dataProduitCmd = $checkProduitCmd->fetch();
                $nbProduitCmd = $checkProduitCmd->rowCount();
            }
            if ($nbProduitCmd == 0) {
                // SI LE PRODUIT SELECTIONNE N'EST PAS DEJA DANS LE PANIER :
                $sqlQuery2 = 'INSERT INTO produitCommander(PRO_ID,COM_ID,QTECOMMANDER) VALUES (:IdProduit, :IdCommande, :qte)';
                $req2 = $bdd->prepare($sqlQuery2);
                $req2->execute([
                    'IdProduit' => $idProduitRapide,
                    'IdCommande' => $commandePanier,
                    'qte' => $qteAutoChoisie
                ]);
            } elseif ($nbProduitCmd > 0) {
                $sqlUpdateQte = $bdd->prepare('UPDATE `produitCommander` SET `QTECOMMANDER` = QTECOMMANDER + :qte WHERE `PRO_ID` = :id AND COM_ID = :commande');
                $sqlUpdateQte->execute([
                    'qte' => $qteAutoChoisie,
                    'id' => $idProduitRapide,
                    'commande' => $commandePanier
                ]);


                $_SESSION['idPanier'] = $derniereData;
                header("Location:produits.php?reg_err=succes");
            } elseif (isset($dataCmdClient)) {
                if ($nbProduitCmd == 0) {

                    $sqlQuery2 = 'INSERT INTO produitCommander(PRO_ID,COM_ID,QTECOMMANDER) VALUES (:IdProduit, :IdCommande, :qte)';
                    $req2 = $bdd->prepare($sqlQuery2);
                    $req2->execute([
                        'IdProduit' => $idProduitRapide,
                        'IdCommande' => $commandePanier,
                        'qte' => $qteAutoChoisie
                    ]);
                } elseif ($nbProduitCmd > 0) {
                    $sqlUpdateQte = $bdd->prepare('UPDATE `produitCommander` SET `QTECOMMANDER` = QTECOMMANDER + :qte WHERE `PRO_ID` = :id COM_ID = :commande');
                    $sqlUpdateQte->execute([
                        'qte' => $qteAutoChoisie,
                        'id' => $idProduitRapide,
                        'commande' => $commandePanier
                    ]);
                }
            }
           
            header("Location:produits.php?reg_err=succes");
        }
    }
    //MIS DANS LE PANIER DEPUIS LA PAGE DETAILPRODUIT.PHP
    else {
        $id = $_POST['idProduit'];
        $qte = $_POST['quantite'];

        $check = $bdd->prepare('SELECT * FROM produit WHERE PRO_ID = ?');
        $check->execute(array($id));
        $dataProduit = $check->fetch();

        $checkProduitCmd = $bdd->prepare('SELECT * FROM produitCommander where PRO_ID =?');
        $checkProduitCmd->execute(array($id));
        $dataProduitCmd = $checkProduitCmd->fetch();
        $nbProduitCmd = $checkProduitCmd->rowCount();


        if ($qteAutoChoisie > $dataProduit['PRO_QTESTOCK']) {
            header("Location:produits.php?reg_err=pasEnStock");
        } else {

            //Verification si le client n'a pas un panier deja cree
            if (!isset($dataCmdClient['COM_ID'])) {
                $sqlQuery = 'INSERT INTO commande(PER_ID, COM_STATUT) VALUES (:perID, :comStatut)';
                $req = $bdd->prepare($sqlQuery);
                $req->execute([
                    'perID' => $data['PER_ID'],
                    'comStatut' =>  'PANIER'
                ]);

                $reponseCommande = $bdd->prepare('SELECT * FROM commande WHERE PER_ID =:id AND COM_STATUT = :statut ');
                $bdd->beginTransaction();
                $reponseCommande->execute([
                    'id' => $data['PER_ID'],
                    'statut' => 'PANIER'
                ]);
                $derniereData = $bdd->lastInsertId();
                $bdd->commit();
                $dataCmdClient = $reponseCommande->fetch();
                $commandePanier = $dataCmdClient['COM_ID'];

                $checkProduitCmd = $bdd->prepare('SELECT * FROM produitCommander WHERE PRO_ID =:produit and COM_ID = :commande');
                $checkProduitCmd->execute(array(
                    'produit' => $id,
                    'commande' => $commandePanier
                ));
                $dataProduitCmd = $checkProduitCmd->fetch();
                $nbProduitCmd = $checkProduitCmd->rowCount();
            } elseif (isset($dataCmdClient['COM_ID'])) {
                $commandePanier = $dataCmdClient['COM_ID'];
                $checkProduitCmd = $bdd->prepare('SELECT * FROM produitCommander WHERE PRO_ID =:produit and COM_ID = :commande');
                $checkProduitCmd->execute(array(
                    'produit' => $id,
                    'commande' => $commandePanier
                ));
                $dataProduitCmd = $checkProduitCmd->fetch();
                $nbProduitCmd = $checkProduitCmd->rowCount();
            }
            if ($nbProduitCmd == 0) {
                // SI LE PRODUIT SELECTIONNE N'EST PAS DEJA DANS LE PANIER :
                $sqlQuery2 = 'INSERT INTO produitCommander(PRO_ID,COM_ID,QTECOMMANDER) VALUES (:IdProduit, :IdCommande, :qte)';
                $req2 = $bdd->prepare($sqlQuery2);
                $req2->execute([
                    'IdProduit' => $id,
                    'IdCommande' => $commandePanier,
                    'qte' => $qte
                ]);
            } elseif ($nbProduitCmd > 0) {
                $sqlUpdateQte = $bdd->prepare('UPDATE `produitCommander` SET `QTECOMMANDER` = QTECOMMANDER + :qte WHERE `PRO_ID` = :id AND COM_ID = :commande');
                $sqlUpdateQte->execute([
                    'qte' => $qte,
                    'id' => $id,
                    'commande' => $commandePanier
                ]);


                $_SESSION['idPanier'] = $derniereData;
                header("Location:produits.php?reg_err=succes");
            } elseif (isset($dataCmdClient)) {
                if ($nbProduitCmd == 0) {

                    $sqlQuery2 = 'INSERT INTO produitCommander(PRO_ID,COM_ID,QTECOMMANDER) VALUES (:IdProduit, :IdCommande, :qte)';
                    $req2 = $bdd->prepare($sqlQuery2);
                    $req2->execute([
                        'IdProduit' => $id,
                        'IdCommande' => $commandePanier,
                        'qte' => $qte
                    ]);
                } elseif ($nbProduitCmd > 0) {
                    $sqlUpdateQte = $bdd->prepare('UPDATE `produitCommander` SET `QTECOMMANDER` = QTECOMMANDER + :qte WHERE `PRO_ID` = :id COM_ID = :commande');
                    $sqlUpdateQte->execute([
                        'qte' => $qte,
                        'id' => $id,
                        'commande' => $commandePanier
                    ]);
                }
            }
            
            header("Location:produits.php?reg_err=succes");
        }
    }
} catch (PDOException $e) {
    echo "Erreur !: " . $e->getMessage() . "<br />";
    die();
}
