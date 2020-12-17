<?php


namespace App\Controller;


use App\Model\Ticket;

class ContactController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('contact.html', ["title"=>"Contact","mail"=>CONTACT_MAIL]);
    }

    static public function send(){
        global $twig;
        //todo if faut vérif si le type est co
        if (!Controller::checkRecaptcha($_POST["g-recaptcha-response"])){
            //Le Recaptcha n'a pas été validé, c'est un bot
            return $twig->render('contact.html', ["title"=>"Contact","mail"=>CONTACT_MAIL, "alert"=>"reCAPTCHA non validé"]);
        }

        $message=$_POST["message"];

        if (strlen($message)>=5){
            //le message est assez long, on le rentre dans la BDD
            $result = Ticket::postTicket(0, $message);//todo ne pas mettre 0 mais l'id du user co
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
