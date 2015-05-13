<?php

/* opensearch.twig */
class __TwigTemplate_76c4b43862aaf17b789596f34ecde6a42b74aeee979992f5ce2b168b542b023e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        if ($this->getAttribute((isset($context["project"]) ? $context["project"] : $this->getContext($context, "project")), "config", array(0 => "base_url"), "method")) {
            // line 2
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
    <OpenSearchDescription xmlns=\"http://a9.com/-/spec/opensearch/1.1/\" xmlns:referrer=\"http://a9.com/-/opensearch/extensions/referrer/\">
        <ShortName>";
            // line 4
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["project"]) ? $context["project"] : $this->getContext($context, "project")), "config", array(0 => "title"), "method"), "html", null, true);
            echo " (";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["project"]) ? $context["project"] : $this->getContext($context, "project")), "version", array()), "html", null, true);
            echo ")</ShortName>
        <Description>Searches ";
            // line 5
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["project"]) ? $context["project"] : $this->getContext($context, "project")), "config", array(0 => "title"), "method"), "html", null, true);
            echo " (";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["project"]) ? $context["project"] : $this->getContext($context, "project")), "version", array()), "html", null, true);
            echo ")</Description>
        <Tags>";
            // line 6
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["project"]) ? $context["project"] : $this->getContext($context, "project")), "config", array(0 => "title"), "method"), "html", null, true);
            echo "</Tags>
        ";
            // line 7
            if ($this->getAttribute((isset($context["project"]) ? $context["project"] : $this->getContext($context, "project")), "config", array(0 => "favicon"), "method")) {
                // line 8
                echo "<Image height=\"16\" width=\"16\" type=\"image/x-icon\">";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["project"]) ? $context["project"] : $this->getContext($context, "project")), "config", array(0 => "favicon"), "method"), "html", null, true);
                echo "</Image>
        ";
            }
            // line 10
            echo "        <Url type=\"text/html\" method=\"GET\" template=\"";
            echo twig_escape_filter($this->env, (strtr($this->getAttribute((isset($context["project"]) ? $context["project"] : $this->getContext($context, "project")), "config", array(0 => "base_url"), "method"), array("%version%" => $this->getAttribute((isset($context["project"]) ? $context["project"] : $this->getContext($context, "project")), "version", array()))) . "/index.html?q={searchTerms}&src={referrer:source?}"), "html", null, true);
            echo "\"/>
        <InputEncoding>UTF-8</InputEncoding>
        <AdultContent>false</AdultContent>
    </OpenSearchDescription>
";
        }
    }

    public function getTemplateName()
    {
        return "opensearch.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  49 => 10,  43 => 8,  41 => 7,  37 => 6,  31 => 5,  25 => 4,  21 => 2,  19 => 1,);
    }
}
