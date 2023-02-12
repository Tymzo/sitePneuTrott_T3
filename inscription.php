<?php 
require_once('php/fonction.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Inscription - PneuTrott</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Inter.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
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
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"></li>
                <li class="nav-item"></li>
                <li class="nav-item"><a class="nav-link" href="produits.php">Produits</a></li>
                <li class="nav-item"><a class="nav-link" href="contacts.php">Contacts</a></li>
                <li class="nav-item"></li>
                <li class="nav-item"><a class="nav-link active" href="inscription.php">Inscription</a></li>

            </ul><a class="btn btn-primary shadow" role="button" href="connexion.php" style="margin-right:0.5%;">Connexion</a>

        </div>
    </div>
</nav>

<section class="py-5">
    <div class="container py-2">
        <div class="row mb-4 mb-lg-5">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <p class="fw-bold text-primary mb-2">Inscription</p>
                <h2 class="fw-bold">Bienvenue</h2>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 col-xl-5">
                <div class="card">
                    <div class="card-body text-center d-flex flex-column align-items-center">
                        <div class="bs-icon-xl bs-icon-circle bs-icon-primary shadow bs-icon my-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"></path>
                            </svg></div>
                            <form id="inscription-form" action = "traitementInscription.php" method ="POST" >

                            
                            <div class="row justify-content-center">
                                <div class="col-md-7 col-xl-6">

                                    <div class="mb-2">
                                        <label>Nom</label>
                                        <input class="form-control form-control-sm" type="text" id="nom" name="nom"
                                               value="">
                                    </div>
                                </div>
                                <div class="col-md-7 col-xl-6">
                                    <div class="mb-2">
                                        <label>Prenom</label>
                                        <input class="form-control form-control-sm" type="text" id="prenom" name="prenom"
                                               value="">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label>Email</label>
                                <input class="form-control form-control-sm" type="email"
                                       name="email" id="email" value="">
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-7 col-xl-6">
                                    <div class="mb-2">
                                        <label>Mot de passe</label>
                                        <input class="form-control form-control-sm" type="password"
                                               name="password1" id="password1" value=""></div>
                                </div>
                                <div class="col-md-7 col-xl-6">
                                    <div class="mb-2" >
                                        <label>Confirmer le mot de passe</label>
                                        <input class="form-control form-control-sm" type="password"
                                               name="password2" id="password2" value=""></div>
                                </div>

                                <div class="mb-2">
                                    <label>Date de naissance</label>
                                    <input class="form-control form-control-sm" name="dateNaissance" id="dateNaissance"
                                           value="" type="date"></div>
                                <div class="mb-2">
                                    <label>Rue</label>
                                    <input class="form-control form-control-sm" type="text" name="rue" id="rue"
                                           value=""></div>


                                <div class="col-md-7 col-xl-6">
                                    <div class="mb-2">
                                        <label>NPA</label>
                                        <input class="form-control form-control-sm" type="number"
                                               name="npa"id="npa" value=""></div>
                                </div>
                                <div class="col-md-7 col-xl-6">
                                    <div class="mb-2">
                                        <label>Localité</label>
                                        <input class="form-control form-control-sm" type="text"
                                               name="localite" id="localite" value=""></div>
                                </div>

                                <div class="mb-2">
                                    <label>Pays</label>
                                    <select class="form-control form-control-sm" id="pays" name="pays">
                                        <?php
                                        afficherPays();
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <p></p>
                                 <input type="submit" value="S'inscrire" onsubmit="submitForm()" >

                                </div>
                                <p></p>
                                <p class="text-muted">Vous avez déjà un compte?&nbsp;<a href="connexion.php">Connexion</a>
                                </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card"></div>
    </div>
</section>
<script>
   function submitForm() {
       // Récupération des données du formulaire
       var formData = new FormData();
       formData.append("nom", document.getElementById("nom").value);
       formData.append("prenom", document.getElementById("prenom").value);
       formData.append("email", document.getElementById("email").value);
       formData.append("password1", document.getElementById("password1").value);
       formData.append("password2", document.getElementById("password2").value);
       formData.append("dateNaissance", document.getElementById("dateNaissance").value);
       formData.append("rue", document.getElementById("rue").value);
       formData.append("npa", document.getElementById("npa").value);
       formData.append("localite", document.getElementById("localite").value);
       formData.append("pays", document.getElementById("pays").value);

       // Envoi des données au script PHP
       var xhr = new XMLHttpRequest();
       xhr.open("POST", "traitementInscription.php", true);
       xhr.onreadystatechange = function() {
           if (xhr.readyState === 4 && xhr.status === 200) {
               var response = JSON.parse(xhr.responseText);
               if (response.success) {
                   alert("Inscription réussie");
               } else {
                   alert(response.message);
               }
           }
       };
       xhr.send(formData);
   }
</script>
<footer class="bg-primary-gradient">
    <div class="container py-4 py-lg-5">
        <div class="row justify-content-center">
            <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item"
                 style="padding-right: 36px;">
                <h3 class="fs-6 fw-bold">Moyen de paiement</h3>
                <ul class="list-unstyled">
                    <li></li>
                </ul>
                <img src="assets/img/paiement-300x56.png"
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
                        class="link-secondary" href="https://edu.ge.ch/secondaire2/esig">ESIG<br><br></a></p>
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