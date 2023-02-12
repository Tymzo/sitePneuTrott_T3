<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Product - PneuTrott</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.reflowhq.com/v2/toolkit.min.css">
    <link rel="stylesheet" href="assets/css/Inter.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
    <?php require_once("php/fonction.php");

    $bdd = getConnexion();
    $idProduit = $_GET['idProduit'];
    $i = 0;
    //Récupération des données des produits de la bdd
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
        }
        // $reponseDeProduits->setFetchMode(PDO::FETCH_BOTH); //Récupération des données des produits de la bdd
        $check = $bdd->prepare('SELECT * FROM produit WHERE PRO_ID = ?');
        $check->execute(array($idProduit));
        $dataProduit1 = $check->fetch();

        $reponseDeProduits2 = $bdd->query("SELECT * FROM produit WHERE CAT_ID = " . $dataProduit1['CAT_ID'] . "&& PRO_ID != $idProduit");
        $reponseDeProduits2->execute();
        $dataProduit = $reponseDeProduits2->fetchAll();
    } catch (PDOException $e) {
        echo "Erreur !: " . $e->getMessage() . "<br />";
        die();
    }


    ?>
</head>

<body style="margin:auto ; padding: auto;">
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
                    <li class="nav-item"><a class="nav-link active" href="produits.php">Produits</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacts.php">Contacts</a></li>
                    <li class="nav-item"></li>
                    <?php
                    if (!isset($_SESSION['user'])) {
                    ?>
                        <li class="nav-item"><a class="nav-link" href="inscription.php">Inscription</a></li>
                    <?php } elseif ($data['PER_TYPE'] = 1) { ?>
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
    <section class="py-5">
        <div class="container py-5">
            <form action="ajoutPanier.php" method="POST">
                <div data-reflow-type="product" data-bss-dynamic-product="" data-bss-dynamic-product-param="product" data-reflow-shoppingcart-url="panier.php" style="display:inline">

                    <div id="img_qttprod" style="display:flex; flex-direction: row; flex-wrap: nowrap; justify-content:  space-around; align-items: flex-end;">
                        <?php
                        echo "<img class = 'ref-image' src=\"img/" . $dataProduit1['PRO_IMAGE'] . "\" loading = \"lazy\" style=\"position: relative; right: 200px ;width: 256px; height:256px; margin: 30px;\">";
                        ?>
                        <div>
                            <?php
                            echo  "<div style=\"\"><label class =\"ref-name\">Quantité disponible</label>";
                            echo "<input  disabled value = " . $dataProduit1['PRO_QTESTOCK'] . "  class=\"form-control form-control-sm\" type=\"number\" min = \"1\" style=\"width: 200px ;\">
                            </div>";
                            echo "<br>";
                            echo  "<div style=\" width: 200px;\"><label class =\"ref-name\">Quantité choisie</label>";
                            echo "<input value = \"1\" class=\"form-control form-control-sm\" type=\"number\" min = \"1\" name=\"quantite\" placeholder=\"1\" id=\"quantite\" onkeyup=\"checkTotalPrice()\" onchange=\"checkTotalPrice()\" style=\"width: 100px  width: 150;\"></div>";
                            echo "<input type=\"hidden\" name=\"idProduit\" value=" . $dataProduit1['PRO_ID'] . ">";
                            echo "<div style=\" width: 200px;\"><br>
                    <label class =\"ref-name\">Prix total </label>
                    <input readonly class=\"form-control form-control-sm\" id=\"total\" value =" . $dataProduit1['PRO_PRIXUNITAIRE'] . 'CHF' . " type=\"text\" name=\"prixTotal\" style=\"width: 100px position: relative; top: 30px; left: 1500px; width: 150;\"></div> <br>";
                            echo "<button class='btn btn-primary shadow' style=\" width: 150;\" type=\"submit\"> Ajouter au panier</button>";

                            ?>
                        </div>
                    </div>

                    <?php
                    echo "<h3 class =\"ref-name\"  style =\"margin-left: 30px;\" >" . $dataProduit1['PRO_NOM'] . "</h3>
                    <p ref-price style=\"margin:30px;\"> Prix/u " . $dataProduit1['PRO_PRIXUNITAIRE'] . " CHF </p>";
                    echo "<h3><strong>Description du produit</strong></h3> <br>";
                    echo "<div class=\"mb-3\"><textarea disabled class=\"form-control form-control-sm\" id=\"message-1\"
                                                name=\"descriptionProduit\" rows=\"10\"
                                                id=\"descriptionProduit\"> " . $dataProduit1['PRO_DESC'] . "</textarea>";



                    ?>


                </div>
        </div>


        </form>
        <input type="hidden" id="prix" value="<?= $dataProduit1['PRO_PRIXUNITAIRE'] ?>">
    </section>

    <div class="container py-5">
        <div class="row mb-4 mb-lg-5" style="text-align:left;">
            <div>
                <h3 class="fw-bold" style="text-align:left;"">Vous aimeriez peut-être...</h3>
            </div>
        </div>
        <div class=" row mx-auto" style="/*max-width: 700px;*/">
                    <table class="ref-products">

                        <?php //https://forums.commentcamarche.net/forum/affich-14046047-boucle-en-php-avec-les-tr-et-td (utiliser sur l'affichage des produits et sur la page admin)
                        $d = 0;
                        foreach ($dataProduit as $produit) {
                            if ($i == '0') {
                                echo '<tr>';
                            }

                            echo '<td>';
                            echo "<a class = 'ref-product' href=\"detailProduit.php?idProduit=" . $produit['PRO_ID'] . "\">";
                            echo "<img class = 'ref-image' src=\"img/" . $produit['PRO_IMAGE'] . "\" loading = \"lazy\" style=\"width: 150px; height:150px; margin: 30px;\">";
                            echo "</a>";
						  	echo "<br>";
						  echo "<p class = 'ref-product' style=\"color:black; margin-left: 30px;\" >".$produit['PRO_NOM']."</p>";
                        ?>
                        <?php
                            echo '</td>';
                            $i++;

                            if ($i == '3') {
                                echo "</tr>";
                                break;
                            }
                        }
                        if ($i != '0') {
                            echo "</tr>";
                        }
                        ?>
                    </table>
            </div>
        </div>








        <footer class="bg-primary-gradient">
            <div class="container py-4 py-lg-5">
                <div class="row justify-content-center">
                    <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item" style="padding-right: 36px;">
                        <h3 class="fs-6 fw-bold">Moyen de paiement</h3>
                        <ul class="list-unstyled">
                            <li></li>
                        </ul><img src="assets/img/paiement-300x56.png" style="margin-right: 39px;padding-right: 0px;padding-left: 0px;margin-left: -7px;" width="165" height="31">
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
        <script src="https://cdn.reflowhq.com/v2/toolkit.min.js"></script>
        <script src="assets/js/bs-init.js"></script>
        <script src="assets/js/bold-and-bright.js"></script>
        <script>
            let prix = $("#prix").val()

            let totalInput = $("#total")
            let quantiteInput = $("#quantite")

            function checkTotalPrice() {
                totalInput.val((prix * quantiteInput.val()) + " CHF")
            }
        </script>
</body>

</html>