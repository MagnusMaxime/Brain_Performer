<?php


namespace App\Controller;


class forumController extends Controller
{
    static public function show()
    {
        global $twig;
        return $twig->render('forum.html', []);
    }

}