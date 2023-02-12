<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Passer commande</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Inter.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
  <?php
  include './php/paypalPaiement.php';

require_once('./php/fonction.php');

try {
    $bdd = getConnexion(); // On inclu la connexion à la bdd
    // si la session existe pas soit si l'on est pas connecté on redirige
    if (!isset($_SESSION['user'])) {

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

$idCommande = $_GET['idCommande'];

$sqlQuery = 'SELECT * from commande WHERE COM_ID = :idCommande ';
$req = $bdd->prepare($sqlQuery);
$req->execute([
	'idCommande' => $_GET['idCommande'],
]);

$commandes = $req->fetchAll();

if (empty($commandes)) {
	echo 'Erreur: Votre commande n\'a pas été trouvée.';
	return;
}

$commande = $commandes[0];


$sqlQuery = $bdd->prepare('SELECT * FROM adresse WHERE ADR_ID = ?');
$sqlQuery->execute(array($data['ADR_DOMICILE']));
$data2 = $sqlQuery->FETCH();
$data3 = $data2['ADR_ID'];

?>

</head>

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
                <li class="nav-item"><a class="nav-link active" href="panier.php">Mon panier</a></li>
            </ul><a class="btn btn-primary shadow" role="button" href=<?= $lienConnexion; ?>><?= $connexion; ?></a
        </div>
</nav>
<section class="py-5">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="container py-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2 class="fw-bold"> <?php echo $data['PER_NOM'];
                                            echo " " . $data['PER_PRENOM'];
                                            ?>
                    </h2>
                    <p class="text-muted w-lg-50">Récaputilatif de la commande n° <?= $idCommande?>&nbsp;</p>
                </div>
        </div>
        <div class="row justify-content-center">
        <div class="container py-5">
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Produit</th>
                    <th scope="col">Prix unitaire (en CHF)</th>
                    <th scope="col">Quantité commandée</th>
                    <th scope="col">Prix TTC (en CHF)</th>
                </tr>
            </thead>
            <tbody>
                <?php
		            $sqlQuery = 'SELECT * FROM produit AS p
					 JOIN produitCommander AS a ON a.PRO_ID = p.PRO_ID
					 WHERE COM_ID = :idCommande';
                    $req = $bdd->prepare($sqlQuery);
                    $req->execute([
                        'idCommande' => $idCommande,
                    ]);
                    $produits = $req->fetchAll();
                    $montantTotal = 0;
                    foreach ($produits as $produit) {
                        $nom = $produit['PRO_NOM'];
                        $prixUnitaire = $produit['PRO_PRIXUNITAIRE'];
                        $quantite = $produit['QTECOMMANDER'];
                        $image = $produit['PRO_IMAGE'];
                        $prix = $prixUnitaire * $quantite;
                        $montantTotal += $prix;
                    ?>
			    <tr>
                    <td><?php echo "<img class = 'ref-image' src=\"img/" . $produit['PRO_IMAGE'] . "\" loading = \"lazy\" style=\"width: 50px; height:50px; margin: 30px;\">";?>
                    <td><?= $nom ?></td>
                    <td><?= number_format($prixUnitaire, 2) ?></td>
                    <td><?= $quantite ?></td>
                    <td><?= number_format($prix, 2) ?></td>
			    </tr>
		        <?php
                }
                $tauxTva = 7.7;
                $montantTVA = $montantTotal * $tauxTva / 100;
                $montantTotal = $montantTotal - $montantTVA;
                $montantTotalTtc = $montantTotal + $montantTVA;
                ?>
            </tbody>
        </table>
        <div style='text-align: right;'>
            <p>Montant total de la commande (HT) : <?= number_format($montantTotal, 2) ?> CHF</p>
            <p>Montant de la TVA (7.7%) : <?= number_format($montantTVA, 2) ?> CHF</p>
            <p>Montant total de la commande (TTC): <strong><?= number_format($montantTotalTtc, 2) ?> CHF</strong></p>
        </div>
    </form>
</section>
</html>
