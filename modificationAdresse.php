<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Mon Profil - PneuTrott</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Inter.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
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

        $sqlQuery = $bdd->prepare('SELECT * FROM adresse WHERE ADR_ID = ?');
        $sqlQuery->execute(array($data['ADR_DOMICILE']));
        $data2 = $sqlQuery->FETCH();
        $data3 = $data2['ADR_ID'];



    } catch (PDOException $e) {
        echo "Erreur !: " . $e->getMessage() . "<br />";
        die();
    }


    ?>


    <?php
    require_once('php/fonction.php');
    try {
        if(isset($_POST['submit'])) {
            if (!empty($_POST['rue']) && !empty($_POST['npa']) && !empty($_POST['localite']) && !empty($_POST['pays'])) {
                $rue = filter_input(INPUT_POST, 'rue', FILTER_UNSAFE_RAW);
                $npa = filter_input(INPUT_POST, 'npa', FILTER_UNSAFE_RAW);
                $localite = filter_input(INPUT_POST, 'localite');
                $pays = filter_input(INPUT_POST, 'pays', FILTER_UNSAFE_RAW);

                $idDomicile = $data3;

                updateAdresse($npa,$localite,$pays,$rue,$idDomicile);
                header('location: modificationAdresse.php?reg_err=reussi');die();
            } else {header('location: modificationAdresse.php?reg_err=champVide');die();}
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
                <li class="nav-item"><a class="nav-link " href="index.php">Accueil</a></li>
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
                    <li class="nav-item"><a class="nav-link active" href="monProfil.php">Mon profil</a></li>
                    <li class="nav-item"><a class="nav-link " href="panier.php">Mon panier</a></li>
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
<section class="py-5">
    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <h2 class="fw-bold"> <?php echo $data['PER_NOM'];
                    echo " " . $data['PER_PRENOM']; ?></h2>
                <p class="text-muted w-lg-50">Modification de l'adresse&nbsp;</p>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body text-center d-flex flex-column align-items-center">
                        <div class="bs-icon-xl bs-icon-circle bs-icon-primary shadow bs-icon my-4"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"></path>
                            </svg></div>

                        <form action="modificationAdresse.php" method="post">
                            <?php
                            if (isset($_GET['reg_err'])) {
                                $err = htmlspecialchars($_GET['reg_err']);

                                switch ($err) {
                                    case 'reussi';
                                        ?>
                                        <div class="alert alert-success">
                                            <strong>Succès ! </strong> modification réussi !
                                        </div>
                                        <?php
                                        break;
                                        ?>
                                    <?php
                                    case 'champVide';
                                        ?>
                                        <div class="alert alert-danger">
                                            <strong>Erreur ! </strong> veuillez remplir tout les champs.
                                        </div>
                                        <?php
                                        break;
                                        ?>

                                    <?php
                                }
                            }
                            ?>
                            <h3>Adresse</h3>
                            <label>Rue</label>
                            <div class="mb-3"><input class="form-control form-control-sm" type="text"  name="rue" value="<?= $data2['ADR_RUE'] ?>"></div>
                            <div class="row">
                                <div class="col">
                                    <label>NPA</label>
                                    <div class="mb-3"><input class="form-control form-control-sm" type="number"  name="npa" value="<?= htmlspecialchars($data2['ADR_NPA']) ?>"></div>
                                </div>
                                <div class="col">
                                    <label>Localité</label>
                                    <div class="mb-3"><input class="form-control form-control-sm" type="text"  name="localite" value="<?= htmlspecialchars($data2['ADR_LOCALITE']) ?>"></div>
                                </div>
                                <div class="col">
                                    <label>Pays</label>
                                    <div class="mb-3"><input class="form-control form-control-sm" type="text"  name="pays" value="<?= htmlspecialchars($data2['ADR_PAYS']) ?>"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary btn-sm shadow d-block w-100" type="submit" name="submit">
                                    Modifer !
                                </button>
                            </div>
                        </form>


                                </div>
                            </div>



                    </div>
                </div>
            </div>


            </div>
    </div>
                </form>
</section>
</html>