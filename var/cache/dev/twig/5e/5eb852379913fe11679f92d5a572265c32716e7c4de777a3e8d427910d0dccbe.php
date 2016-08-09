<?php

/* expedientes/show_list.html.twig */
class __TwigTemplate_9056df9b8961320bd20575cd70ab0aecf3c1ffed51baf1520564fd643bb78852 extends Twig_Template
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
        $__internal_f91123107386b5daf0bd0e3a733a120396bde922c20c0797a083be02e0dd48d6 = $this->env->getExtension("native_profiler");
        $__internal_f91123107386b5daf0bd0e3a733a120396bde922c20c0797a083be02e0dd48d6->enter($__internal_f91123107386b5daf0bd0e3a733a120396bde922c20c0797a083be02e0dd48d6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "expedientes/show_list.html.twig"));

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
            echo $this->env->getExtension('dump')->dump($this->env, $context, $context["expediente"]);
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
        
        $__internal_f91123107386b5daf0bd0e3a733a120396bde922c20c0797a083be02e0dd48d6->leave($__internal_f91123107386b5daf0bd0e3a733a120396bde922c20c0797a083be02e0dd48d6_prof);

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
        return array (  92 => 40,  80 => 33,  74 => 30,  69 => 29,  67 => 28,  57 => 21,  53 => 20,  49 => 19,  42 => 16,  38 => 15,  22 => 1,);
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
/*       {{ dump(expediente) }}*/
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
