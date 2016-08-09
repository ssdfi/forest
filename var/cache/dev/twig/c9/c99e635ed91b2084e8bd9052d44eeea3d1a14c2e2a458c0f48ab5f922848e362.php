<?php

/* expedientes/show_list.html.twig */
class __TwigTemplate_234a2a47c8b8db1725e70a6062c081d310986938b7199203f029598abeef8228 extends Twig_Template
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
        $__internal_208d910daa9718ef859be36198e0c411960d5341522a1b96110aa11ba44fbfeb = $this->env->getExtension("native_profiler");
        $__internal_208d910daa9718ef859be36198e0c411960d5341522a1b96110aa11ba44fbfeb->enter($__internal_208d910daa9718ef859be36198e0c411960d5341522a1b96110aa11ba44fbfeb_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "expedientes/show_list.html.twig"));

        // line 1
        echo "<table id=\"expedientes\" class=\"table table-hover table-grid\">
  <thead>
    <tr>
      <th>ID</th>
      <th nowrap>Número interno</th>
      <th nowrap>Número expediente</th>
      <th>Titular</th>
      <th>Última Entrada</th>
      <th>Última Salida</th>
      <th>Técnico</th>
      <th class=\"icon\">Activo</th>
    </tr>
  </thead>
  <tbody>
      ";
        // line 15
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["expedientes"]) ? $context["expedientes"] : $this->getContext($context, "expedientes")));
        foreach ($context['_seq'] as $context["_key"] => $context["expediente"]) {
            // line 16
            echo "      ";
            // line 17
            echo "
      <tr data-link=\"expediente_path\">
        <td>";
            // line 19
            echo twig_escape_filter($this->env, $this->getAttribute($context["expediente"], "id", array()), "html", null, true);
            echo "</td>
        <td nowrap>";
            // line 20
            echo twig_escape_filter($this->env, $this->getAttribute($context["expediente"], "numeroInterno", array()), "html", null, true);
            echo "</td>
        <td nowrap>";
            // line 21
            echo twig_escape_filter($this->env, $this->getAttribute($context["expediente"], "numeroExpediente", array()), "html", null, true);
            echo "</td>
        <td>
          <abbr title=\"expediente titulares map\" data-length=\"20\">sio</abbr>
        </td>
        <td>20/10/2016</td>
        <td>22/10/2016</td>
        <td>
          ";
            // line 28
            if ($this->getAttribute($this->getAttribute($context["expediente"], "tecnico", array(), "any", false, true), "nombre", array(), "any", true, true)) {
                // line 29
                echo "           <abbr title=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["expediente"], "tecnico", array()), "nombre", array()), "html", null, true);
                echo "\" data-length=\"20\">
             ";
                // line 30
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["expediente"], "tecnico", array()), "nombre", array()), "html", null, true);
                echo "
           </abbr>
           ";
            }
            // line 33
            echo "
        <td class=\"icon\">
          <!--Si es activo, poner un logo de activo common/boolean_value-->
          X
        </td>
      </tr>
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['expediente'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 40
        echo "  </tbody>
</table>
";
        
        $__internal_208d910daa9718ef859be36198e0c411960d5341522a1b96110aa11ba44fbfeb->leave($__internal_208d910daa9718ef859be36198e0c411960d5341522a1b96110aa11ba44fbfeb_prof);

    }

    public function getTemplateName()
    {
        return "expedientes/show_list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 40,  79 => 33,  73 => 30,  68 => 29,  66 => 28,  56 => 21,  52 => 20,  48 => 19,  44 => 17,  42 => 16,  38 => 15,  22 => 1,);
    }
}
/* <table id="expedientes" class="table table-hover table-grid">*/
/*   <thead>*/
/*     <tr>*/
/*       <th>ID</th>*/
/*       <th nowrap>Número interno</th>*/
/*       <th nowrap>Número expediente</th>*/
/*       <th>Titular</th>*/
/*       <th>Última Entrada</th>*/
/*       <th>Última Salida</th>*/
/*       <th>Técnico</th>*/
/*       <th class="icon">Activo</th>*/
/*     </tr>*/
/*   </thead>*/
/*   <tbody>*/
/*       {% for expediente in expedientes %}*/
/*       {# dump(expediente) #}*/
/* */
/*       <tr data-link="expediente_path">*/
/*         <td>{{ expediente.id }}</td>*/
/*         <td nowrap>{{ expediente.numeroInterno }}</td>*/
/*         <td nowrap>{{ expediente.numeroExpediente }}</td>*/
/*         <td>*/
/*           <abbr title="expediente titulares map" data-length="20">sio</abbr>*/
/*         </td>*/
/*         <td>20/10/2016</td>*/
/*         <td>22/10/2016</td>*/
/*         <td>*/
/*           {% if expediente.tecnico.nombre is defined %}*/
/*            <abbr title="{{ expediente.tecnico.nombre }}" data-length="20">*/
/*              {{ expediente.tecnico.nombre }}*/
/*            </abbr>*/
/*            {% endif %}*/
/* */
/*         <td class="icon">*/
/*           <!--Si es activo, poner un logo de activo common/boolean_value-->*/
/*           X*/
/*         </td>*/
/*       </tr>*/
/*       {% endfor %}*/
/*   </tbody>*/
/* </table>*/
/* */
