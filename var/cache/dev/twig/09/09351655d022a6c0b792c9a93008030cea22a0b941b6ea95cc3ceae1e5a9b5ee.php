<?php

/* @WebProfiler/Profiler/header.html.twig */
class __TwigTemplate_54cc948f8850600bed5c22ba6a44bb12b2ce3f2e456a30221082adc8cf515fde extends Twig_Template
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
        $__internal_aef902a7501a6f1de7f53854b97dcbc06a86d4eb1f5a4f137e2c27ad29c184d1 = $this->env->getExtension("native_profiler");
        $__internal_aef902a7501a6f1de7f53854b97dcbc06a86d4eb1f5a4f137e2c27ad29c184d1->enter($__internal_aef902a7501a6f1de7f53854b97dcbc06a86d4eb1f5a4f137e2c27ad29c184d1_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Profiler/header.html.twig"));

        // line 1
        echo "<div id=\"header\">
    <div class=\"container\">
        <h1>";
        // line 3
        echo twig_include($this->env, $context, "@WebProfiler/Icon/symfony.svg");
        echo " Symfony <span>Profiler</span></h1>

        <div class=\"search\">
            <form method=\"get\" action=\"https://symfony.com/search\" target=\"_blank\">
                <div class=\"form-row\">
                    <input name=\"q\" id=\"search-id\" type=\"search\" placeholder=\"search on symfony.com\">
                    <button type=\"submit\" class=\"btn\">Search</button>
                </div>
           </form>
        </div>
    </div>
</div>
";
        
        $__internal_aef902a7501a6f1de7f53854b97dcbc06a86d4eb1f5a4f137e2c27ad29c184d1->leave($__internal_aef902a7501a6f1de7f53854b97dcbc06a86d4eb1f5a4f137e2c27ad29c184d1_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Profiler/header.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  26 => 3,  22 => 1,);
    }
}
/* <div id="header">*/
/*     <div class="container">*/
/*         <h1>{{ include('@WebProfiler/Icon/symfony.svg') }} Symfony <span>Profiler</span></h1>*/
/* */
/*         <div class="search">*/
/*             <form method="get" action="https://symfony.com/search" target="_blank">*/
/*                 <div class="form-row">*/
/*                     <input name="q" id="search-id" type="search" placeholder="search on symfony.com">*/
/*                     <button type="submit" class="btn">Search</button>*/
/*                 </div>*/
/*            </form>*/
/*         </div>*/
/*     </div>*/
/* </div>*/
/* */
