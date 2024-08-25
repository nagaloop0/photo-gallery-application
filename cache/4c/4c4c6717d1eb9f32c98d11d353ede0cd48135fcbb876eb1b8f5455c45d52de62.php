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

/* register.twig */
class __TwigTemplate_3d0521322c94208fb6574ed9cfd46768ac00f26310a62bec395b6a7f23b7ceb5 extends Template
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
        echo "<!DOCTYPE html>
<html>

<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Pikasso - Register</title>
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
            <form action=\"index.php\" method=\"POST\">
                <input type=\"hidden\" name=\"action\" value=\"register\"/>
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
                <div class=\"form-group m-2 mt-4\">
                    <label for=\"password\" style=\"color: gray;\">Confirm Password</label>
                    <input type=\"password\" class=\"form-control\" id=\"confirm_password\" placeholder=\"Re-enter Password\" name=\"confirmpassword\"
                        required>
                </div>
                <div class=\"m-2 mt-4 text-danger\">
                    ";
        // line 39
        if (($context["error"] ?? null)) {
            echo " ";
            echo twig_escape_filter($this->env, ($context["error"] ?? null), "html", null, true);
            echo " ";
        }
        // line 40
        echo "                </div>  
                <div class=\"m-2 mt-4\">
                    <input type=\"submit\" class=\"btn btn-primary\" value=\"Create\"/>
                </div>
            </form>
            <div class=\"text-center mt-3\">
                <label>&copy; Kaushik Gallery</label>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', ()=>{
            document.getElementById(\"confirm_password\").addEventListener(\"focusout\", (e)=>{
                var actualPassword = document.getElementById(\"password\");
                var confirmPassword = e.currentTarget.value; 
                console.log(actualPassword, confirmPassword)
                if(actualPassword && actualPassword.value){
                    if(actualPassword.value !== confirmPassword){
                        alert(\"Password Mismatch\");
                        actualPassword.value = \"\";
                        e.currentTarget.value = \"\";
                    }
                }else{
                    alert(\"Enter Password\");
                }
            });
        });
    </script>
</body>

</html>";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "register.twig";
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
        return array (  83 => 40,  77 => 39,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "register.twig", "/var/www/html/pikasso/templates/register.twig");
    }
}
