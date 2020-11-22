<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* header.html */
class __TwigTemplate_4d7f4667f61caa75852d86010eaabd640e4f215cfde2850f461b2f13066f1a89 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!doctype html>
<html class=\"no-js\" lang=\"\">
<head>

    <meta charset=\"utf-8\">
    <title>Brain Performer</title>
    <meta name=\"description\" content=\"\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">

    <meta property=\"og:title\" content=\"\">
    <meta property=\"og:type\" content=\"\">
    <meta property=\"og:url\" content=\"\">
    <meta property=\"og:image\" content=\"\">

    <link rel=\"manifest\" href=\"site.webmanifest\">
    <link rel=\"apple-touch-icon\" href=\"icon.png\">

    <link rel=\"stylesheet\" href=\"css/normalize.css\">
    <link rel=\"stylesheet\" href=\"css/main.css\">

    <meta name=\"theme-color\" content=\"#fafafa\">
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js\"></script>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/stylesheets/main.css\" />

</head>

<header class=\"header\">
    <a href=\"\">
        <img src=\"\" alt=\"Logo Brain Performer\" title=\"Brain Performer\">
    </a>
    <div class=\"header-right\">
        <a href=\"\">Accueil</a>
        <a href=\"\"></a>
    </div>
</header>

";
    }

    public function getTemplateName()
    {
        return "header.html";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "header.html", "/Users/marcpartensky/Programs/BrainPerformer/src/views/header.html");
    }
}
