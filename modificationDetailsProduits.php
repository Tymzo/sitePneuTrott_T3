<?php

require_once('./php/fonction.php');
$bdd = getConnexion();

$sqlQuery = 'SELECT * FROM produit WHERE PRO_ID = :idProduit';
$req = $bdd->prepare($sqlQuery);
$req->execute([
    'idProduit' => $_GET['idProduit'],
]);
$produits = $req->fetchAll();
$produit = $produits[0];

$sqlQuery2 = "SELECT CAT_ID, CAT_NOM FROM categorie";
$req = $bdd->prepare($sqlQuery2);
$req->execute();
$cats = $req->fetchAll();


if (isset($_POST["ajout"])) {
    if (!isset($_POST['nom']) || empty($_POST['nom']) ||
        !isset($_POST['prixUnitaire']) || empty($_POST['prixUnitaire']) ||
        !isset($_POST['qtestock'])||
        !isset($_POST['categorie']) || empty($_POST['categorie']) ||
        !isset($_POST['descriptionProduit']) || empty($_POST['descriptionProduit'])) {

        echo '<p>Veuillez remplir tout les champs.</p>';
    } else {

        $visible = 1;

        if (isset($_POST['visible'])) {
            $visible = 0;
        }

        //ajouter dans le update la variable......

        $sqlQuery3 = 'UPDATE produit SET PRO_NOM = :nom, PRO_PRIXUNITAIRE = :prixUnitaire, PRO_QTESTOCK = :qtestock, CAT_ID = :categorie , PRO_DESC = :descriptionProduit, PRO_VISIBLE = :visible where PRO_ID = :idProduit';
        $req = $bdd->prepare($sqlQuery3);
        $req->execute([
            'idProduit' => $_GET['idProduit'],
            'nom' => $_POST['nom'],
            'prixUnitaire' => $_POST['prixUnitaire'],
            'qtestock' => $_POST['qtestock'],
            'descriptionProduit' => $_POST['descriptionProduit'],
            'categorie' => $_POST['categorie'],
            'visible' => $visible]);
        echo '<p>La modification a bien été faite.</p>';
    }
}
try {
    if(!isset($_SESSION['user'])){
        header('Location:index.php');
        die();
    }
    else{
        // On récupere les données de l'utilisateur
        $reponseUser= $bdd->prepare('SELECT * FROM personne WHERE PER_ID = ?');
        $reponseUser->execute(array($_SESSION['user']));
        $data = $reponseUser->fetch();

        $email=$data['PER_EMAIL'];
        $connexion = "Deconnexion";
        $lienConnexion = "deconnexion.php";


    }
}catch (PDOException $e) {
    echo "Erreur !: " . $e->getMessage() . "<br />";
    die();
}
?>


<?php



?>

    <!DOCTYPE html>
    <html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - PneuTrott</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Inter.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body style="/*background: url("design.jpg");*/background-position: 0 -60px;">
<form action="" method="post">
    <nav class="navbar navbar-light navbar-expand-md sticky-top navbar-shrink py-3" id="mainNav">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="/"><span
                        class="bs-icon-sm bs-icon-circle bs-icon-primary shadow d-flex justify-content-center align-items-center me-2 bs-icon"><svg
                            xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icon-tabler-scooter">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="18" cy="17" r="2"></circle>
                        <circle cx="6" cy="17" r="2"></circle>
                        <path d="M8 17h5a6 6 0 0 1 5 -5v-5a2 2 0 0 0 -2 -2h-1"></path>
                    </svg></span><span>PneuTrott</span></a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span
                        class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link" href="produits.php">Produits</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacts.php">Contacts</a></li>
                    <li class="nav-item"></li>
                    <?php
                    if(!isset($_SESSION['user'])){
                        ?>
                        <li class="nav-item"><a class="nav-link " href="inscription.php">Inscription</a></li>
                    <?php }
                    elseif($data['PER_TYPE'] = 0){?>
                        <li class="nav-item"><a class="nav-link active" href="monProfil.php">Mon profil</a></li>
                        <?php
                    }
                    else{
                        ?>
                        <li class="nav-item"><a class="nav-link active" href="admin.php">Admin</a></li>
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
                    <h2 class="fw-bold">Modification du produit</h2>
                    <p class="text-muted w-lg-50">Modifier les onglet du produit ci-dessous&nbsp;</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item"
                     style="padding-right: 36px;">
                    
                    <label class ="ref-name">Nom</label>
                    <div class="mb-3"><input class="form-control form-control-sm" type="text" name="nom" id="nom"
                                             value="<?= htmlspecialchars($produit['PRO_NOM']) ?>"></div>
                    <ul class="list-unstyled">
                        <li></li>

                        <label class ="ref-name">Prix unitaire</label>
                        <div class="mb-3"><input class="form-control form-control-sm" type="float" name="prixUnitaire"
                                                 id="prixUnitaire"
                                                 value="<?= htmlspecialchars($produit['PRO_PRIXUNITAIRE']) ?>"></div>
                        <ul class="list-unstyled">
                            <li></li>

                            <label class ="ref-name">Quantité en stock</label>
                            <div class="mb-3"><input class="form-control form-control-sm" type="number" min="0" name="qtestock"
                                                     id="qtestock"
                                                     value="<?= htmlspecialchars($produit['PRO_QTESTOCK']) ?>" ></div>
                            <ul class="list-unstyled">
                                <li></li>

                                <div class="mb-3">
                                <label class ="ref-name">Categorie</label>
                                    <select class="form-control form-control-sm" type="text" name="categorie"
                                            id="categorie" placeholder="Categorie">
                                        <?php
                                        foreach ($cats as $cat) { ?>
                                            <option value="<?php echo($cat['CAT_ID']); ?>" <?php if ($cat['CAT_ID'] == $produit['CAT_ID']) {
                                                echo("Selected");
                                            } ?> ><?php echo($cat['CAT_NOM']); ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                </div>
                <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item"
                     style="padding-right: 36px;">
                     <label class ="ref-name">Description</label>
                    <div class="mb-3"><textarea class="form-control form-control-sm" id="message-1"
                                                name="descriptionProduit" rows="6"
                                                id="descriptionProduit"> <?= htmlspecialchars($produit['PRO_DESC']) ?></textarea>
                    </div>
                    <ul class="list-unstyled">
                        <li>
                            <?php
                            if ($produit['PRO_VISIBLE'] != 1) {
                                echo "<input type=\"checkbox\" id=\"visible\" name=\"visible\" checked>";
                            } else {
                                echo "<input type=\"checkbox\" id=\"visible\" name=\"visible\">";
                            }
                            ?>
                            <label for="visible"> Voulez-vous cacher le produit </label> <br>
                            <h8>(si la case est cochée, le produit n'est pas visible)</h8>
                            <br>
                        </li>
                </div>
                <div class="row justify-content-center">
                    <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item"
                         style="padding-right: 36px;">
                        <input class="btn btn-primary shadow" type="submit" name="ajout" value="Enregistrer">
                        <ul class="list-unstyled">
                            <li></li>
                    </div>
                    <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item"
                         style="padding-right: 36px;">
                        <input class="btn btn-primary shadow" type="reset">
                        <ul class="list-unstyled">
                            <li></li>
                    </div>
                </div>
</form>
</body>
<?php
?>