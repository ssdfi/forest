<?php

/* @Twig/Exception/exception_full.html.twig */
class __TwigTemplate_e0c271a903dc38105fb69b8853cd952bb406b4fda3369d4bd9b7b5e6bf636358 extends Twig_Template
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
        $__internal_954df35cb7550e598810c8ec36dd230faedd94410ced40111d3dc587234f5540 = $this->env->getExtension("native_profiler");
        $__internal_954df35cb7550e598810c8ec36dd230faedd94410ced40111d3dc587234f5540->enter($__internal_954df35cb7550e598810c8ec36dd230faedd94410ced40111d3dc587234f5540_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_954df35cb7550e598810c8ec36dd230faedd94410ced40111d3dc587234f5540->leave($__internal_954df35cb7550e598810c8ec36dd230faedd94410ced40111d3dc587234f5540_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_55a7d0b51725b67e1587c4f74fca66fa03cc44183659c0b952ac7c97c57b2b65 = $this->env->getExtension("native_profiler");
        $__internal_55a7d0b51725b67e1587c4f74fca66fa03cc44183659c0b952ac7c97c57b2b65->enter($__internal_55a7d0b51725b67e1587c4f74fca66fa03cc44183659c0b952ac7c97c57b2b65_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_55a7d0b51725b67e1587c4f74fca66fa03cc44183659c0b952ac7c97c57b2b65->leave($__internal_55a7d0b51725b67e1587c4f74fca66fa03cc44183659c0b952ac7c97c57b2b65_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_db1365829c148fc46fa6dd2f41ab874a3ed78d18f22e505fdf0b39c9c74856d9 = $this->env->getExtension("native_profiler");
        $__internal_db1365829c148fc46fa6dd2f41ab874a3ed78d18f22e505fdf0b39c9c74856d9->enter($__internal_db1365829c148fc46fa6dd2f41ab874a3ed78d18f22e505fdf0b39c9c74856d9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_db1365829c148fc46fa6dd2f41ab874a3ed78d18f22e505fdf0b39c9c74856d9->leave($__internal_db1365829c148fc46fa6dd2f41ab874a3ed78d18f22e505fdf0b39c9c74856d9_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_408575505460dcacfe26ac3082b1e2f4fd66d871b6c2d8f64c43273aba6c9b26 = $this->env->getExtension("native_profiler");
        $__internal_408575505460dcacfe26ac3082b1e2f4fd66d871b6c2d8f64c43273aba6c9b26->enter($__internal_408575505460dcacfe26ac3082b1e2f4fd66d871b6c2d8f64c43273aba6c9b26_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("@Twig/Exception/exception.html.twig", "@Twig/Exception/exception_full.html.twig", 12)->display($context);
        
        $__internal_408575505460dcacfe26ac3082b1e2f4fd66d871b6c2d8f64c43273aba6c9b26->leave($__internal_408575505460dcacfe26ac3082b1e2f4fd66d871b6c2d8f64c43273aba6c9b26_prof);

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
}
/* {% extends '@Twig/layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     <link href="{{ absolute_url(asset('bundles/framework/css/exception.css')) }}" rel="stylesheet" type="text/css" media="all" />*/
/* {% endblock %}*/
/* */
/* {% block title %}*/
/*     {{ exception.message }} ({{ status_code }} {{ status_text }})*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/*     {% include '@Twig/Exception/exception.html.twig' %}*/
/* {% endblock %}*/
/* */
