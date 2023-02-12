<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Historique des commandes</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Inter.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
    <?php

    require_once('./php/fonction.php');

    $bdd = getConnexion();
    if (!isset($_SESSION['user'])) {
        header('Location:index.php');
        die();
    }
    $sqlQuery = "SELECT * FROM produit order by PRO_QTESTOCK asc";
    $req = $bdd->prepare($sqlQuery);
    $req->execute();
    $lienConnexion = "deconnexion.php";
    $connexion = "Deconnexion";

    $sqlQueryCmd = "SELECT * FROM commande JOIN produitCommander ON commande.COM_ID = produitCommander.COM_ID WHERE COM_STATUT = :statut";
    $reponseCommande = $bdd->prepare($sqlQueryCmd); //RECUPERATION DES PRODUITS MIS DANS LE PANIER TEMPORAIREMENT
    $reponseCommande->execute(array(
        'statut' => 'PANIER'
    ));
    $commandes  = $reponseCommande->fetchAll();

    $reponseDeProduits = $bdd->prepare("SELECT * FROM commande JOIN produitCommander ON commande.COM_ID = produitCommander.COM_ID join produit ON produit.PRO_ID = produitCommander.PRO_ID JOIN personne ON personne.PER_ID = commande.PER_ID WHERE COM_STATUT = :statut");
    $reponseDeProduits->execute(
        [

            'statut' => 'En cours'
        ]

    );
    $commandes  = $reponseDeProduits->fetchAll(PDO::FETCH_ASSOC);





    ?>
</head>

<body style="/*background: url(" design.jpg");*/background-position: 0 -60px;">
    <nav class="navbar navbar-light navbar-expand-md sticky-top navbar-shrink py-3" id="mainNav">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="index.php"><span class="bs-icon-sm bs-icon-circle bs-icon-primary shadow d-flex justify-content-center align-items-center me-2 bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-scooter">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="18" cy="17" r="2"></circle>
                        <circle cx="6" cy="17" r="2"></circle>
                        <path d="M8 17h5a6 6 0 0 1 5 -5v-5a2 2 0 0 0 -2 -2h-1"></path>
                    </svg></span><span>PneuTrott</span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link" href="produits.php">Produits</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacts.php">Contacts</a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link active" href="admin.php">Admin</a></li>
                </ul><a class="btn btn-primary shadow" role="button" href=<?= $lienConnexion; ?>><?= $connexion; ?></a>
            </div>
        </div>
    </nav>

    <section class="py-5">

        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2 class="fw-bold">Historique des commandes</h2>
                    <p class="text-muted w-lg-50">Commandes des clients&nbsp;</p>
                </div>
            </div>

            <?php

            $sqlQuery = 'SELECT * from commande JOIN personne on commande.PER_ID = personne.PER_ID WHERE COM_STATUT = "Paye" ';
            $req = $bdd->prepare($sqlQuery);
            $req->execute();


            $commandes = $req->fetchAll();

            if (empty($commandes)) {
                echo 'Erreur: Votre commande n\'a pas été trouvée.';
                return;
            }

            $commande = $commandes[0];

            ?>


            <table class="table" style="background-color: white;">
                <thead>
                    <tr>
                        <TH>N° de commande</TH>
                        <th>Acheteur</th>

                        <th>Statut</th>
                        <th>Date de la commande </th>
                        

                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($commandes as $commande) {
                        echo '<tr>';
                        echo '<td><a href="detailHistoriqueCommandeAdmin.php?idCommande=' . $commande['COM_ID'] . '">' . $commande['COM_ID'] . '';

                        echo '<td><a href="detailHistoriqueCommandeAdmin.php?idCommande=' . $commande['COM_ID'] . '">' . $commande['PER_NOM'] . '';

                        echo '<td><a href="detailHistoriqueCommandeAdmin.php?idCommande=' . $commande['COM_ID'] . '">' . $commande['COM_STATUT'] . '';

                        echo '<td><a href="detailHistoriqueCommandeAdmin.php?idCommande=' . $commande['COM_ID'] . '">' . $commande['COM_DATEHEURE'] . '';

                        echo '<td class =\'btn btn-info btn-sm\' style=\'--bs-btn-padding-y: .5px; --bs-btn-padding-x: .2px; --bs-btn-font-size: .75rem;\'><a href="detailHistoriqueCommandeAdmin.php?idCommande=' . $commande['COM_ID'] . ' ">Voir détails';

                        echo '</tr>';
                    }

                    ?>





                    </tr>
                </tbody>
            </table>


        </div>