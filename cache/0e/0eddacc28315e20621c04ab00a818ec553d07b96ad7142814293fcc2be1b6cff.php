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

/* login.twig */
class __TwigTemplate_790fd48b4ba6ccee8323d97212932744f1214f3f1f630b0a977855853b4b3ea1 extends Template
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
    <title>Pikasso</title>
    <link href=\"templates/css/bootstrap.min.css\" rel=\"stylesheet\">
    <script src=\"templates/js/bootstrap.bundle.min.js\"></script>
    <link rel=\"stylesheet\" href=\"templates/css/style.css\">
</head>

<body>
    <div class=\"d-flex h-100\">
        <div class=\"login-cover\">
        </div>
        <div class=\"mx-3 bg-white p-2 mt-2\" style=\"width: 40%;\" >
            <div class=\"d-flex justify-content-center w-100\">
                <a class=\"navbar-brand\" href=\"index.php\"><img src=\"templates/images/kaushik-logo.png\" alt=\"kaushik-logo\" width=\"200\"/></a>
            </div>
            <form action=\"index.php\" method=\"GET\">
                <input type=\"hidden\" name=\"action\" value=\"authenticate\"/>
                <div class=\"form-group m-2 mt-4\">
                    <label for=\"username\" style=\"color: gray\">Username or email</label>
                    <input type=\"text\" class=\"form-control\" id=\"username\" placeholder=\"Enter Username\" name=\"username\"
                        required>
                </div>
                <div class=\"form-group m-2 mt-4\">
                    <label for=\"password\" style=\"color: gray;\">Password</label>
                    <input type=\"password\" class=\"form-control\" id=\"password\" placeholder=\"Enter Password\" name=\"password\"
                        required>
                </div>
                <div class=\"checkbox m-2 mt-4\">
                    <label style=\"color: gray\"><input type=\"checkbox\" checked=\"checked\"> Remember me</label>
                </div>
                <div class=\"checkbox m-2 mt-4\">
                    <label class=\"text-danger\">";
        // line 37
        if (($context["error"] ?? null)) {
            echo " ";
            echo twig_escape_filter($this->env, ($context["error"] ?? null), "html", null, true);
            echo " ";
        }
        echo " </label>
                </div>
                <div class=\"m-2\">
                    <input type=\"submit\" class=\"btn btn-primary\" />
                </div>
            </form>
            <div class=\"text-center m-2\">
                <span class=\"text-muted\">Are you new?</span><a class=\"mx-1\" href=\"index.php?action=register\">Create Account</a>
            </div>
            <div class=\"text-center mt-3\">
                <label>&copy; Kaushik Gallery</label>
            </div>
        </div>
    </div>
</body>

</html>";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "login.twig";
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
        return array (  75 => 37,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "login.twig", "/var/www/html/pikasso/templates/login.twig");
    }
}
