<?php

require_once('./php/fonction.php');

$bdd = getConnexion();

$sqlQuery = "SELECT CAT_ID, CAT_NOM FROM categorie";
$req = $bdd->prepare($sqlQuery);
$req->execute();
$cats = $req->fetchAll();

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
    <form action="traitementAjout.php" method="post" enctype="multipart/form-data" id="ajoutProduit">  <!-- ajout d'un id pour pouvoir recup le formulaire-->
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2 class="fw-bold">Ajout de produit</h2>
                    <p class="text-muted w-lg-50">Remplir les champs ci-dessous afin d'ajouter un produit au catalgoue&nbsp;</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item" style="padding-right: 36px;">
                    <div class="mb-3"><input class="form-control form-control-sm" type="text" name="nom" id ="nom" placeholder="Nom du produit"></div>
                    <ul class="list-unstyled">
                        <li></li>

                        <div class="mb-3"><input class="form-control form-control-sm" type="float" name="prixUnitaire" id ="prixUnitaire" placeholder="Prix unitaire"></div>
                        <ul class="list-unstyled">
                            <li></li>

                            <div class="mb-3"><input class="form-control form-control-sm" type="number" name="qtestock" id ="qtestock" placeholder="Quantité en stock"></div>
                            <ul class="list-unstyled">
                                <li></li>

                                <div class="mb-3">
                                    <select class="form-control form-control-sm" type="text" name="categorie" id ="categorie" placeholder="Categorie">
                                        <?php
                                        foreach ($cats as $cat) {?>
                                            <option value="<?php echo( $cat['CAT_ID']);?>"><?php echo( $cat['CAT_NOM']);?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                </div>
                <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item" style="padding-right: 36px;">
                    <div class="mb-3"><textarea class="form-control form-control-sm" id="message-1" name="descriptionProduit" rows="6" id ="descriptionProduit" placeholder="Description du produit"></textarea></div>
                    <ul class="list-unstyled">
                        <li></li>

                        <div class="mb-3"><input class="form-control form-control-sm" type="file" name="fileToUpload" id="fileToUpload" placeholder="Image du produit" /></div>
                        <ul class="list-unstyled">
                            <li></li>
                </div>

                <div class="row justify-content-center">
                    <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item" style="padding-right: 36px;">
                        <input class="btn btn-primary shadow"  type="submit" name="ajout" value="Confirmer l'ajout" onsubmit="validerFormulaire()">
                        <ul class="list-unstyled">
                            <li></li>
                    </div>
                    <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item" style="padding-right: 36px;">
                        <input class="btn btn-primary shadow" type="reset">
                        <ul class="list-unstyled">
                            <li></li>
                    </div>
    </form>
</section>

    <?php
    if(isset($_GET['reg_err']))
    {
        $err = htmlspecialchars($_GET['reg_err']);

        switch($err)
        {
            case 'success':
                ?>
                <div class="alert alert-success">
                    <strong>Succès</strong> ajout réussie !
                </div>
                <?php
                break;

            case 'champVide':
                ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> champ vide
                </div>
                <?php
                break;

            case 'notImage':
                ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> ceci n'est pas une image
                </div>
                <?php
                break;

                case 'imageExist':
                ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> image déjà existante
                </div>
                <?php
                break;

            case 'imageTaille':
                ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> taille de l'image trop grosse
                </div>
            <?php
            case 'imageIncorr':
                ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> mauvais format d'image
                </div>
            <?php

        }
    }
    ?>
    <script>
        function validerFormulaire(){
            //je recup les données du formulaire
            var formData = new FormData(); //creer une nouvelle instance du formulaire
            formData.append("nom", document.getElementById("nom").value)
            formData.append("prixUnitaire", document.getElementById("prixUnitaire").value)
            formData.append("qtestock", document.getElementById("qtestock").value)
            formData.append("categorie", document.getElementById("categorie").value)
            formData.append("descriptionProduit", document.getElementById("descriptionProduit").value)
            formData.append("fileToUpload", document.getElementById("fileToUpload").value)

            //envoie des données au script
            var xhr = new XMLHttpRequest(); //permet d'interagir avec le serveur
            xhr.open("POST", "traitementAjout.php", true); //true = asynchrone, permet d'envoyé une requête au serveur, même si la réponse n'a pas encore atteint le navigateur
                                                            //synchrone = envoie une requête a la fois au serveur, si je veux envoyé d'autre requête je dois attendre la rép du serv
            xhr.onreadystatechange = function (){
                if (xhr.readyState === 4 && xhr.status === 200) //le "4" verif que la requête a bien été envoyée et le "200" verif si la page existe
                    var reponse = JSON.parse(xhr.responseText);
                if (reponse.succes){
                    alert("ajout réussie")
                }else{
                    alert(reponse.message)
                }
            };
            xhr.send(formData)
        }
    </script>

