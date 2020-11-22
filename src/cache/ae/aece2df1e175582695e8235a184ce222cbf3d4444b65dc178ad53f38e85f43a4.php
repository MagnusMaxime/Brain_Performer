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

/* layout.html */
class __TwigTemplate_989705877f7a16e68601a933d9d1174426da0d227c12d7214ec8644c6e8ed44e extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
  ";
        // line 4
        $this->loadTemplate("header.html", "layout.html", 4)->display($context);
        // line 5
        echo "</head>

<body>
  ";
        // line 8
        $this->loadTemplate("nav.html", "layout.html", 8)->display($context);
        // line 9
        echo "
  ";
        // line 10
        $this->displayBlock('content', $context, $blocks);
        // line 11
        echo "
  ";
        // line 12
        $this->loadTemplate("footer.html", "layout.html", 12)->display($context);
        // line 13
        echo "</body>

</html>
";
    }

    // line 10
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "layout.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  69 => 10,  62 => 13,  60 => 12,  57 => 11,  55 => 10,  52 => 9,  50 => 8,  45 => 5,  43 => 4,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "layout.html", "/Users/marcpartensky/Programs/BrainPerformer/src/views/layout.html");
    }
}
