<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traitement contact</title>
</head>

<body>
    <?php
    require_once("php/fonction.php");
    //attribution des variables:
    $emailExpediteur = $_POST['email'];
    $message = $_POST['message'];
    $destinataire = "ahmed.bnbds@eduge.ch";
    $objet = "Demande depuis le formulaire de contact";
	$expediteur = "From: $emailExpediteur";
    //verification si les formulaires ont été remplis
    if (!empty($emailExpediteur)) {
        if (!empty($message)) {
		  if (isset($_POST['submit'])) { //inspiration du code : https://artisansweb.net/a-guide-on-hcaptcha-integration-with-php/
                $data = array(
                    'secret' => "0x6FB5Bc8bf9400a3477D73aDb19dE350f81faA04f",
                    'response' => $_POST['h-captcha-response']
                );
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://hcaptcha.com/siteverify");
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $responseData = json_decode($response);
                if ($responseData->success) {
                    // proceed the form
                    mail($destinataire, $objet, $message, $expediteur);
                    header('Location:contacts.php?reg_err=success');
				}else{
				  header('Location:contacts.php?reg_err=captchaNonRemplis');
				  die();}
            } else {
                header('Location:contacts.php?reg_err=captchaNonRemplis');
                die();
            }
        } else {
            header('Location:contacts.php?reg_err=messageNonRemplis');
            die();
        }
    } else {
        header('Location:contacts.php?reg_err=emailNonRemplis');
        die();
    }
    ?>
</body>

</html>