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

<body style="/*background: url(&quot;design.jpg&quot;);*/background-position: 0 -60px;">
<nav class="navbar navbar-light navbar-expand-md sticky-top navbar-shrink py-3" id="mainNav">
    <div class="container"><a class="navbar-brand d-flex align-items-center" href="index.php/"><span
                    class="bs-icon-sm bs-icon-circle bs-icon-primary shadow d-flex justify-content-center align-items-center me-2 bs-icon"><svg
                        xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icon-tabler-scooter">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="18" cy="17" r="2"></circle>
                        <circle cx="6" cy="17" r="2"></circle>
                        <path d="M8 17h5a6 6 0 0 1 5 -5v-5a2 2 0 0 0 -2 -2h-1"></path>
                    </svg></span><span>PneuTrott</span></a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span
                    class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
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
                <?php } elseif ($typePersonne == 0) {
                    ?>
                    <li class="nav-item"><a class="nav-link" href="monProfil.php">Mon profil</a></li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
                    <?php
                }
                ?>
            </ul>
            <a class="btn btn-primary shadow" role="button" href=<?= $lienConnexion; ?>><?= $connexion; ?></a>
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
                    <h1 class="fw-bold">Condition général de vente</h1>
                </div>
            </div>
        </div>
    </div>
</header>


<body>
<div class="row pt-3">
    <div class="col-md-8 col-xl-8 text-center text-md-start mx-auto" style="width: 80em;">

        <div id="outputPage">
            <div data-exp="" class="">
                <div

                <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Center;">
                <span
                        style="font-style:normal;font-weight:bold;text-decoration:underline;"></span><br><br>Les
                    présentes conditions générales régissent l’utilisation de ce site <span
                            style="font-style:italic;font-weight:normal;">www.pneutrott.ch</span>.<br>Ce site appartient
                    et est
                    géré par Fitim Imeri<br>En utilisant ce site, vous indiquez que vous avez lu et compris les
                    conditions
                    d’utilisation et que vous acceptez de les respecter en tout temps.<br><br>Type de site : e-commerce
                </p>
                <div>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                    <span
                            style="font-style:normal;font-weight:bold;text-decoration:underline;">Propriété intellectuelle</span><br><br>Tout
                        contenu publié et mis à disposition sur ce site est la propriété de Fitim Imeri et de ses
                        créateurs. Cela comprend, mais n’est pas limité aux images, textes, logos, documents, fichiers
                        téléchargeables et tout ce qui contribue à la composition de ce site. </p></div>
                <div>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        <span style="font-style:normal;font-weight:bold;text-decoration:underline;">Comptes</span><br><br>Lorsque
                        vous créez un compte sur notre site, vous acceptez ce qui suit : </p>
                    <ol start="1"
                        style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;list-style:decimal;">
                        <li style="text-align:left;" value="1"><span>que vous êtes seul responsable de votre compte et de la sécurité et la confidentialité de votre compte, y compris les mots de passe ou les renseignements de nature délicate joints à ce compte, et</span><span
                                    style="color:#000000;"><br></span></li>
                        <li style="text-align:left;" value="2"><span>que tous les renseignements personnels que vous nous fournissez par l’entremise de votre compte sont à jour, exacts et véridiques et que vous mettrez à jour vos renseignements personnels s’ils changent.</span><span
                                    style="color:#000000;"><br></span></li>
                    </ol>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        Nous nous réservons le droit de suspendre ou de résilier votre compte si vous utilisez notre
                        site
                        illégalement ou si vous violez les conditions d’utilisation acceptable. </p></div>
                <div>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        <span style="font-style:normal;font-weight:bold;text-decoration:underline;">Ventes des biens et services</span><br>Ce
                        document régit la vente des biens mis à disposition sur notre site. </p>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        Les biens que nous offrons comprennent : </p>
                    <ul style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;list-style:disc;">
                        <li style="text-align:left;" value="1"><span>Des pièces détachées de trottinette</span><span
                                    style="color:#000000;"><br></span></li>
                    </ul>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        Les biens liés à ce document sont les biens qui sont affichés sur notre site au moment où vous y
                        accédez. Cela comprend tous les produits énumérés comme étant en rupture de stock. Toutes les
                        informations, descriptions ou images que nous fournissons sur nos biens sont décrites et
                        présentées
                        avec la plus grande précision possible. Cependant, nous ne sommes pas légalement &nbsp;tenus par
                        ces
                        informations, descriptions ou images car nous ne pouvons pas garantir l’exactitude de chaque
                        produit
                        ou service que nous fournissons. Vous acceptez d’acheter ces biens à vos propres risques. </p>
                </div>
                <div>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        <span style="font-style:normal;font-weight:bold;text-decoration:underline;">Paiements</span><br><br>Nous
                        acceptons les modes de paiement suivants sur ce site : </p>
                    <ul style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;list-style:disc;">
                        <li style="text-align: left;" value="1"><span>Carte bancaire</span><span style="color:#000000;"><br></span>
                        </li>
                        <li style="text-align: left;" value="2"><span>PayPal</span><span
                                    style="color:#000000;"><br></span></li>
                    </ul>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        Lorsque vous nous fournissez vos renseignements de paiement, vous nous confirmez que vous avez
                        autorisé l’utilisation et l’accès à l’instrument de paiement que vous avez choisi d’utiliser. En
                        nous fournissant vos détails de paiement, vous confirmez que vous nous autorisez à facturer le
                        montant dû à cet instrument de paiement.<br><br>Si nous estimons que votre paiement a violé une
                        loi
                        ou l’une de nos conditions d’utilisation, nous nous réservons le droit d’annuler votre
                        transaction.
                    </p></div>
                <div>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                    <span
                            style="font-style:normal;font-weight:bold;text-decoration:underline;">Transport et livraison</span><br><br>Lorsque
                        vous effectuez un achat sur notre site, vous acceptez et reconnaissez de fournir un email valide
                        et
                        une adresse d’expédition pour la commande. Nous nous réservons le droit de modifier, rejeter ou
                        annuler votre commande chaque fois que cela devient nécessaire. Si nous annulons votre commande
                        et
                        avons déjà traité votre paiement, nous vous donnerons un remboursement équivalent au montant que
                        vous avez payé. Vous convenez qu’il vous incombe de surveiller votre mode de paiement. Bien que
                        nous
                        visions à vous fournir une estimation précise des délais et des coûts d’expédition, ceux-ci
                        peuvent
                        varier en raison de circonstances imprévues. </p></div>
                <div>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        <span style="font-style:normal;font-weight:bold;text-decoration:underline;">Remboursement</span><br><br><span
                                style="font-style:italic;font-weight:normal;">Remboursement des biens</span></p>
                    <div>
                        <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                            Nous acceptons les demandes de remboursement sur notre site pour les produits qui répondent
                            à
                            l’une des exigences suivantes : </p>
                        <ol start="1"
                            style="text-align:left;line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;list-style:decimal;">
                            <li style="margin-bottom:18.0pt;" value="1">
                                <span>le bien est de la mauvaise taille</span><span
                                        style="color:#000000;"><br></span></li>
                            <li style="margin-bottom:0.0pt;" value="2"><span>changement de mentalité</span><span
                                        style="color:#000000;"><br></span></li>
                        </ol>
                        <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                            Les demandes de remboursement peuvent être faites dans les délais de 14 jours après la
                            réception
                            de vos biens. </p>
                        <div>
                            <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                                Les remboursements ne s’appliquent pas aux produits/services suivants : </p>
                            <ol start="1"
                                style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;list-style:decimal;">
                                <li style="text-align:left;margin-bottom:0.0pt;" value="1">
                                    <span>Produits utiliser</span><span
                                            style="color:#000000;"><br></span></li>
                                <li style="text-align:left;margin-bottom:0.0pt;" value="2">
                                    <span>Produits endomagé</span><span
                                            style="color:#000000;"><br></span></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        <span style="font-style:normal;font-weight:bold;text-decoration:underline;">Retours</span></p>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        Les retours peuvent être effectués en personne aux endroits suivants&nbsp;: <br>
                        Rue du 31 Décembre 41, 1207 Genève </p>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        Veuillez suivre cette procédure pour retourner vos articles par la poste : <br>Emballez le
                        produits
                        dans le carton utiliser pour l'envoie. Le retour n'est pas pris en charge par PneuTrott et sera donc a vos frais </p>
                </div>
                <div>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        <span style="font-style:normal;font-weight:bold;text-decoration:underline;">Limitation de responsabilité</span><br><br>Fitim Imeri ne sera pas tenu responsable de tout problème découlant de ce site.
                        Néanmoins, Fitim Imeri sera tenus responsables de tout problème
                        découlant de toute utilisation irrégulière de ce site. </p></div>
                <div>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        <span style="font-style:normal;font-weight:bold;text-decoration:underline;">Indemnité</span><br><br>En
                        tant qu’utilisateur, vous indemnisez par les présentes Fitim Imeri de toute responsabilité, de
                        tout coût, de toute cause d’action, de tout dommage ou de toute dépense découlant de votre
                        utilisation de ce site ou de votre violation de l’une des dispositions énoncées dans le présent
                        document. </p></div>
                <div>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                    <span
                            style="font-style:normal;font-weight:bold;text-decoration:underline;">Lois applicables</span><br><br>Ce
                        document est soumis aux lois applicables en Suisse et vise à se conformer à ses règles et
                        règlements
                        nécessaires. Cela inclut la réglementation à l’échelle de l’UE énoncée dans le RGPD. </p></div>
                <div>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                    <span
                            style="font-style:normal;font-weight:bold;text-decoration:underline;">Divisibilité</span><br><br>Si,
                        à tout moment, l’une des dispositions énoncées dans le présent document est jugée incompatible
                        ou
                        invalide en vertu des lois applicables, ces dispositions seront considérées comme nulles et
                        seront
                        retirées du présent document. Toutes les autres dispositions ne seront pas touchées par les lois
                        et
                        le reste du document sera toujours considéré comme valide. </p></div>
                <div>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        <span style="font-style:normal;font-weight:bold;text-decoration:underline;">Modifications</span><br><br>Ces
                        conditions générales peuvent être modifiées de temps à autre afin de maintenir le respect de la
                        loi
                        et de refléter tout changement à la façon dont nous gérons notre site et la façon dont nous nous
                        attendons à ce que les utilisateurs se comportent sur notre site. Nous recommandons à nos
                        utilisateurs de vérifier ces conditions générales de temps à autre pour s’assurer qu’ils sont
                        informés de toute mise à jour. Au besoin, nous informerons les utilisateurs par courriel des
                        changements apportés à ces conditions ou nous afficherons un avis sur notre site. </p></div>
                <div>
                    <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Left;">
                        <span style="font-style:normal;font-weight:bold;text-decoration:underline;">Contact</span><br><br>Veuillez
                        communiquer avec nous si vous avez des questions ou des préoccupations. Nos coordonnées sont les
                        suivantes :<br><br>+41 22 73 51 20<br><br>info@velo-service.com </p></div>
                <p style="line-height:18.0pt;font-size:12.0pt;line-height:18.0pt;font-family:Times New Roman;color:#000000;text-align:Right;">
                    <span style="font-style:italic;font-weight:normal;">Date d'entrée en vigueur : </span>le 14 octobre
                    2022. </p></div>

        </div>
    </div>
</div>
</body>





<section></section>
<footer class="bg-primary-gradient">
    <div class="container py-4 py-lg-5">
        <div class="row justify-content-center">
            <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item"
                 style="padding-right: 36px;">
                <h3 class="fs-6 fw-bold">Moyen de paiement</h3>
                <ul class="list-unstyled">
                    <li></li>
                </ul>
                <img src="assets/img/paypal.png"
                     style="margin-right: 39px;padding-right: 0px;padding-left: 0px;margin-left: -7px;" width="165"
                     height="31">
            </div>
            <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item">
                <h3 class="fs-6 fw-bold">Contact</h3>
                <ul class="list-unstyled">
                    <li><a href="#">Téléphone : +41 22 735 12 05</a></li>
                    <li><a href="#">Email : info@velo-service.com</a></li>
                </ul>
            </div>
            <div class="col-lg-3 text-center text-lg-start d-flex flex-column align-items-center order-first align-items-lg-start order-lg-last item social">
                <div class="fw-bold d-flex align-items-center mb-2"><span
                            class="bs-icon-sm bs-icon-circle bs-icon-primary d-flex justify-content-center align-items-center bs-icon me-2"><svg
                                xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icon-tabler-scooter">
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
            <p style="margin-bottom: -27px;padding-bottom: 0px;padding-right: 86px;">Site crée par&nbsp;<a
                        class="link-secondary" href="https://edu.ge.ch/secondaire2/uldry/accueil">ESIG<br><br></a></p>
            <ul class="list-inline fs-3 mb-0">
                <li class="list-inline-item"><a href="facebook.com">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                             viewBox="0 0 16 16" class="bi bi-facebook text-primary">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"></path>
                        </svg>
                    </a></li>
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