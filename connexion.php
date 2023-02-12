<?php
require_once('./php/fonction.php');
$err = null;
try {
    if (isset($_POST['submit'])) {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            $email = htmlspecialchars($_POST['email']);
            $mdp = htmlspecialchars($_POST['password']);


            $emailMinuscule = strtolower($email); // email transformé en minuscule

            $connexion = getConnexion();
            $request = $connexion->prepare("SELECT * from `personne` WHERE `PER_EMAIL` = ?");
            $request->execute(array($emailMinuscule));
            $data = $request->fetch();
            $row = $request->rowCount();



            if ($row > 0) { //verifie que l'email existe
                if(filter_var($emailMinuscule, FILTER_VALIDATE_EMAIL)){ //vérifie  que c'est bien un email
                    if (password_verify($mdp, $data['PER_MDP'])) { //vérifie  que les deux mot de passe sont les mêmes, non hash et hash
                        $_SESSION['user'] = $data['PER_ID']; //définition du $_SESSION
                        $err = "reussi";//affiche un message si tous les if sont juste = affichage d'un message de succès pour la connexion
                        header("Location:index.php?connexion=1");
                    } else {$err="mdpEmail";} //vérifie si le mot de passe est le bon, si c'est pas le cas = message d'erreur (mauvais mdp)
                }
            } else {$err="inexistant";} //vérifie si l'email existe, si c'est pas le cas = message d'erreur (email inexistante)
        } else {$err="champVide";} // si le formulaire est envoyé sans aucune données
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
    <title>Connexion - PneuTrott</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Inter.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body>
<nav class="navbar navbar-light navbar-expand-md sticky-top navbar-shrink py-3" id="mainNav">
    <div class="container"><a class="navbar-brand d-flex align-items-center" href="index.php"><span
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
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"></li>
                <li class="nav-item"></li>
                <li class="nav-item"><a class="nav-link" href="produits.php">Produits</a></li>
                <li class="nav-item"><a class="nav-link" href="contacts.php">Contacts</a></li>
                <li class="nav-item"></li>
                <li class="nav-item"><a class="nav-link" href="inscription.php">Inscription</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="connexion.php">Connexion</a>
        </div>
    </div>
</nav>
<section class="py-5">
    <div class="container py-5">
        <div class="row mb-4 mb-lg-5">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <p class="fw-bold text-primary mb-2">Connexion</p>
                <h2 class="fw-bold">Bon retour parmis nous !</h2>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 col-xl-5">
                <div class="card">
                    <div class="card-body text-center d-flex flex-column align-items-center">
                        <div class="bs-icon-xl bs-icon-circle bs-icon-primary shadow bs-icon my-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                                 viewBox="0 0 16 16" class="bi bi-person">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"></path>
                            </svg>
                        </div>
                        <form action="connexion.php" method="post">

                            <?php
                            if ($err!=null) {
                                switch ($err) {
                                    case 'mdpEmail':
                                        ?>
                                        <div class="alert alert-danger  ">
                                            <strong>Erreur ! </strong> mot de passe ou l'adresse mail est fausse.
                                        </div>
                                        <?php
                                        break;
                                        ?>
                                    <?php
                                    case 'reussi';
                                        ?>
                                        <div class="alert alert-success">
                                            <strong>Succès ! </strong> vous êtes connecté !
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
                                    case 'inexistant';
                                        ?>
                                        <div class="alert alert-danger">
                                            <strong>Erreur ! </strong> mot de passe ou l'adresse mail est fausse.
                                        </div>

                                    <?php
                                }
                            }
                            ?>
                            <div class="mb-3"><input class="form-control form-control-sm" type="email" name="email"
                                                     placeholder="Email"></div>
                            <div class="mb-3"><input class="form-control form-control-sm" type="password"
                                                     name="password" placeholder="Mot de passe"></div>
                            <div class="mb-3">
                                <button class="btn btn-primary btn-sm shadow d-block w-100" type="submit" name="submit">
                                    Connectez-vous !&nbsp;
                                </button>
                            </div>
                            <p class="text-muted">Vous avez pas de compte?&nbsp;<a
                                        href="inscription.php">Inscription</a>

                                        
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- Bouton qui lance la fonction showForm lorsqu'il est cliqué -->
<button onclick="showForm()">Inscription</button>

<!-- Formulaire d'inscription qui sera affiché lorsque la fonction showForm est appelée -->
<form action="inscription.php" method="post" id="form-inscription" style="display:none;">
                            <?php
                            if($err!=null)
                            {

                                switch($err)
                                {
                                    case 'pasMajeur':
                                        ?>
                                        <div class="alert alert-danger  ">
                                            <strong>Erreur ! </strong> vous devez être majeur pour vous inscrire.
                                        </div>
                                        <?php
                                        break;
                                        ?>

                                    <?php
                                    case 'emailTropLong':
                                        ?>

                                        <div class="alert alert-danger">
                                            <strong>Erreur ! </strong> l'email est trop long.
                                        </div>

                                        <?php
                                        break;
                                    case 'emailExistant':
                                        ?>
                                        <div class="alert alert-danger">
                                            <strong>Erreur ! </strong> l'email est déjà existant.
                                        </div>
                                        <?php
                                        break;

                                    case 'reussi':
                                        ?>
                                        <div class="alert alert-success">
                                            <strong>Succès ! </strong> vous êtes inscrit !
                                        </div>
                                        <?php
                                        break;
                                    case 'mdpPasPareil':
                                        ?>
                                        <div class="alert alert-danger">
                                            <strong>Erreur ! </strong> les deux mots de passe ne correspondent pas !
                                        </div>
                                        <?php
                                        break;
                                    case 'champVide':
                                        ?>
                                        <div class="alert alert-danger">
                                            <strong>Erreur ! </strong> veuillez remplir tout les champs.
                                        </div>
                                    <?php
                                }
                            }
                            ?>

                            <div class="row justify-content-center">
                                <div class="col-md-7 col-xl-6">

                                    <div class="mb-2">
                                        <label>Nom</label>
                                        <input class="form-control form-control-sm" type="text"  name="nom"
                                               value="<?php if (isset($nom)) {
                                                   echo $nom;
                                               } ?>">
                                    </div>
                                </div>
                                <div class="col-md-7 col-xl-6">
                                    <div class="mb-2">
                                        <label>Prenom</label>
                                        <input class="form-control form-control-sm" type="text"  name="prenom"
                                               value="<?php if (isset($prenom)) {
                                                   echo $prenom;
                                               } ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label>Email</label>
                                <input class="form-control form-control-sm" type="email"
                                       name="email" value="<?php if (isset($email)) {
                                    echo $email;
                                } ?>">
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-7 col-xl-6">
                                    <div class="mb-2">
                                        <label>Mot de passe</label>
                                        <input class="form-control form-control-sm" type="password"
                                               name="password1" value="<?php if (isset($mdp1)) {
                                            echo $mdp1;
                                        } ?>"></div>
                                </div>
                                <div class="col-md-7 col-xl-6">
                                    <div class="mb-2" >
                                        <label>Confirmer le mot de passe</label>
                                        <input class="form-control form-control-sm" type="password"
                                               name="password2" value="<?php if (isset($mdp2)) {
                                            echo $mdp2;
                                        } ?>"></div>
                                </div>

                                <div class="mb-2">
                                    <label>Date de naissance</label>
                                    <input class="form-control form-control-sm" name="dateNaissance"
                                           value="<?php if (isset($dateNaissance)) {
                                               echo $dateNaissance;
                                           } ?>" type="date"></div>
                                <div class="mb-2">
                                    <label>Rue</label>
                                    <input class="form-control form-control-sm" type="text" name="rue"
                                           value="<?php if (isset($rue)) {
                                               echo $rue;
                                           } ?>"></div>


                                <div class="col-md-7 col-xl-6">
                                    <div class="mb-2">
                                        <label>NPA</label>
                                        <input class="form-control form-control-sm" type="number"
                                               name="npa" value="<?php if (isset($npa)) {
                                            echo $npa;
                                        } ?>"></div>
                                </div>
                                <div class="col-md-7 col-xl-6">
                                    <div class="mb-2">
                                        <label>Localité</label>
                                        <input class="form-control form-control-sm" type="text"
                                               name="localite" value="<?php if (isset($localite)) {
                                            echo $localite;
                                        } ?>"></div>
                                </div>

                                <div class="mb-2">
                                    <label>Pays</label>
                                    <select class="form-control form-control-sm"  name="pays"
                                            value="<?php if (isset($pays)) {
                                                echo $pays;
                                            } ?>">
                                        <?php
                                        afficherPays();
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <p></p>
                                    <button class="btn btn-primary btn-sm shadow d-block w-100" type="submit" name="submit">
                                        Inscrivez-vous
                                    </button>
                                </div>
                                
                        </form>

                        <button id="btn-close">Fermer le formulaire</button>
<!-- Fonction JavaScript qui permet d'afficher le formulaire lorsqu'elle est appelée -->
<script>
  function showForm() {
  var form = document.getElementById("form-inscription");
  form.style.display = "block";

  var form = document.getElementById("form-inscription");

// Création de la div
var divNode = document.createElement("div");
divNode.id="text"

// Mise en place du texte
var textNode = document.createTextNode("Nous espérons satisfaire à vos demandes");

// Ajout du noeud de texte au noeud div
divNode.appendChild(textNode);

// Mise en place d'un style
divNode.style.padding = "10px";
divNode.style.fontWeight = "bold";

// Placement de la div avant le formulaire
form.parentNode.insertBefore(divNode, form);

    // Ajout d'un événement click sur le bouton de fermeture du formulaire
    
    
  }
  // Fonction pour fermer le formulaire d'inscription
  function hideForm() {
    var form = document.getElementById("form-inscription");
    form.style.display = "none";
    
    var divNode = document.getElementById("text");
    divNode.parentNode.removeChild(divNode)
}

    // Ajout d'un événement click sur le bouton de fermeture du formulaire
    var btnClose = document.getElementById("btn-close");
    btnClose.addEventListener("click", hideForm);
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
                    <li><a href="#">Email : info@pneu-trott.com</a></li>
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