<?php
header('Content-Type: application/json');
require_once('php/fonction.php');
$bdd = getConnexion();

if (
    !isset($_POST['nom']) || empty($_POST['nom']) ||
    !isset($_POST['prixUnitaire']) || empty($_POST['prixUnitaire']) ||
    !isset($_POST['qtestock']) || empty($_POST['qtestock']) ||
    !isset($_POST['categorie']) || empty($_POST['categorie']) ||
    !isset($_POST['descriptionProduit']) || empty($_POST['descriptionProduit'])
) {
    $response = array(
        'success' => false,
        'message' => 'Tous les champs sont obligatoires'
    );
    echo json_encode($response);
    exit();
} else {
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $response = array(
                'success' => false,
                'message' => "File is not an image."
            );
            echo json_encode($response);
            exit();
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;

        $response = array(
            'success' => false,
            'message' => 'File already exist'
        );
        echo json_encode($response);
        exit();
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $uploadOk = 0;

        $response = array(
            'success' => false,
            'message' => 'File is too big'
        );
        echo json_encode($response);
        exit();
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {

        $response = array(
            'success' => false,
            'message' => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."
        );
        echo json_encode($response);
        exit();
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {


        $response = array(
            'success' => false,
            'message' => "Sorry, your file was not uploaded."
        );
        echo json_encode($response);
        exit();
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            //echo "L'image". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " a bien été téléchargé.";
            //Quand tout est ok on est ICI!!!!!
            $visible = 1;
            $query = $bdd->prepare ("INSERT INTO produit(CAT_ID, PRO_NOM, PRO_DESC, PRO_PRIXUNITAIRE, PRO_IMAGE,PRO_QTESTOCK,PRO_VISIBLE) VALUES (:catID, :nomProduit, :proDescription, :prixUnitaire, :proImage, :qteStock, :proVisible)");
            $query->bindParam(':catID', $_POST["categorie"]);
            $query->bindParam(':nomProduit',$_POST['nom']);
            $query->bindParam(':proDescription', $_POST['descriptionProduit']);
            $query->bindParam(':prixUnitaire', $_POST['prixUnitaire']);
            $query->bindParam(':proImage', $_FILES['fileToUpload']['name']);
            $query->bindParam(':qteStock', $_POST['qtestock']);
            $query->bindParam(':proVisible', $visible);

            if($query->execute()) {
                $response = array(
                    'success' => true,
                    'message' => 'Produit ajouter'
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'success' => false,
                    'message' => "Une erreur est survenue lors de l'ajout"
                );
                echo json_encode($response);
            }

            header("Location:ajoutProduit.php?success");
        }
    }
}
?>