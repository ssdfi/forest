<?php

/* expedientes/create.html.twig */
class __TwigTemplate_36a1b3268d5a0aaa792070a8512df105713b4bd7e2fe41700acd67efd5699c7c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "expedientes/create.html.twig", 1);
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
        $__internal_cec904902ccbb9311aea3b04bfb6501bd3da47c7e139633735a64d054fb7cfea = $this->env->getExtension("native_profiler");
        $__internal_cec904902ccbb9311aea3b04bfb6501bd3da47c7e139633735a64d054fb7cfea->enter($__internal_cec904902ccbb9311aea3b04bfb6501bd3da47c7e139633735a64d054fb7cfea_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "expedientes/create.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_cec904902ccbb9311aea3b04bfb6501bd3da47c7e139633735a64d054fb7cfea->leave($__internal_cec904902ccbb9311aea3b04bfb6501bd3da47c7e139633735a64d054fb7cfea_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_83dc504511410d51a4d0fc01bdad8583358493b2d315a6eb57a062d566ce22a0 = $this->env->getExtension("native_profiler");
        $__internal_83dc504511410d51a4d0fc01bdad8583358493b2d315a6eb57a062d566ce22a0->enter($__internal_83dc504511410d51a4d0fc01bdad8583358493b2d315a6eb57a062d566ce22a0_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

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
    TODsO EXPEDIENTES CREAATEE
  </div>

";
        
        $__internal_83dc504511410d51a4d0fc01bdad8583358493b2d315a6eb57a062d566ce22a0->leave($__internal_83dc504511410d51a4d0fc01bdad8583358493b2d315a6eb57a062d566ce22a0_prof);

    }

    public function getTemplateName()
    {
        return "expedientes/create.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 4,  34 => 3,  11 => 1,);
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
/*     TODsO EXPEDIENTES CREAATEE*/
/*   </div>*/
/* */
/* {% endblock %}*/
/* */
