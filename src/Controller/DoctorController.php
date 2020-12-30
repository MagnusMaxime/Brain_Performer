<?php

namespace App\Controller;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use App\Model\User;

class DoctorController extends Controller
{

    static public function sendToken(){
        global $twig;
        if (self::needToBeDoctor()){
            return "";
        }
        $twig_array=["title"=>"Envoyer un lien"];
        if (!isset($_POST["mail"])) {
            return $twig->render('doctor/sendToken.html', $twig_array);
        }
        if (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)){
            $twig_array["alert"]='"'.$_POST["mail"].'" '." n'est pas une adresse mail valide.";
            return $twig->render('doctor/sendToken.html', $twig_array);
        }
        if ((!isset($_SESSION['token']) or $_SESSION['token']=="")){
            //le token du médecin est étrange
            $twig_array["alert"] = "Vous n'avez pas de jeton médecin. Contactez un administrateur.";
            return $twig->render('doctor/sendToken.html', $twig_array);
        }

        echo "<!--";
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Enable verbose debug output
            $mail->isSMTP();     // Send using SMTP
            $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth   = true;   // Enable SMTP authentication
            $mail->Username   = MAIL;     // SMTP username
            $mail->Password   = MAIL_PASSWORD;  // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;   // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            // From email address and name
            $mail->setFrom(MAIL, $_SESSION['firstname']." ".strtoupper($_SESSION['lastname']));
            // To email addresss
            $mail->addAddress($_POST["mail"]);   // Add a recipient
            //$mail->addReplyTo('reply@example.com', 'Reply'); // Recipent reply address
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            // Content
            $mail->isHTML(false);  // Set email format to HTML
            $mail->Subject = "Votre lien d'inscription BrainPerformer";
            $mail->Body    = "Bonjour,\nVoici votre lien d'inscription sur la plateforme BrainPerfomer :\nhttp://www.healing-path.fr/inscription?token=".urlencode($_SESSION['token'])."\nVotre docteur sera ".$_SESSION['firstname']." ".strtoupper($_SESSION['lastname']).".\nCordialement,\nBrain Performer.";
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send();
            echo "-->";
            $twig_array["danger"]="Le mail a bien été envoyé à ".'"'.$_POST["mail"].'"';
            return $twig->render('doctor/sendToken.html', $twig_array);

        } catch (Exception $e) {
            echo "-->";
            $twig_array["danger"]="Erreur dans l'envoi du mail ".$mail->ErrorInfo.".";
            return $twig->render('doctor/sendToken.html', $twig_array);
        }
    }

		/*
		 * Affiche la liste des patients d'un médecin.
		 */
		public function patients() {
        global $twig;
        if (self::needToBeDoctor()){
            return "";
        }
				error_log('token');
				error_log(strval($_SESSION['token']));
				$context = User::filter(['grade' => 0, 'token' => $_SESSION['token']]);
				if (empty($context)) {
					$context["info"] = "Vous n'avez aucun patient.";
				}
				return $twig->render('doctor/patients.html', $context);
		}
}

