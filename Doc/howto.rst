### ControlLer

/**
 * @Route("/uploadify", name="_demo_uploadify")
 * @Template()
 */
public function uploadifyAction()
{
    $form = $this->createFormBuilder(null)->add('titi', 'text', array(
        'uploadify_enabled' => true,
        'uploadify' => array(
            'auto' => true,
            'uploader' => '_demo_contact'
        )
    ))->getForm();
    return array('form' => $form->createView());
}

### Layout

{% extends "AcmeDemoBundle::layout.html.twig" %}

{# --> Start content block #}
{% block content %}
<form>
    {% form_theme form 'RuianUploadifyBundle:Form:fields.html.twig' %}
    {{ form_widget(form) }}
</form>
{% endblock content %}
{# <-- End content block #}

### AppKernel

new Ruian\UploadifyBundle\RuianUploadifyBundle(),

### Autoload

$loader->add('Ruian', __DIR__ . '/../vendor');
