<?php

/* namespace.twig */
class __TwigTemplate_4b1f95a08c31fad65252aaf800867d0888165caec69e960fda3476315e4ee9c8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout/layout.twig", "namespace.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body_class' => array($this, 'block_body_class'),
            'page_id' => array($this, 'block_page_id'),
            'below_menu' => array($this, 'block_below_menu'),
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
        $context["__internal_4f7f3f08efd8ab83f6c0d8d8b218cf192893ddc4b160548fba7af622a8252302"] = $this->loadTemplate("macros.twig", "namespace.twig", 2);
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, (isset($context["namespace"]) ? $context["namespace"] : $this->getContext($context, "namespace")), "html", null, true);
        echo " | ";
        $this->displayParentBlock("title", $context, $blocks);
    }

    // line 4
    public function block_body_class($context, array $blocks = array())
    {
        echo "namespace";
    }

    // line 5
    public function block_page_id($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, ("namespace:" . strtr((isset($context["namespace"]) ? $context["namespace"] : $this->getContext($context, "namespace")), array("\\" => "_"))), "html", null, true);
    }

    // line 7
    public function block_below_menu($context, array $blocks = array())
    {
        // line 8
        echo "    <div class=\"namespace-breadcrumbs\">
        <ol class=\"breadcrumb\">
            <li><span class=\"label label-default\">Namespace</span></li>
            ";
        // line 11
        echo $context["__internal_4f7f3f08efd8ab83f6c0d8d8b218cf192893ddc4b160548fba7af622a8252302"]->getbreadcrumbs((isset($context["namespace"]) ? $context["namespace"] : $this->getContext($context, "namespace")));
        echo "
        </ol>
    </div>
";
    }

    // line 16
    public function block_page_content($context, array $blocks = array())
    {
        // line 17
        echo "
    <div class=\"page-header\">
        <h1>";
        // line 19
        echo twig_escape_filter($this->env, (isset($context["namespace"]) ? $context["namespace"] : $this->getContext($context, "namespace")), "html", null, true);
        echo "</h1>
    </div>

    ";
        // line 22
        if ((isset($context["subnamespaces"]) ? $context["subnamespaces"] : $this->getContext($context, "subnamespaces"))) {
            // line 23
            echo "        <h2>Namespaces</h2>
        <div class=\"namespace-list\">
            ";
            // line 25
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["subnamespaces"]) ? $context["subnamespaces"] : $this->getContext($context, "subnamespaces")));
            foreach ($context['_seq'] as $context["_key"] => $context["ns"]) {
                echo $context["__internal_4f7f3f08efd8ab83f6c0d8d8b218cf192893ddc4b160548fba7af622a8252302"]->getnamespace_link($context["ns"]);
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ns'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 26
            echo "        </div>
    ";
        }
        // line 28
        echo "
    ";
        // line 29
        if ((isset($context["classes"]) ? $context["classes"] : $this->getContext($context, "classes"))) {
            // line 30
            echo "        <h2>Classes</h2>
        ";
            // line 31
            echo $context["__internal_4f7f3f08efd8ab83f6c0d8d8b218cf192893ddc4b160548fba7af622a8252302"]->getrender_classes((isset($context["classes"]) ? $context["classes"] : $this->getContext($context, "classes")));
            echo "
    ";
        }
        // line 33
        echo "
    ";
        // line 34
        if ((isset($context["interfaces"]) ? $context["interfaces"] : $this->getContext($context, "interfaces"))) {
            // line 35
            echo "        <h2>Interfaces</h2>
        ";
            // line 36
            echo $context["__internal_4f7f3f08efd8ab83f6c0d8d8b218cf192893ddc4b160548fba7af622a8252302"]->getrender_classes((isset($context["interfaces"]) ? $context["interfaces"] : $this->getContext($context, "interfaces")));
            echo "
    ";
        }
        // line 38
        echo "
    ";
        // line 39
        if ((isset($context["exceptions"]) ? $context["exceptions"] : $this->getContext($context, "exceptions"))) {
            // line 40
            echo "        <h2>Exceptions</h2>
        ";
            // line 41
            echo $context["__internal_4f7f3f08efd8ab83f6c0d8d8b218cf192893ddc4b160548fba7af622a8252302"]->getrender_classes((isset($context["exceptions"]) ? $context["exceptions"] : $this->getContext($context, "exceptions")));
            echo "
    ";
        }
        // line 43
        echo "
";
    }

    public function getTemplateName()
    {
        return "namespace.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  142 => 43,  137 => 41,  134 => 40,  132 => 39,  129 => 38,  124 => 36,  121 => 35,  119 => 34,  116 => 33,  111 => 31,  108 => 30,  106 => 29,  103 => 28,  99 => 26,  90 => 25,  86 => 23,  84 => 22,  78 => 19,  74 => 17,  71 => 16,  63 => 11,  58 => 8,  55 => 7,  49 => 5,  43 => 4,  35 => 3,  31 => 1,  29 => 2,  11 => 1,);
    }
}
