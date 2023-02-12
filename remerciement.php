<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Accueil - PneuTrott</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Inter.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
    <script src='https://www.hCaptcha.com/1/api.js' async defer></script>
    <?php
    require_once("php/fonction.php");
    $err = null;
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
                    <li class="nav-item"><a class="nav-link active" href="index.php">Accueil</a></li>
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
                        <li class="nav-item"><a class="nav-link" href="panier.php">Mon panier</a></li>
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
    <header class="bg-primary-gradient">
        <div class="container pt-4 pt-xl-5">
            <div class="row pt-6">
                <div class="col-md-8 col-xl-8 text-center text-md-start mx-auto">
                    <div class="text-center">
                        <?php
                        if (isset($_GET['connexion'])) {
                        ?>
                            <div class="alert alert-success">
                                <strong>Succès ! </strong> vous êtes connecté !
                            </div>
                        <?php
                        }
                        ?>
                        <h1 class="fw-bold">Nous vous remercions pour votre commande</h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section>
        <div class="row pt-5">
            <div class="col-md-8 col-xl-6 text-center text-md-start mx-auto" style="width: 780px;">
                <div class="text-center">
                    <h5>
                        Votre commande a été prise en compte et sera traitée dans les meilleurs délais. <br>
                    </h5>
                    <br>
                    <p> <a href="index.php" style="text-align:center;">Revenir a la page d'accueil</a> </p>
                </div>
            </div>
        </div>
    </section>

</html>