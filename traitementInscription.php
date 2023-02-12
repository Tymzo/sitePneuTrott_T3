<?php
header('Content-Type: application/json');
require_once('php/fonction.php');
$bdd = getConnexion();

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$dateNaissance = $_POST['dateNaissance'];
$rue = $_POST['rue'];
$npa = $_POST['npa'];
$localite = $_POST['localite'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$pays = $_POST['pays'];

//Validation des données
if(empty($nom) || empty($prenom) || empty($email) || empty($dateNaissance) || empty($rue) || empty($npa) || empty($localite) || empty($password1) || empty($password2) || empty($pays)){
    $response = array(
        'success' => false,
        'message' => 'Tous les champs sont obligatoires'
    );
    echo json_encode($response);
    exit();
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $response = array(
        'success' => false,
        'message' => 'Email non valide'
    );
    echo json_encode($response);
    exit();
}

// Hash le mot de passe avec Bcrypt, via un coût de 12
$cost = ['cost' => 12];
$mdpSecure = password_hash($password1, PASSWORD_BCRYPT, $cost);

// Ajout de l'adresse dans la base de données et récupération de l'ID
$idAdresse = idAdresse($rue, $npa, $localite, $pays);

// Ajout de l'utilisateur dans la base de données
$query = $bdd->prepare("INSERT INTO personne (per_nom, per_prenom, per_email, per_dateNaissance, adr_domicile, per_mdp) VALUES (:nom, :prenom, :email, :dateNaissance, :idAdresse, :password)");
$query->bindParam(':nom', $nom);
$query->bindParam(':prenom', $prenom);
$query->bindParam(':email', $email);
$query->bindParam(':dateNaissance', $dateNaissance);
$query->bindParam(':idAdresse', $idAdresse);
$query->bindParam(':password', $mdpSecure);

if($query->execute()) {
$response = array(
'success' => true,
'message' => 'Inscription réussie'
);
  echo json_encode($response);
} else {
$response = array(
'success' => false,
'message' => "Une erreur est survenue lors de l'inscription"
);
  echo json_encode($response);
}

header("Location:inscription.php?success");

?>