<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Modifier Produit</title>
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
    $produits = $req->fetchAll();
    $lienConnexion = "deconnexion.php";
    $connexion = "Deconnexion"


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
    <form action="modifierProduit.php" method="post">
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2 class="fw-bold">Stock</h2>
                    <p class="text-muted w-lg-50">Gestion de stock&nbsp;</p>
                </div>
            </div>


            <table class="table" style="background-color: white;">
                <thead>
                <tr>
                    <th>Nom du produit</th>
                    <th>Statut</th>
                    <th>Quantité</th>
                </tr>
                </thead>
                <tbody>
                <?php


                foreach ($produits as $produit) {
                    if ($produit['PRO_QTESTOCK'] == 0) {


                        echo '<tr>';
                        echo '<td>' . $produit['PRO_NOM'] . '</td><td><font color="red">Stock épuisé</td><td>' . $produit['PRO_QTESTOCK'] . '</td>';
                        echo '</tr>';
                        // echo " Pour le ".$produit['NOM'].", le stock épuisé.La quantité est de ".$produit['QUANTITE']." <br><br>";
                    } elseif ($produit['PRO_QTESTOCK'] > 0 && $produit['PRO_QTESTOCK'] <= 20) {
                        echo '<tr>';
                        echo '<td>' . $produit['PRO_NOM'] . '</td><td><font color="orange">Stock presque épuisé</td><td>' . $produit['PRO_QTESTOCK'] . '</td>';
                        echo '</tr>';


                        // echo 'Pour le '.$produit['NOM'].', le stock est presque épuisé. La quantité est de' .$produit['QUANTITE'].'<br><br>';

                    } else {
                        echo '<tr>';
                        echo '<td>' . $produit['PRO_NOM'] . '</td><td><font color="green">Disponible</td><td>' . $produit['PRO_QTESTOCK'] . '</td>';
                        echo '</tr>';

                        // echo 'Le '.$produit['NOM'].' est disponible. La quantité est de '.$produit['QUANTITE'] .'<br><br>';
                    }
                }

                ?>





                </tr>
                </tbody>
            </table>

            </div>