<?php


namespace App\Controller;

use App\model\Sent;


class SentController extends Controller
{
    public static function verification() {
        global $twig;
            if (strlen($_POST['recipient'])<1)
            {
                return $twig->render('contact.html', ["title"=>"Contact", "alert"=>"Veuillez remplir ce champ."]);
            }
            $query = mysql_query("SELECT id FROM message WHERE recipient = '$_recipient'");
            if (mysql_num_rows($query) == 0);
            {
               return $twig->render('contact.html', ["title"=>"Contact", "alert"=>"cette utilisateur n'existe pas."]);
            }

    }


}
?>