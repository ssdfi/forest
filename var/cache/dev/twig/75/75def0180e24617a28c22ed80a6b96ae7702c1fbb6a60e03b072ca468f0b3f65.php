<?php

/* base.html.twig */
class __TwigTemplate_de21ac9b25629666398f781e2bfc3c1d5dc2885fbcf136260b782776c577e61f extends Twig_Template
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
        $__internal_4167d981e74f7bff62d9d062b7a8fdedf0413d96b11c7864636e6b23983686e4 = $this->env->getExtension("native_profiler");
        $__internal_4167d981e74f7bff62d9d062b7a8fdedf0413d96b11c7864636e6b23983686e4->enter($__internal_4167d981e74f7bff62d9d062b7a8fdedf0413d96b11c7864636e6b23983686e4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "base.html.twig"));

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
        
        $__internal_4167d981e74f7bff62d9d062b7a8fdedf0413d96b11c7864636e6b23983686e4->leave($__internal_4167d981e74f7bff62d9d062b7a8fdedf0413d96b11c7864636e6b23983686e4_prof);

    }

    // line 10
    public function block_title($context, array $blocks = array())
    {
        $__internal_e0e5a76474021ad78a975d86d0c39e1c91d8a69770cda6389c564f3b5e269b27 = $this->env->getExtension("native_profiler");
        $__internal_e0e5a76474021ad78a975d86d0c39e1c91d8a69770cda6389c564f3b5e269b27->enter($__internal_e0e5a76474021ad78a975d86d0c39e1c91d8a69770cda6389c564f3b5e269b27_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "ForestApp -";
        
        $__internal_e0e5a76474021ad78a975d86d0c39e1c91d8a69770cda6389c564f3b5e269b27->leave($__internal_e0e5a76474021ad78a975d86d0c39e1c91d8a69770cda6389c564f3b5e269b27_prof);

    }

    // line 11
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_4644437670948437b8a41c8fa1b65807f4ad37409cb3887bdfaea5494128e91b = $this->env->getExtension("native_profiler");
        $__internal_4644437670948437b8a41c8fa1b65807f4ad37409cb3887bdfaea5494128e91b->enter($__internal_4644437670948437b8a41c8fa1b65807f4ad37409cb3887bdfaea5494128e91b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_4644437670948437b8a41c8fa1b65807f4ad37409cb3887bdfaea5494128e91b->leave($__internal_4644437670948437b8a41c8fa1b65807f4ad37409cb3887bdfaea5494128e91b_prof);

    }

    // line 61
    public function block_body($context, array $blocks = array())
    {
        $__internal_b192eda72c4867c94c10e40720aed636b7cd0360596078eab04021ba9a499318 = $this->env->getExtension("native_profiler");
        $__internal_b192eda72c4867c94c10e40720aed636b7cd0360596078eab04021ba9a499318->enter($__internal_b192eda72c4867c94c10e40720aed636b7cd0360596078eab04021ba9a499318_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        echo " ";
        
        $__internal_b192eda72c4867c94c10e40720aed636b7cd0360596078eab04021ba9a499318->leave($__internal_b192eda72c4867c94c10e40720aed636b7cd0360596078eab04021ba9a499318_prof);

    }

    // line 65
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_364f2f149dba019eda75870053cfa8b5c9e906e7b46a54d047fe8929b6d56dec = $this->env->getExtension("native_profiler");
        $__internal_364f2f149dba019eda75870053cfa8b5c9e906e7b46a54d047fe8929b6d56dec->enter($__internal_364f2f149dba019eda75870053cfa8b5c9e906e7b46a54d047fe8929b6d56dec_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_364f2f149dba019eda75870053cfa8b5c9e906e7b46a54d047fe8929b6d56dec->leave($__internal_364f2f149dba019eda75870053cfa8b5c9e906e7b46a54d047fe8929b6d56dec_prof);

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
