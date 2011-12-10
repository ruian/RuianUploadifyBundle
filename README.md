RuianUploadifyBundle
===================

* [Installation](#installation)
* [Example](#example)

<a name="installation"></a>

## Installation

### Step 1) Get the bundle

First, grab the RuianUploadifyBundle :

Add the following lines to your  `deps` file and then run `php bin/vendors
install`:

```
[RuianUploadifyBundle]
    git=git://github.com/ruian/RuianUploadifyBundle.git
    target=bundles/Ruian/UploadifyBundle
```

### Step 2) Register the namespaces

Add the following two namespace entries to the `registerNamespaces` call
in your autoloader:

``` php
<?php
// app/autoload.php
$loader->registerNamespaces(array(
    // ...
    'Ruian' => __DIR__.'/../vendor/bundles',
    // ...
));
```

### Step 3) Register the bundle

To start using the bundle, register it in your Kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Ruian\UploadifyBundle\RuianUploadifyBundle(),
    );
    // ...
)
```

<a name="example"></a>
## Imagine a user profile

``` php
<?php
namespace XXXX\XXXXBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ruian\UploadifyBundle\Model\Ressource;

/**
 * XXXX\XXXXBundle\Entity\Profile
 * @ORM\Entity
 * @ORM\Table(name="XXXX_XXXX_profile")
 */
class Profile
{
    /**
     * @var integer $id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $username;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $avatar;

    protected $avatar_uploadify;

    function __construct()
    {
        $this->avatar_uploadify = new Ressource();
    }

    /**
     * @param string $username
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $avatar
     * @return void
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }
    
    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar_file
     * @return void
     */
    public function setAvatarUploadify($avatar_uploadify)
    {
        $this->avatar_uploadify = $avatar_uploadify;
    }
    
    /**
     * @return string
     */
    public function getAvatarUploadify()
    {
        return $this->avatar_uploadify;
    }
}
```

## Form ProfileType

``` php
<?php

namespace XXXX\XXXXBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Ruian\UploadifyBundle\Form\RessourceType;

class MediaGameType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'label' => 'Username',
                'attr'  => array(
                    'placeholder' => 'Example: Ruian',
                    'class' => 'span15'
                )
            ))
            ->add('avatar', 'hidden')
            ->add('avatar_uploadify', new RessourceType())
        ;
    }

    public function getName()
    {
        return 'XXXX_XXXX_profiletype';
    }
}
```

## Controller

``` php
<?php

namespace XXXX\XXXXBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use XXXX\XXXXBundle\Entity\Profile;

class ProfileController extends Controller
{
    public function newAction()
    {
        $request = $this->get('request');
        $entity = new Profile();
        $form = $this->createForm(new ProfileType(), $entity);
        if ('POST' === $request->getMethod()) {
            # Do your stuff, like save in bdd or whatever
        }

        return $this->render('XXXXXXXXBundle:XXXX:new.html.twig', array(
            'form'      => $form,
            'form_view' => $form->createView()
        ));
    }

    public function uploadAction()
    {
        $request = $this->get('request');

        $entity = new Ressource();

        $entity->setFolder($request->request->get('folder'));
        $entity->setFile($request->files->get('Filedata'));

        $entity->upload();

        $response = new Response(json_encode($entity->toArray()));
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');
        return $response;
    }
}
```

## View (XXXXXXXXBundle:XXXX:new.html.twig)

``` twig
<form method="post" action="{{ path('your_path_to_new_profile') }}" {{ form_enctype(form_view) }}>
    <div class="{% if form.username.hasErrors %}error{% endif %}">
        {{ form_label(form_view.username)}}
        <div>
        {{ form_widget(form_view.username)}}
        </div>
    </div>
    <div class="{% if form.avatar_uploadify.file.hasErrors %}error{% endif %}">
        {{ form_label(form_view.avatar_uploadify.file)}}
        <div>
            {{ form_widget(form_view.avatar_uploadify.file, {'attr' : {'data-path' : path('your_path_to_upload_profile'), 'data-folder' : '/uploads/profile/avatar/'}})}}
        </div>
        <div id="avatar-preview">
                
        </div>
    </div>
    <div>
        {{ form_widget(form_view._token )}}
        {{ form_widget(form_view.avatar )}}
        <input type="submit" value="Save" />
    </div>
</form>
```

## Script referer to uploadify doc, BUT IMPORTANT
if these lines are not set, the bundle will not work.
'_uploadify' : true,
'_session' : $('id_of_input_avatar_uploadify').attr('data-session'),
just add them like the example show it.

``` javascript
$('id_of_input_avatar_uploadify').uploadify({
    'uploader'  : '/bundles/ruianuploadify/swf/uploadify.swf',
    'script'    : $('id_of_input_avatar_uploadify').attr('data-path'),
    'folder'    : $('id_of_input_avatar_uploadify').attr('data-folder'),
    'scriptData'   : {
        '_uploadify' : true,
        '_session' : $('id_of_input_avatar_uploadify').attr('data-session'),
    },
    'cancelImg' : '/bundles/ruianuploadify/images/cancel.png',
    'auto'      : true,
    'onComplete'  : function(event, ID, fileObj, response, data) {
        response = jQuery.parseJSON(response);
        jQuery('#avatar-preview').html("<img src='"+response.folder+response.file+"' />");
    }
  });
```
