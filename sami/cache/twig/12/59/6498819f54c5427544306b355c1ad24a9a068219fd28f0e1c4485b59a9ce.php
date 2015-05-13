<?php

/* class.twig */
class __TwigTemplate_12596498819f54c5427544306b355c1ad24a9a068219fd28f0e1c4485b59a9ce extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout/layout.twig", "class.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body_class' => array($this, 'block_body_class'),
            'page_id' => array($this, 'block_page_id'),
            'below_menu' => array($this, 'block_below_menu'),
            'page_content' => array($this, 'block_page_content'),
            'class_signature' => array($this, 'block_class_signature'),
            'method_signature' => array($this, 'block_method_signature'),
            'method_parameters_signature' => array($this, 'block_method_parameters_signature'),
            'parameters' => array($this, 'block_parameters'),
            'return' => array($this, 'block_return'),
            'exceptions' => array($this, 'block_exceptions'),
            'see' => array($this, 'block_see'),
            'constants' => array($this, 'block_constants'),
            'properties' => array($this, 'block_properties'),
            'methods' => array($this, 'block_methods'),
            'methods_details' => array($this, 'block_methods_details'),
            'method' => array($this, 'block_method'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout/layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        $context["__internal_f97b41c439ba2e99b1942622ffb45509e0fbf703c02e17fb7e05084a0a94ebb7"] = $this->loadTemplate("macros.twig", "class.twig", 2);
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "name", array()), "html", null, true);
        echo " | ";
        $this->displayParentBlock("title", $context, $blocks);
    }

    // line 4
    public function block_body_class($context, array $blocks = array())
    {
        echo "class";
    }

    // line 5
    public function block_page_id($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, ("class:" . strtr($this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "name", array()), array("\\" => "_"))), "html", null, true);
    }

    // line 7
    public function block_below_menu($context, array $blocks = array())
    {
        // line 8
        echo "    ";
        if ($this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "namespace", array())) {
            // line 9
            echo "        <div class=\"namespace-breadcrumbs\">
            <ol class=\"breadcrumb\">
                <li><span class=\"label label-default\">";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "categoryName", array()), "html", null, true);
            echo "</span></li>
                ";
            // line 12
            echo $context["__internal_f97b41c439ba2e99b1942622ffb45509e0fbf703c02e17fb7e05084a0a94ebb7"]->getbreadcrumbs($this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "namespace", array()));
            echo "
                <li>";
            // line 13
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "shortname", array()), "html", null, true);
            echo "</li>
            </ol>
        </div>
    ";
        }
    }

    // line 19
    public function block_page_content($context, array $blocks = array())
    {
        // line 20
        echo "
    <div class=\"page-header\">
        <h1>";
        // line 22
        echo twig_escape_filter($this->env, twig_last($this->env, twig_split_filter($this->env, $this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "name", array()), "\\")), "html", null, true);
        echo "</h1>
    </div>

    ";
        // line 25
        if (($this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "shortdesc", array()) || $this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "longdesc", array()))) {
            // line 26
            echo "        <h3>Usage</h3>
        <div class=\"description\">
            ";
            // line 28
            if ($this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "shortdesc", array())) {
                // line 29
                echo "<p>";
                echo $this->env->getExtension('sami')->parseDesc($context, $this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "shortdesc", array()), (isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")));
                echo "</p>";
            }
            // line 31
            echo "            ";
            if ($this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "longdesc", array())) {
                // line 32
                echo "<p>";
                echo $this->env->getExtension('sami')->parseDesc($context, $this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "longdesc", array()), (isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")));
                echo "</p>";
            }
            // line 34
            echo "        </div>
    ";
        }
        // line 36
        echo "
    <p>";
        // line 37
        $this->displayBlock("class_signature", $context, $blocks);
        echo "</p>

    ";
        // line 39
        if ((isset($context["traits"]) ? $context["traits"] : $this->getContext($context, "traits"))) {
            // line 40
            echo "        <h2>Traits</h2>

        ";
            // line 42
            echo $context["__internal_f97b41c439ba2e99b1942622ffb45509e0fbf703c02e17fb7e05084a0a94ebb7"]->getrender_classes((isset($context["traits"]) ? $context["traits"] : $this->getContext($context, "traits")));
            echo "
    ";
        }
        // line 44
        echo "
    ";
        // line 45
        if ((isset($context["constants"]) ? $context["constants"] : $this->getContext($context, "constants"))) {
            // line 46
            echo "        <h2>Constants</h2>

        ";
            // line 48
            $this->displayBlock("constants", $context, $blocks);
            echo "
    ";
        }
        // line 50
        echo "
    ";
        // line 51
        if ((isset($context["properties"]) ? $context["properties"] : $this->getContext($context, "properties"))) {
            // line 52
            echo "        <h2>Properties</h2>

        ";
            // line 54
            $this->displayBlock("properties", $context, $blocks);
            echo "
    ";
        }
        // line 56
        echo "
    ";
        // line 57
        if ((isset($context["methods"]) ? $context["methods"] : $this->getContext($context, "methods"))) {
            // line 58
            echo "        <h2>Methods</h2>

        ";
            // line 60
            $this->displayBlock("methods", $context, $blocks);
            echo "

        <h2>Details</h2>

        ";
            // line 64
            $this->displayBlock("methods_details", $context, $blocks);
            echo "
    ";
        }
        // line 66
        echo "
";
    }

    // line 69
    public function block_class_signature($context, array $blocks = array())
    {
        // line 70
        if (( !$this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "interface", array()) && $this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "abstract", array()))) {
            echo "abstract ";
        }
        // line 71
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "categoryName", array()), "html", null, true);
        echo "
    <strong>";
        // line 72
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "shortname", array()), "html", null, true);
        echo "</strong>";
        // line 73
        if ($this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "parent", array())) {
            // line 74
            echo "        extends ";
            echo $context["__internal_f97b41c439ba2e99b1942622ffb45509e0fbf703c02e17fb7e05084a0a94ebb7"]->getclass_link($this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "parent", array()));
        }
        // line 76
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "interfaces", array())) > 0)) {
            // line 77
            echo "        implements
        ";
            // line 78
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")), "interfaces", array()));
            $context['loop'] = array(
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            );
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["interface"]) {
                // line 79
                echo $context["__internal_f97b41c439ba2e99b1942622ffb45509e0fbf703c02e17fb7e05084a0a94ebb7"]->getclass_link($context["interface"]);
                // line 80
                if ( !$this->getAttribute($context["loop"], "last", array())) {
                    echo ", ";
                }
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['length'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['interface'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
    }

    // line 85
    public function block_method_signature($context, array $blocks = array())
    {
        // line 86
        if ($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "final", array())) {
            echo "final";
        }
        // line 87
        echo "    ";
        if ($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "abstract", array())) {
            echo "abstract";
        }
        // line 88
        echo "    ";
        if ($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "static", array())) {
            echo "static";
        }
        // line 89
        echo "    ";
        if ($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "protected", array())) {
            echo "protected";
        }
        // line 90
        echo "    ";
        if ($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "private", array())) {
            echo "private";
        }
        // line 91
        echo "    ";
        echo $context["__internal_f97b41c439ba2e99b1942622ffb45509e0fbf703c02e17fb7e05084a0a94ebb7"]->gethint_link($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "hint", array()));
        echo "
    <strong>";
        // line 92
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "name", array()), "html", null, true);
        echo "</strong>";
        $this->displayBlock("method_parameters_signature", $context, $blocks);
    }

    // line 95
    public function block_method_parameters_signature($context, array $blocks = array())
    {
        // line 96
        $context["__internal_e6620e648e39c4225719d3ef05974372aea4ca5f039fd97004813c596e64167a"] = $this->loadTemplate("macros.twig", "class.twig", 96);
        // line 97
        echo $context["__internal_e6620e648e39c4225719d3ef05974372aea4ca5f039fd97004813c596e64167a"]->getmethod_parameters_signature((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")));
    }

    // line 100
    public function block_parameters($context, array $blocks = array())
    {
        // line 101
        echo "    <table class=\"table table-condensed\">
        ";
        // line 102
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "parameters", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["parameter"]) {
            // line 103
            echo "            <tr>
                <td>";
            // line 104
            if ($this->getAttribute($context["parameter"], "hint", array())) {
                echo $context["__internal_f97b41c439ba2e99b1942622ffb45509e0fbf703c02e17fb7e05084a0a94ebb7"]->gethint_link($this->getAttribute($context["parameter"], "hint", array()));
            }
            echo "</td>
                <td>\$";
            // line 105
            echo twig_escape_filter($this->env, $this->getAttribute($context["parameter"], "name", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 106
            echo $this->env->getExtension('sami')->parseDesc($context, $this->getAttribute($context["parameter"], "shortdesc", array()), (isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")));
            echo "</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['parameter'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 109
        echo "    </table>
";
    }

    // line 112
    public function block_return($context, array $blocks = array())
    {
        // line 113
        echo "    <table class=\"table table-condensed\">
        <tr>
            <td>";
        // line 115
        echo $context["__internal_f97b41c439ba2e99b1942622ffb45509e0fbf703c02e17fb7e05084a0a94ebb7"]->gethint_link($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "hint", array()));
        echo "</td>
            <td>";
        // line 116
        echo $this->env->getExtension('sami')->parseDesc($context, $this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "hintDesc", array()), (isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")));
        echo "</td>
        </tr>
    </table>
";
    }

    // line 121
    public function block_exceptions($context, array $blocks = array())
    {
        // line 122
        echo "    <table class=\"table table-condensed\">
        ";
        // line 123
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "exceptions", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["exception"]) {
            // line 124
            echo "            <tr>
                <td>";
            // line 125
            echo $context["__internal_f97b41c439ba2e99b1942622ffb45509e0fbf703c02e17fb7e05084a0a94ebb7"]->getclass_link($this->getAttribute($context["exception"], 0, array(), "array"));
            echo "</td>
                <td>";
            // line 126
            echo $this->env->getExtension('sami')->parseDesc($context, $this->getAttribute($context["exception"], 1, array(), "array"), (isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")));
            echo "</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['exception'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 129
        echo "    </table>
";
    }

    // line 132
    public function block_see($context, array $blocks = array())
    {
        // line 133
        echo "    <table class=\"table table-condensed\">
        ";
        // line 134
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "tags", array(0 => "see"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
            // line 135
            echo "            <tr>
                <td>";
            // line 136
            echo twig_escape_filter($this->env, $this->getAttribute($context["tag"], 0, array(), "array"), "html", null, true);
            echo "</td>
                <td>";
            // line 137
            echo twig_escape_filter($this->env, twig_join_filter(twig_slice($this->env, $context["tag"], 1, null), " "), "html", null, true);
            echo "</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tag'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 140
        echo "    </table>
";
    }

    // line 143
    public function block_constants($context, array $blocks = array())
    {
        // line 144
        echo "    <table class=\"table table-condensed\">
        ";
        // line 145
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["constants"]) ? $context["constants"] : $this->getContext($context, "constants")));
        foreach ($context['_seq'] as $context["_key"] => $context["constant"]) {
            // line 146
            echo "            <tr>
                <td>";
            // line 147
            echo twig_escape_filter($this->env, $this->getAttribute($context["constant"], "name", array()), "html", null, true);
            echo "</td>
                <td class=\"last\">
                    <p><em>";
            // line 149
            echo $this->env->getExtension('sami')->parseDesc($context, $this->getAttribute($context["constant"], "shortdesc", array()), (isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")));
            echo "</em></p>
                    <p>";
            // line 150
            echo $this->env->getExtension('sami')->parseDesc($context, $this->getAttribute($context["constant"], "longdesc", array()), (isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")));
            echo "</p>
                </td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['constant'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 154
        echo "    </table>
";
    }

    // line 157
    public function block_properties($context, array $blocks = array())
    {
        // line 158
        echo "    <table class=\"table table-condensed\">
        ";
        // line 159
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["properties"]) ? $context["properties"] : $this->getContext($context, "properties")));
        foreach ($context['_seq'] as $context["_key"] => $context["property"]) {
            // line 160
            echo "            <tr>
                <td class=\"type\" id=\"property_";
            // line 161
            echo twig_escape_filter($this->env, $this->getAttribute($context["property"], "name", array()), "html", null, true);
            echo "\">
                    ";
            // line 162
            if ($this->getAttribute($context["property"], "static", array())) {
                echo "static";
            }
            // line 163
            echo "                    ";
            if ($this->getAttribute($context["property"], "protected", array())) {
                echo "protected";
            }
            // line 164
            echo "                    ";
            if ($this->getAttribute($context["property"], "private", array())) {
                echo "private";
            }
            // line 165
            echo "                    ";
            echo $context["__internal_f97b41c439ba2e99b1942622ffb45509e0fbf703c02e17fb7e05084a0a94ebb7"]->gethint_link($this->getAttribute($context["property"], "hint", array()));
            echo "
                </td>
                <td>\$";
            // line 167
            echo twig_escape_filter($this->env, $this->getAttribute($context["property"], "name", array()), "html", null, true);
            echo "</td>
                <td class=\"last\">";
            // line 168
            echo $this->env->getExtension('sami')->parseDesc($context, $this->getAttribute($context["property"], "shortdesc", array()), (isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")));
            echo "</td>
                <td>";
            // line 170
            if ( !($this->getAttribute($context["property"], "class", array()) === (isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")))) {
                // line 171
                echo "<small>from&nbsp;";
                echo $context["__internal_f97b41c439ba2e99b1942622ffb45509e0fbf703c02e17fb7e05084a0a94ebb7"]->getproperty_link($context["property"], false, true);
                echo "</small>";
            }
            // line 173
            echo "</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['property'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 176
        echo "    </table>
";
    }

    // line 179
    public function block_methods($context, array $blocks = array())
    {
        // line 180
        echo "    <div class=\"container-fluid underlined\">
        ";
        // line 181
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["methods"]) ? $context["methods"] : $this->getContext($context, "methods")));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["method"]) {
            // line 182
            echo "            <div class=\"row\">
                <div class=\"col-md-2 type\">
                    ";
            // line 184
            if ($this->getAttribute($context["method"], "static", array())) {
                echo "static&nbsp;";
            }
            echo $context["__internal_f97b41c439ba2e99b1942622ffb45509e0fbf703c02e17fb7e05084a0a94ebb7"]->gethint_link($this->getAttribute($context["method"], "hint", array()));
            echo "
                </div>
                <div class=\"col-md-8 type\">
                    <a href=\"#method_";
            // line 187
            echo twig_escape_filter($this->env, $this->getAttribute($context["method"], "name", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["method"], "name", array()), "html", null, true);
            echo "</a>";
            $this->displayBlock("method_parameters_signature", $context, $blocks);
            echo "
                    ";
            // line 188
            if ( !$this->getAttribute($context["method"], "shortdesc", array())) {
                // line 189
                echo "                        <p class=\"no-description\">No description</p>
                    ";
            } else {
                // line 191
                echo "                        <p>";
                echo $this->env->getExtension('sami')->parseDesc($context, $this->getAttribute($context["method"], "shortdesc", array()), (isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")));
                echo "</p>";
            }
            // line 193
            echo "                </div>
                <div class=\"col-md-2\">";
            // line 195
            if ( !($this->getAttribute($context["method"], "class", array()) === (isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")))) {
                // line 196
                echo "<small>from&nbsp;";
                echo $context["__internal_f97b41c439ba2e99b1942622ffb45509e0fbf703c02e17fb7e05084a0a94ebb7"]->getmethod_link($context["method"], false, true);
                echo "</small>";
            }
            // line 198
            echo "</div>
            </div>
        ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['method'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 201
        echo "    </div>
";
    }

    // line 204
    public function block_methods_details($context, array $blocks = array())
    {
        // line 205
        echo "    <div id=\"method-details\">
        ";
        // line 206
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["methods"]) ? $context["methods"] : $this->getContext($context, "methods")));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["method"]) {
            // line 207
            echo "            <div class=\"method-item\">
                ";
            // line 208
            $this->displayBlock("method", $context, $blocks);
            echo "
            </div>
        ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['method'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 211
        echo "    </div>
";
    }

    // line 214
    public function block_method($context, array $blocks = array())
    {
        // line 215
        echo "    <h3 id=\"method_";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "name", array()), "html", null, true);
        echo "\">
        <div class=\"location\">";
        // line 216
        if ( !($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "class", array()) === (isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")))) {
            echo "in ";
            echo $context["__internal_f97b41c439ba2e99b1942622ffb45509e0fbf703c02e17fb7e05084a0a94ebb7"]->getmethod_link((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), false, true);
            echo " ";
        }
        echo "at line ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "line", array()), "html", null, true);
        echo "</div>
        <code>";
        // line 217
        $this->displayBlock("method_signature", $context, $blocks);
        echo "</code>
    </h3>
    <div class=\"details\">
        ";
        // line 220
        if (($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "shortdesc", array()) || $this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "longdesc", array()))) {
            // line 221
            echo "            <div class=\"method-description\">
                ";
            // line 222
            if (( !$this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "shortdesc", array()) &&  !$this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "longdesc", array()))) {
                // line 223
                echo "                    <p class=\"no-description\">No description</p>
                ";
            } else {
                // line 225
                echo "                    ";
                if ($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "shortdesc", array())) {
                    // line 226
                    echo "<p>";
                    echo $this->env->getExtension('sami')->parseDesc($context, $this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "shortdesc", array()), (isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")));
                    echo "</p>";
                }
                // line 228
                echo "                    ";
                if ($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "longdesc", array())) {
                    // line 229
                    echo "<p>";
                    echo $this->env->getExtension('sami')->parseDesc($context, $this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "longdesc", array()), (isset($context["class"]) ? $context["class"] : $this->getContext($context, "class")));
                    echo "</p>";
                }
            }
            // line 232
            echo "            </div>
        ";
        }
        // line 234
        echo "        <div class=\"tags\">
            ";
        // line 235
        if ($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "parameters", array())) {
            // line 236
            echo "                <h4>Parameters</h4>

                ";
            // line 238
            $this->displayBlock("parameters", $context, $blocks);
            echo "
            ";
        }
        // line 240
        echo "
            ";
        // line 241
        if (($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "hintDesc", array()) || $this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "hint", array()))) {
            // line 242
            echo "                <h4>Return Value</h4>

                ";
            // line 244
            $this->displayBlock("return", $context, $blocks);
            echo "
            ";
        }
        // line 246
        echo "
            ";
        // line 247
        if ($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "exceptions", array())) {
            // line 248
            echo "                <h4>Exceptions</h4>

                ";
            // line 250
            $this->displayBlock("exceptions", $context, $blocks);
            echo "
            ";
        }
        // line 252
        echo "
            ";
        // line 253
        if ($this->getAttribute((isset($context["method"]) ? $context["method"] : $this->getContext($context, "method")), "tags", array(0 => "see"), "method")) {
            // line 254
            echo "                <h4>See also</h4>

                ";
            // line 256
            $this->displayBlock("see", $context, $blocks);
            echo "
            ";
        }
        // line 258
        echo "        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "class.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  782 => 258,  777 => 256,  773 => 254,  771 => 253,  768 => 252,  763 => 250,  759 => 248,  757 => 247,  754 => 246,  749 => 244,  745 => 242,  743 => 241,  740 => 240,  735 => 238,  731 => 236,  729 => 235,  726 => 234,  722 => 232,  716 => 229,  713 => 228,  708 => 226,  705 => 225,  701 => 223,  699 => 222,  696 => 221,  694 => 220,  688 => 217,  678 => 216,  673 => 215,  670 => 214,  665 => 211,  648 => 208,  645 => 207,  628 => 206,  625 => 205,  622 => 204,  617 => 201,  601 => 198,  596 => 196,  594 => 195,  591 => 193,  586 => 191,  582 => 189,  580 => 188,  572 => 187,  563 => 184,  559 => 182,  542 => 181,  539 => 180,  536 => 179,  531 => 176,  523 => 173,  518 => 171,  516 => 170,  512 => 168,  508 => 167,  502 => 165,  497 => 164,  492 => 163,  488 => 162,  484 => 161,  481 => 160,  477 => 159,  474 => 158,  471 => 157,  466 => 154,  456 => 150,  452 => 149,  447 => 147,  444 => 146,  440 => 145,  437 => 144,  434 => 143,  429 => 140,  420 => 137,  416 => 136,  413 => 135,  409 => 134,  406 => 133,  403 => 132,  398 => 129,  389 => 126,  385 => 125,  382 => 124,  378 => 123,  375 => 122,  372 => 121,  364 => 116,  360 => 115,  356 => 113,  353 => 112,  348 => 109,  339 => 106,  335 => 105,  329 => 104,  326 => 103,  322 => 102,  319 => 101,  316 => 100,  312 => 97,  310 => 96,  307 => 95,  301 => 92,  296 => 91,  291 => 90,  286 => 89,  281 => 88,  276 => 87,  272 => 86,  269 => 85,  250 => 80,  248 => 79,  231 => 78,  228 => 77,  226 => 76,  222 => 74,  220 => 73,  217 => 72,  212 => 71,  208 => 70,  205 => 69,  200 => 66,  195 => 64,  188 => 60,  184 => 58,  182 => 57,  179 => 56,  174 => 54,  170 => 52,  168 => 51,  165 => 50,  160 => 48,  156 => 46,  154 => 45,  151 => 44,  146 => 42,  142 => 40,  140 => 39,  135 => 37,  132 => 36,  128 => 34,  123 => 32,  120 => 31,  115 => 29,  113 => 28,  109 => 26,  107 => 25,  101 => 22,  97 => 20,  94 => 19,  85 => 13,  81 => 12,  77 => 11,  73 => 9,  70 => 8,  67 => 7,  61 => 5,  55 => 4,  47 => 3,  43 => 1,  41 => 2,  11 => 1,);
    }
}
