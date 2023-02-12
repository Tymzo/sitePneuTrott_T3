<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Shopping Cart - PneuTrott</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.reflowhq.com/v2/toolkit.min.css">
    <link rel="stylesheet" href="assets/css/Inter.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
    <?php
    require_once("php/fonction.php");



    try {
        $bdd = getConnexion(); // On inclu la connexion à la bdd
        // si la session existe pas soit si l'on est pas connecté on redirige
        if (!isset($_SESSION['user'])) {
            header('Location:index.php');
            die();
            $email = "";
            $connexion = "Connexion";
            $lienConnexion = "connexion.php";
        } else {
            // On récupere les données de l'utilisateur
            $reponseUser = $bdd->prepare('SELECT * FROM personne WHERE PER_ID = ?');
            $reponseUser->execute(array($_SESSION['user']));
            $data = $reponseUser->fetch();

            $email = $data['PER_EMAIL'];
            $connexion = "Deconnexion";
            $lienConnexion = "deconnexion.php";
            $typePersonne = $data['PER_TYPE'];
        }
    } catch (PDOException $e) {
        echo "Erreur !: " . $e->getMessage() . "<br />";
        die();
    }


    ?>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md sticky-top navbar-shrink py-3" id="mainNav">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="index.php"><span class="bs-icon-sm bs-icon-circle bs-icon-primary shadow d-flex justify-content-center align-items-center me-2 bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-scooter">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="18" cy="17" r="2"></circle>
                        <circle cx="6" cy="17" r="2"></circle>
                        <path d="M8 17h5a6 6 0 0 1 5 -5v-5a2 2 0 0 0 -2 -2h-1"></path>
                    </svg></span><span>PneuTrott</span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link " href="index.php">Accueil</a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link" href="produits.php">Produits</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacts.php">Contacts</a></li>
                    <li class="nav-item"></li>
                    <?php
                    if (!isset($_SESSION['user'])) {
                    ?>
                        <li class="nav-item"><a class="nav-link" href="inscription.php">Inscription</a></li>
                    <?php } elseif ($typePersonne == 0) { ?>
                        <li class="nav-item"><a class="nav-link" href="monProfil.php">Mon profil</a></li>
                        <li class="nav-item"><a class="nav-link active" href="panier.php">Mon panier</a></li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
                    <?php
                    }
                    ?>
                </ul><a class="btn btn-primary shadow" role="button" href=<?= $lienConnexion; ?>><?= $connexion; ?></a>
            </div>
        </div>
    </nav>

    <section class="py-5">
        <div class="container py-5">
            <div class="row mx-auto" style="/*max-width: 700px;*/">
                <div class="col">
                    <div data-reflow-type="shopping-cart">
                        <?php

                        $reponseCommande = $bdd->prepare("SELECT * FROM commande JOIN produitCommander ON commande.COM_ID = produitCommander.COM_ID WHERE PER_ID = ? AND COM_STATUT ='PANIER'"); //RECUPERATION DES PRODUITS MIS DANS LE PANIER TEMPORAIREMENT
                        $reponseCommande->execute(array($data['PER_ID']),);
                        $reponseCommande->setFetchMode(PDO::FETCH_ASSOC);

                        $reponseDeProduits = $bdd->prepare("SELECT * FROM produitCommander JOIN produit ON produit.PRO_ID = produitCommander.PRO_ID join commande ON commande.COM_ID = produitCommander.COM_ID WHERE PRO_VISIBLE = 1 and PER_ID = :client and COM_STATUT = :statut");
                        $reponseDeProduits->execute(array(
                            'client' => $data['PER_ID'],
                            'statut' => 'PANIER'
                        ));
                        $reponseDeProduits->setFetchMode(PDO::FETCH_ASSOC);
                        $dataProduit = $reponseDeProduits->fetchAll();

                        $prixPanier = 0;




                        foreach ($dataProduit as $produit) {
                            $prixQuantite = $produit['PRO_PRIXUNITAIRE'] * $produit['QTECOMMANDER'];
                            echo '<form action="modificationQte.php" method="post"><td>';

                            echo "<h5 class =\"ref-name\"  style =\"margin-left: 30px;\" ><strong>" . $produit['PRO_NOM'] . "</strong></h5>";

                            echo "<a class = 'ref-product' href=\"detailProduit.php?idProduit=" . $produit['PRO_ID'] . "\">";
                            echo "<img class = 'ref-image' src=\"img/" . $produit['PRO_IMAGE'] . "\" loading = \"lazy\" style=\"width: 256px; height:256px; margin: 30px;\">";
                            echo "</a>";


                            echo "<p style='';>Quantité choisie: </p>";
                            echo "<input value = " . $produit['QTECOMMANDER'] . " class=\"form-control form-control-sm\" type=\"number\" min = \"1\"name=\"quantite\" placeholder=\"1\" id=\"quantite\" onkeyup=\"checkTotalPrice()\" onchange=\"checkTotalPrice()\" style=\";width: 100px ;\">";

                            echo "<div style=\"display:inline-bloc; width: 100px;\"><br>
                            <label class =\"ref-name\">Prix total : </label>
                            <input readonly class=\"form-control form-control-sm\" id=\"total\" value =" . $prixQuantite . 'CHF' . " type=\"text\" name=\"prixTotal\" style=\"width: 100px \"> <br></div>";
                            echo "<input type='hidden' name='produit' value='" . $produit["PRO_ID"] . "'><input type='submit' value='Enregistrer' name='enregistrer' id='enregistrer' style = \"background-color : green; border-color: green;\"  class=\"btn btn-primary shadow\" >";
                            echo "<input type='submit' value='Supprimer' name='supprimer'  class=\"btn btn-primary shadow\" style = \" margin-left:30px; background-color : red; border-color: red;\"></form>";

                            $prixPanier = $prixPanier + $prixQuantite;
                            echo "<br><br>";
                        }

                        if (isset($produit)) {
                            $dateAjout = strtotime($produit['COM_DATEHEURE']);
                            $varTemps = strtotime(date('Y-m-d H:i:s')) - $dateAjout;

                        ?><div>
                                <br><?php
                                    echo "<Strong>PRIX TOTAL DE LA COMMANDE :</strong>";
                                    echo "<br>";
                                    echo "<input readonly class=\"form-control form-control-sm\" id=\"total\" value =" . $prixPanier . "CHF style= \"width: 250px;\">";
                                    echo "<br>";
                                    echo "</ul><a class=\"btn btn-primary shadow\" role=\"button\" style=\";width: 100px position: relative; top: 30px; left: 1500px; width: 250px\" href= detailsCommande.php?idCommande=" . $produit['COM_ID'] . ">Passer commande</a>";
                                } else {
                                    echo "Le panier est vide, voulez-vous <a href=\"produits.php\" style=\"color:blue; position :inline-bloc;\" class=\"fs-6 fw-bold\">ajouter un produit dans le panier ?</a>";
                                }
                                    ?>
                            </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class=" bg-primary-gradient">
        <div class="container py-4 py-lg-5">
            <div class="row justify-content-center">
                <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item" style="padding-right: 36px;">
                    <h3 class="fs-6 fw-bold">Moyen de paiement</h3>
                    <ul class="list-unstyled">
                        <li></li>
                    </ul><img src="assets/img/paiement-300x56.png" style="margin-right: 39px;padding-right: 0px;padding-left: 0px;margin-left: -7px;" width="165" height="31">
                </div>