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

/* header.twig */
class __TwigTemplate_73634815f3f853f726fef512fb666d875a33f9d4734d9619a7a1cbbdfebf8b91 extends Template
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
        echo "<div class=\"\">
    <nav class=\"navbar navbar-expand-lg navbar-light bg-white\">
        <div class=\"container-fluid\">
            <div class=\"d-flex justify-content-center w-100\">
                <a class=\"navbar-brand\" href=\"index.php\"><img src=\"templates/images/kaushik-logo.png\" alt=\"kaushik-logo\" width=\"200\" /></a>
            </div>
        </div>
    </nav>
    <div class=\"container-fluid\">
        <div class=\"text-center\">
            ";
        // line 11
        if (twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "username", [], "any", false, false, false, 11)) {
            // line 12
            echo "                <h3>Latest Images</h3>
                <p>Every child is an artist. The problem is how to remain an artist once we grow up.</p>
                <span class=\"text-muted mx-2\">";
            // line 14
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "username", [], "any", false, false, false, 14), "html", null, true);
            echo "</span><a href=\"index.php?action=logout\">Logout</a>
            ";
        }
        // line 16
        echo "        </div>
    </div>
</div>
";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "header.twig";
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
        return array (  60 => 16,  55 => 14,  51 => 12,  49 => 11,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "header.twig", "/var/www/html/pikasso/templates/header.twig");
    }
}
