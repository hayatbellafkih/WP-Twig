<?php

/* single.twig */
class __TwigTemplate_e1c97b49976b65d9a791e495f18d7a29412bfc04d2f8b5c8306fa5d72604c69d extends Twig_Template
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
        // line 1
        echo "<html>
";
        // line 3
        echo "<body>
hhhhhhhhhhhhhh
hhhhhhjhhhhh
";
        // line 6
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($context["loop"]);
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
            // line 7
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('the_content')->getCallable(), array()), "html", null, true);
            echo "
";
            // line 8
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('comments_popup_link')->getCallable(), array("No comments", "1 comment", "% comments", "btn btn-primary", "Comments Disabled")), "html", null, true);
            // line 9
            echo "
";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 11
        echo "</body>
</html>";
    }

    public function getTemplateName()
    {
        return "single.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 11,  50 => 9,  48 => 8,  44 => 7,  27 => 6,  22 => 3,  19 => 1,);
    }
}
