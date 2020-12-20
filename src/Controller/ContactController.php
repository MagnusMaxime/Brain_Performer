<?php


namespace App\Controller;


use App\Model\Ticket;

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
