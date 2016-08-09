<?php

/* expedientes/list.html.twig */
class __TwigTemplate_93413696271f579e0c7d5588d5f53921174609aa328d1bda23c7973e8f1b9dc8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "expedientes/list.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_148bc63b47f4bb607b39c249e2c2a27e6b415f5be7c875e5e3744957eef1b7c1 = $this->env->getExtension("native_profiler");
        $__internal_148bc63b47f4bb607b39c249e2c2a27e6b415f5be7c875e5e3744957eef1b7c1->enter($__internal_148bc63b47f4bb607b39c249e2c2a27e6b415f5be7c875e5e3744957eef1b7c1_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "expedientes/list.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_148bc63b47f4bb607b39c249e2c2a27e6b415f5be7c875e5e3744957eef1b7c1->leave($__internal_148bc63b47f4bb607b39c249e2c2a27e6b415f5be7c875e5e3744957eef1b7c1_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_eadefc2a6f0ed11cd6b5a6824d56275ce08c3855cf85f40ce9de368d14842c17 = $this->env->getExtension("native_profiler");
        $__internal_eadefc2a6f0ed11cd6b5a6824d56275ce08c3855cf85f40ce9de368d14842c17->enter($__internal_eadefc2a6f0ed11cd6b5a6824d56275ce08c3855cf85f40ce9de368d14842c17_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "  <div class=\"col-md-3 hidden-print\">
    <div class=\"panel panel-primary\">
      <div class=\"panel-heading\">
        <h3 class=\"panel-title\">Buscador</h3>
      </div>
    </div>
    <div class=\"panel-body\">
    </div>
  </div>
  <div class=\"col-md-9\">
    ";
        // line 14
        echo twig_include($this->env, $context, "expedientes/show_list.html.twig", array("expedientes" => (isset($context["expedientes"]) ? $context["expedientes"] : $this->getContext($context, "expedientes"))));
        echo "
  </div>

";
        
        $__internal_eadefc2a6f0ed11cd6b5a6824d56275ce08c3855cf85f40ce9de368d14842c17->leave($__internal_eadefc2a6f0ed11cd6b5a6824d56275ce08c3855cf85f40ce9de368d14842c17_prof);

    }

    public function getTemplateName()
    {
        return "expedientes/list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  52 => 14,  40 => 4,  34 => 3,  11 => 1,);
    }
}
/* {% extends 'base.html.twig' %}*/
/* */
/* {% block body %}*/
/*   <div class="col-md-3 hidden-print">*/
/*     <div class="panel panel-primary">*/
/*       <div class="panel-heading">*/
/*         <h3 class="panel-title">Buscador</h3>*/
/*       </div>*/
/*     </div>*/
/*     <div class="panel-body">*/
/*     </div>*/
/*   </div>*/
/*   <div class="col-md-9">*/
/*     {{ include('expedientes/show_list.html.twig', {'expedientes': expedientes}) }}*/
/*   </div>*/
/* */
/* {% endblock %}*/
/* */
