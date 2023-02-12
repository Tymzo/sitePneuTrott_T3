<?php

session_start();

const DB_HOST = "hhva.myd.infomaniak.com";
const DB_NAME = "hhva_t23_3_v21";
const DB_USER = "hhva_t23_3_v21";
const DB_PASS = "0QB1RAWn5L";

//Connexion à la base de données
function getConnexion()
{
    static $dbb = null;
    if ($dbb === null) {
        try {
            $connectionString = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '';
            $dbb = new PDO($connectionString, DB_USER, DB_PASS);
            $dbb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbb->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    return $dbb;
}




//Recupère le dernier ID insert pour l'adresse
function idAdresse($rue, $npa, $localite, $pays)
{
    try {
        $request = getConnexion()->prepare("INSERT INTO `adresse` (ADR_NPA, ADR_LOCALITE, ADR_PAYS, ADR_RUE) VALUES (:npa, :localite, :pays, :rue)");
        $request->bindParam(':rue', $rue);
        $request->bindParam(':npa', $npa);
        $request->bindParam(':localite', $localite);
        $request->bindParam(':pays', $pays);
        $request->execute();

        return  getConnexion()->lastInsertId();
    } catch (PDOException $e) {
        throw $e;
    }
}


//Permet d'inscire la personne sur le site
function register($idAdresse, $nom, $prenom, $email, $dateNaissance, $mdpSecure)
{
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("INSERT INTO `personne` (ADR_DOMICILE,PER_NOM,PER_PRENOM,PER_EMAIL,PER_TYPE,PER_DATENAISSANCE,PER_MDP,PER_NOAVS) VALUES (:idAdresse, :nom, :prenom, :email, '0', :dateNaissance, :mdp, NULL)");
        $request->bindParam(':idAdresse', $idAdresse);
        $request->bindParam(':nom', $nom);
        $request->bindParam(':prenom', $prenom);
        $request->bindParam(':email', $email);
        $request->bindParam(':dateNaissance', $dateNaissance);
        $request->bindParam(':mdp', $mdpSecure);

        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}


// vérifie dans la bdd si l'email est déjà existant
function checkEmail($email)
{
    try {
        $request = getConnexion()->prepare("SELECT * from `personne` WHERE `PER_EMAIL` = :email");
        $request->bindParam(':email', $email);
        $request->execute();

        return $request->fetch();
    } catch (PDOException $e) {
        throw $e;
    }
}

// verifie que le user a 18 ans au moins == fonction de ce site: https://stackoverflow.com/questions/1812589/validate-if-age-is-over-18-years-old
function validateAge($dateNaissance, $age = 18)
{
    // $birthday can be UNIX_TIMESTAMP or just a string-date.
    if (is_string($dateNaissance)) {
        $dateNaissance = strtotime($dateNaissance);
    }

    // check
    // 31536000 is the number of seconds in a 365 days year.
    if (time() - $dateNaissance < $age * 31536000) {
        return false;
    }

    return true;
}

// sort les pays dans l'ordr alpha
function getPays()
{
    try {
        $request = getConnexion()->prepare("SELECT * from `pays` ORDER BY nom_fr_fr ASC");

        $request->execute();

        return $request->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}

function afficherPays()
{
    $data = getPays();
    foreach ($data as $pays) {
        echo "<option value=\"" . $pays["nom_fr_fr"] . "\"> " . $pays["nom_fr_fr"] . "</option>";
    }
}




function getTypePersonne($email)
{
    try {
        $request = getConnexion()->prepare("SELECT `PER_TYPE` FROM `personne` WHERE `PER_EMAIL` = :email");
        $request->bindParam(':email', $email);
        $request->execute();

        return $request->fetch();
    } catch (PDOException $e) {
        throw $e;
    }
}

function getInfoUser($email)
{
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("SELECT * from `personne` WHERE `PER_EMAIL` = :email");
        $request->bindParam(':email', $email, PDO::PARAM_INT);
        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw $e;
    }
}


function getProduit()
{
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("SELECT * from");

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw $e;
    }
}


function validationCaptcha($code, $ip = null) //Je me suis inspiré sur un forum https://openclassrooms.com/forum/sujet/recaptcha-probleme-avec-verification-php
{
    if (empty($code)) {
        return false;
        exit;
    } else {
        $params = [
            'secret'    => '********************3',
            'response'  => $code
        ];
        if ($ip) {
            $params['remoteip'] = $ip;
        }
        $url = "https://www.hCaptcha.com/1/api.js" . http_build_query($params);
        if (function_exists('curl_version')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Evite les problèmes, si le ser
            $response = curl_exec($curl);
        } else {
            // Si curl n'est pas dispo, un bon vieux file_get_contents
            $response = file_get_contents($url);
        }
        if (empty($response) || is_null($response)) {
            return false;
            exit;
        } else {
            $json = json_decode($response);
            return $json->success;
        }
    }
}





//Recupère le dernier ID insert pour l'adresse de livraison
function idAdresseLivraison($rue, $npa, $localite, $pays)
{
    try {
        $request = getConnexion()->prepare("INSERT INTO `adresse` (ADR_NPA, ADR_LOCALITE, ADR_PAYS, ADR_RUE) VALUES (:npa, :localite, :pays, :rue)");
        $request->bindParam(':rue', $rue);
        $request->bindParam(':npa', $npa);
        $request->bindParam(':localite', $localite);
        $request->bindParam(':pays', $pays);
        $request->execute();

        return  getConnexion()->lastInsertId();
    } catch (PDOException $e) {
        throw $e;
    }
}



//Permet d'inscire la personne sur le site
function updateCommande($adresseLivraison)
{
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("UPDATE `commande` SET (ADR_LIVRAISSON, COM_STATUT )VALUES (:adresseLivraison, 'En cours')");
        $request->bindParam(':adresseLivraison', $adresseLivraison);

        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}



//Mise à jour du mdp
function updateMDP($mdpSecure, $idPersonne)
{
    try {
        $request = getConnexion()->prepare("UPDATE personne SET PER_MDP = :mdp where PER_ID = :idPersonne");
        $request->bindParam(':idPersonne', $idPersonne, PDO::PARAM_INT);
        $request->bindParam(':mdp', $mdpSecure,PDO::PARAM_STR);

        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}



//Mise à jour de l'adresse
function updateAdresse($npa,$localite,$pays,$rue,$idDomicile)
{
    try {
        $request = getConnexion()->prepare("UPDATE adresse SET ADR_NPA = :npa, ADR_LOCALITE = :localite, ADR_PAYS = :pays, ADR_RUE = :rue where ADR_ID = :id");
        $request->bindParam(':npa', $npa, PDO::PARAM_INT);
        $request->bindParam(':localite', $localite);
        $request->bindParam(':pays', $pays);
        $request->bindParam(':rue', $rue);
        $request->bindParam(':id', $idDomicile,PDO::PARAM_INT);

        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}


//Mise à jour du statut de la commande
function updateStaut($idCommande)
{
    try {
        $request = getConnexion()->prepare("UPDATE commande SET COM_STATUT = 'Paye' where COM_ID = :id");
        $request->bindParam(':id', $idCommande, PDO::PARAM_INT);

        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}


//Mise à jour du statut de la commande
function updateStock($qte, $idProduit)
{
    try {

        $request = getConnexion()->prepare('UPDATE `produit` SET `PRO_QTESTOCK` = PRO_QTESTOCK - :qte WHERE `produit`.`PRO_ID` = :id ');
        $request->bindParam(':qte', $qte);
        $request->bindParam(':id', $idProduit, PDO::PARAM_INT);

        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}




