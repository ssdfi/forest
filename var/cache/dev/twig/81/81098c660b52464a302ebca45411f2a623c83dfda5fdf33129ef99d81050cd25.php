<?php

/* base.html.twig */
class __TwigTemplate_ebe837cdc76fefe8e5336ef9d712c2834f1aed20a445cc38782721916279d297 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_39572d4c987d74462a60a8b403350d7e1f573866e4d6a5450d4289f306db7528 = $this->env->getExtension("native_profiler");
        $__internal_39572d4c987d74462a60a8b403350d7e1f573866e4d6a5450d4289f306db7528->enter($__internal_39572d4c987d74462a60a8b403350d7e1f573866e4d6a5450d4289f306db7528_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta name=\"description\" content=\"\">
    <meta name=\"author\" content=\"\">
    <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("favicon.png"), "html", null, true);
        echo "\" />
    <title>";
        // line 10
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    ";
        // line 11
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 12
        echo "    <!-- Bootstrap core CSS -->
    <link rel=\"stylesheet\" href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/bootstrap.min.css"), "html", null, true);
        echo "\" />
    <link rel=\"stylesheet\" href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/body.css"), "html", null, true);
        echo "\" />

  </head>

  <body>
    <nav class=\"navbar navbar-inverse navbar-fixed-top\">
      <div class=\"container\">
        <div class=\"navbar-header\">
          <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar\" aria-expanded=\"false\" aria-controls=\"navbar\">
            <span class=\"sr-only\">Ver navegador</span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
          </button>
          <a class=\"navbar-brand\" href=\"/\">
            <i class=\"glyphicon glyphicon-tree-deciduous\"></i>
          </a>
        </div>
        <div id=\"navbar\" class=\"collapse navbar-collapse\">
          <ul class=\"nav navbar-nav\">
            <li><a href=\"/\">Expedientes</a></li>
            <li><a href=\"#\">Titulares</a></li>
            <li><a href=\"#contact\">Técnicos</a></li>
            <li><a href=\"#contact\">Plantaciones</a></li>
          </ul>
          <ul class=\"nav navbar-nav navbar-right\">
            <!--NUEVO EXPEDIENTE -->
            <li class=\"navbar-primary\">
              <a id=\"nav-new-expediente\" href=\"/expedientes/create\">
                <span class=\"glyphicon glyphicon-plus\" aria-hidden=\"true\"></span>
                Nuevo Expediente
              </a>
            </li>
          <li class=\"navbar-danger\">
            <!--logout -->
              <a id=\"nav-logout\" href=\"/logout\" data-confirm=\"¿Está seguro que desea cerrar la sesión?\">
                <span class=\"glyphicon glyphicon glyphicon-log-out\" aria-hidden=\"true\"></span> Salir
              </a>
          </li>
        </ul>
        </div>
      </div>
    </nav>

    <div class=\"container-fluid\">
        <div class=\"row\">
            <div class=\"col-md-12\">
                ";
        // line 61
        $this->displayBlock('body', $context, $blocks);
        // line 62
        echo "            </div>
        </div>
    </div>
      ";
        // line 65
        $this->displayBlock('javascripts', $context, $blocks);
        // line 66
        echo "  </body>
</html>
";
        
        $__internal_39572d4c987d74462a60a8b403350d7e1f573866e4d6a5450d4289f306db7528->leave($__internal_39572d4c987d74462a60a8b403350d7e1f573866e4d6a5450d4289f306db7528_prof);

    }

    // line 10
    public function block_title($context, array $blocks = array())
    {
        $__internal_9e09913790693fe6d6c86aab7e12ec2e39389282d6310e2d183856990e40e2c0 = $this->env->getExtension("native_profiler");
        $__internal_9e09913790693fe6d6c86aab7e12ec2e39389282d6310e2d183856990e40e2c0->enter($__internal_9e09913790693fe6d6c86aab7e12ec2e39389282d6310e2d183856990e40e2c0_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "ForestApp -";
        
        $__internal_9e09913790693fe6d6c86aab7e12ec2e39389282d6310e2d183856990e40e2c0->leave($__internal_9e09913790693fe6d6c86aab7e12ec2e39389282d6310e2d183856990e40e2c0_prof);

    }

    // line 11
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_a4f37a15e8ff5e1b07c9461c0cee8ba7274ab15ad3242e85293d921662c469df = $this->env->getExtension("native_profiler");
        $__internal_a4f37a15e8ff5e1b07c9461c0cee8ba7274ab15ad3242e85293d921662c469df->enter($__internal_a4f37a15e8ff5e1b07c9461c0cee8ba7274ab15ad3242e85293d921662c469df_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_a4f37a15e8ff5e1b07c9461c0cee8ba7274ab15ad3242e85293d921662c469df->leave($__internal_a4f37a15e8ff5e1b07c9461c0cee8ba7274ab15ad3242e85293d921662c469df_prof);

    }

    // line 61
    public function block_body($context, array $blocks = array())
    {
        $__internal_d1abe82a48a8d4d4e9422344a18623cc9e5bd4eb88261456437f47a3c93056c2 = $this->env->getExtension("native_profiler");
        $__internal_d1abe82a48a8d4d4e9422344a18623cc9e5bd4eb88261456437f47a3c93056c2->enter($__internal_d1abe82a48a8d4d4e9422344a18623cc9e5bd4eb88261456437f47a3c93056c2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        echo " ";
        
        $__internal_d1abe82a48a8d4d4e9422344a18623cc9e5bd4eb88261456437f47a3c93056c2->leave($__internal_d1abe82a48a8d4d4e9422344a18623cc9e5bd4eb88261456437f47a3c93056c2_prof);

    }

    // line 65
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_83c03e3a50e3a9ba69c5013729e50a3e6741120da11b7097e73eee24afb1569a = $this->env->getExtension("native_profiler");
        $__internal_83c03e3a50e3a9ba69c5013729e50a3e6741120da11b7097e73eee24afb1569a->enter($__internal_83c03e3a50e3a9ba69c5013729e50a3e6741120da11b7097e73eee24afb1569a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_83c03e3a50e3a9ba69c5013729e50a3e6741120da11b7097e73eee24afb1569a->leave($__internal_83c03e3a50e3a9ba69c5013729e50a3e6741120da11b7097e73eee24afb1569a_prof);

    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  156 => 65,  144 => 61,  133 => 11,  121 => 10,  112 => 66,  110 => 65,  105 => 62,  103 => 61,  53 => 14,  49 => 13,  46 => 12,  44 => 11,  40 => 10,  36 => 9,  26 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html lang="en">*/
/*   <head>*/
/*     <meta charset="utf-8">*/
/*     <meta http-equiv="X-UA-Compatible" content="IE=edge">*/
/*     <meta name="viewport" content="width=device-width, initial-scale=1">*/
/*     <meta name="description" content="">*/
/*     <meta name="author" content="">*/
/*     <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}" />*/
/*     <title>{% block title %}ForestApp -{% endblock %}</title>*/
/*     {% block stylesheets %}{% endblock %}*/
/*     <!-- Bootstrap core CSS -->*/
/*     <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />*/
/*     <link rel="stylesheet" href="{{ asset('css/body.css') }}" />*/
/* */
/*   </head>*/
/* */
/*   <body>*/
/*     <nav class="navbar navbar-inverse navbar-fixed-top">*/
/*       <div class="container">*/
/*         <div class="navbar-header">*/
/*           <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">*/
/*             <span class="sr-only">Ver navegador</span>*/
/*             <span class="icon-bar"></span>*/
/*             <span class="icon-bar"></span>*/
/*             <span class="icon-bar"></span>*/
/*           </button>*/
/*           <a class="navbar-brand" href="/">*/
/*             <i class="glyphicon glyphicon-tree-deciduous"></i>*/
/*           </a>*/
/*         </div>*/
/*         <div id="navbar" class="collapse navbar-collapse">*/
/*           <ul class="nav navbar-nav">*/
/*             <li><a href="/">Expedientes</a></li>*/
/*             <li><a href="#">Titulares</a></li>*/
/*             <li><a href="#contact">Técnicos</a></li>*/
/*             <li><a href="#contact">Plantaciones</a></li>*/
/*           </ul>*/
/*           <ul class="nav navbar-nav navbar-right">*/
/*             <!--NUEVO EXPEDIENTE -->*/
/*             <li class="navbar-primary">*/
/*               <a id="nav-new-expediente" href="/expedientes/create">*/
/*                 <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>*/
/*                 Nuevo Expediente*/
/*               </a>*/
/*             </li>*/
/*           <li class="navbar-danger">*/
/*             <!--logout -->*/
/*               <a id="nav-logout" href="/logout" data-confirm="¿Está seguro que desea cerrar la sesión?">*/
/*                 <span class="glyphicon glyphicon glyphicon-log-out" aria-hidden="true"></span> Salir*/
/*               </a>*/
/*           </li>*/
/*         </ul>*/
/*         </div>*/
/*       </div>*/
/*     </nav>*/
/* */
/*     <div class="container-fluid">*/
/*         <div class="row">*/
/*             <div class="col-md-12">*/
/*                 {% block body %} {% endblock %}*/
/*             </div>*/
/*         </div>*/
/*     </div>*/
/*       {% block javascripts %}{% endblock %}*/
/*   </body>*/
/* </html>*/
/* */
