<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Historique des commandes</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Inter.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
    
</head>

<body>

    
    <?php require_once("php/fonction.php");
    try {
        if (!isset($_SESSION['user'])) {
            header('Location:index.php');
            die();
        }

        // On récupere les données de l'utilisateur
        $bdd = getConnexion();
        $reponseUser = $bdd->prepare('SELECT * FROM personne WHERE PER_ID = ?');
        $reponseUser->execute(array($_SESSION['user']));
        $data = $reponseUser->fetch();
        $typePersonne = $data['PER_TYPE'];
        $connexion = "Deconnexion";
        $lienConnexion = "deconnexion.php";
        $typePersonne = $data['PER_TYPE'];
    } catch (PDOException $e) {
        echo "Erreur !: " . $e->getMessage() . "<br />";
        die();
    }
?>


    <body style="/*background: url("design.jpg");*/background-position: 0 -60px;">
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
                <li class="nav-item"><a class="nav-link" href="inscription.php">Inscription</a></li>
                <li class="nav-item"><a class="nav-link active " href="panier.php">Mon Profil</a></li>
                <li class="nav-item"><a class="nav-link  " href="panier.php">Mon Panier</a></li>
            </ul><a class="btn btn-primary shadow" role="button" href=<?= $lienConnexion; ?>><?= $connexion; ?></a
        </div>
</nav>
<section class="py-5">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="container py-5">

        <?php
        
		$sqlQuery = 'SELECT * from commande WHERE PER_ID = :idCommande AND COM_STATUT = "Paye" ';
                $req = $bdd->prepare($sqlQuery);
                $req->execute([
                    'idCommande' => $_SESSION['user'],
                ]);


                $commandes = $req->fetchAll();

                if (empty($commandes)) {
                    echo "Vous n'avez pas passé de commande encore ,";
                    echo "voulez-vous <a href=\"produits.php\" style=\"color:blue; position :inline-bloc;\" class=\"fs-6 fw-bold\">ajouter un produit dans le panier ?</a>";
                    return;
                }
                
                $commande = $commandes[0];

    ?>
                <table class="table" style="background-color: white;">
                <thead>
                <tr>
                    <th>N° de la commande</th>
                    <th>Statut</th>
                    <th>Date de la commande</th>
                </tr>
                </thead>
                <tbody>
                <?php


                foreach ($commandes as $commande) {
                        echo '<tr>';
                        echo '<td><a href="commande_details_historique.php?idCommande=' . $commande['COM_ID'] . '">' . $commande['COM_ID'] . '';
                        echo '<td><a href="commande_details_historique.php?idCommande=' . $commande['COM_ID'] . '">' . $commande['COM_STATUT'] . '';
                        echo '<td><a href="commande_details_historique.php?idCommande=' . $commande['COM_ID'] . '">' . $commande['COM_DATEHEURE'] . '';
                        echo '</tr>';
                        
                }

                ?>
                </tr>
                </tbody>
            </table>

	</ul>
	<p><a href="monProfil.php">Retour à la page précédente...</a></p>

</html>