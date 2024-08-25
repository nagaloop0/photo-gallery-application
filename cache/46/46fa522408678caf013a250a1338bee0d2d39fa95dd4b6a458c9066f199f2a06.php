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

/* home.twig */
class __TwigTemplate_6761a3a5371e243de87ac45a583ef9d6c4781c798424b12594ee40981fe7b3ea extends Template
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
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">

<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Pikasso | Home</title>
    <link href=\"templates/css/bootstrap.min.css\" rel=\"stylesheet\">
    <script src=\"templates/js/bootstrap.bundle.min.js\"></script>
    <script src=\"templates/js/vue.min.js\"></script>
    <script src=\"templates/js/axios.min.js\"></script>
    <link rel=\"stylesheet\" href=\"templates/css/style.css\">
    <link href=\"templates/css/material-you.css\" rel=\"stylesheet\" />
    </head>

<body>
    <div class=\"vue-container container-fluid\" id=\"app\">
        ";
        // line 19
        echo twig_include($this->env, $context, "header.twig");
        echo "
        <div class=\"input-group my-3\">
            <input class=\"form-control\" placeholder=\"Search\" v-model=\"search\" type=\"text\">
            <button class=\"btn btn-secondary\" @click=\"getData()\">Search</span>
        </div>
        <hr />

        <div class=\"m-2\">
            <div v-if=\"journals.length > 0\">
                <div class=\"row\">
                    <div class=\"col-sm-6 col-xs-12 col-md-3 col-lg-2\" v-for=\"(journal, index) in journals\"
                        :key=\"journal.id\">
                        <div class=\"rounded-3 border h-100 d-flex flex-column justify-content-center align-content-center bg-light pointer gallery-card position-relative\"
                            :title=\"journal.title\">
                            <template v-if=\"journal.photos.length > 0\">
                                <!-- <a :href=\"'index.php?action=editview&id='+journal.id\"> -->
                                <img :src=\"journal.photos[0]['photo_name']\" class=\"rounded-3 border\" style=\"object-fit:cover; aspect-ratio: 1/1; border-radius: 0.5rem;margin: 5% 0\"
                                    height=\"100%\" width=\"100%\" />
                                <!-- </a> -->
                            </template>
                            <template v-else>
                                <div class=\"text-center\">";
        // line 40
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["journal"] ?? null), "title", [], "any", false, false, false, 40), "html", null, true);
        echo "</div>
                            </template>
                            <div class=\"bg-warning d-none gallery-card-options position-absolute w-100 p-2\">
                                <button class=\"btn btn-secondary btn-sm\" @click=\"zoomInOut(journal.photos[0]['photo_name'])\"><span class=\"material-symbols-outlined\"> zoom_in </span></button>
                                <button class=\"btn btn-secondary btn-sm\" @click=\"editview(index)\"><span class=\"material-symbols-outlined\">edit</span></button>
                                <button class=\"btn btn-danger btn-sm\" @click=\"deleteGallery(journal.id)\"><span class=\"material-symbols-outlined\">delete</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p v-else>No Gallery available.</p>
        </div>

        <div ref=\"zoomModal\" class=\"zoom-modal\" :class=\"isZoomin ? 'd-flex': ''\">
            <button class=\"btn btn-light close shadow border\" @click=\"zoomInOut('')\"><span class=\"material-symbols-outlined\"> close </span></button>
            <img :src=\"zoomImage\" alt=\"Your Image\" class=\"modal-content\">
        </div>

        <editview v-if=\"showModal\" :data=\"editData\" @close=\"showModal = false\"></editview>

        <p class=\"position-fixed bg-light shadow\" style=\"bottom:1rem; right:1rem; z-index:1000;\">
            <button type=\"button\" class=\"btn btn-primary fs-1 text\" @click=\"editview(-1)\">
                <span class=\"material-symbols-outlined\"> add_circle </span>
            </button>
        </p>
    </div>
    <script src=\"templates/app.js\"></script>
</body>

</html>";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "home.twig";
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
        return array (  81 => 40,  57 => 19,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "home.twig", "/var/www/html/pikasso/templates/home.twig");
    }
}
