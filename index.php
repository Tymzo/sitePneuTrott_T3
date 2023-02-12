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
    try{
        $bdd = getConnexion(); // On inclu la connexion à la bdd
        // si la session existe pas soit si l'on est pas connecté on redirige
        if(!isset($_SESSION['user'])){

            $email = "";
            $connexion = "Connexion";
            $lienConnexion = "connexion.php";
        }
        else{
            // On récupere les données de l'utilisateur
            $reponseUser= $bdd->prepare('SELECT * FROM personne WHERE PER_ID = ?');
            $reponseUser->execute(array($_SESSION['user']));
            $data = $reponseUser->fetch();

            $email=$data['PER_EMAIL'];
            $connexion = "Deconnexion";
            $lienConnexion = "deconnexion.php";
            $typePersonne = $data['PER_TYPE'];


        }
    }catch (PDOException $e) {
        echo "Erreur !: " . $e->getMessage() . "<br />";
        die();
    }


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
                <li class="nav-item"><a class="nav-link active" href="index.php">Accueil</a></li>
                <li class="nav-item"></li>
                <li class="nav-item"></li>
                <li class="nav-item"><a class="nav-link" href="produits.php">Produits</a></li>
                <li class="nav-item"><a class="nav-link" href="contacts.php">Contacts</a></li>
                <li class="nav-item"></li>
                <?php
                if(!isset($_SESSION['user'])){
                    ?>
                    <li class="nav-item"><a class="nav-link" href="inscription.php">Inscription</a></li>
                <?php }

                elseif ($typePersonne == 0){?>
                    <li class="nav-item"><a class="nav-link" href="monProfil.php">Mon profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="panier.php">Mon panier</a></li>
                    <?php
                }
                else{
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
        <div class="row pt-5">
            <div class="col-md-8 col-xl-6 text-center text-md-start mx-auto">
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
                    <h1 class="fw-bold">Bienvenue chez PneuTrott</h1>
                </div>
            </div>
        </div>
    </div>
</header>
<section>
    <div class="row pt-5">
        <div class="col-md-8 col-xl-6 text-center text-md-start mx-auto" style="width: 780px;">
            <div class="carousel slide" data-bs-ride="false" id="carousel-1">
                <div class="carousel-inner">
                    <div class="carousel-item active"><img class="w-100 d-block" src="assets/img/e-scooter-5432641_1920.jpg"></div>
                    <div class="carousel-item"><img class="w-100 d-block" src="assets/img/boy-695346_1920.jpg" style="padding-right: 10px;padding-left: 10px;"></div>
                </div>
                <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span><span class="visually-hidden">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button" data-bs-slide="next"><span class="carousel-control-next-icon"></span><span class="visually-hidden">Next</span></a></div>
                <ol class="carousel-indicators">
                    <li data-bs-target="#carousel-1" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carousel-1" data-bs-slide-to="1"></li>
                </ol>
            </div>
            <div class="text-center">
                <section class="py-5 mt-5">
                    <p class="fw-bold mb-2">Qui sommes-nous ?</p>
                    <p class="text-muted mb-0" style="text-align: justify;padding-left: 15px;padding-right: 15px;font-size: 16px;color: #4e5d78;"><br><span style="color: rgb(0, 0, 0); background-color: transparent;">Nous nous sommes fixé pour objectif de vous proposer une gamme complète de pneus pour deux roues de haute qualité de manière aussi efficace, fiable et rapide que possible.</span><br><br><span style="color: rgb(0, 0, 0); background-color: transparent;">Votre satisfaction à l'égard de nos produits, délais de livraison, services et prix ainsi qu'un accompagnement personnalisé et des conseils compétents sont nos tâches les plus importantes.</span><br><br><span style="color: rgb(0, 0, 0); background-color: transparent;">Nous travaillons chaque jour selon ces principes pour vous. C'est peut-être la recette du succès qui a fait de nous l'une des entreprises leaders de cette industrie. Mais nous ne nous reposerons jamais et nous ne serons jamais complaisants. Notre orientation est vous, vos préoccupations, vos souhaits et vos exigences changeantes envers nous.</span><br><br><span style="color: rgb(0, 0, 0); background-color: transparent;">Toutes vos questions, préoccupations et demandes sont donc toujours les bienvenues !</span><br><br></p>
                </section>
            </div>
        </div>
    </div>
</section>
<section></section>
<footer class="bg-primary-gradient">
    <div class="container py-4 py-lg-5">
        <div class="row justify-content-center">
            <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item" style="padding-right: 36px;">
                <h3 class="fs-6 fw-bold">Moyen de paiement</h3>
                <ul class="list-unstyled">
                    <li></li>
                </ul><img src="assets/img/paypal.png" style="margin-right: 39px;padding-right: 0px;padding-left: 0px;margin-left: -7px;" width="165" height="31">
            </div>
            <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item">
                <h3 class="fs-6 fw-bold">Contact</h3>
                <ul class="list-unstyled">
                    <li><a href="#">Téléphone : +41 22 735 12 05</a></li>
                    <li><a href="#">Email : info@velo-service.com</a></li>
                </ul>
            </div>
            <div class="col-lg-3 text-center text-lg-start d-flex flex-column align-items-center order-first align-items-lg-start order-lg-last item social">
                <div class="fw-bold d-flex align-items-center mb-2"><span class="bs-icon-sm bs-icon-circle bs-icon-primary d-flex justify-content-center align-items-center bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-scooter">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="18" cy="17" r="2"></circle>
                                <circle cx="6" cy="17" r="2"></circle>
                                <path d="M8 17h5a6 6 0 0 1 5 -5v-5a2 2 0 0 0 -2 -2h-1"></path>
                            </svg></span><span>PneuTrott</span></div>
                <p class="text-muted copyright" style="color: rgb(78, 93, 120);">Le meilleur pour votre trottinette</p>
            </div>
        </div>
        <hr>
        <div class="text-muted d-flex justify-content-between align-items-center pt-3">
            <p class="mb-0">Copyright © 2022 PneuTrott</p>
            <p style="margin-bottom: -27px;padding-bottom: 0px;padding-right: 86px;">Site crée par&nbsp;<a class="link-secondary" href="https://edu.ge.ch/secondaire2/uldry/accueil">ESIG<br><br></a></p>
            <ul class="list-inline fs-3 mb-0">
                <li class="list-inline-item"><a href="facebook.com"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-facebook text-primary">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"></path>
                        </svg></a></li>
            </ul>
        </div>
    </div>
</footer>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="assets/js/bold-and-bright.js"></script>
</body>

</html>