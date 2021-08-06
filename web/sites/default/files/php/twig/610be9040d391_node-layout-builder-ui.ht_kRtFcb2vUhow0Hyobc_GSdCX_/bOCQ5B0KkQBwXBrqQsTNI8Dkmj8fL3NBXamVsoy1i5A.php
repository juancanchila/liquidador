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

/* modules/contrib/node_layout_builder/templates/node-layout-builder-ui.html.twig */
class __TwigTemplate_21a1aaf2cb9e31164c2c0ca106ff2169cb47ab3be2b3188f1dedbe6ebc9f9052 extends \Twig\Template
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
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<div class=\"nlb-wrapper\">
  ";
        // line 2
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(($context["data"] ?? null), 2, $this->source));
        echo "

  ";
        // line 4
        if ((($context["editable"] ?? null) == 1)) {
            // line 5
            echo "    <div class=\"add-templates\">
      ";
            // line 6
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["link_add_template"] ?? null), 6, $this->source), "html", null, true);
            echo "
    </div>

    <div class=\"nlb-save-wrapper\">
      ";
            // line 10
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["btn_add_section"] ?? null), 10, $this->source), "html", null, true);
            echo "
      <a href=\"#\" class=\"btn-save-data btn btn-primary nlb-save-data\" title=\"";
            // line 11
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Save Layout"));
            echo "\">
        <i class=\"fas fa-save\"></i>
      </a>
    </div>
  ";
        }
        // line 16
        echo "
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/contrib/node_layout_builder/templates/node-layout-builder-ui.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  71 => 16,  63 => 11,  59 => 10,  52 => 6,  49 => 5,  47 => 4,  42 => 2,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/node_layout_builder/templates/node-layout-builder-ui.html.twig", "C:\\xampp\\htdocs\\EPA\\Liquidador\\web\\modules\\contrib\\node_layout_builder\\templates\\node-layout-builder-ui.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 4);
        static $filters = array("raw" => 2, "escape" => 6, "t" => 11);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['raw', 'escape', 't'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
