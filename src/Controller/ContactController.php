<?php


namespace App\Controller;


use App\Model\Ticket;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Except;
//https://accounts.google.com/DisplayUnlockCaptcha

class ContactController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('contact.html', ["title"=>"Contact","mail"=>CONTACT_MAIL]);
    }

    static public function sendMail(){
        global $twig;
        if (!Controller::checkRecaptcha($_POST["g-recaptcha-response"])){
            //Le Recaptcha n'a pas été validé, c'est un bot
            return $twig->render('contact.html', ["title"=>"Contact","mail"=>CONTACT_MAIL, "alert"=>"reCAPTCHA non validé"]);
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
            $mail->setFrom(MAIL, $_POST["name-mail"]);
            // To email addresss
            $mail->addAddress(MAIL);   // Add a recipient
            //$mail->addReplyTo('reply@example.com', 'Reply'); // Recipent reply address
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            // Content
            $mail->isHTML(false);  // Set email format to HTML
            $mail->Subject = '[Formulaire contact]'.$_POST["topic-message"];
            $mail->Body    = $_POST["message-mail"];
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send();
            echo "-->";
            return $twig->render('message.html', ["title"=>"Mail envoyé","message"=>"Le mail a été envoyé à ".CONTACT_MAIL]);

        } catch (Exception $e) {
            echo "-->";
            return $twig->render('contact.html', ["title"=>"Contact","mail"=>CONTACT_MAIL, "alert"=>"Erreur dans l'envoi du mail ".$mail->ErrorInfo]);

        }


    }

    static public function post(){
        //l'utilisateur a rempli un des deux formulaire
        if ($_POST["message-mail"]!=""){
            //l'utilisateur a rempli le formualire pour un mail
            return self::sendMail();
        }
        //l'utilisateur a rempli le formulaire de messagerie interne
        return self::send();
    }

    static public function send(){
        global $twig;

        if (!isset($_SESSION['id'])){
            //l'utilisateur est pas connecté et a besoin d'être connecté
            return $twig->render('contact.html', ["title"=>"Contact","mail"=>CONTACT_MAIL, "alert"=>"Vous devez être connecté pour utiliser la messagerie interne"]);
        }

        $message=$_POST["message"];

        if (strlen($message)>=5){
            //le message est assez long, on le rentre dans la BDD
            $result = Ticket::postTicket($_SESSION['id'], $message);
            if ($result){
                //le ticket a été posté
                return $twig->render('message.html', ["title"=>"Ticket envoyé","message"=>"Votre ticket a été envoyé :)"]);
            }else{
                //le ticket n'a pas été posté
                return $twig->render('contact.html', ["title"=>"Contact","mail"=>CONTACT_MAIL, "alert"=>"Erreur dans l'envoi de votre ticket :("]);
            }
        }

        //le message posté est trop court, on réaffiche le formulaire de contact

        return $twig->render('contact.html', ["title"=>"Contact","mail"=>CONTACT_MAIL, "alert"=>"Votre message est trop court, expliquez davantage votre problème"]);
    }
}
