<?php

/* traits.twig */
class __TwigTemplate_67f63d695195d455f47e1599ae99e9c64b6fc52ba580b1c9c92cbd9bea466367 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout/layout.twig", "traits.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body_class' => array($this, 'block_body_class'),
            'page_content' => array($this, 'block_page_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout/layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        $context["__internal_94b8e4f529360a9ab9970d994e69a85f173a5efd5bf58540c372d9e0ecee32ea"] = $this->loadTemplate("macros.twig", "traits.twig", 2);
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "Traits | ";
        $this->displayParentBlock("title", $context, $blocks);
    }

    // line 4
    public function block_body_class($context, array $blocks = array())
    {
        echo "traits";
    }

    // line 6
    public function block_page_content($context, array $blocks = array())
    {
        // line 7
        echo "    <div class=\"page-header\">
        <h1>Traits</h1>
    </div>

    <div class=\"container-fluid underlined\">
        ";
        // line 12
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["classes"]) ? $context["classes"] : $this->getContext($context, "classes")));
        foreach ($context['_seq'] as $context["_key"] => $context["class"]) {
            // line 13
            echo "            ";
            if ($this->getAttribute($context["class"], "trait", array())) {
                // line 14
                echo "                <div class=\"row\">
                    <div class=\"col-md-6\">
                        ";
                // line 16
                echo $context["__internal_94b8e4f529360a9ab9970d994e69a85f173a5efd5bf58540c372d9e0ecee32ea"]->getclass_link($context["class"], true);
                echo "
                    </div>
                    <div class=\"col-md-6\">
                        ";
                // line 19
                echo $this->env->getExtension('sami')->parseDesc($context, $this->getAttribute($context["class"], "shortdesc", array()), $context["class"]);
                echo "
                    </div>
                </div>
            ";
            }
            // line 23
            echo "        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['class'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 24
        echo "    </div>
";
    }

    public function getTemplateName()
    {
        return "traits.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  86 => 24,  80 => 23,  73 => 19,  67 => 16,  63 => 14,  60 => 13,  56 => 12,  49 => 7,  46 => 6,  40 => 4,  33 => 3,  29 => 1,  27 => 2,  11 => 1,);
    }
}
