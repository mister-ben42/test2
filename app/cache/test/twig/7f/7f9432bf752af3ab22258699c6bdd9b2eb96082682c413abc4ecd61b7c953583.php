<?php

/* @Twig/layout.html.twig */
class __TwigTemplate_bc0f624bbfd1863f4160eab25773e6bd96f0226996a58293967ffe2a2e13bc5f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'head' => array($this, 'block_head'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_7195880eae06f037aa1f4c47f1206f009c9057fbb9ab85c8f5b12a60f0c01ab5 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_7195880eae06f037aa1f4c47f1206f009c9057fbb9ab85c8f5b12a60f0c01ab5->enter($__internal_7195880eae06f037aa1f4c47f1206f009c9057fbb9ab85c8f5b12a60f0c01ab5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/layout.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=";
        // line 4
        echo twig_escape_filter($this->env, $this->env->getCharset(), "html", null, true);
        echo "\"/>
        <meta name=\"robots\" content=\"noindex,nofollow\" />
        <title>";
        // line 6
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
         ";
        // line 7
        $this->displayBlock('head', $context, $blocks);
        // line 8
        echo "    </head>
    <body>        

            <div class=\"sf-reset\">
                ";
        // line 12
        $this->displayBlock('body', $context, $blocks);
        // line 13
        echo "            </div>
        </div>
    </body>
</html>
";
        
        $__internal_7195880eae06f037aa1f4c47f1206f009c9057fbb9ab85c8f5b12a60f0c01ab5->leave($__internal_7195880eae06f037aa1f4c47f1206f009c9057fbb9ab85c8f5b12a60f0c01ab5_prof);

    }

    // line 6
    public function block_title($context, array $blocks = array())
    {
        $__internal_f8217e66bbc382f84f737203918f644e6d31617a0f5474234aa82a7455170fd6 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_f8217e66bbc382f84f737203918f644e6d31617a0f5474234aa82a7455170fd6->enter($__internal_f8217e66bbc382f84f737203918f644e6d31617a0f5474234aa82a7455170fd6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "@Twig/layout.html.twig"));

        
        $__internal_f8217e66bbc382f84f737203918f644e6d31617a0f5474234aa82a7455170fd6->leave($__internal_f8217e66bbc382f84f737203918f644e6d31617a0f5474234aa82a7455170fd6_prof);

    }

    // line 7
    public function block_head($context, array $blocks = array())
    {
        $__internal_287c3cb76ea9c16c3ea8cf4cfd99bae19bc29a5f4c16465f168e1c1c590cbfe4 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_287c3cb76ea9c16c3ea8cf4cfd99bae19bc29a5f4c16465f168e1c1c590cbfe4->enter($__internal_287c3cb76ea9c16c3ea8cf4cfd99bae19bc29a5f4c16465f168e1c1c590cbfe4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "@Twig/layout.html.twig"));

        
        $__internal_287c3cb76ea9c16c3ea8cf4cfd99bae19bc29a5f4c16465f168e1c1c590cbfe4->leave($__internal_287c3cb76ea9c16c3ea8cf4cfd99bae19bc29a5f4c16465f168e1c1c590cbfe4_prof);

    }

    // line 12
    public function block_body($context, array $blocks = array())
    {
        $__internal_91e30cadf90a5a5097fc02a5db506ccaf8c88b2b06a4ed9e86c367f0af5d1051 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_91e30cadf90a5a5097fc02a5db506ccaf8c88b2b06a4ed9e86c367f0af5d1051->enter($__internal_91e30cadf90a5a5097fc02a5db506ccaf8c88b2b06a4ed9e86c367f0af5d1051_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "@Twig/layout.html.twig"));

        
        $__internal_91e30cadf90a5a5097fc02a5db506ccaf8c88b2b06a4ed9e86c367f0af5d1051->leave($__internal_91e30cadf90a5a5097fc02a5db506ccaf8c88b2b06a4ed9e86c367f0af5d1051_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 12,  71 => 7,  60 => 6,  49 => 13,  47 => 12,  41 => 8,  39 => 7,  35 => 6,  30 => 4,  25 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset={{ _charset }}\"/>
        <meta name=\"robots\" content=\"noindex,nofollow\" />
        <title>{% block title %}{% endblock %}</title>
         {% block head %}{% endblock %}
    </head>
    <body>        

            <div class=\"sf-reset\">
                {% block body %}{% endblock %}
            </div>
        </div>
    </body>
</html>
", "@Twig/layout.html.twig", "/home/benoit/essai/test2/app/Resources/TwigBundle/views/layout.html.twig");
    }
}
