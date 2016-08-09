<?php

/* @WebProfiler/Collector/router.html.twig */
class __TwigTemplate_249fcb69efbd5154e855b0f947b6b10a660f39e8052184b853884295a2fd482b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/router.html.twig", 1);
        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_2eed9c696f1392c7c9348d4e5dfbcc92f137e421121079be6c7dad776dcb8b8e = $this->env->getExtension("native_profiler");
        $__internal_2eed9c696f1392c7c9348d4e5dfbcc92f137e421121079be6c7dad776dcb8b8e->enter($__internal_2eed9c696f1392c7c9348d4e5dfbcc92f137e421121079be6c7dad776dcb8b8e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_2eed9c696f1392c7c9348d4e5dfbcc92f137e421121079be6c7dad776dcb8b8e->leave($__internal_2eed9c696f1392c7c9348d4e5dfbcc92f137e421121079be6c7dad776dcb8b8e_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_f07460925834f75bc7a57c1598f7157bfeb2921ff9a29bf3260ffba5c0c3f7a8 = $this->env->getExtension("native_profiler");
        $__internal_f07460925834f75bc7a57c1598f7157bfeb2921ff9a29bf3260ffba5c0c3f7a8->enter($__internal_f07460925834f75bc7a57c1598f7157bfeb2921ff9a29bf3260ffba5c0c3f7a8_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_f07460925834f75bc7a57c1598f7157bfeb2921ff9a29bf3260ffba5c0c3f7a8->leave($__internal_f07460925834f75bc7a57c1598f7157bfeb2921ff9a29bf3260ffba5c0c3f7a8_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_575e76e3b248cc7ecf41a49a97a6a6b7c7e817319cb16198005a9fcef6644646 = $this->env->getExtension("native_profiler");
        $__internal_575e76e3b248cc7ecf41a49a97a6a6b7c7e817319cb16198005a9fcef6644646->enter($__internal_575e76e3b248cc7ecf41a49a97a6a6b7c7e817319cb16198005a9fcef6644646_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_575e76e3b248cc7ecf41a49a97a6a6b7c7e817319cb16198005a9fcef6644646->leave($__internal_575e76e3b248cc7ecf41a49a97a6a6b7c7e817319cb16198005a9fcef6644646_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_5d00cbef8aac74e1494eb6a1a5753a11e8083b3cded76d9fa93f468a7aaba9d6 = $this->env->getExtension("native_profiler");
        $__internal_5d00cbef8aac74e1494eb6a1a5753a11e8083b3cded76d9fa93f468a7aaba9d6->enter($__internal_5d00cbef8aac74e1494eb6a1a5753a11e8083b3cded76d9fa93f468a7aaba9d6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_router", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
        echo "
";
        
        $__internal_5d00cbef8aac74e1494eb6a1a5753a11e8083b3cded76d9fa93f468a7aaba9d6->leave($__internal_5d00cbef8aac74e1494eb6a1a5753a11e8083b3cded76d9fa93f468a7aaba9d6_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/router.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 13,  67 => 12,  56 => 7,  53 => 6,  47 => 5,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@WebProfiler/Profiler/layout.html.twig' %}*/
/* */
/* {% block toolbar %}{% endblock %}*/
/* */
/* {% block menu %}*/
/* <span class="label">*/
/*     <span class="icon">{{ include('@WebProfiler/Icon/router.svg') }}</span>*/
/*     <strong>Routing</strong>*/
/* </span>*/
/* {% endblock %}*/
/* */
/* {% block panel %}*/
/*     {{ render(path('_profiler_router', { token: token })) }}*/
/* {% endblock %}*/
/* */
