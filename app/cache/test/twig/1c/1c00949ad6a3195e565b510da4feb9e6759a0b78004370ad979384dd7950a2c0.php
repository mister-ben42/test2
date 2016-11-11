<?php

/* @Twig/Exception/exception_full.html.twig */
class __TwigTemplate_f971d03fa22e4713f4194c5441bff9e9a8d8bc114009554b1cd694e690274d6d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Twig/layout.html.twig", "@Twig/Exception/exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@Twig/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_3ccbaeaaec4be5e6ab07888af1198873e5f4e0d7c177c6b7eb6419a865f25284 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_3ccbaeaaec4be5e6ab07888af1198873e5f4e0d7c177c6b7eb6419a865f25284->enter($__internal_3ccbaeaaec4be5e6ab07888af1198873e5f4e0d7c177c6b7eb6419a865f25284_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_3ccbaeaaec4be5e6ab07888af1198873e5f4e0d7c177c6b7eb6419a865f25284->leave($__internal_3ccbaeaaec4be5e6ab07888af1198873e5f4e0d7c177c6b7eb6419a865f25284_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_8c295b462e853507720849d9ea7c1ad673148f1ad42ae641fea39f17951a8744 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_8c295b462e853507720849d9ea7c1ad673148f1ad42ae641fea39f17951a8744->enter($__internal_8c295b462e853507720849d9ea7c1ad673148f1ad42ae641fea39f17951a8744_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "@Twig/Exception/exception_full.html.twig"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_8c295b462e853507720849d9ea7c1ad673148f1ad42ae641fea39f17951a8744->leave($__internal_8c295b462e853507720849d9ea7c1ad673148f1ad42ae641fea39f17951a8744_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_5defb6266bdb7045ff2fa2dbb5d83c8a56c75553779c11b9ab84f709b6d1d6a8 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_5defb6266bdb7045ff2fa2dbb5d83c8a56c75553779c11b9ab84f709b6d1d6a8->enter($__internal_5defb6266bdb7045ff2fa2dbb5d83c8a56c75553779c11b9ab84f709b6d1d6a8_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "@Twig/Exception/exception_full.html.twig"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_5defb6266bdb7045ff2fa2dbb5d83c8a56c75553779c11b9ab84f709b6d1d6a8->leave($__internal_5defb6266bdb7045ff2fa2dbb5d83c8a56c75553779c11b9ab84f709b6d1d6a8_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_1865dcc27cfbab2f9f1648ebba82c1f407d641832562707d94bdd2af16a5d84c = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_1865dcc27cfbab2f9f1648ebba82c1f407d641832562707d94bdd2af16a5d84c->enter($__internal_1865dcc27cfbab2f9f1648ebba82c1f407d641832562707d94bdd2af16a5d84c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "@Twig/Exception/exception_full.html.twig"));

        // line 12
        echo "    ";
        $this->loadTemplate("@Twig/Exception/exception.html.twig", "@Twig/Exception/exception_full.html.twig", 12)->display($context);
        
        $__internal_1865dcc27cfbab2f9f1648ebba82c1f407d641832562707d94bdd2af16a5d84c->leave($__internal_1865dcc27cfbab2f9f1648ebba82c1f407d641832562707d94bdd2af16a5d84c_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@Twig/layout.html.twig' %}

{% block head %}
    <link href=\"{{ absolute_url(asset('bundles/framework/css/exception.css')) }}\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
{% endblock %}

{% block title %}
    {{ exception.message }} ({{ status_code }} {{ status_text }})
{% endblock %}

{% block body %}
    {% include '@Twig/Exception/exception.html.twig' %}
{% endblock %}
", "@Twig/Exception/exception_full.html.twig", "/home/benoit/essai/test2/vendor/symfony/symfony/src/Symfony/Bundle/TwigBundle/Resources/views/Exception/exception_full.html.twig");
    }
}
