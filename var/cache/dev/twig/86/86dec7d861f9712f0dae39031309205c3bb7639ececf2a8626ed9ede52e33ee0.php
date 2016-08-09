<?php

/* @WebProfiler/Collector/exception.html.twig */
class __TwigTemplate_d5aec4c8bdd68480da2af36cbcc1c6e064887d78bee1f8501216133cdae63729 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/exception.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
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
        $__internal_dc2a32dae2610dbf0d3072409ba5dc5b44b5455e553dc44fae59c53399eebf63 = $this->env->getExtension("native_profiler");
        $__internal_dc2a32dae2610dbf0d3072409ba5dc5b44b5455e553dc44fae59c53399eebf63->enter($__internal_dc2a32dae2610dbf0d3072409ba5dc5b44b5455e553dc44fae59c53399eebf63_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/exception.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_dc2a32dae2610dbf0d3072409ba5dc5b44b5455e553dc44fae59c53399eebf63->leave($__internal_dc2a32dae2610dbf0d3072409ba5dc5b44b5455e553dc44fae59c53399eebf63_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_ba11ad89d78ad5c43eede3aac64cb672ea1bcce3b3ec80816c939c38a3c86d21 = $this->env->getExtension("native_profiler");
        $__internal_ba11ad89d78ad5c43eede3aac64cb672ea1bcce3b3ec80816c939c38a3c86d21->enter($__internal_ba11ad89d78ad5c43eede3aac64cb672ea1bcce3b3ec80816c939c38a3c86d21_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    ";
        if ($this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "hasexception", array())) {
            // line 5
            echo "        <style>
            ";
            // line 6
            echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_exception_css", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
            echo "
        </style>
    ";
        }
        // line 9
        echo "    ";
        $this->displayParentBlock("head", $context, $blocks);
        echo "
";
        
        $__internal_ba11ad89d78ad5c43eede3aac64cb672ea1bcce3b3ec80816c939c38a3c86d21->leave($__internal_ba11ad89d78ad5c43eede3aac64cb672ea1bcce3b3ec80816c939c38a3c86d21_prof);

    }

    // line 12
    public function block_menu($context, array $blocks = array())
    {
        $__internal_38ff6c96ec75d24af7b069f9b8e69b63411d730e8fc08472e3521e4447dbaeed = $this->env->getExtension("native_profiler");
        $__internal_38ff6c96ec75d24af7b069f9b8e69b63411d730e8fc08472e3521e4447dbaeed->enter($__internal_38ff6c96ec75d24af7b069f9b8e69b63411d730e8fc08472e3521e4447dbaeed_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 13
        echo "    <span class=\"label ";
        echo (($this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "hasexception", array())) ? ("label-status-error") : ("disabled"));
        echo "\">
        <span class=\"icon\">";
        // line 14
        echo twig_include($this->env, $context, "@WebProfiler/Icon/exception.svg");
        echo "</span>
        <strong>Exception</strong>
        ";
        // line 16
        if ($this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "hasexception", array())) {
            // line 17
            echo "            <span class=\"count\">
                <span>1</span>
            </span>
        ";
        }
        // line 21
        echo "    </span>
";
        
        $__internal_38ff6c96ec75d24af7b069f9b8e69b63411d730e8fc08472e3521e4447dbaeed->leave($__internal_38ff6c96ec75d24af7b069f9b8e69b63411d730e8fc08472e3521e4447dbaeed_prof);

    }

    // line 24
    public function block_panel($context, array $blocks = array())
    {
        $__internal_83e4762141490eb760f50f0c927667d9a02ecc59298210770fef0f0a78f68e07 = $this->env->getExtension("native_profiler");
        $__internal_83e4762141490eb760f50f0c927667d9a02ecc59298210770fef0f0a78f68e07->enter($__internal_83e4762141490eb760f50f0c927667d9a02ecc59298210770fef0f0a78f68e07_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 25
        echo "    <h2>Exceptions</h2>

    ";
        // line 27
        if ( !$this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "hasexception", array())) {
            // line 28
            echo "        <div class=\"empty\">
            <p>No exception was thrown and caught during the request.</p>
        </div>
    ";
        } else {
            // line 32
            echo "        <div class=\"sf-reset\">
            ";
            // line 33
            echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_exception", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
            echo "
        </div>
    ";
        }
        
        $__internal_83e4762141490eb760f50f0c927667d9a02ecc59298210770fef0f0a78f68e07->leave($__internal_83e4762141490eb760f50f0c927667d9a02ecc59298210770fef0f0a78f68e07_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/exception.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  117 => 33,  114 => 32,  108 => 28,  106 => 27,  102 => 25,  96 => 24,  88 => 21,  82 => 17,  80 => 16,  75 => 14,  70 => 13,  64 => 12,  54 => 9,  48 => 6,  45 => 5,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@WebProfiler/Profiler/layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     {% if collector.hasexception %}*/
/*         <style>*/
/*             {{ render(path('_profiler_exception_css', { token: token })) }}*/
/*         </style>*/
/*     {% endif %}*/
/*     {{ parent() }}*/
/* {% endblock %}*/
/* */
/* {% block menu %}*/
/*     <span class="label {{ collector.hasexception ? 'label-status-error' : 'disabled' }}">*/
/*         <span class="icon">{{ include('@WebProfiler/Icon/exception.svg') }}</span>*/
/*         <strong>Exception</strong>*/
/*         {% if collector.hasexception %}*/
/*             <span class="count">*/
/*                 <span>1</span>*/
/*             </span>*/
/*         {% endif %}*/
/*     </span>*/
/* {% endblock %}*/
/* */
/* {% block panel %}*/
/*     <h2>Exceptions</h2>*/
/* */
/*     {% if not collector.hasexception %}*/
/*         <div class="empty">*/
/*             <p>No exception was thrown and caught during the request.</p>*/
/*         </div>*/
/*     {% else %}*/
/*         <div class="sf-reset">*/
/*             {{ render(path('_profiler_exception', { token: token })) }}*/
/*         </div>*/
/*     {% endif %}*/
/* {% endblock %}*/
/* */
