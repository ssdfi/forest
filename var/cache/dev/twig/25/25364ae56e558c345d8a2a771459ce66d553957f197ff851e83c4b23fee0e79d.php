<?php

/* expedientes/list.html.twig */
class __TwigTemplate_a55c4a3fb2169036e58e097aa19df3e394e7b9be55cfa06a5370312a51d9508c extends Twig_Template
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
        $__internal_d6a4c68878cbc86a46e51bbb2074b16359fd4de11f28011c801637fa0479d33e = $this->env->getExtension("native_profiler");
        $__internal_d6a4c68878cbc86a46e51bbb2074b16359fd4de11f28011c801637fa0479d33e->enter($__internal_d6a4c68878cbc86a46e51bbb2074b16359fd4de11f28011c801637fa0479d33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "expedientes/list.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_d6a4c68878cbc86a46e51bbb2074b16359fd4de11f28011c801637fa0479d33e->leave($__internal_d6a4c68878cbc86a46e51bbb2074b16359fd4de11f28011c801637fa0479d33e_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_7bb874750320bf0e1c13505460669ca3a09e2c360051ebe7360a98cf072678ad = $this->env->getExtension("native_profiler");
        $__internal_7bb874750320bf0e1c13505460669ca3a09e2c360051ebe7360a98cf072678ad->enter($__internal_7bb874750320bf0e1c13505460669ca3a09e2c360051ebe7360a98cf072678ad_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

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
        
        $__internal_7bb874750320bf0e1c13505460669ca3a09e2c360051ebe7360a98cf072678ad->leave($__internal_7bb874750320bf0e1c13505460669ca3a09e2c360051ebe7360a98cf072678ad_prof);

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
