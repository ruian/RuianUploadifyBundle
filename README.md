RuianUploadifyBundle
===================

[![Build Status](https://secure.travis-ci.org/ruian/RuianUploadifyBundle.png)](http://travis-ci.org/ruian/RuianUploadifyBundle)

### /Warning\ i made a new version of this bundle you can still use the old one by using the tag v1.0
    [RuianUploadifyBundle]
        git=git://github.com/ruian/RuianUploadifyBundle.git
        target=bundles/Ruian/UploadifyBundle
        version=v1.0

* [Installation](#installation)
* [How to](#example)

<a name="installation"></a>

## Installation

### Step 1) Get the bundle

Go into your `deps` file add these lines:

    [RuianUploadifyBundle]
        git=git://github.com/ruian/RuianUploadifyBundle.git
        target=bundles/Ruian/UploadifyBundle

Launch install `php bin/vendors install`

### Step 2) Register the namespaces

Go into your `app/autoload.php` file and register this new namespace:

    <?php
    // app/autoload.php
    $loader->registerNamespaces(array(
        // ...
        'Ruian' => __DIR__.'/../vendor/bundles',
        // ...
    ));

### Step 3) Register the bundle

Go into your `app/AppKernel.php`, and register it in your Kernel:

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

<a name="example"></a>

## How to

### Configure

Go into your `app/config.yml` and choose a secret key to encrypt your Session_id

    ruian_uploadify:
        token: "Th1sIs@S3cret!"

Imagine you have a user model like this

    //Acme/DemoBundle/Model/Picture.php
    <?php
    namespace Acme\DemoBundle\Model;

    class Picture
    {
        protected $data;

        public function __construct($data = null)
        {
            if (null !== $data) {
                $this->data = $date;
            }
        }

        /** 
         * @return string
         */
        public function getData()
        {
            return $this->data;
        }
        
        /**
         * @param $data
         * @return void
         */
        public function setData($data)
        {
            $this->data = $data;
        }
    }

Create a form associate

    //Acme/DemoBundle/Form/Type/PictureType.php
    <?php
    namespace Acme\DemoBundle\Form\Type;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilder;

    class PictureType extends AbstractType
    {
        public function buildForm(FormBuilder $builder, array $options)
        {
            $builder
                ->add('data', 'hidden')
                ->add('picture_uploadify', 'uploadify_resource', array(
                    'data' => array(
                        'folder'  => '/uploads/files/',
                        'preview' => 'picture_preview',
                        'path'    => 'AcmeDemoBundle_upload',
                        'copy'    => $this->getName() . '_' . 'data'
                    ),
                    'property_path' => false
                ))
            ;
        }

        public function getName()
        {
            return "picture_type";
        }
    }

        // some code ...

### Api

    // The folder where you to save your files
    'folder'  => '/uploads/files/'
    
    // If you want to have a preview of your download give an ID element from your DOM
    'preview' => 'picture_preview'

    // give a route to uploadify to upload your file
    'path'    => 'RuianUploadifyBundle_upload'

    // Referrer the property who is linked to uploadify
    'copy'    => $this->getName() . '_' . 'picture'

Now we have all elements let's go with our controller and view

### Routing

    AcmeDemoBundle_new:
        pattern:  /new
        defaults: { _controller: AcmeDemoBundle:Demo:new }

    AcmeDemoBundle_upload:
        pattern:  /upload
        defaults: { _controller: AcmeDemoBundle:Demo:upload }


### Controller

    <?php
    namespace Acme\DemoBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Response;
    use Acme\DemoBundle\Model\Picture;
    use Acme\DemoBundle\Form\Type\PictureType;
    use Ruian\UploadifyBundle\Model\Resource;

    class DemoController extends Controller
    {
        // some code ...

        public function newAction()
        {
            $form = $this->createForm(new PictureType(), new Picture());

            // some code ...

            return $this->render('AcmeDemoBundle:Demo:new.html.twig', array(
                'form' => $form->createView()
            ));
        }

        // some code ...

        public function uploadAction()
        {
            $request = $this->get('request');

            $entity = new Resource($this->container->getParameter('kernel.root_dir') . '/../web/');

            $entity->setFolder($request->request->get('folder'));
            $entity->setFile($request->files->get('Filedata'));

            $entity->upload();

            $response = new Response(json_encode($entity->toArray()));
            $response->headers->set('Content-Type', 'application/json; charset=UTF-8');
            return $response;
        }
    }

### View

    <!DOCTYPE html>
    <html>
    <head>
        <title></title>
        <link rel="stylesheet" type="text/css" href="{{ asset('bundles/ruianuploadify/css/uploadify.css') }}">
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="{{ asset('bundles/ruianuploadify/js/swfobject.js') }}"></script>
        <script type="text/javascript" src="{{ asset('bundles/ruianuploadify/js/uploadify.js') }}"></script>
    </head>
    <body>
        <!-- some code ... -->
        <form method="post" action="{{ path('AcmeDemoBundle_new') }}">
            {% form_theme form 'RuianUploadifyBundle:Form:fields.html.twig' %}
            {{ form_widget(form) }}
            <input type="submit" value="save"/>
        </form>
        <!-- some code ... -->
    </body>
    </html>

### Install assets
    
    php5 app/console assets:install web/


If you prefer you can choose to not use the form theme i give to you but you will need to write all the js :-)
Or you can just override it into your bundle `RuianUploadifyBundle/Resources/views/Form/fields.html.twig`

# TODO

- add validator for myme type