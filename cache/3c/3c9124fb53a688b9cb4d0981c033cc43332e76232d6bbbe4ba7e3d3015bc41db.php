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

/* invalid.twig */
class __TwigTemplate_9345e570fce20840626f09950046bf5d8779d5d1d7387255a890d07b14526ae9 extends Template
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
        echo "<!doctype>
<html>

<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Pikasso | Error</title>
    <link href=\"templates/css/bootstrap.min.css\" rel=\"stylesheet\">
    <!-- <script src=\"templates/js/bootstrap.bundle.min.js\"></script> -->
    <!-- <script src=\"templates/js/vue.min.js\"></script> -->
</head>

<body>
    ";
        // line 14
        echo twig_include($this->env, $context, "header.twig", array(), true, false, true);
        echo "
    <div class=\"container text-center\">
        <h4>";
        // line 16
        echo twig_escape_filter($this->env, ($context["error"] ?? null), "html", null, true);
        echo "</h4>
        <a href=\"index.php\">Home</a>
    </div>
</body>

</html>";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "invalid.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  57 => 16,  52 => 14,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "invalid.twig", "/var/www/html/pikasso/templates/invalid.twig");
    }
}
